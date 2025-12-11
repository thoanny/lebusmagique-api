<?php

namespace App\Controller\Api\Gw2;

use App\Entity\Gw2Api\Item;
use App\Entity\Gw2Api\ItemPrice;
use App\Entity\Gw2Api\Recipe;
use App\Entity\Gw2Api\RecipeIngredient;
use App\Repository\Gw2Api\ItemPriceRepository;
use App\Repository\Gw2Api\ItemRepository;
use App\Repository\Gw2Api\RecipeRepository;
use App\Service\Api;
use App\Service\Gw2Api;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

class ItemsController extends AbstractController
{

    public function __construct(private ItemRepository $itemRepository, private ItemPriceRepository $itemPriceRepository, private RecipeRepository $recipeRepository, private Gw2Api $Gw2Api, private Api $api, private EntityManagerInterface $em)
    {
    }

    protected function getGw2Item($uid, $withRecipes = true) {
        if ($uid) {
            $item = $this->itemRepository->findOneBy(['uid' => $uid]);

            if (!$item || ($item->getUpdatedAt() <= (new DateTime('now'))->modify('- 30 days'))) {
                $apiItem = $this->Gw2Api->getItem($uid);

                if (!is_array($apiItem) && $apiItem->getCode()) {
                    return match ($apiItem->getCode()) {
                        404 => $this->api->respondNotFound('Item not found'),
                        default => $this->api->respondWithErrors($apiItem->getMessage()),
                    };
                }

                if (!$item) {
                    $item = new Item();
                }

                $text = [];
                if (isset($apiItem['description'])) {
                    $text[] = $apiItem['description'];
                }
                if (isset($apiItem['details']['description'])) {
                    $text[] = $apiItem['details']['description'];
                }

                $item->setUid($apiItem['id'])
                    ->setName($apiItem['name'])
                    ->setText(implode(' ', $text))
                    ->setType($apiItem['type'])
                    ->setSubtype(($apiItem['details']['type'] ?? null))
                    ->setRarity($apiItem['rarity'])
                    ->setUpdatedAt(new DateTimeImmutable())
                    ->setData($apiItem);

                $iconsDirectory = $this->getParameter('api.uploads.gw2.items');
                $iconFile = "$iconsDirectory/{$apiItem['id']}.png";
                if (!file_exists($iconFile)) {
                    $iconContent = @file_get_contents($apiItem['icon']);
                    if ($iconContent) {
                        file_put_contents($iconFile, $iconContent);
                    }
                }

                $this->em->persist($item);
                $this->em->flush();

                $getPrice = $this->Gw2Api->getPrice($uid);
                if($getPrice) {
                    $checksum = md5(json_encode($getPrice));
                    $price = $item->getItemPrice();
                    if($price) {
                        if($price->getChecksum() !== $checksum && $price->getUpdatedAt()->format('Y-m-d H:i:s') <= date('Y-m-d H:i:s', strtotime('-6 hours'))) {
                            $price
                                ->setBuysQuantity($getPrice['buys']['quantity'])
                                ->setBuysUnitPrice($getPrice['buys']['unit_price'])
                                ->setSellsQuantity($getPrice['sells']['quantity'])
                                ->setSellsUnitPrice($getPrice['sells']['unit_price'])
                                ->setUpdatedAt(new \DateTimeImmutable())
                                ->setChecksum($checksum)
                            ;
                            $this->em->flush();
                        }
                    } else {
                        $price = (new ItemPrice())
                            ->setItem($item)
                            ->setBuysQuantity($getPrice['buys']['quantity'])
                            ->setBuysUnitPrice($getPrice['buys']['unit_price'])
                            ->setSellsQuantity($getPrice['sells']['quantity'])
                            ->setSellsUnitPrice($getPrice['sells']['unit_price'])
                            ->setUpdatedAt(new \DateTimeImmutable())
                            ->setChecksum($checksum)
                        ;

                        $this->em->persist($price);
                        $this->em->flush();
                    }
                }

                $data = $item->getData();
                if(isset($data['details']['infusion_slots'])) {
                    foreach($data['details']['infusion_slots'] as $infu) {
                        if(isset($infu['item_id'])) {
                            $this->getGw2Item($infu['item_id']);
                        }
                    }
                }

                if($withRecipes) {
                    $recipes = $this->Gw2Api->getRecipesByOutput($item->getUid());
                    if($recipes) {
                        foreach($recipes as $r) {
                            $recipe = $this->recipeRepository->findOneBy(['uid' => $r]);
                            if(!$recipe) {
                                $recipe = new Recipe();
                            }

                            $_recipe = $this->Gw2Api->getRecipe($r);
                            if($_recipe) {
                                $recipe->setUid($r);
                                $recipe->setItem($this->getGw2Item($_recipe['output_item_id'], false));
                                $recipe->setQuantity($_recipe['output_item_count']);
                                $recipe->setData($_recipe);

                                foreach($_recipe['ingredients'] as $ing) {
                                    $ingredient = (new RecipeIngredient())
                                        ->setItem($this->getGw2Item($ing['item_id']))
                                        ->setQuantity($ing['count'])
                                    ;
                                    $recipe->addIngredient($ingredient);
                                }

                                $item->addRecipe($recipe);
                            }
                        }
                    }
                }

                $this->em->persist($item);
                $this->em->flush();
            }

            return $item;
        }
    }

    #[Route('/api/gw2/items/{uid}', name: 'app_api_gw2_item', methods: ['GET'])]
    #[OA\Tag(name: 'GW2')]
    public function appApiGw2Item(int $uid, SerializerInterface $serializer): JsonResponse
    {
        $item = $this->getGw2Item($uid);
        $data = $serializer->serialize(
            $item,
            'json', ['groups' => ['item','price', 'recipe', 'ingredient']]
        );
        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/api/gw2/items', name: 'app_api_gw2_items', methods: ['GET'])]
    #[OA\Tag(name: 'GW2')]
    public function appApiGw2Items(SerializerInterface $serializer): JsonResponse
    {
        $items = $this->itemRepository->findBy([], ['updatedAt' => 'DESC'], 25);
        $data = $serializer->serialize(
            $items,
            'json', ['groups' => ['item','price']]
        );
        return new JsonResponse($data, 200, [], true);
    }
}

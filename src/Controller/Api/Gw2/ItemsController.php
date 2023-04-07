<?php

namespace App\Controller\Api\Gw2;

use App\Controller\Api\ApiController;
use App\Entity\Gw2Api\Item;
use App\Repository\Gw2Api\ItemRepository;
use App\Service\Gw2Api;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemsController extends AbstractController
{
    protected ApiController $api;

    public function __construct(ApiController $api) {
        $this->api = $api;
    }

    #[Route('/api/gw2/items/{uid}', name: 'app_api_gw2_items', defaults: ['uid' => null])]
    public function appApiGw2Items($uid, Gw2Api $Gw2Api, ItemRepository $itemRepository, EntityManagerInterface $em): Response
    {

        if ($uid) {
            $item = $itemRepository->findOneBy(['uid' => $uid]);

            if (!$item || ($item && $item->getUpdatedAt() <= (new DateTime('now'))->modify('- 30 days'))) {
                $apiItem = $Gw2Api->getItem($uid);

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

                // TODO : Vérifier si infusions, si oui les récupérer

                $iconsDirectory = $this->getParameter('api.uploads.gw2.items');
                $iconFile = "$iconsDirectory/{$apiItem['id']}.png";
                if (!file_exists($iconFile)) {
                    $iconContent = @file_get_contents($apiItem['icon']);
                    if ($iconContent) {
                        file_put_contents($iconFile, $iconContent);
                    }
                }

                $em->persist($item);
                $em->flush();
            }

            return $this->json($item);
        }

        $items = $itemRepository->findAll();
        return $this->json($items);
    }
}

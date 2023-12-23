<?php

namespace App\Controller\Api\Palia;

use App\Repository\Palia\ItemRepository;
use App\Service\ImageEncoded;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

class ItemController extends AbstractController
{
    #[Route('/api/palia/items/{slug}', name: 'app_api_palia_item', methods: ['GET'])]
    #[OA\Tag(name: 'Palia')]
    public function appApiPaliaItem($slug, ItemRepository $itemRepository, SerializerInterface $serializer, ImageEncoded $imageEncoded): JsonResponse
    {
        $item = $itemRepository->findOneBy(['slug' => $slug]);
        $item->setIconEncoded($imageEncoded->get($item->getIcon(), '/uploads/api/palia/items/', 'palia_item_icon'));
        return new JsonResponse($serializer->serialize($item, 'json', ['groups' => ['api', 'item']]), 200, [], true);
    }

    #[Route('/api/palia/items', name: 'app_api_palia_items', methods: ['GET'])]
    #[OA\Tag(name: 'Palia')]
    public function appApiPaliaItems(ItemRepository $itemRepository, SerializerInterface $serializer, ImageEncoded $imageEncoded): JsonResponse
    {
        $items = $itemRepository->findBy([], ['name' => 'ASC']);
        foreach($items as $i) {
            $i->setIconEncoded($imageEncoded->get($i->getIcon(), '/uploads/api/palia/items/', 'palia_item_icon'));
        }
        return new JsonResponse($serializer->serialize($items, 'json', ['groups' => ['api']]), 200, [], true);
    }
}

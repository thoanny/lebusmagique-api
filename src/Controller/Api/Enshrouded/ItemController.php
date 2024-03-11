<?php

namespace App\Controller\Api\Enshrouded;

use App\Repository\Enshrouded\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ItemController extends AbstractController
{
    #[Route('/api/enshrouded/items', name: 'app_api_enshrouded_items')]
    public function appApiEnshroudedItems(SerializerInterface $serializer, ItemRepository $itemRepository): JsonResponse
    {
        $items = $itemRepository->findby([], ['name' => 'ASC']);
        return new JsonResponse($serializer->serialize($items, 'json', ['groups' => ['items']]), 200, [], true);
    }

    #[Route('/api/enshrouded/items/{id}', name: 'app_api_enshrouded_item')]
    public function appApiEnshroudedItem($id, SerializerInterface $serializer, ItemRepository $itemRepository): JsonResponse
    {
        $item = $itemRepository->findOneBy(['id' => $id]);
        return new JsonResponse($serializer->serialize($item, 'json', ['groups' => ['item']]), 200, [], true);
    }
}

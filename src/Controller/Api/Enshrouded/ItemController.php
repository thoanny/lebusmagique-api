<?php

namespace App\Controller\Api\Enshrouded;

use App\Repository\Enshrouded\ItemCategoryRepository;
use App\Repository\Enshrouded\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

class ItemController extends AbstractController
{
    #[Route('/api/enshrouded/items', name: 'app_api_enshrouded_items', methods: ['GET'])]
    #[OA\Tag(name: 'Enshrouded')]
    public function appApiEnshroudedItems(SerializerInterface $serializer, ItemRepository $itemRepository): JsonResponse
    {
        $items = $itemRepository->findby([], ['name' => 'ASC']);
        return new JsonResponse($serializer->serialize($items, 'json', ['groups' => ['items']]), 200, [], true);
    }

    #[Route('/api/enshrouded/items/categories', name: 'app_api_enshrouded_items_categories', methods: ['GET'])]
    #[OA\Tag(name: 'Enshrouded')]
    public function appApiEnshroudedItemsCategories(SerializerInterface $serializer, ItemCategoryRepository $categoryRepository): JsonResponse
    {
        $categories = $categoryRepository->findBy([], ['name' => 'ASC']);
        return new JsonResponse($serializer->serialize($categories, 'json', ['groups' => ['categories']]), 200, [], true);
    }

    #[Route('/api/enshrouded/items/{id}', name: 'app_api_enshrouded_item', methods: ['GET'])]
    #[OA\Tag(name: 'Enshrouded')]
    public function appApiEnshroudedItem($id, SerializerInterface $serializer, ItemRepository $itemRepository): JsonResponse
    {
        $item = $itemRepository->findOneBy(['id' => $id]);
        return new JsonResponse($serializer->serialize($item, 'json', ['groups' => ['item']]), 200, [], true);
    }
}

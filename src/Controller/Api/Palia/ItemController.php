<?php

namespace App\Controller\Api\Palia;

use App\Repository\Palia\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ItemController extends AbstractController
{
    #[Route('/api/palia/items', name: 'app_api_palia_items')]
    public function appApiPaliaItems(ItemRepository $itemRepository, SerializerInterface $serializer): JsonResponse
    {
        $items = $itemRepository->findAll();
        return new JsonResponse($serializer->serialize($items, 'json', ['groups' => ['api']]), 200, [], true);
    }
}

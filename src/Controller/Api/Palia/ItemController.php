<?php

namespace App\Controller\Api\Palia;

use App\Repository\Palia\ItemRepository;
use App\Service\ImageEncoded;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ItemController extends AbstractController
{
    #[Route('/api/palia/items', name: 'app_api_palia_items')]
    public function appApiPaliaItems(ItemRepository $itemRepository, SerializerInterface $serializer, ImageEncoded $imageEncoded): JsonResponse
    {
        $items = $itemRepository->findAll();
        foreach($items as $i) {
            $i->setIconEncoded($imageEncoded->get($i->getIcon(), '/uploads/api/palia/items/', 'palia_item_icon'));
        }
        return new JsonResponse($serializer->serialize($items, 'json', ['groups' => ['api']]), 200, [], true);
    }
}

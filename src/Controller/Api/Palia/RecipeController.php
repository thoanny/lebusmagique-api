<?php

namespace App\Controller\Api\Palia;

use App\Repository\Palia\RecipeRepository;
use App\Service\ImageEncoded;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

class RecipeController extends AbstractController
{
    #[Route('/api/palia/recipes', name: 'app_api_palia_recipes', methods: ['GET'])]
    #[OA\Tag(name: 'Palia')]
    public function appApiPaliaItems(RecipeRepository $recipeRepository, SerializerInterface $serializer, ImageEncoded $imageEncoded): JsonResponse
    {
        $recipes = $recipeRepository->findAll();
        foreach($recipes as $r) {
            $r->getItem()->setIconEncoded($imageEncoded->get($r->getItem()->getIcon(), '/uploads/api/palia/items/', 'palia_item_icon'));
            if(!$r->getWorkshop()->getIconEncoded()) {
                $r->getWorkshop()->setIconEncoded($imageEncoded->get($r->getWorkshop()->getIcon(), '/uploads/api/palia/items/', 'palia_item_icon'));
            }
            foreach($r->getIngredients() as $i) {
                if(!$i->getItem()->getIconEncoded()) {
                    $i->getItem()->setIconEncoded($imageEncoded->get($i->getItem()->getIcon(), '/uploads/api/palia/items/', 'palia_item_icon'));
                }
            }

        }
        return new JsonResponse($serializer->serialize($recipes, 'json', ['groups' => ['recipe']]), 200, [], true);
    }
}

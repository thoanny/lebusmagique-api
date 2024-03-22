<?php

namespace App\Controller\Api\Enshrouded;

use App\Repository\Enshrouded\ItemRepository;
use App\Repository\Enshrouded\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/api/enshrouded', name: 'app_api_enshrouded_home')]
    public function appApiEnshroudedHome(ItemRepository $itemRepository, RecipeRepository $recipeRepository): JsonResponse
    {

        return $this->json([
            'items' => $itemRepository->getItemsCount(),
            'recipes' => $recipeRepository->getRecipesCount(),
        ]);
    }
}

<?php

namespace App\Controller\Api\Enshrouded;

use App\Repository\Enshrouded\RecipeCategoryRepository;
use App\Repository\Enshrouded\RecipeRepository;
use App\Repository\Enshrouded\RecipeSourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

class RecipeController extends AbstractController
{
    #[Route('/api/enshrouded/recipes', name: 'app_api_enshrouded_recipes')]
    #[OA\Tag(name: 'Enshrouded')]
    public function appApiEnshroudedRecipes(
        SerializerInterface $serializer,
        RecipeCategoryRepository $recipeCategoryRepository,
    ): JsonResponse
    {
        $recipes = $recipeCategoryRepository->findBy([], ['root' => 'ASC', 'lft' => 'ASC']);
        return new JsonResponse($serializer->serialize($recipes, 'json', ['groups' => ['recipes']]), 200, [], true);
    }

    #[Route('/api/enshrouded/recipes/sources', name: 'app_api_enshrouded_recipes_sources')]
    #[OA\Tag(name: 'Enshrouded')]
    public function appApiEnshroudedRecipesSources(
        SerializerInterface $serializer,
        RecipeSourceRepository $recipeSourceRepository
    ): JsonResponse
    {
        $sources = $recipeSourceRepository->findAll();
        return new JsonResponse($serializer->serialize($sources, 'json', ['groups' => ['recipes_sources']]), 200, [], true);
    }

    #[Route('/api/enshrouded/recipes/{id}', name: 'app_api_enshrouded_recipe')]
    public function appApiEnsourdedRecipe($id, RecipeRepository $recipeRepository, SerializerInterface $serializer): JsonResponse {
        $recipe = $recipeRepository->findOneBy(['id'=>$id]);
        return new JsonResponse($serializer->serialize($recipe, 'json', ['groups' => ['recipe']]), 200, [], true);
    }
}

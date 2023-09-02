<?php

namespace App\Controller\Api\Palia;

use App\Repository\Palia\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RecipeController extends AbstractController
{
    #[Route('/api/palia/recipes', name: 'app_api_palia_recipes')]
    public function appApiPaliaItems(RecipeRepository $recipeRepository, SerializerInterface $serializer): JsonResponse
    {
        $items = $recipeRepository->findAll();
        return new JsonResponse($serializer->serialize($items, 'json', ['groups' => ['recipe']]), 200, [], true);
    }
}

<?php

namespace App\Controller\Api\Gw2;

use App\Entity\Gw2\Decoration;
use App\Repository\Gw2\DecorationCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DecorationsController extends AbstractController
{
    #[Route('/api/gw2/decorations', name: 'app_api_gw2_decorations')]
    public function appApiGw2Decorations(DecorationCategoryRepository $categoryRepository, SerializerInterface $serializer): JsonResponse
    {
        $categories = $categoryRepository->findAllForApi();
        return new JsonResponse($serializer->serialize($categories, 'json', ['groups' => 'decorations-categories']), 200, [], true);
    }

    #[Route('/api/gw2/decorations/{id}', name: 'app_api_gw2_decoration')]
    public function appApiGw2Decoration(Decoration $decoration, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse($serializer->serialize($decoration, 'json', ['groups' => ['decoration', 'decoration-recipe', 'ingredient']]), 200, [], true);
    }
}

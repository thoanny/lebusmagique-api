<?php

namespace App\Controller\Api\Enshrouded;

use App\Repository\Enshrouded\ItemRepository;
use App\Repository\Enshrouded\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class SitemapController extends AbstractController
{
    #[Route('/api/enshrouded/sitemap', name: 'app_api_enshrouded_sitemap', methods: ['GET'])]
    #[OA\Tag(name: 'Enshrouded')]
    public function appApiEnshroudedSitemap(ItemRepository $itemRepository, RecipeRepository $recipeRepository): JsonResponse
    {
        $sitemap = [];

        $items = $itemRepository->getItemsId();
        foreach($items as $item) {
            $sitemap[] = ["loc" => "/items/{$item['id']}"];
        }

        $recipes = $recipeRepository->getItemsId();
        foreach($recipes as $recipe) {
            $sitemap[] = ["loc" => "/recipes/{$recipe['id']}"];
        }

        return $this->json($sitemap);
    }
}

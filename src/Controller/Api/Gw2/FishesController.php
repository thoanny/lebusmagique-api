<?php

namespace App\Controller\Api\Gw2;

use App\Repository\Gw2Api\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FishesController extends AbstractController
{
    #[Route('/api/gw2/fishes', name: 'app_api_gw2_fishes')]
    public function index(ItemRepository $itemRepository): Response
    {
        $fishes = $itemRepository->findFishes();
        return $this->json($fishes);
    }
}

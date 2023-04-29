<?php

namespace App\Controller\Admin\Gw2;

use App\Repository\Gw2Api\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemsController extends AbstractController
{
    #[Route('/admin/gw2/items', name: 'app_admin_gw2_items')]
    public function appAdminGw2Items(ItemRepository $itemRepository): Response
    {
        $items = $itemRepository->adminItems();
        return $this->render('admin/gw2/items/index.html.twig', [
            'items' => $items,
        ]);
    }
}

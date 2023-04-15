<?php

namespace App\Controller\Api\Admin\Gw2;

use App\Repository\Gw2Api\ItemRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
class ItemController extends AbstractController
{
    #[Route('/api/admin/gw2/items', name: 'app_api_admin_gw2_items')]
    public function appApiAdminGw2Items(ItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findAllAdmin();
        return $this->json($items);
    }
}

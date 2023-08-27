<?php

namespace App\Controller\Admin\Palia\Item;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_PALIA')]
class ItemController extends AbstractController
{
    #[Route('/admin/palia/items', name: 'app_admin_palia_items')]
    public function index(): Response
    {
        return $this->render('admin/palia/item/index.html.twig', [
            'controller_name' => 'ItemController',
        ]);
    }
}

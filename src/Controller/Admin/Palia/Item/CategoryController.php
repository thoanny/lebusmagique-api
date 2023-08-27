<?php

namespace App\Controller\Admin\Palia\Item;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_PALIA')]
class CategoryController extends AbstractController
{
    #[Route('/admin/palia/items/categories', name: 'app_admin_palia_items_categories')]
    public function index(): Response
    {
        return $this->render('admin/palia/item/category.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}

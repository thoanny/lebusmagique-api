<?php

namespace App\Controller\Admin\Palia;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_PALIA')]
class RecipeController extends AbstractController
{
    #[Route('/admin/palia/recipes', name: 'app_admin_palia_recipes')]
    public function index(): Response
    {
        return $this->render('admin/palia/recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }
}

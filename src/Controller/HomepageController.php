<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        return $this->render('homepage/index.html.twig');
    }
}

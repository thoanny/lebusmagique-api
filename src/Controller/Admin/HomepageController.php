<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_homepage')]
    public function appAdminHomepage(): Response
    {
        return $this->render('admin/homepage/index.html.twig', []);
    }
}

<?php

namespace App\Controller\Admin\Palia;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_PALIA')]
class LocationController extends AbstractController
{
    #[Route('/admin/palia/locations', name: 'app_admin_palia_locations')]
    public function index(): Response
    {
        return $this->render('admin/palia/location/index.html.twig', [
            'controller_name' => 'LocationController',
        ]);
    }
}

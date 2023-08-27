<?php

namespace App\Controller\Admin\Palia;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_PALIA')]
class CurrencyController extends AbstractController
{
    #[Route('/admin/palia/currencies', name: 'app_admin_palia_currencies')]
    public function index(): Response
    {
        return $this->render('admin/palia/currency/index.html.twig', [
            'controller_name' => 'CurrencyController',
        ]);
    }
}

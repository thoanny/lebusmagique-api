<?php

namespace App\Controller\Admin\Palia\Character;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_PALIA')]
class CharacterController extends AbstractController
{
    #[Route('/admin/palia/characters', name: 'app_admin_palia_characters')]
    public function index(): Response
    {
        return $this->render('admin/palia/character/index.html.twig', [
            'controller_name' => 'CharacterController',
        ]);
    }
}

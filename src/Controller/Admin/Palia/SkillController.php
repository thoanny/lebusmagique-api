<?php

namespace App\Controller\Admin\Palia;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_PALIA')]
class SkillController extends AbstractController
{
    #[Route('/admin/palia/skills', name: 'app_admin_palia_skills')]
    public function index(): Response
    {
        return $this->render('admin/palia/skill/index.html.twig', [
            'controller_name' => 'SkillController',
        ]);
    }
}

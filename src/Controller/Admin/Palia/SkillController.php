<?php

namespace App\Controller\Admin\Palia;

use App\Entity\Palia\Skill;
use App\Form\Admin\Palia\SkillType;
use App\Repository\Palia\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_PALIA')]
class SkillController extends AbstractController
{
    #[Route('/admin/palia/skills/{id}', name: 'app_admin_palia_skills', defaults: ['id' => null])]
    public function index(SkillRepository $skillRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        $skills = $skillRepository->findAll();

        if($id) {
            $skill = $skillRepository->findOneBy(['id' => $id]);

            if(!$skill) {
                $this->addFlash('error', 'Compétence introuvable...');
                return $this->redirectToRoute('app_admin_palia_skills');
            }
        } else {
            $skill = new Skill();
        }

        $form = $this->createForm(SkillType::class, $skill);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $skill = $form->getData();

            $em->persist($skill);
            $em->flush();

            $this->addFlash('success', 'Localisation enregistrée');
            return $this->redirectToRoute('app_admin_palia_skills');
        }

        return $this->render('admin/palia/skill/index.html.twig', [
            'skills' => $skills,
            'skill' => $skill,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/palia/skills/delete/{id}', name: 'app_admin_palia_skill_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminPaliaSkillDelete(SkillRepository $skillRepository, EntityManagerInterface $em, $id): RedirectResponse
    {
        if(!$id) {
            $this->addFlash('error', 'Compétence introuvable...');
            return $this->redirectToRoute('app_admin_palia_skills');
        }

        $skill = $skillRepository->findOneBy(['id' => $id]);
        if(!$skill) {
            $this->addFlash('error', 'Compétence introuvable...');
            return $this->redirectToRoute('app_admin_palia_skills');
        }

        $em->remove($skill);
        $em->flush();

        $this->addFlash('success', 'Compétence supprimée');
        return $this->redirectToRoute('app_admin_palia_skills');
    }
}

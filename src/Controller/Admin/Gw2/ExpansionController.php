<?php

namespace App\Controller\Admin\Gw2;

use App\Entity\Gw2\Expansion;
use App\Form\Admin\Gw2\ExpansionType;
use App\Repository\Gw2\ExpansionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExpansionController extends AbstractController
{
    #[Route('/admin/gw2/expansions/{id}', name: 'app_admin_gw2_expansions', defaults: ['id' => null])]
    public function appAdminGw2Expansions(ExpansionRepository $expansionRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        $expansions = $expansionRepository->findAll();

        if($id) {
            $expansion = $expansionRepository->findOneBy(['id' => $id]);

            if(!$expansion) {
                $this->addFlash('error', 'Extension introuvable...');
                return $this->redirectToRoute('app_admin_gw2_expansions');
            }
        } else {
            $expansion = new Expansion();
        }

        $form = $this->createForm(ExpansionType::class, $expansion);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $expansion = $form->getData();

            $em->persist($expansion);
            $em->flush();

            $this->addFlash('success', 'Extension enregistrée');
            return $this->redirectToRoute('app_admin_gw2_expansions');
        }

        return $this->render('admin/gw2/expansion/index.html.twig', [
            'expansions' => $expansions,
            'expansion' => $expansion,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/gw2/expansions/delete/{id}', name: 'app_admin_gw2_expansion_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminGw2ExpansionDelete(ExpansionRepository $expansionRepository, EntityManagerInterface $em, $id): RedirectResponse
    {
        if(!$id) {
            $this->addFlash('error', 'Extension introuvable...');
            return $this->redirectToRoute('app_admin_gw2_expansions');
        }

        $expansion = $expansionRepository->findOneBy(['id' => $id]);
        if(!$expansion) {
            $this->addFlash('error', 'Extension introuvable...');
            return $this->redirectToRoute('app_admin_gw2_expansions');
        }

        $em->remove($expansion);
        $em->flush();

        $this->addFlash('success', 'Extension supprimée');
        return $this->redirectToRoute('app_admin_gw2_expansions');
    }
}

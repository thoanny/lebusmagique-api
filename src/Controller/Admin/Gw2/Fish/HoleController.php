<?php

namespace App\Controller\Admin\Gw2\Fish;

use App\Entity\Gw2\Fish\Hole;
use App\Form\Admin\Gw2\Fish\HoleType;
use App\Repository\Gw2\Fish\HoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_GW2')]
class HoleController extends AbstractController
{
    #[Route('/admin/gw2/fish/holes', name: 'app_admin_gw2_fish_holes')]
    public function appAdminGw2FishHoles(HoleRepository $holeRepository): Response
    {
        $holes = $holeRepository->findAll();
        return $this->render('admin/gw2/fish/hole/index.html.twig', [
            'holes' => $holes,
        ]);
    }

    #[Route('/admin/gw2/fish/holes/edit/{id}', name: 'app_admin_gw2_fish_hole_edit', defaults: ['id' => null])]
    public function appAdminGw2FishHoleEdit($id, HoleRepository $holeRepository, Request $request, EntityManagerInterface $em): Response
    {
        if($id) {
            $hole = $holeRepository->findOneBy(['id' => $id]);

            if(!$hole) {
                $this->addFlash('error', 'Zone de pêche introuvable');
                return $this->redirectToRoute('app_admin_gw2_fish_holes');
            }
        } else {
            $hole = new Hole();
        }

        $form = $this->createForm(HoleType::class, $hole);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hole = $form->getData();
            $em->persist($hole);
            $em->flush();

            $this->addFlash('success', 'Zone de pêche enregistrée');
            return $this->redirectToRoute('app_admin_gw2_fish_holes');
        }

        return $this->render('admin/gw2/fish/hole/edit.html.twig', [
            'hole' => $hole,
            'form' => $form->createView()
        ]);
    }
}

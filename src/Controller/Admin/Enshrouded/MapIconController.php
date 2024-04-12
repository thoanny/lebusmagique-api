<?php

namespace App\Controller\Admin\Enshrouded;

use App\Entity\Enshrouded\MapIcon;
use App\Form\Admin\Enshrouded\MapIconType;
use App\Repository\Enshrouded\MapIconRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/enshrouded/map/icons')]
class MapIconController extends AbstractController
{
    #[Route('/', name: 'app_admin_enshrouded_map_icon_index', methods: ['GET'])]
    public function index(MapIconRepository $mapIconRepository): Response
    {
        return $this->render('admin/enshrouded/map_icon/index.html.twig', [
            'map_icons' => $mapIconRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_enshrouded_map_icon_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mapIcon = new MapIcon();
        $form = $this->createForm(MapIconType::class, $mapIcon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mapIcon);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_enshrouded_map_icon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/map_icon/new.html.twig', [
            'map_icon' => $mapIcon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_map_icon_show', methods: ['GET'])]
    public function show(MapIcon $mapIcon): Response
    {
        return $this->render('admin/enshrouded/map_icon/show.html.twig', [
            'map_icon' => $mapIcon,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_enshrouded_map_icon_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MapIcon $mapIcon, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MapIconType::class, $mapIcon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_enshrouded_map_icon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/map_icon/edit.html.twig', [
            'map_icon' => $mapIcon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_map_icon_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, MapIcon $mapIcon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mapIcon->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mapIcon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_enshrouded_map_icon_index', [], Response::HTTP_SEE_OTHER);
    }
}

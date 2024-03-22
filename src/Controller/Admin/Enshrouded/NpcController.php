<?php

namespace App\Controller\Admin\Enshrouded;

use App\Entity\Enshrouded\Npc;
use App\Form\Admin\Enshrouded\NpcType;
use App\Repository\Enshrouded\NpcRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/enshrouded/npcs')]
class NpcController extends AbstractController
{
    #[Route('/', name: 'app_admin_enshrouded_npc_index', methods: ['GET'])]
    public function index(NpcRepository $npcRepository): Response
    {
        return $this->render('admin/enshrouded/npc/index.html.twig', [
            'npcs' => $npcRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_enshrouded_npc_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $npc = new Npc();
        $form = $this->createForm(NpcType::class, $npc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($npc);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_enshrouded_npc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/npc/new.html.twig', [
            'npc' => $npc,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_npc_show', methods: ['GET'])]
    public function show(Npc $npc): Response
    {
        return $this->render('admin/enshrouded/npc/show.html.twig', [
            'npc' => $npc,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_enshrouded_npc_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Npc $npc, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NpcType::class, $npc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_enshrouded_npc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/npc/edit.html.twig', [
            'npc' => $npc,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_npc_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Npc $npc, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$npc->getId(), $request->request->get('_token'))) {
            $entityManager->remove($npc);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_enshrouded_npc_index', [], Response::HTTP_SEE_OTHER);
    }
}

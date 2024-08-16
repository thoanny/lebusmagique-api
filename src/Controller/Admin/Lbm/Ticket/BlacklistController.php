<?php

namespace App\Controller\Admin\Lbm\Ticket;

use App\Entity\Lbm\Ticket\Blacklist;
use App\Form\Admin\Lbm\Ticket\BlacklistType;
use App\Repository\Lbm\Ticket\BlacklistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/lbm/tickets/blacklist')]
class BlacklistController extends AbstractController
{
    #[Route('/', name: 'app_admin_lbm_ticket_blacklist_index', methods: ['GET'])]
    public function index(BlacklistRepository $blacklistRepository): Response
    {
        return $this->render('admin/lbm/ticket/blacklist/index.html.twig', [
            'blacklists' => $blacklistRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_lbm_ticket_blacklist_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $blacklist = new Blacklist();
        $form = $this->createForm(BlacklistType::class, $blacklist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // TODO : setUser && setCreatedAt
            $entityManager->persist($blacklist);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_lbm_ticket_blacklist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lbm/ticket/blacklist/new.html.twig', [
            'blacklist' => $blacklist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_lbm_ticket_blacklist_show', methods: ['GET'])]
    public function show(Blacklist $blacklist): Response
    {
        return $this->render('admin/lbm/ticket/blacklist/show.html.twig', [
            'blacklist' => $blacklist,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_lbm_ticket_blacklist_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blacklist $blacklist, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlacklistType::class, $blacklist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_lbm_ticket_blacklist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lbm/ticket/blacklist/edit.html.twig', [
            'blacklist' => $blacklist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_lbm_ticket_blacklist_delete', methods: ['POST'])]
    public function delete(Request $request, Blacklist $blacklist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blacklist->getId(), $request->request->get('_token'))) {
            $entityManager->remove($blacklist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_lbm_ticket_blacklist_index', [], Response::HTTP_SEE_OTHER);
    }
}

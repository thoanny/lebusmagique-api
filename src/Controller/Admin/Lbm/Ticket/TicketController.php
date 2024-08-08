<?php

namespace App\Controller\Admin\Lbm\Ticket;

use App\Entity\Lbm\Ticket\Ticket;
use App\Repository\Lbm\Ticket\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/lbm/tickets/tickets')]
class TicketController extends AbstractController
{
    #[Route('/', name: 'app_admin_lbm_ticket_ticket_index', methods: ['GET'])]
    public function index(TicketRepository $ticketRepository): Response
    {
        return $this->render('admin/lbm/ticket/ticket/index.html.twig', [
            'tickets' => $ticketRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_lbm_ticket_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket): Response
    {
        return $this->render('admin/lbm/ticket/ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_lbm_ticket_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_lbm_ticket_ticket_index', [], Response::HTTP_SEE_OTHER);
    }
}

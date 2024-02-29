<?php

namespace App\Controller\Admin\Lbm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    #[Route('/admin/lbm/tickets/requests', name: 'app_admin_lbm_tickets_requests')]
    public function appAdminLbmTicketsRequests(): Response
    {
        return $this->render('admin/lbm/ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }

    #[Route('/admin/lbm/tickets/blacklist', name: 'app_admin_lbm_tickets_blacklist')]
    public function appAdminLbmTicketsBlacklist(): Response
    {
        return $this->render('admin/lbm/ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }

    #[Route('/admin/lbm/tickets/validate', name: 'app_admin_lbm_tickets_validate')]
    public function appAdminLbmTicketsValidate(): Response
    {
        return $this->render('admin/lbm/ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }

    #[Route('/admin/lbm/tickets/guilds', name: 'app_admin_lbm_tickets_guilds')]
    public function appAdminLbmTicketsGuilds(): Response
    {
        return $this->render('admin/lbm/ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }
}

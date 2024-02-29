<?php

namespace App\Controller\Api\Lbm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class TicketController extends AbstractController
{
    #[Route('/api/lbm/tickets/validate', name: 'app_api_lbm_tickets_validate', methods: ['POST'])]
    #[OA\Tag(name: 'LBM')]
    public function appApiLbmTicketsValidate(): JsonResponse
    {
        return $this->json([]);
    }

    #[Route('/api/lbm/tickets/request', name: 'app_api_lbm_tickets_request', methods: ['POST'])]
    #[OA\Tag(name: 'LBM')]
    public function appApiLbmTicketsRequest(): JsonResponse
    {
        return $this->json([]);
    }

    #[Route('/api/lbm/tickets/check', name: 'app_api_lbm_tickets_check', methods: ['POST'])]
    #[OA\Tag(name: 'LBM')]
    public function appApiLbmTicketsCheck(): JsonResponse
    {
        return $this->json([]);
    }

    #[Route('/api/lbm/tickets/guilds', name: 'app_api_lbm_tickets_guilds', methods: ['GET'])]
    #[OA\Tag(name: 'LBM')]
    public function appApiLbmTicketsGuilds(): JsonResponse
    {
        return $this->json([]);
    }
}

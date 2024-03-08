<?php

namespace App\Controller\Api\Lbm;

use App\Repository\Lbm\Ticket\GuildRepository;
use App\Service\Api;
use App\Service\Gw2Api;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\SerializerInterface;

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
    public function appApiLbmTicketsRequest(Request $request, Api $api, Gw2Api $gw2Api, EntityManagerInterface $em, GuildRepository $guildRepository): JsonResponse
    {
        $request = $api->transformJsonBody($request);
        $token = $request->get('token');
        $email = $request->get('email');
        $guild = $request->get('guild');

        if(empty($token) || empty($email) || empty($guild)) {
            return $api->respondBadRequest("Token, Email and Guild are required");
        }

        $guildExists = $guildRepository->findOneBy(['uid' => $guild]);
        if(!$guildExists) {
            return $api->respondNotFound("Guild not found");
        }

        $account = $gw2Api->getAccount($token);

        if(!$account) {
            // TODO : gérer les différents codes d'erreur
            return $api->respondBadRequest("Guild Wars 2 API error");
        }

        $ticketRequest = (new \App\Entity\Lbm\Ticket\Request())
            ->setEmail($email)
            ->setAccountName($account['name'])
            ->setAccountAge($account['age'])
            ->setAccountAccess($account['access'])
            ->setAccountGuilds($account['guilds'])
            ->setStatus('pending')
            ->setEmailSent(false)
            ->setCreatedAt(new \DateTimeImmutable())
        ;

        $em->persist($ticketRequest);
        $em->flush();

        return $api->respondCreated('Ticket request successfully created');
    }

    #[Route('/api/lbm/tickets/check', name: 'app_api_lbm_tickets_check', methods: ['POST'])]
    #[OA\Tag(name: 'LBM')]
    public function appApiLbmTicketsCheck(): JsonResponse
    {
        return $this->json([]);
    }

    #[Route('/api/lbm/tickets/guilds', name: 'app_api_lbm_tickets_guilds', methods: ['GET'])]
    #[OA\Tag(name: 'LBM')]
    public function appApiLbmTicketsGuilds(GuildRepository $guildRepository, SerializerInterface $serializer): JsonResponse
    {
        $guilds = $guildRepository->findBy(['active' => true], ['sortOrder' => 'ASC', 'name' => 'ASC']);
        return new JsonResponse($serializer->serialize($guilds, 'json', ['groups' => ['api']]), 200, [], true);
    }
}

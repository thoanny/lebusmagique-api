<?php

namespace App\Controller\Api\Lbm;

use App\Entity\Lbm\Ticket\Ticket;
use App\Repository\Lbm\Ticket\GuildRepository;
use App\Repository\Lbm\Ticket\TicketRepository;
use App\Service\Api;
use App\Service\Gw2Api;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TicketController extends AbstractController
{
    #[Route('/api/lbm/tickets/validate', name: 'app_api_lbm_tickets_validate', methods: ['POST'])]
    public function appApiLbmTicketsValidate(): JsonResponse
    {
        return $this->json([]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/api/lbm/tickets/new', name: 'app_api_lbm_tickets_new', methods: ['POST'])]
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

        // TODO : vérifier qu'il n'est pas blacklisté
        // TODO : vérifier qu'il n'existe pas une demande avec cette adresse e-mail+guilde
        // TODO : vérifier qu'il n'existe pas une demande avec ce nom de compte+guilde

        $guilds = $gw2Api->getAccountGuildsName($account['guilds']);

        $ticketRequest = (new Ticket())
            ->setEmail($email)
            ->setAccountName($account['name'])
            ->setAccountCreated(new \DateTime($account['created']))
            ->setAccountAccess($account['access'])
            ->setAccountGuilds($guilds)
            ->setGuild($guildExists)
            ->setStatus('pending')
            ->setEmailSent(false)
            ->setCreatedAt(new \DateTimeImmutable())
        ;

        $em->persist($ticketRequest);
        $em->flush();

        return new JsonResponse([
            'accountname' => $account['name'],
            'email' => $email
        ], 201);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/api/lbm/tickets/check', name: 'app_api_lbm_tickets_check', methods: ['POST'])]
    public function appApiLbmTicketsCheck(Request $request, Api $api, TicketRepository $ticketRepository): JsonResponse
    {
        $request = $api->transformJsonBody($request);
        $accountName = $request->get('accountname');
        $email = $request->get('email');

        $data = [];

        $tickets = $ticketRepository->findBy(['accountName' => $accountName, 'email' => $email], ['id' => 'DESC']);
        foreach($tickets as $ticket) {
            $previous = $ticketRepository->countPreviousTickets($ticket->getId(), $ticket->getGuild()->getId());
            $data[] = [
                'guild' => $ticket->getGuild()->getName(),
                'status' => $ticket->getStatus(),
                'previous' => $previous
            ];
        }

        return new JsonResponse([
            'accountname' => $accountName,
            'email' => $email,
            'data' => $data
        ]);
    }

    #[Route('/api/lbm/tickets/guilds', name: 'app_api_lbm_tickets_guilds', methods: ['GET'])]
    public function appApiLbmTicketsGuilds(GuildRepository $guildRepository, SerializerInterface $serializer): JsonResponse
    {
        $guilds = $guildRepository->findBy(['active' => true], ['sortOrder' => 'ASC', 'name' => 'ASC']);
        return new JsonResponse($serializer->serialize($guilds, 'json', ['groups' => ['api']]), 200, [], true);
    }
}

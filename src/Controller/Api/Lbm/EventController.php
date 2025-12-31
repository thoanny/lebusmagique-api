<?php

namespace App\Controller\Api\Lbm;

use App\Repository\Lbm\Event\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class EventController extends AbstractController
{
    // TODO : https://www.youtube.com/watch?v=SlF9Wxyx0O8

    #[Route('/api/lbm/events', name: 'app_api_lbm_event')]
    public function index(SerializerInterface $serializer, EventRepository $eventRepository): JsonResponse
    {
        $events = $eventRepository->findNextEvents();
        return new JsonResponse($serializer->serialize($events, 'json', ['groups' => 'api']), json: true);
    }
}

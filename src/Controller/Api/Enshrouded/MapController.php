<?php

namespace App\Controller\Api\Enshrouded;

use App\Repository\Enshrouded\MapCategoryRepository;
use App\Repository\Enshrouded\MapMarkerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

class MapController extends AbstractController
{
    #[Route('/api/enshrouded/map', name: 'app_api_enshrouded_map', methods: ['GET'])]
    #[OA\Tag(name: 'Enshrouded')]
    public function index(SerializerInterface $serializer, MapCategoryRepository $mapCategoryRepository, MapMarkerRepository $mapMarkerRepository): JsonResponse
    {
        $categories = $mapCategoryRepository->findBy([], ['name' => 'ASC']);
        return new JsonResponse($serializer->serialize($categories, 'json', ['groups' => ['api']]), 200, [], true);
    }
}

<?php

namespace App\Controller\Api\Palia;

use App\Repository\Palia\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CharacterController extends AbstractController
{
    #[Route('/api/palia/characters', name: 'app_api_palia_characters')]
    public function appApiPaliaCharacters(CharacterRepository $characterRepository, SerializerInterface $serializer): JsonResponse
    {
        $characters = $characterRepository->findAll();
        return new JsonResponse($serializer->serialize($characters, 'json', ['groups' => ['api']]), 200, [], true);
    }

    #[Route('/api/palia/characters/{slug}', name: 'app_api_palia_character')]
    public function appApiPaliaCharacter($slug, CharacterRepository $characterRepository, SerializerInterface $serializer): JsonResponse
    {
        $character = $characterRepository->findOneBy(['slug' => $slug]);
        return new JsonResponse($serializer->serialize($character, 'json', ['groups' => ['api']]), 200, [], true);
    }
}

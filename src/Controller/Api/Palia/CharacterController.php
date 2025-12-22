<?php

namespace App\Controller\Api\Palia;

use App\Repository\Palia\CharacterRepository;
use App\Service\ImageEncoded;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

class CharacterController extends AbstractController
{
    #[Route('/api/palia/characters', name: 'app_api_palia_characters', methods: ['GET'])]
    #[OA\Tag(name: 'Palia')]
    public function appApiPaliaCharacters(CharacterRepository $characterRepository, SerializerInterface $serializer, ImageEncoded $imageEncoded): JsonResponse
    {
        $characters = $characterRepository->findBy([], ['name' => 'ASC']);
        foreach($characters as $character) {
            $character->setAvatarEncoded($imageEncoded->get($character->getAvatar(), '/uploads/api/palia/characters/avatars/', 'palia_character_avatar'));
            $character->setIllustrationEncoded($imageEncoded->get($character->getIllustration(), '/uploads/api/palia/characters/illustrations/', 'palia_character_illustration'));
            foreach($character->getWishes() as $wish) {
                $wish->getItem()->setIconEncoded($imageEncoded->get($wish->getItem()->getIcon(), '/uploads/api/palia/items/', 'palia_item_icon'));
            }
        }
        return new JsonResponse($serializer->serialize($characters, 'json', ['groups' => ['api']]), 200, [], true);
    }

    #[Route('/api/palia/characters/{slug}', name: 'app_api_palia_character', methods: ['GET'])]
    #[OA\Tag(name: 'Palia')]
    public function appApiPaliaCharacter($slug, CharacterRepository $characterRepository, SerializerInterface $serializer, ImageEncoded $imageEncoded): JsonResponse
    {
        $character = $characterRepository->findOneBy(['slug' => $slug]);
        $character->setAvatarEncoded($imageEncoded->get($character->getAvatar(), '/uploads/api/palia/characters/avatars/', 'palia_character_avatar'));
        $character->setIllustrationEncoded($imageEncoded->get($character->getIllustration(), '/uploads/api/palia/characters/illustrations/', 'palia_character_illustration'));
        foreach($character->getWishes() as $wish) {
            $wish->getItem()->setIconEncoded($imageEncoded->get($wish->getItem()->getIcon(), '/uploads/api/palia/items/', 'palia_item_icon'));
        }
        return new JsonResponse($serializer->serialize($character, 'json', ['groups' => ['api', 'character']]), 200, [], true);
    }
}

<?php

namespace App\Controller\Api\Gw2;

use App\Repository\Gw2Api\WizardVaultObjectiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class WizardVaultController extends AbstractController
{
    #[Route('/api/gw2/wizard-vault/objectives', name: 'app_api_gw2_wizard_vault_objectives')]
    public function index(WizardVaultObjectiveRepository $objectiveRepository, SerializerInterface $serializer): JsonResponse
    {
        $objectives = $objectiveRepository->findBy(['active' => true], ['title' => 'ASC']);
        return new JsonResponse($serializer->serialize($objectives, 'json', ['groups' => ['api']]), 200, [], true);
    }
}

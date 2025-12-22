<?php

namespace App\Controller\Api\Gw2;

use App\Repository\Gw2Api\WizardVaultObjectiveRepository;
use App\Service\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

class WizardVaultController extends AbstractController
{
    #[Route('/api/gw2/wizard-vault/objectives', name: 'app_api_gw2_wizard_vault_objectives', methods: ['POST'])]
    #[OA\Tag(name: 'GW2')]
    public function appApiGw2WizardVaultObjectives(WizardVaultObjectiveRepository $objectiveRepository, SerializerInterface $serializer, Api $api, Request $request): JsonResponse
    {
        $request = $api->transformJsonBody($request);
        $ids = $request->get('ids');

        $objectives = $objectiveRepository->findBy(['uid' => $ids], ['title' => 'ASC']);
        return new JsonResponse($serializer->serialize($objectives, 'json', ['groups' => ['api']]), 200, [], true);
    }
}

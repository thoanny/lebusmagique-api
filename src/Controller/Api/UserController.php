<?php

namespace App\Controller\Api;

use App\Service\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class UserController extends AbstractController
{
    #[Route('/api/user', name: 'app_api_user', methods: ['GET'])]
    #[OA\Tag(name: 'Authentication')]
    public function appApiUser(Api $api): Response
    {
        return $api->response($this->getUser()->toArray());
    }
}

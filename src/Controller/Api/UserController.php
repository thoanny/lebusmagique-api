<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use App\Service\Api;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class UserController extends AbstractController
{
    #[Route('/api/user', name: 'app_api_user', methods: ['GET'])]
    public function appApiUser(Api $api): Response
    {
        return $api->response($this->getUser()->toArray());
    }
}

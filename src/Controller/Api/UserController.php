<?php

namespace App\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class UserController extends AbstractController
{
    protected ApiController $api;

    public function __construct(ApiController $api) {
        $this->api = $api;
    }

    #[Route('/api/user', name: 'app_api_user')]
    public function appApiUser(): Response
    {
        return $this->api->response($this->getUser()->toArray());
    }
}

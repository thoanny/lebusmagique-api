<?php

namespace App\Controller\Api\Admin;

use App\Repository\UserRepository;
use App\Service\Api;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
class UserController extends AbstractController
{
    #[Route('/api/admin/users', name: 'app_api_admin_users')]
    public function appApiAdminUsers(Api $api, UserRepository $userRepository): Response
    {
        $users = $userRepository->api_findAll();
        return $api->response($users);
    }
}

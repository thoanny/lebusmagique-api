<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/admin/users', name: 'app_admin_users')]
    public function appAdminUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->adminUsers();
        return $this->render('admin/users/index.html.twig', [
            'users' => $users,
        ]);
    }
}

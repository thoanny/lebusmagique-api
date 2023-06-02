<?php

namespace App\Controller\Admin;

use App\Form\Admin\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
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

    #[Route('/admin/users/edit/{id}', name: 'app_admin_user_edit')]
    public function appAdminUserEdit($id, UserRepository $userRepository, Request $request, EntityManagerInterface $em): Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);
        if(!$user) {
            $this->addFlash('error', 'Utilisateur introuvable');
            return $this->redirectToRoute('app_admin_users');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Utilisateur enregistré');
            return $this->redirectToRoute('app_admin_users');
        }

        return $this->render('admin/users/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

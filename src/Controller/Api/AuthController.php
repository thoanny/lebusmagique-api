<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Api;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     */
    #[Route('/api/register', name: 'app_api_register', methods: ['POST'])]
    public function appApiRegister(Request $request, UserPasswordHasherInterface $hasher, UserRepository $userRepository, EntityManagerInterface $em, Api $api): JsonResponse
    {
        $request = $api->transformJsonBody($request);
        $password = $request->get('password');
        $email = $request->get('email');
        $nickname = $request->get('nickname');

        if(empty($password) || empty($email) || empty($nickname)) {
            return $api->respondBadRequest("Password, Email and Nickname are required");
        }

        $exists = $userRepository->findByEmailOrNickname($email, $nickname);
        if($exists) {
            return $api->respondConflict("Email or Nickname already used");
        }

        $user = new User();
        $user->setPassword($hasher->hashPassword($user, $password));
        $user->setEmail($email);
        $user->setNickname($nickname);
        $user->setCreatedAt(new \DateTimeImmutable());

        $em->persist($user);
        $em-> flush();

        return $api->respondCreated(sprintf('Users %s successfully created', $user->getNickname()));
    }

    #[Route('api/logout', name:'app_api_logout')]
    public function appApiLogout(){}

}

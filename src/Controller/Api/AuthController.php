<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{

    private EntityManagerInterface $em;
    private ApiController $api;

    public function __construct(EntityManagerInterface $em, ApiController $api)
    {
        $this->em = $em;
        $this->api = $api;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/api/register', name: 'app_api_register', methods: ['POST'])]
    public function appApiRegister(Request $request, UserPasswordHasherInterface $hasher, UserRepository $userRepository): JsonResponse
    {
        $request = $this->api->transformJsonBody($request);
        $password = $request->get('password');
        $email = $request->get('email');
        $nickname = $request->get('nickname');

        if(empty($password) || empty($email) || empty($nickname)) {
            return $this->api->respondValidationError("Empty Password, Email or Nickname");
        }

        $exists = $userRepository->findByEmailOrNickname($email, $nickname);
        if($exists) {
            return $this->api->respondValidationError("Email or Nickname already used");
        }

        $user = new User();
        $user->setPassword($hasher->hashPassword($user, $password));
        $user->setEmail($email);
        $user->setNickname($nickname);
        $user->setCreatedAt(new \DateTimeImmutable());

        $this->em->persist($user);
        $this->em-> flush();

        return $this->api->respondWithSuccess(sprintf('User %s successfully created', $user->getNickname()));
    }

}

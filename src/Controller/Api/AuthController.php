<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/api/register', name: 'app_api_register', methods: ['POST'])]
    public function appApiRegister(Request $request, UserPasswordHasherInterface $hasher, UserRepository $userRepository): JsonResponse
    {
        $request = $this->api->transformJsonBody($request);
        $password = $request->get('password');
        $email = $request->get('email');

        if (empty($password) || empty($email)) {
            return $this->api->respondValidationError("Invalid Password or Email");
        }

        $exists = $userRepository->findOneBy(['email' => $email]);
        if($exists) {
            return $this->api->respondValidationError("Email already used");
        }

        $user = new User();
        $user->setPassword($hasher->hashPassword($user, $password));
        $user->setEmail($email);
        $user->setCreatedAt(new \DateTimeImmutable());
        $this->em->persist($user);
        $this->em-> flush();
        return $this->api->respondWithSuccess(sprintf('User %s successfully created', $user->getEmail()));
    }

}

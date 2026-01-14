<?php

namespace App\Controller\User;

use App\Repository\Genshin\Map\UserMarkerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

final class AccountController extends AbstractController
{
    public function __construct(private UserMarkerRepository $userMarkerRepository)
    {
    }

    #[Route('/user/account/delete', name: 'app_user_account_delete')]
    public function user_account_delete(EntityManagerInterface $entityManager): RedirectResponse
    {
        $user = $this->getUser();

        $markers = $this->userMarkerRepository->findBy(['user' => $user]);
        foreach($markers as $marker) {
            $entityManager->remove($marker);
        }

        $entityManager->remove($user);

        $entityManager->flush();

        return $this->redirectToRoute('app_homepage');
    }
}

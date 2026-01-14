<?php

namespace App\Controller\User;

use App\Repository\Genshin\Map\UserMarkerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/genshin-impact')]
final class GenshinController extends AbstractController
{
    #[Route('/map-markers-reset', name: 'app_user_genshin_map_markers_reset')]
    public function map_markers_reset(UserMarkerRepository $userMarkerRepository, EntityManagerInterface $entityManager): RedirectResponse
    {
        $user = $this->getUser();
        $userMarkers = $userMarkerRepository->findBy(['user' => $user]);
        foreach($userMarkers as $um) {
            $entityManager->remove($um);
        }

        $entityManager->flush();

        $this->addFlash('success', 'Les marqueurs Genshin Impact ont bien été supprimés.');
        return $this->redirectToRoute('app_homepage');
    }
}

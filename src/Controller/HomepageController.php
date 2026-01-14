<?php

namespace App\Controller;

use App\Repository\Genshin\Map\UserMarkerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HomepageController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/', name: 'app_homepage')]
    #[IsGranted('ROLE_USER')]
    public function index(EntityManagerInterface $entityManager, UserMarkerRepository $genshinUserMarkerRepository): Response
    {
        $user = $this->getUser();
        $genshinMapUserMarkers = $genshinUserMarkerRepository->getUserMarkersCount($user);
        return $this->render('homepage/index.html.twig', [
            'genshin_map_user_markers' => $genshinMapUserMarkers,
        ]);
    }
}

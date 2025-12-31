<?php

namespace App\Controller\Admin;

use App\Repository\Genshin\Map\GroupRepository;
use App\Repository\Genshin\Map\IconRepository;
use App\Repository\Genshin\Map\MapRepository;
use App\Repository\Genshin\Map\MarkerRepository;
use App\Repository\Genshin\Map\SectionRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/admin-old', name: 'app_admin_homepage')]
    public function appAdminHomepage(
        MapRepository $mapRepository,
        SectionRepository $sectionRepository,
        GroupRepository $groupRepository,
        MarkerRepository $markerRepository,
        IconRepository $iconRepository
    ): Response
    {
        $stats = [
            // TODO : ajouter les stats
            'lbm' => [
                'events' => 0,
                'users' => 0,
            ],
            'gw2' => [
                'builds' => 0,
                'maps' => [
                    'markers' => 0
                ],
                'api' => [
                    'items' => 0
                ],
                'universe' => [
                    'stories' => 0,
                    'creators' => 0,
                    'videos' => 0,
                ]
            ],
            'genshin' => [
                'maps' => [
                    'maps' => $mapRepository->getCount(),
                    'sections' => $sectionRepository->getCount(),
                    'groups' => $groupRepository->getCount(),
                    'markers' => $markerRepository->getCount(),
                    'icons' => $iconRepository->getCount(),
                ]
            ]
        ];

        return $this->render('admin/homepage/index.html.twig', [
            'stats' => $stats
        ]);
    }
}

<?php

namespace App\Controller\Api\Gw2;

use App\Repository\Gw2\Fish\DailyRepository;
use App\Repository\Gw2Api\ItemRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FishesController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     */
    #[Route('/api/gw2/fishes', name: 'app_api_gw2_fishes', methods: ['GET'])]
    public function index(ItemRepository $itemRepository, DailyRepository $dailyRepository): Response
    {
        $fishes = $itemRepository->findFishes();
        $data = [
            'daily' => null,
            'fishes' => []
        ];

        $daily = $dailyRepository->findTodayFish();
        if($daily) {
            $fish = $daily->getFish();
            $data['daily'] = [
                'day' => ($daily->getDay())->format('Y-m-d'),
                'uid' => $fish->getUid(),
                'name' => $fish->getName(),
                'rarity' => $fish->getRarity(),
                'power' => $fish->getFishPower(),
                'time' => $fish->getFishTime(),
                'achievement' => null,
                'bait' => null,
                'hole' => null,
            ];

            if($achievement = $fish->getFishAchievement()) {
                $data['daily']['achievement'] = [
                    'uid' => $achievement->getAchievementId(),
                    'repeatUid' => $achievement->getAchievementRepeatId(),
                    'name' => $achievement->getName(),
                    'maps' => [],
                ];

                if($maps = $achievement->getMaps()) {
                    foreach($maps as $m) {
                        $data['daily']['achievement']['maps'][] = [
                            'uid' => $m->getMapId(),
                            'name' => $m->getName(),
                        ];
                    }
                }
            }

            if($bait = $fish->getFishBaitItem()) {
                $data['daily']['bait'] = [
                    'uid' => $bait->getUid(),
                    'name' => $bait->getName(),
                    'rarity' => $bait->getRarity(),
                    'power' => $bait->getFishBaitPower()
                ];
            }

            if($hole = $fish->getFishHole()) {
                $data['daily']['hole'] = [
                    'id' => $hole->getId(),
                    'name' => $hole->getName()
                ];
            }
        }

        foreach($fishes as $k => $fish) {
            $data['fishes'][$k] = [
                'uid' => $fish->getUid(),
                'name' => $fish->getName(),
                'rarity' => $fish->getRarity(),
                'power' => $fish->getFishPower(),
                'time' => $fish->getFishTime(),
                'specialization' => $fish->getFishSpecialization(),
                'strangeDiet' => $fish->isFishStrangeDietAchievement(),
                'achievement' => null,
                'bait' => null,
                'hole' => null
            ];

            if($achievement = $fish->getFishAchievement()) {
                $data['fishes'][$k]['achievement'] = [
                    'uid' => $achievement->getAchievementId(),
                    'repeatUid' => $achievement->getAchievementRepeatId(),
                    'name' => $achievement->getName(),
                    'maps' => []
                ];

                if($maps = $fish->getFishAchievement()->getMaps()) {
                    foreach($maps as $m) {
                        $data['fishes'][$k]['achievement']['maps'][] = [
                            'uid' => $m->getMapId(),
                            'name' => $m->getName(),
                        ];
                    }
                }
            }

            if($bait = $fish->getFishBaitItem()) {
                $data['fishes'][$k]['bait'] = [
                    'uid' => $bait->getUid(),
                    'name' => $bait->getName(),
                    'rarity' => $bait->getRarity(),
                    'power' => $bait->getFishBaitPower()
                ];
            }

            if($hole = $fish->getFishHole()) {
                $data['fishes'][$k]['hole'] = [
                    'id' => $hole->getId(),
                    'name' => $hole->getName()
                ];
            }
        }

        return $this->json($data);
    }
}

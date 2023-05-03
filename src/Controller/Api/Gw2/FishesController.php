<?php

namespace App\Controller\Api\Gw2;

use App\Repository\Gw2Api\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FishesController extends AbstractController
{
    #[Route('/api/gw2/fishes', name: 'app_api_gw2_fishes')]
    public function index(ItemRepository $itemRepository): Response
    {
        $fishes = $itemRepository->findFishes();
        $data = [];

        foreach($fishes as $k => $fish) {
            $data[$k] = [
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
                $data[$k]['achievements'] = [
                    'uid' => $achievement->getAchievementId(),
                    'repeatUid' => $achievement->getAchievementRepeatId(),
                    'name' => $achievement->getName(),
                    'maps' => []
                ];

                if($maps = $fish->getFishAchievement()->getMaps()) {
                    foreach($maps as $m) {
                        $data[$k]['achievements']['maps'][] = $m->getMapId();
                    }
                }
            }

            if($bait = $fish->getFishBaitItem()) {
                $data[$k]['bait'] = [
                    'uid' => $bait->getUid(),
                    'name' => $bait->getName(),
                    'rarity' => $bait->getRarity(),
                    'power' => $bait->getFishBaitPower()
                ];
            }

            if($hole = $fish->getFishHole()) {
                $data[$k]['hole'] = [
                    'id' => $hole->getId(),
                    'name' => $hole->getName()
                ];
            }
        }

        return $this->json($data);
    }
}

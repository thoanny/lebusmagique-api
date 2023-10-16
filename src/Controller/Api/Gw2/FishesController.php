<?php

namespace App\Controller\Api\Gw2;

use App\Repository\Gw2\Fish\DailyRepository;
use App\Repository\Gw2Api\ItemRepository;
use App\Service\Gw2Api;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FishesController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     */
    #[Route('/api/gw2/fishes', name: 'app_api_gw2_fishes', methods: ['GET'])]
    public function index(ItemRepository $itemRepository, DailyRepository $dailyRepository, Request $request, Gw2Api $gw2Api): Response
    {
        $token = $request->query->get('token');
        $achievementsIds = [];

        $fishes = $itemRepository->findFishes();
        $data = [
            'token' => null,
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
                    'id' => $achievement->getId(),
                    'uid' => $achievement->getAchievementId(),
                    'repeatUid' => $achievement->getAchievementRepeatId(),
                    'name' => $achievement->getName(),
                ];
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
            $data['fishes'][$fish->getUid()] = [
                'uid' => $fish->getUid(),
                'name' => $fish->getName(),
                'rarity' => $fish->getRarity(),
                'power' => $fish->getFishPower(),
                'time' => $fish->getFishTime(),
                'specialization' => $fish->getFishSpecialization(),
                'strangeDiet' => $fish->isFishStrangeDietAchievement(),
                'achievement' => null,
                'bait' => null,
                'hole' => null,
                'status' => null,
            ];

            if($achievement = $fish->getFishAchievement()) {
                $data['fishes'][$fish->getUid()]['achievement'] = [
                    'id' => $achievement->getId(),
                    'uid' => $achievement->getAchievementId(),
                    'repeatUid' => $achievement->getAchievementRepeatId(),
                    'name' => $achievement->getName(),
                ];

                if($token && !in_array($achievement->getAchievementId(), $achievementsIds)) {
                    $achievementsIds[] = $achievement->getAchievementId();
                }

                if($token && !in_array($achievement->getAchievementRepeatId(), $achievementsIds)) {
                    $achievementsIds[] = $achievement->getAchievementRepeatId();
                }
            }

            if($bait = $fish->getFishBaitItem()) {
                $data['fishes'][$fish->getUid()]['bait'] = [
                    'uid' => $bait->getUid(),
                    'name' => $bait->getName(),
                    'rarity' => $bait->getRarity(),
                    'power' => $bait->getFishBaitPower()
                ];
            }

            if($hole = $fish->getFishHole()) {
                $data['fishes'][$fish->getUid()]['hole'] = [
                    'id' => $hole->getId(),
                    'name' => $hole->getName()
                ];
            }
        }

        if($token && $achievementsIds) {
            $achievements = $gw2Api->getAchievements($achievementsIds);
            foreach($achievements as $achievement) {
                if($achievement['bits']) {
                    foreach($achievement['bits'] as $k => $bit) {
                        if($bit['type'] === 'Item' && isset($data['fishes'][$bit['id']])) {
                            $data['fishes'][$bit['id']]['achievement']['bits'][$achievement['id']] = $k;
                        }
                    }
                }
            }

            $accountAchievements = $gw2Api->getAccountAchievement($token);
            $data['token'] = (!$accountAchievements) ? 'notok' : 'ok';

            if($accountAchievements) {

                foreach($data['fishes'] as $fish) {
                    if(isset($fish['achievement']['repeatUid'])) {

                        // Succès répétable
                        $achievement = array_search($fish['achievement']['repeatUid'], array_column($accountAchievements, 'id'));
                        if($achievement !== false) {
                            $achievement = $accountAchievements[$achievement];
                            if($achievement['done']) {
                                $data['fishes'][$fish['uid']]['status'] = 'repeat';
                            } else {
                                if(in_array($fish['achievement']['bits'][$fish['achievement']['repeatUid']], $achievement['bits'])) {
                                    $data['fishes'][$fish['uid']]['status'] = 'repeat';
                                }
                            }
                        } else {
                            // Succès normal
                            $achievement = array_search($fish['achievement']['uid'], array_column($accountAchievements, 'id'));
                            if($achievement !== false) {
                                $achievement = $accountAchievements[$achievement];
                                if($achievement['done']) {
                                    $data['fishes'][$fish['uid']]['status'] = 'done';
                                } else {
                                    if(in_array($fish['achievement']['bits'][$fish['achievement']['uid']], $achievement['bits'])) {
                                        $data['fishes'][$fish['uid']]['status'] = 'done';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // Réindexer les poissons
        $data['fishes'] = array_values($data['fishes']);

        return $this->json($data);
    }
}

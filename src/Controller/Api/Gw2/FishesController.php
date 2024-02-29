<?php

namespace App\Controller\Api\Gw2;

use App\Repository\Gw2\Fish\DailyRepository;
use App\Repository\Gw2\Fish\FishRepository;
use App\Repository\Gw2Api\ItemRepository;
use App\Service\Gw2Api;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\SerializerInterface;

class FishesController extends AbstractController
{

    #[Route('/api/gw2/fishes', name: 'app_api_gw2_fishes', methods: ['GET'])]
    #[OA\Tag(name: 'GW2')]
    public function appApiGw2Fishes(FishRepository $fishRepository, Request $request, Gw2Api $gw2Api, SerializerInterface $serializer): Response
    {
        $token = $request->query->get('token');
        $achievementsIds = [];

        $fishBits = [];

        // TODO : voir pour changer l'ordre des poissons par nom ASC, si pas possible, en JS

        $fishes = $fishRepository->findAll();

        if($token) {
            foreach($fishes as $f) {
                if($achievement = $f->getAchievement()) {
                    if(!in_array($achievement->getAchievementId(), $achievementsIds) && $achievement->getAchievementId() > 0) {
                        $achievementsIds[] = $achievement->getAchievementId();
                    }

                    if(!in_array($achievement->getAchievementRepeatId(), $achievementsIds) && $achievement->getAchievementRepeatId() > 0) {
                        $achievementsIds[] = $achievement->getAchievementRepeatId();
                    }
                }
            }

            if($achievementsIds) {
                $achievements = $gw2Api->getAchievements($achievementsIds);
                foreach($achievements as $achievement) {
                    if($achievement['bits']) {
                        foreach($achievement['bits'] as $k => $bit) {
                            if($bit['type'] === 'Item') {
                                $fishBits[$bit['id']][$achievement['id']] = $k;
                            }
                        }
                    }
                }

                $accountAchievements = $gw2Api->getAccountAchievement($token);
                if($accountAchievements) {

                    foreach($fishes as $f) {
                        if($f->getAchievement()) {
                            if($aid = $f->getAchievement()->getAchievementId()) {
                                $achievement = array_search($aid, array_column($accountAchievements, 'id'));
                                if($achievement !== false) {
                                    $aa = $accountAchievements[$achievement];
                                    if($aa['done']) {
                                        $f->setStatus('done');
                                    } else {
                                        if(isset($fishBits[$f->getItem()->getUid()][$aid]) && in_array($fishBits[$f->getItem()->getUid()][$aid], $aa['bits'])) {
                                            $f->setStatus('done');
                                        }
                                    }
                                }
                            }

                            if($aid = $f->getAchievement()->getAchievementRepeatId()) {
                                $achievement = array_search($aid, array_column($accountAchievements, 'id'));
                                if($achievement !== false) {
                                    $aa = $accountAchievements[$achievement];
                                    if($aa['done']) {
                                        $f->setStatus('repeat');
                                    } else {
                                        if(isset($fishBits[$f->getItem()->getUid()][$aid]) && in_array($fishBits[$f->getItem()->getUid()][$aid], $aa['bits'])) {
                                            $f->setStatus('repeat');
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return new JsonResponse($serializer->serialize($fishes, 'json', ['groups' => 'fish']), 200, [], true);

    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/api/gw2/fishes/daily', name: 'app_api_gw2_fish_daily', methods: ['GET'])]
    #[OA\Tag(name: 'GW2')]
    public function appApiGw2FishDaily(DailyRepository $dailyRepository, SerializerInterface $serializer): Response
    {
        $daily = $dailyRepository->findTodayFish();
        if(!$daily) {
            return new JsonResponse(null);
        }

        return new JsonResponse($serializer->serialize($daily, 'json', ['groups' => 'fish']), 200, [], true);
    }
}

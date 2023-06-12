<?php

namespace App\Controller\Api\User\Genshin;

use App\Entity\Genshin\Map\UserMarker;
use App\Repository\Genshin\Map\MapRepository;
use App\Repository\Genshin\Map\MarkerRepository;
use App\Repository\Genshin\Map\UserMarkerRepository;
use App\Service\Api;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[IsGranted('ROLE_USER')]
class MapController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    /**
     * Marqueurs enregistrés de l'utilisateur
     */
    #[Route('/api/user/genshin/map/{slug}', name: 'app_api_user_genshin_map', methods: ['GET'])]
    #[OA\Tag(name: 'Genshin')]
    public function appApiUserGenshinMap($slug, MapRepository $mapRepository, UserMarkerRepository $userMarkerRepository, Api $api): JsonResponse
    {
        $user = $this->getUser();
        if(!$user) {
            return $api->respondUnauthorized();
        }

        $map = $mapRepository->findOneBy(['slug' => $slug]);
        if(!$map) {
            return $api->respondNotFound();
        }

        $data = [];
        $userMarkers = $userMarkerRepository->findMarkersId($map, $user);
        foreach($userMarkers as $um) {
            $data[] = $um['id'];
        }

        return new JsonResponse($data);

    }

    #[Route('/api/user/genshin/map/marker', name: 'app_api_user_genshin_map_marker', methods: ['POST'])]
    #[OA\Tag(name: 'Genshin')]
    public function appApiUserGenshinMapMarker(MapRepository $mapRepository, MarkerRepository $markerRepository, UserMarkerRepository $userMarkerRepository, Api $api, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $request = $api->transformJsonBody($request);
        $user = $this->getUser();
        $map = $request->get('map');
        $action = $request->get('action');
        $marker = $request->get('marker');

        if(!$user) {
            return $api->respondUnauthorized();
        }

        if(!$map || !$action || !$marker) {
            return $api->respondBadRequest('001');
        }

        if(!in_array($action, ['add', 'remove'])) {
            return $api->respondBadRequest('002');
        }

        $map = $mapRepository->findOneBy(['slug' => $map]);
        if(!$map) {
            return $api->respondNotFound('Map not found!');
        }

        $marker = $markerRepository->findOneBy(['id' => $marker]);
        if(!$marker) {
            return $api->respondNotFound('Marker not found!');
        }

        $exists = $userMarkerRepository->findOneBy(['map' => $map, 'marker' => $marker, 'user' => $user]);

        if($action === 'add') {
            if(!$exists) {
                $userMarker = (new UserMarker())
                    ->setMap($map)
                    ->setMarker($marker)
                    ->setUser($user);

                $em->persist($userMarker);
                $em->flush();

                return $api->respondCreated('Marqueur enregistré.');
            }
        } else if($action === 'remove') {
            if($exists) {
                $em->remove($exists);
                $em->flush();

                return $api->respondWithSuccess('Marqueur supprimé.');
            }
        }

        return $api->respondBadRequest('003');
    }

    /**
     * Marqueurs enregistrés de l'utilisateur
     */
    #[Route('/api/user/genshin/map/makers/reset', name: 'app_api_user_genshin_map_markers_reset', methods: ['POST'])]
    #[OA\Tag(name: 'Genshin')]
    public function appApiUserGenshinMapMarkersReset(MapRepository $mapRepository, UserMarkerRepository $userMarkerRepository, Api $api, Request $request, EntityManagerInterface $em): JsonResponse
    {

        $request = $api->transformJsonBody($request);
        $user = $this->getUser();
        $map = $request->get('map');

        if(!$user) {
            return $api->respondUnauthorized();
        }

        $map = $mapRepository->findOneBy(['slug' => $map]);
        if(!$map) {
            return $api->respondNotFound('Map not found!');
        }

        $userMarkers = $userMarkerRepository->findBy(['map' => $map, 'user' => $user]);
        foreach($userMarkers as $um) {
            $em->remove($um);
        }

        $em->flush();

        return $api->respondWithSuccess('Suivi des marqueurs réinitialisés.');

    }
}

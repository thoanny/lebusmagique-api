<?php

namespace App\Controller\Api\Genshin;

use App\Repository\Genshin\Map\GroupRepository;
use App\Repository\Genshin\Map\IconRepository;
use App\Repository\Genshin\Map\MapRepository;
use App\Repository\Genshin\Map\MarkerRepository;
use App\Repository\Genshin\Map\SectionRepository;
use App\Service\Api;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class MapController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    /**
     * Informations sur la carte interactive
     *
     * Expose les informations de la carte, de ses sections, groupes, marqueurs et icônes et les autres cartes disponibles.
     * @throws NonUniqueResultException
     */
    #[Route('/api/genshin/map/{slug}', name: 'app_api_genshin_map', defaults: ['slug' => null], methods: ['GET'])]
    #[OA\Tag(name: 'Genshin')]
    public function index(MapRepository $mapRepository, SectionRepository $sectionRepository, GroupRepository $groupRepository, MarkerRepository $markerRepository, IconRepository $iconRepository, Api $api, $slug): Response
    {
        $map = $mapRepository->findOneBySlug($slug);
        if(!$map) {
            return $api->respondNotFound('Map not found');
        }

        $maps = $mapRepository->findActiveMaps();

        $sectionsIds = [];
        $sections = $sectionRepository->findByMap($map['id']);
        foreach($sections as $section) {
            $sectionsIds[] = $section['id'];
        }

        $iconsIds = [];
        $groupsIds = [];
        $groups = $groupRepository->findBySections($sectionsIds);
        foreach($groups as $group) {
            $groupsIds[] = $group['id'];

            if($group['iconId'] && !in_array($group['iconId'], $iconsIds)) {
                $iconsIds[] = $group['iconId'];
            }
        }

        $markers = $markerRepository->findByGroups($groupsIds);


        foreach($markers as $marker) {
            // TODO : ajouter LiipImagine et envoyer imageThumbnail et imageFull
            if($marker['iconId'] && !in_array($marker['iconId'], $iconsIds)) {
                $iconsIds[] = $marker['iconId'];
            }
        }

        $icons = $iconRepository->findByIds($iconsIds);
        foreach($icons as $k => $v) {
            $size = explode(',', $v['iconSize']);
            $anchor = explode(',', $v['iconAnchor']);
            $popup = explode(',', $v['popupAnchor']);
            $icons[$k]['iconSize'] = [(int) $size[0], (int) $size[1]];
            $icons[$k]['iconAnchor'] = [(int) $anchor[0], (int) $anchor[1]];
            $icons[$k]['popupAnchor'] = [(int) $popup[0], (int) $popup[1]];
        }

        list($a, $b) = explode('|', $map['bounds']);
        list($c, $d) = explode(',', $a);
        list($e, $f) = explode(',', $b);

        $map['bounds'] = [$c, $d, $e, $f];
        $map['center'] = explode(',', $map['center']);

        return new JsonResponse([
            'map' => $map,
            'sections' => $sections,
            'groups' => $groups,
            'markers' => $markers,
            'icons' => $icons,
            'maps' => $maps
        ]);
    }
}

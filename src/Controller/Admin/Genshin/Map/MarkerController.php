<?php

namespace App\Controller\Admin\Genshin\Map;

use App\Entity\Genshin\Map\Marker;
use App\Form\Admin\Genshin\Map\MarkerType;
use App\Repository\Genshin\Map\GroupRepository;
use App\Repository\Genshin\Map\MarkerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarkerController extends AbstractController
{
    #[Route('/admin/genshin/maps/markers', name: 'app_admin_genshin_maps_markers')]
    public function appAdminMapsMarkers(GroupRepository $groupRepository, MarkerRepository $markerRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $filters = [
            'query' => $request->query->get('query'),
            'group' => $request->query->getInt('group'),
            'format' => $request->query->getAlpha('format'),
            'active' => $request->query->getInt('active'),
        ];

        $markers = $paginator->paginate(
            $markerRepository->findByFilters($filters),
            $request->query->getInt('page', 1),
            25
        );

        $groups = $groupRepository->findAll();

        return $this->render('admin/genshin/map/marker/index.html.twig', [
            'markers' => $markers,
            'groups' => $groups,
            'filters' => $filters
        ]);
    }

    #[Route('/admin/genshin/maps/markers/edit/{id}', name: 'app_admin_genshin_maps_marker_edit', defaults: ['id' => null])]
    public function appAdminGenshinMapsMarkerEdit(GroupRepository $groupRepository, MarkerRepository $markerRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        if($id) {
            $marker = $markerRepository->findOneBy(['id' => $id]);

            if(!$marker) {
                $this->addFlash('error', 'Marqueur introuvable...');
                return $this->redirectToRoute('app_admin_genshin_maps_markers');
            }

            $group = $marker->getMarkerGroup();
        } else {
            $group = $request->query->getInt('group');
            if(!$group) {
                $this->addFlash('error', 'Vous devez choisir un groupe...');
                return $this->redirectToRoute('app_admin_genshin_maps_markers');
            }

            $group = $groupRepository->findOneBy(['id' => $group]);
            if(!$group) {
                $this->addFlash('error', 'Groupe introuvable...');
                return $this->redirectToRoute('app_admin_genshin_maps_markers');
            }

            $marker = new Marker();
        }

        $marker->setMarkerGroup($group);

        $form = $this->createForm(MarkerType::class, $marker);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $marker = $form->getData();

            $em->persist($marker);
            $em->flush();

            $this->addFlash('success', 'Marqueur enregistré');
            return $this->redirectToRoute('app_admin_genshin_maps_markers');
        }

        return $this->render('admin/genshin/map/marker/edit.html.twig', [
            'marker' => $marker,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/genshin/maps/markers/delete/{id}', name: 'app_admin_genshin_maps_marker_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminGenshinMapsMarkerDelete($id, MarkerRepository $markerRepository, EntityManagerInterface $em): RedirectResponse {
        if(!$id) {
            $this->addFlash('error', 'Marqueur introuvable...');
            return $this->redirectToRoute('app_admin_genshin_maps_markers');
        }

        $marker = $markerRepository->findOneBy(['id' => $id]);
        if(!$marker) {
            $this->addFlash('error', 'Marqueur introuvable...');
            return $this->redirectToRoute('app_admin_genshin_maps_markers');
        }

        $em->remove($marker);
        $em->flush();

        $this->addFlash('success', 'Marqueur supprimé');
        return $this->redirectToRoute('app_admin_genshin_maps_markers');
    }
}

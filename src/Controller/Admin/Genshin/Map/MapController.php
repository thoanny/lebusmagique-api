<?php

namespace App\Controller\Admin\Genshin\Map;

use App\Entity\Genshin\Map\Map;
use App\Form\Admin\Genshin\Map\MapType;
use App\Repository\Genshin\Map\MapRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    #[Route('/admin/genshin/maps', name: 'app_admin_genshin_maps')]
    public function appAdminGenshinMaps(MapRepository $mapRepository): Response
    {
        $maps = $mapRepository->findAll();
        return $this->render('admin/genshin/map/map/index.html.twig', [
            'maps' => $maps,
        ]);
    }

    #[Route('/admin/genshin/maps/edit/{id}', name: 'app_admin_genshin_map_edit', defaults: ['id' => null])]
    public function appAdminGenshinMapEdit(MapRepository $mapRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        if($id) {
            $map = $mapRepository->findOneBy(['id' => $id]);

            if(!$map) {
                $this->addFlash('error', 'Carte introuvable...');
                return $this->redirectToRoute('app_admin_genshin_maps');
            }
        } else {
            $map = new Map();
        }

        $form = $this->createForm(MapType::class, $map);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $map = $form->getData();

            $em->persist($map);
            $em->flush();

            $this->addFlash('success', 'Carte enregistrée');
            return $this->redirectToRoute('app_admin_genshin_maps');
        }

        return $this->render('admin/genshin/map/map/edit.html.twig', [
            'map' => $map,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/genshin/maps/maps/delete/{id}', name: 'app_admin_genshin_map_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminGenshinMapDelete($id, MapRepository $mapRepository, EntityManagerInterface $em): RedirectResponse {
        if(!$id) {
            $this->addFlash('error', 'Carte introuvable...');
            return $this->redirectToRoute('app_admin_genshin_maps');
        }

        $map = $mapRepository->findOneBy(['id' => $id]);
        if(!$map) {
            $this->addFlash('error', 'Carte introuvable...');
            return $this->redirectToRoute('app_admin_genshin_maps');
        }

        $em->remove($map);
        $em->flush();

        $this->addFlash('success', 'Carte supprimée');
        return $this->redirectToRoute('app_admin_genshin_maps');
    }
}

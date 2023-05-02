<?php

namespace App\Controller\Admin\Gw2\Fish;

use App\Entity\Gw2\Fish\Map;
use App\Form\Admin\Gw2\Fish\MapType;
use App\Repository\Gw2\Fish\MapRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    #[Route('/admin/gw2/fish/maps', name: 'app_admin_gw2_fish_maps')]
    public function appAdminGw2FishMaps(MapRepository $mapRepository): Response
    {
        $maps = $mapRepository->findAll();
        return $this->render('admin/gw2/fish/map/index.html.twig', [
            'maps' => $maps,
        ]);
    }

    #[Route('/admin/gw2/fish/maps/edit/{id}', name: 'app_admin_gw2_fish_map_edit', defaults: ['id' => null])]
    public function appAdminGw2FishMapEdit($id, MapRepository $mapRepository, Request $request, EntityManagerInterface $em): Response
    {
        if($id) {
            $map = $mapRepository->findOneBy(['id' => $id]);

            if(!$map) {
                $this->addFlash('error', 'Carte introuvable');
                return $this->redirectToRoute('app_admin_gw2_fish_maps');
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
            return $this->redirectToRoute('app_admin_gw2_fish_maps');
        }

        return $this->render('admin/gw2/fish/map/edit.html.twig', [
            'map' => $map,
            'form' => $form->createView()
        ]);
    }
}

<?php

namespace App\Controller\Admin\Enshrouded;

use App\Entity\Enshrouded\MapMarker;
use App\Form\Admin\Enshrouded\MapMarkerType;
use App\Repository\Enshrouded\MapMarkerRepository;
use App\Service\LiipCacheManager;
use App\Service\Uid;
use Doctrine\ORM\EntityManagerInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/enshrouded/map/markers')]
class MapMarkerController extends AbstractController
{
    private string $liipPath = '/uploads/api/enshrouded/map/images';
    private array $liipFilters = [
        '960x540',
        '384x216'
    ];

    #[Route('/', name: 'app_admin_enshrouded_map_marker_index', methods: ['GET'])]
    public function index(MapMarkerRepository $mapMarkerRepository): Response
    {
        return $this->render('admin/enshrouded/map_marker/index.html.twig', [
            'map_markers' => $mapMarkerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_enshrouded_map_marker_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Uid $uid, LiipCacheManager $cacheManager): Response
    {
        $mapMarker = new MapMarker();
        $form = $this->createForm(MapMarkerType::class, $mapMarker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mapMarker->setUid($uid->generate());
            $entityManager->persist($mapMarker);
            $entityManager->flush();

            if($form->get('imageFile')->getData()) {
                $cacheManager->generate("$this->liipPath/{$mapMarker->getImage()}", $this->liipFilters);
            }

            return $this->redirectToRoute('app_admin_enshrouded_map_marker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/map_marker/new.html.twig', [
            'map_marker' => $mapMarker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_map_marker_show', methods: ['GET'])]
    public function show(MapMarker $mapMarker): Response
    {
        return $this->render('admin/enshrouded/map_marker/show.html.twig', [
            'map_marker' => $mapMarker,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_enshrouded_map_marker_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MapMarker $mapMarker, EntityManagerInterface $entityManager, LiipCacheManager $cacheManager): Response
    {
        $currentImage = $mapMarker->getImage();
        $form = $this->createForm(MapMarkerType::class, $mapMarker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            if($form->get('imageFile')->getData()) {
                if($currentImage) {
                    $cacheManager->remove("$this->liipPath/$currentImage", $this->liipFilters);
                }
                $cacheManager->generate("$this->liipPath/{$mapMarker->getImage()}", $this->liipFilters);
            }

            return $this->redirectToRoute('app_admin_enshrouded_map_marker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/map_marker/edit.html.twig', [
            'map_marker' => $mapMarker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_map_marker_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, MapMarker $mapMarker, EntityManagerInterface $entityManager, CacheManager $cacheManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mapMarker->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mapMarker);
            $entityManager->flush();

            if($mapMarker->getImage()) {
                $cacheManager->remove("$this->liipPath/{$mapMarker->getImage()}", $this->liipFilters);
            }
        }

        return $this->redirectToRoute('app_admin_enshrouded_map_marker_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller\Admin\Enshrouded;

use App\Entity\Enshrouded\MapCategory;
use App\Form\Admin\Enshrouded\MapCategoryType;
use App\Repository\Enshrouded\MapCategoryRepository;
use App\Service\Uid;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/enshrouded/map/categories')]
class MapCategoryController extends AbstractController
{
    #[Route('/', name: 'app_admin_enshrouded_map_category_index', methods: ['GET'])]
    public function index(MapCategoryRepository $mapCategoryRepository): Response
    {
        return $this->render('admin/enshrouded/map_category/index.html.twig', [
            'map_categories' => $mapCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_enshrouded_map_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Uid $uid): Response
    {
        $mapCategory = new MapCategory();
        $form = $this->createForm(MapCategoryType::class, $mapCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mapCategory->setUid($uid->generate());
            $entityManager->persist($mapCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_enshrouded_map_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/map_category/new.html.twig', [
            'map_category' => $mapCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_map_category_show', methods: ['GET'])]
    public function show(MapCategory $mapCategory): Response
    {
        return $this->render('admin/enshrouded/map_category/show.html.twig', [
            'map_category' => $mapCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_enshrouded_map_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MapCategory $mapCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MapCategoryType::class, $mapCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_enshrouded_map_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/map_category/edit.html.twig', [
            'map_category' => $mapCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_map_category_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, MapCategory $mapCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mapCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mapCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_enshrouded_map_category_index', [], Response::HTTP_SEE_OTHER);
    }
}

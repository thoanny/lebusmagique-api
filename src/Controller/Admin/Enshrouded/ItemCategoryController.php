<?php

namespace App\Controller\Admin\Enshrouded;

use App\Entity\Enshrouded\ItemCategory;
use App\Form\Admin\Enshrouded\ItemCategoryType;
use App\Repository\Enshrouded\ItemCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/enshrouded/items-categories')]
class ItemCategoryController extends AbstractController
{
    #[Route('/', name: 'app_admin_enshrouded_item_category_index', methods: ['GET'])]
    public function index(ItemCategoryRepository $itemCategoryRepository): Response
    {
        return $this->render('admin/enshrouded/item_category/index.html.twig', [
            'item_categories' => $itemCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_enshrouded_item_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $itemCategory = new ItemCategory();
        $form = $this->createForm(ItemCategoryType::class, $itemCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($itemCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_enshrouded_item_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/item_category/new.html.twig', [
            'item_category' => $itemCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_item_category_show', methods: ['GET'])]
    public function show(ItemCategory $itemCategory): Response
    {
        return $this->render('admin/enshrouded/item_category/show.html.twig', [
            'item_category' => $itemCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_enshrouded_item_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemCategory $itemCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemCategoryType::class, $itemCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_enshrouded_item_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/item_category/edit.html.twig', [
            'item_category' => $itemCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_item_category_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, ItemCategory $itemCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($itemCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_enshrouded_item_category_index', [], Response::HTTP_SEE_OTHER);
    }
}

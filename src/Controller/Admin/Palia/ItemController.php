<?php

namespace App\Controller\Admin\Palia;

use App\Entity\Palia\Item;
use App\Entity\Palia\ItemCategory;
use App\Form\Admin\Palia\Item\CategoryType;
use App\Form\Admin\Palia\Item\ItemType;
use App\Repository\Palia\ItemCategoryRepository;
use App\Repository\Palia\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_PALIA')]
class ItemController extends AbstractController
{
    #[Route('/admin/palia/items', name: 'app_admin_palia_items')]
    public function appAdminPaliaItems(ItemRepository $itemRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $items = $paginator->paginate(
            $itemRepository->findAll(),
            $request->query->getInt('page', 1),
            25
        );

        return $this->render('admin/palia/item/index.html.twig', [
            'items' => $items,
        ]);
    }

    #[Route('/admin/palia/items/edit/{id}', name: 'app_admin_palia_item_edit', defaults: ['id' => null])]
    public function appAdminPaliaItemEdit(ItemRepository $itemRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        if($id) {
            $item = $itemRepository->findOneBy(['id' => $id]);

            if(!$item) {
                $this->addFlash('error', 'Objet introuvable...');
                return $this->redirectToRoute('app_admin_palia_items');
            }
        } else {
            $item = new Item();
        }

        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Objet enregistré');
            return $this->redirectToRoute('app_admin_palia_items');
        }

        return $this->render('admin/palia/item/edit.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/palia/items/delete/{id}', name: 'app_admin_palia_item_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminPaliaItemDelete(ItemRepository $itemRepository, EntityManagerInterface $em, $id): RedirectResponse
    {
        if(!$id) {
            $this->addFlash('error', 'Objet introuvable...');
            return $this->redirectToRoute('app_admin_palia_items');
        }

        $item = $itemRepository->findOneBy(['id' => $id]);
        if(!$item) {
            $this->addFlash('error', 'Objet introuvable...');
            return $this->redirectToRoute('app_admin_palia_items');
        }

        $em->remove($item);
        $em->flush();

        $this->addFlash('success', 'Objet supprimé');
        return $this->redirectToRoute('app_admin_palia_items');
    }

    #[Route('/admin/palia/items/categories/{id}', name: 'app_admin_palia_items_categories', defaults: ['id' => null])]
    public function appAdminPaliaItemsCategories(ItemCategoryRepository $categoryRepository, Request $request, EntityManagerInterface $em, PaginatorInterface $paginator, $id): Response
    {
        $categories = $paginator->paginate(
            $categoryRepository->findAll(),
            $request->query->getInt('page', 1),
            25
        );

        if($id) {
            $category = $categoryRepository->findOneBy(['id' => $id]);

            if(!$category) {
                $this->addFlash('error', 'Catégorie introuvable...');
                return $this->redirectToRoute('app_admin_palia_items_categories');
            }
        } else {
            $category = new ItemCategory();
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Catégorie enregistrée');
            return $this->redirectToRoute('app_admin_palia_items_categories');
        }

        return $this->render('admin/palia/item/category.html.twig', [
            'categories' => $categories,
            'category' => $category,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/palia/items/categories/delete/{id}', name: 'app_admin_palia_item_category_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminPaliaItemCategoryDelete(ItemCategoryRepository $categoryRepository, EntityManagerInterface $em, $id): RedirectResponse
    {
        if(!$id) {
            $this->addFlash('error', 'Catégorie introuvable...');
            return $this->redirectToRoute('app_admin_palia_items_categories');
        }

        $category = $categoryRepository->findOneBy(['id' => $id]);
        if(!$category) {
            $this->addFlash('error', 'Catégorie introuvable...');
            return $this->redirectToRoute('app_admin_palia_items_categories');
        }

        $em->remove($category);
        $em->flush();

        $this->addFlash('success', 'Catégorie supprimée');
        return $this->redirectToRoute('app_admin_palia_items_categories');
    }
}

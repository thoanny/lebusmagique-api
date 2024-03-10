<?php

namespace App\Controller\Admin\Enshrouded;

use App\Entity\Enshrouded\RecipeCategory;
use App\Form\Admin\Enshrouded\RecipeCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/enshrouded/recipes-categories')]
class RecipeCategoryController extends AbstractController
{
    #[Route('/', name: 'app_admin_enshrouded_recipe_category_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(RecipeCategory::class);
        return $this->render('admin/enshrouded/recipe_category/index.html.twig', [
            'recipe_categories' => $repo->childrenHierarchy(),
        ]);
    }

    #[Route('/new', name: 'app_admin_enshrouded_recipe_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recipeCategory = new RecipeCategory();
        $form = $this->createForm(RecipeCategoryType::class, $recipeCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recipeCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_enshrouded_recipe_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/recipe_category/new.html.twig', [
            'recipe_category' => $recipeCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_recipe_category_show', methods: ['GET'])]
    public function show(RecipeCategory $recipeCategory): Response
    {
        return $this->render('admin/enshrouded/recipe_category/show.html.twig', [
            'recipe_category' => $recipeCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_enshrouded_recipe_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RecipeCategory $recipeCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecipeCategoryType::class, $recipeCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_enshrouded_recipe_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/recipe_category/edit.html.twig', [
            'recipe_category' => $recipeCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/move/{type<up|down>}', name: 'app_admin_enshrouded_recipe_category_move', methods: ['GET'])]
    public function move($type, RecipeCategory $recipeCategory, EntityManagerInterface $entityManager): RedirectResponse
    {
        $repo = $entityManager->getRepository(RecipeCategory::class);
        // TODO : Actuellement incompatible avec les items sans parent et l'ORM v3.0

        if('up' === $type) {
            $repo->moveUp($recipeCategory);
        } else {
            $repo->moveDown($recipeCategory);
        }

        return $this->redirectToRoute('app_admin_enshrouded_recipe_category_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_recipe_category_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, RecipeCategory $recipeCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recipeCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recipeCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_enshrouded_recipe_category_index', [], Response::HTTP_SEE_OTHER);
    }
}

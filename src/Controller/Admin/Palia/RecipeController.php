<?php

namespace App\Controller\Admin\Palia;

use App\Entity\Palia\Recipe;
use App\Form\Admin\Palia\RecipeType;
use App\Repository\Palia\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_PALIA')]
class RecipeController extends AbstractController
{
    #[Route('/admin/palia/recipes', name: 'app_admin_palia_recipes')]
    public function appAdminPaliaRecipes(PaginatorInterface $paginator, RecipeRepository $recipeRepository, Request $request): Response
    {
        $recipes = $paginator->paginate(
            $recipeRepository->findAll(),
            $request->query->getInt('page', 1),
            25
        );

        return $this->render('admin/palia/recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }



    #[Route('/admin/palia/recipes/edit/{id}', name: 'app_admin_palia_recipe_edit', defaults: ['id' => null])]
    public function appAdminPaliaRecipeEdit(RecipeRepository $recipeRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        if($id) {
            $recipe = $recipeRepository->findOneBy(['id' => $id]);

            if(!$recipe) {
                $this->addFlash('error', 'Recette introuvable...');
                return $this->redirectToRoute('app_admin_palia_recipes');
            }
        } else {
            $recipe = new Recipe();
        }

        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();

            $em->persist($recipe);
            $em->flush();

            $this->addFlash('success', 'Recette enregistrée');
            return $this->redirectToRoute('app_admin_palia_recipes');
        }

        return $this->render('admin/palia/recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/palia/recipes/delete/{id}', name: 'app_admin_palia_recipe_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminPaliaRecipeDelete(RecipeRepository $recipeRepository, EntityManagerInterface $em, $id): RedirectResponse
    {
        if(!$id) {
            $this->addFlash('error', 'Recette introuvable...');
            return $this->redirectToRoute('app_admin_palia_recipes');
        }

        $recipe = $recipeRepository->findOneBy(['id' => $id]);
        if(!$recipe) {
            $this->addFlash('error', 'Recette introuvable...');
            return $this->redirectToRoute('app_admin_palia_recipes');
        }

        $em->remove($recipe);
        $em->flush();

        $this->addFlash('success', 'Recette supprimée');
        return $this->redirectToRoute('app_admin_palia_recipes');
    }
}

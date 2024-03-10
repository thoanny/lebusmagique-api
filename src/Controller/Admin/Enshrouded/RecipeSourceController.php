<?php

namespace App\Controller\Admin\Enshrouded;

use App\Entity\Enshrouded\RecipeSource;
use App\Entity\Enshrouded\RecipeSourceItem;
use App\Entity\Enshrouded\RecipeSourceNpc;
use App\Form\Admin\Enshrouded\RecipeSourceItemType;
use App\Form\Admin\Enshrouded\RecipeSourceNpcType;
use App\Repository\Enshrouded\RecipeSourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/enshrouded/recipes-sources')]
class RecipeSourceController extends AbstractController
{
    #[Route('/', name: 'app_admin_enshrouded_recipe_source_index', methods: ['GET'])]
    public function index(RecipeSourceRepository $recipeSourceRepository): Response
    {
        return $this->render('admin/enshrouded/recipe_source/index.html.twig', [
            'recipe_sources' => $recipeSourceRepository->findAll(),
        ]);
    }

    #[Route('/new/{type<npc|item>}', name: 'app_admin_enshrouded_recipe_source_new', methods: ['GET', 'POST'])]
    public function new($type, Request $request, EntityManagerInterface $entityManager): Response
    {

        if($type === 'npc') {
            $recipeSource = new RecipeSourceNpc();
            $form = $this->createForm(RecipeSourceNpcType::class, $recipeSource);
        } else {
            $recipeSource = new RecipeSourceItem();
            $form = $this->createForm(RecipeSourceItemType::class, $recipeSource);
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recipeSource);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_enshrouded_recipe_source_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/recipe_source/new.html.twig', [
            'recipe_source' => $recipeSource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_recipe_source_show', methods: ['GET'])]
    public function show(RecipeSource $recipeSource): Response
    {
        return $this->render('admin/enshrouded/recipe_source/show.html.twig', [
            'recipe_source' => $recipeSource,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_recipe_source_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, RecipeSource $recipeSource, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recipeSource->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recipeSource);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_enshrouded_recipe_source_index', [], Response::HTTP_SEE_OTHER);
    }
}

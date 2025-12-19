<?php

namespace App\Controller\Admin\Gw2;

use App\Entity\Gw2\DecorationCategory;
use App\Form\Gw2\DecorationCategoryType;
use App\Repository\Gw2\DecorationCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin-old/gw2/decorations/categories')]
class DecorationCategoryController extends AbstractController
{
    #[Route('/', name: 'app_admin_gw2_decoration_category_index', methods: ['GET'])]
    public function index(DecorationCategoryRepository $decorationCategoryRepository): Response
    {
        return $this->render('admin/gw2/decoration_category/index.html.twig', [
            'decoration_categories' => $decorationCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_gw2_decoration_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $decorationCategory = new DecorationCategory();
        $form = $this->createForm(DecorationCategoryType::class, $decorationCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($decorationCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_gw2_decoration_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gw2/decoration_category/new.html.twig', [
            'decoration_category' => $decorationCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_gw2_decoration_category_show', methods: ['GET'])]
    public function show(DecorationCategory $decorationCategory): Response
    {
        return $this->render('admin/gw2/decoration_category/show.html.twig', [
            'decoration_category' => $decorationCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_gw2_decoration_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DecorationCategory $decorationCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DecorationCategoryType::class, $decorationCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_gw2_decoration_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gw2/decoration_category/edit.html.twig', [
            'decoration_category' => $decorationCategory,
            'form' => $form,
        ]);
    }
}

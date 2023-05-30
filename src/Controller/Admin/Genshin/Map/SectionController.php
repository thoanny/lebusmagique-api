<?php

namespace App\Controller\Admin\Genshin\Map;

use App\Entity\Genshin\Map\Section;
use App\Form\Admin\Genshin\Map\SectionType;
use App\Repository\Genshin\Map\SectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SectionController extends AbstractController
{
    #[Route('/admin/genshin/maps/sections', name: 'app_admin_genshin_maps_sections')]
    public function appAdminGenshinMapsSections(SectionRepository $sectionRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $sections = $paginator->paginate(
            $sectionRepository->findAll(),
            $request->query->getInt('page', 1),
            25
        );

        return $this->render('admin/genshin/map/section/index.html.twig', [
            'sections' => $sections,
        ]);
    }

    #[Route('/admin/genshin/maps/sections/edit/{id}', name: 'app_admin_genshin_maps_section_edit', defaults: ['id' => null])]
    public function appAdminGenshinMapsSectionEdit(SectionRepository $sectionRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        if($id) {
            $section = $sectionRepository->findOneBy(['id' => $id]);

            if(!$section) {
                $this->addFlash('error', 'Section introuvable...');
                return $this->redirectToRoute('app_admin_genshin_maps_sections');
            }
        } else {
            $section = new Section();
        }

        $form = $this->createForm(SectionType::class, $section);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $section = $form->getData();

            $em->persist($section);
            $em->flush();

            $this->addFlash('success', 'Section enregistrée');
            return $this->redirectToRoute('app_admin_genshin_maps_sections');
        }

        return $this->render('admin/genshin/map/section/edit.html.twig', [
            'section' => $section,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/genshin/maps/sections/delete/{id}', name: 'app_admin_genshin_maps_section_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminGenshinMapsSectionDelete($id, SectionRepository $sectionRepository, EntityManagerInterface $em): RedirectResponse {
        if(!$id) {
            $this->addFlash('error', 'Section introuvable...');
            return $this->redirectToRoute('app_admin_genshin_maps_sections');
        }

        $section = $sectionRepository->findOneBy(['id' => $id]);
        if(!$section) {
            $this->addFlash('error', 'Section introuvable...');
            return $this->redirectToRoute('app_admin_genshin_maps_sections');
        }

        $em->remove($section);
        $em->flush();

        $this->addFlash('success', 'Section supprimée');
        return $this->redirectToRoute('app_admin_genshin_maps_sections');
    }
}

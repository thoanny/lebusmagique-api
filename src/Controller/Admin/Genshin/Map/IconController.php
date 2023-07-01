<?php

namespace App\Controller\Admin\Genshin\Map;

use App\Entity\Genshin\Map\Icon;
use App\Form\Admin\Genshin\Map\IconType;
use App\Repository\Genshin\Map\IconRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IconController extends AbstractController
{
    #[Route('/admin/genshin/maps/icons', name: 'app_admin_genshin_maps_icons')]
    public function appAdminGenshinMapsIcons(IconRepository $iconRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $filters = [
            'query' => $request->query->get('query'),
        ];

        $icons = $paginator->paginate(
            $iconRepository->findByFilters($filters),
            $request->query->getInt('page', 1),
            25
        );
        return $this->render('admin/genshin/map/icon/index.html.twig', [
            'icons' => $icons,
            'filters' => $filters
        ]);
    }

    #[Route('/admin/genshin/maps/icons/edit/{id}', name: 'app_admin_genshin_maps_icon_edit', defaults: ['id' => null])]
    public function appAdminGenshinMapsIconEdit(IconRepository $iconRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        if($id) {
            $icon = $iconRepository->findOneBy(['id' => $id]);

            if(!$icon) {
                $this->addFlash('error', 'Icône introuvable...');
                return $this->redirectToRoute('app_admin_genshin_maps_icons');
            }
        } else {
            $icon = new Icon();
        }

        $form = $this->createForm(IconType::class, $icon);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $icon = $form->getData();

            $em->persist($icon);
            $em->flush();

            $this->addFlash('success', 'Icône enregistrée');
            return $this->redirectToRoute('app_admin_genshin_maps_icons');
        }

        return $this->render('admin/genshin/map/icon/edit.html.twig', [
            'icon' => $icon,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/genshin/maps/icons/delete/{id}', name: 'app_admin_genshin_maps_icon_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminGenshinMapsIconDelete($id, IconRepository $iconRepository, EntityManagerInterface $em): RedirectResponse {
        if(!$id) {
            $this->addFlash('error', 'Icône introuvable...');
            return $this->redirectToRoute('app_admin_genshin_maps_icons');
        }

        $icon = $iconRepository->findOneBy(['id' => $id]);
        if(!$icon) {
            $this->addFlash('error', 'Icône introuvable...');
            return $this->redirectToRoute('app_admin_genshin_maps_icons');
        }

        $em->remove($icon);
        $em->flush();

        $this->addFlash('success', 'Icône supprimée');
        return $this->redirectToRoute('app_admin_genshin_maps_icons');
    }
}

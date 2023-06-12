<?php

namespace App\Controller\Admin\Genshin\Map;

use App\Entity\Genshin\Map\Group;
use App\Form\Admin\Genshin\Map\GroupType;
use App\Repository\Genshin\Map\GroupRepository;
use App\Repository\Genshin\Map\SectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_GENSHIN')]
class GroupController extends AbstractController
{
    #[Route('/admin/genshin/maps/groups', name: 'app_admin_genshin_maps_groups')]
    public function appAdminGenshinMapsGroups(GroupRepository $groupRepository, SectionRepository $sectionRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $groups = $paginator->paginate(
            $groupRepository->findAll(),
            $request->query->getInt('page', 1),
            25
        );

        $sections = $sectionRepository->findAll();

        return $this->render('admin/genshin/map/group/index.html.twig', [
            'groups' => $groups,
            'sections' => $sections
        ]);
    }

    #[Route('/admin/genshin/maps/groups/edit/{id}', name: 'app_admin_genshin_maps_group_edit', defaults: ['id' => null])]
    public function appAdminGenshinMapsGroupEdit(GroupRepository $groupRepository, SectionRepository $sectionRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        if($id) {
            $group = $groupRepository->findOneBy(['id' => $id]);

            if(!$group) {
                $this->addFlash('error', 'Groupe introuvable...');
                return $this->redirectToRoute('app_admin_genshin_maps_groups');
            }

            $section = $group->getSection();
        } else {
            $section = $request->query->getInt('section');
            if(!$section) {
                $this->addFlash('error', 'Vous devez choisir une section...');
                return $this->redirectToRoute('app_admin_genshin_maps_groups');
            }

            $section = $sectionRepository->findOneBy(['id' => $section]);
            if(!$section) {
                $this->addFlash('error', 'Section introuvable...');
                return $this->redirectToRoute('app_admin_genshin_maps_groups');
            }

            $group = new Group();
        }

        $group->setSection($section);

        $form = $this->createForm(GroupType::class, $group);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->getData();

            $em->persist($group);
            $em->flush();

            $this->addFlash('success', 'Groupe enregistré');
            return $this->redirectToRoute('app_admin_genshin_maps_groups');
        }

        return $this->render('admin/genshin/map/group/edit.html.twig', [
            'group' => $group,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/genshin/maps/groups/delete/{id}', name: 'app_admin_genshin_maps_group_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminGenshinMapsGroupDelete($id, GroupRepository $groupRepository, EntityManagerInterface $em): RedirectResponse {
        if(!$id) {
            $this->addFlash('error', 'Groupe introuvable...');
            return $this->redirectToRoute('app_admin_genshin_maps_groups');
        }

        $group = $groupRepository->findOneBy(['id' => $id]);
        if(!$group) {
            $this->addFlash('error', 'Groupe introuvable...');
            return $this->redirectToRoute('app_admin_genshin_maps_groups');
        }

        $em->remove($group);
        $em->flush();

        $this->addFlash('success', 'Groupe supprimé');
        return $this->redirectToRoute('app_admin_genshin_maps_groups');
    }
}

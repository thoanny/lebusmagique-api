<?php

namespace App\Controller\Admin\Palia;

use App\Entity\Palia\Character;
use App\Entity\Palia\CharacterGroup;
use App\Form\Admin\Palia\CharacterGroupType;
use App\Form\Admin\Palia\CharacterType;
use App\Repository\Palia\CharacterGroupRepository;
use App\Repository\Palia\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_PALIA')]
class CharacterController extends AbstractController
{
    #[Route('/admin/palia/characters', name: 'app_admin_palia_characters')]
    public function appAdminPaliaCharacters(CharacterRepository $characterRepository): Response
    {
        $characters = $characterRepository->findAll();
        return $this->render('admin/palia/character/index.html.twig', [
            'characters' => $characters,
        ]);
    }

    #[Route('/admin/palia/characters/edit/{id}', name: 'app_admin_palia_character_edit', defaults: ['id' => null])]
    public function appAdminPaliaCharacterEdit(CharacterRepository $characterRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        if($id) {
            $character = $characterRepository->findOneBy(['id' => $id]);

            if(!$character) {
                $this->addFlash('error', 'Personnage introuvable...');
                return $this->redirectToRoute('app_admin_palia_characters');
            }
        } else {
            $character = new Character();
        }

        $form = $this->createForm(CharacterType::class, $character);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Personnage enregistré');
            return $this->redirectToRoute('app_admin_palia_characters');
        }

        return $this->render('admin/palia/character/edit.html.twig', [
            'character' => $character,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/palia/characters/delete/{id}', name: 'app_admin_palia_character_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminPaliaCharacterDelete(CharacterRepository $characterRepository, EntityManagerInterface $em, $id): RedirectResponse
    {
        if(!$id) {
            $this->addFlash('error', 'Personnage introuvable...');
            return $this->redirectToRoute('app_admin_palia_characters');
        }

        $character = $characterRepository->findOneBy(['id' => $id]);
        if(!$character) {
            $this->addFlash('error', 'Personnage introuvable...');
            return $this->redirectToRoute('app_admin_palia_characters');
        }

        $em->remove($character);
        $em->flush();

        $this->addFlash('success', 'Personnage supprimé');
        return $this->redirectToRoute('app_admin_palia_characters');
    }

    #[Route('/admin/palia/characters/groups/{id}', name: 'app_admin_palia_characters_groups', defaults: ['id' => null])]
    public function appAdminPaliaCharactersGroups(CharacterGroupRepository $characterGroupRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        $groups = $characterGroupRepository->findAll();

        if($id) {
            $group = $characterGroupRepository->findOneBy(['id' => $id]);

            if(!$group) {
                $this->addFlash('error', 'Localisation introuvable...');
                return $this->redirectToRoute('app_admin_palia_characters_groups');
            }
        } else {
            $group = new CharacterGroup();
        }

        $form = $this->createForm(CharacterGroupType::class, $group);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $location = $form->getData();

            $em->persist($location);
            $em->flush();

            $this->addFlash('success', 'Localisation enregistrée');
            return $this->redirectToRoute('app_admin_palia_characters_groups');
        }

        return $this->render('admin/palia/character/group.html.twig', [
            'groups' => $groups,
            'group' => $group,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/palia/characters/groups/delete/{id}', name: 'app_admin_palia_character_group_delete')]
    public function appAdminPaliaCharacterGroupDelete(CharacterGroupRepository $characterGroupRepository, EntityManagerInterface $em, $id): RedirectResponse
    {
        if(!$id) {
            $this->addFlash('error', 'Groupe introuvable...');
            return $this->redirectToRoute('app_admin_palia_characters_groups');
        }

        $group = $characterGroupRepository->findOneBy(['id' => $id]);
        if(!$group) {
            $this->addFlash('error', 'Groupe introuvable...');
            return $this->redirectToRoute('app_admin_palia_characters_groups');
        }

        $em->remove($group);
        $em->flush();

        $this->addFlash('success', 'Groupe supprimé');
        return $this->redirectToRoute('app_admin_palia_characters_groups');
    }
}

<?php

namespace App\Controller\Admin\Gw2\Fish;

use App\Entity\Gw2\Fish\Achievement;
use App\Form\Admin\Gw2\Fish\AchievementType;
use App\Repository\Gw2\Fish\AchievementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_GW2')]
class AchievementController extends AbstractController
{
    #[Route('/admin/gw2/fish/achievements', name: 'app_admin_gw2_fish_achievements')]
    public function appAdminGw2FishAchievements(AchievementRepository $achievementRepository): Response
    {
        $achievements = $achievementRepository->findAll();
        return $this->render('admin/gw2/fish/achievement/index.html.twig', [
            'achievements' => $achievements,
        ]);
    }

    #[Route('/admin/gw2/fish/achievements/edit/{id}', name: 'app_admin_gw2_fish_achievement_edit', defaults: ['id' => null])]
    public function index($id, AchievementRepository $achievementRepository, Request $request, EntityManagerInterface $em): Response
    {
        if($id) {
            $achievement = $achievementRepository->findOneBy(['id' => $id]);

            if(!$achievement) {
                $this->addFlash('error', 'Succès de pêche introuvable');
                return $this->redirectToRoute('app_admin_gw2_fish_achievements');
            }
        } else {
            $achievement = new Achievement();
        }

        $form = $this->createForm(AchievementType::class, $achievement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $achievement = $form->getData();
            $em->persist($achievement);
            $em->flush();

            $this->addFlash('success', 'Succès de pêche enregistré');
            return $this->redirectToRoute('app_admin_gw2_fish_achievements');
        }

        return $this->render('admin/gw2/fish/achievement/edit.html.twig', [
            'achievement' => $achievement,
            'form' => $form->createView()
        ]);
    }
}

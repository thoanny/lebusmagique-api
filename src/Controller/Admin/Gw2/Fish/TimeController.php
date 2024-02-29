<?php

namespace App\Controller\Admin\Gw2\Fish;

use App\Entity\Gw2\Fish\Time;
use App\Form\Admin\Gw2\Fish\TimeType;
use App\Repository\Gw2\Fish\TimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TimeController extends AbstractController
{
    #[Route('/admin/gw2/fish/times/{id}', name: 'app_admin_gw2_fish_time', defaults: ['id' => null])]
    public function appAdminGw2FishTime(Request $request, EntityManagerInterface $em, TimeRepository $timeRepository, $id): Response
    {
        if($id) {
            $time = $timeRepository->findOneBy(['id' => $id]);
            if(!$time) {
                $this->addFlash('error', 'Horaire introuvable.');
                return $this->redirectToRoute('app_admin_gw2_fish_time');
            }
        } else {
            $time = new Time();
        }

        $times = $timeRepository->findAll();

        $form = $this->createForm(TimeType::class, $time);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $time = $form->getData();

            $em->persist($time);
            $em->flush();

            $this->addFlash('success', 'Horaire enregistré');
            return $this->redirectToRoute('app_admin_gw2_fish_time');
        }
        return $this->render('admin/gw2/fish/time/index.html.twig', [
            'times' => $times,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/gw2/fish/times/delete/{id}', name: 'app_admin_gw2_fish_time_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminGw2FishTimeDelete(EntityManagerInterface $em, TimeRepository $timeRepository, $id): RedirectResponse
    {
        $time = $timeRepository->findOneBy(['id' => $id]);
        if(!$time) {
            $this->addFlash('error', 'Horaire introuvable.');
            return $this->redirectToRoute('app_admin_gw2_fish_time');
        }

        $em->remove($time);
        $em->flush();

        $this->addFlash('success', 'Horaire supprimé.');
        return $this->redirectToRoute('app_admin_gw2_fish_time');
    }
}

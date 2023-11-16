<?php

namespace App\Controller\Admin\Gw2\Fish;

use App\Entity\Gw2\Fish\Daily;
use App\Form\Admin\Gw2\Fish\DailyType;
use App\Repository\Gw2\Fish\DailyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_GW2')]
class DailyController extends AbstractController
{
    #[Route('/admin/gw2/fish/dailies', name: 'app_admin_gw2_fish_dailies')]
    public function index(DailyRepository $dailyRepository, PaginatorInterface $paginator, Request $request, EntityManagerInterface $em): Response
    {
        $dailies = $paginator->paginate(
            $dailyRepository->findBy([], ['day' => 'DESC']),
            $request->query->getInt('page', 1),
            25
        );

        $form = $this->createForm(DailyType::class, new Daily());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $daily = $form->getData();

            $em->persist($daily);
            $em->flush();

            $this->addFlash('success', 'Poisson quotidien enregistrée');
            return $this->redirectToRoute('app_admin_gw2_fish_dailies');
        }

        return $this->render('admin/gw2/fish/daily/index.html.twig', [
            'dailies' => $dailies,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/gw2/fish/dailies/delete/{id}', name: 'app_admin_gw2_fish_daily_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete($id, DailyRepository $dailyRepository, EntityManagerInterface $em): RedirectResponse
    {
        $daily = $dailyRepository->findOneBy(['id' => $id]);
        if(!$daily) {
            $this->addFlash('error', 'Poisson quotidien introuvable');
            return $this->redirectToRoute('app_admin_gw2_fish_dailies');
        }

        $em->remove($daily);
        $em->flush();

        $this->addFlash('success', 'Poisson quotidien supprimé');
        return $this->redirectToRoute('app_admin_gw2_fish_dailies');
    }
}

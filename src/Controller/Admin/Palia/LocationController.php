<?php

namespace App\Controller\Admin\Palia;

use App\Entity\Palia\Location;
use App\Form\Admin\Palia\LocationType;
use App\Repository\Palia\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_PALIA')]
class LocationController extends AbstractController
{

    #[Route('/admin/palia/locations/{id}', name: 'app_admin_palia_locations', defaults: ['id' => null])]
    public function appAdminPaliaLocations(LocationRepository $locationRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        $locations = $locationRepository->findAll();

        if($id) {
            $location = $locationRepository->findOneBy(['id' => $id]);

            if(!$location) {
                $this->addFlash('error', 'Localisation introuvable...');
                return $this->redirectToRoute('app_admin_palia_locations');
            }
        } else {
            $location = new Location();
        }

        $form = $this->createForm(LocationType::class, $location);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $location = $form->getData();

            $em->persist($location);
            $em->flush();

            $this->addFlash('success', 'Localisation enregistrée');
            return $this->redirectToRoute('app_admin_palia_locations');
        }

        return $this->render('admin/palia/location/index.html.twig', [
            'locations' => $locations,
            'location' => $location,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/palia/locations/delete/{id}', name: 'app_admin_palia_location_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminPaliaLocationDelete(LocationRepository $locationRepository, EntityManagerInterface $em, $id): RedirectResponse
    {
        if(!$id) {
            $this->addFlash('error', 'Localisation introuvable...');
            return $this->redirectToRoute('app_admin_palia_locations');
        }

        $category = $locationRepository->findOneBy(['id' => $id]);
        if(!$category) {
            $this->addFlash('error', 'Localisation introuvable...');
            return $this->redirectToRoute('app_admin_palia_locations');
        }

        $em->remove($category);
        $em->flush();

        $this->addFlash('success', 'Localisation supprimée');
        return $this->redirectToRoute('app_admin_palia_locations');
    }
}

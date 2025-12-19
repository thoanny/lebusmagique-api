<?php

namespace App\Controller\Admin\Gw2;

use App\Entity\Gw2Api\WizardVaultObjective;
use App\Form\Admin\Gw2\WizardVaultObjectiveType;
use App\Repository\Gw2Api\WizardVaultObjectiveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_GW2')]
class WizardVaultController extends AbstractController
{
    #[Route('/admin-old/gw2/wizard-vault/objectives', name: 'app_admin_gw2_wizard_vault_objectives')]
    public function appAdminGw2WizardVaultObjectives(WizardVaultObjectiveRepository $objectiveRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $filters = [
            's' => $request->query->get('s')
        ];

        $objectives = $paginator->paginate(
            $objectiveRepository->findByFilters($filters),
            $request->query->getInt('page', 1),
            25
        );
        return $this->render('admin/gw2/wizard-vault/objective/index.html.twig', [
            'objectives' => $objectives,
            'filters' => $filters
        ]);
    }

    #[Route('/admin-old/gw2/wizard-vault/objectives/edit/{id}', name: 'app_admin_gw2_wizard_vault_objective_edit', defaults: ['id' => null])]
    public function appAdminGw2WizardVaultObjectiveEdit(WizardVaultObjectiveRepository $objectiveRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        if($id) {
            $objective = $objectiveRepository->findOneBy(['id' => $id]);

            if(!$objective) {
                $this->addFlash('error', 'Objectif introuvable...');
                return $this->redirectToRoute('app_admin_gw2_wizard_vault_objectives');
            }
        } else {
            $objective = new WizardVaultObjective();
        }

        $form = $this->createForm(WizardVaultObjectiveType::class, $objective);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $objective = $form->getData();

            if(!$id) {
                $objective->setCreatedAt(new \DateTimeImmutable());
            }

            $objective->setUpdatedAt(new \DateTimeImmutable());

            $em->persist($objective);
            $em->flush();

            $this->addFlash('success', 'Objectif enregistré');
            return $this->redirectToRoute('app_admin_gw2_wizard_vault_objectives');
        }

        return $this->render('admin/gw2/wizard-vault/objective/edit.html.twig', [
            'objective' => $objective,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin-old/gw2/wizard-vault/objectives/delete/{id}', name: 'app_admin_gw2_wizard_vault_objective_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminGw2WizardVaultObjectiveDelete(WizardVaultObjectiveRepository $objectiveRepository, EntityManagerInterface $em, $id): RedirectResponse
    {
        if(!$id) {
            $this->addFlash('error', 'Objectif introuvable...');
            return $this->redirectToRoute('app_admin_gw2_wizard_vault_objectives');
        }

        $objective = $objectiveRepository->findOneBy(['id' => $id]);
        if(!$objective) {
            $this->addFlash('error', 'Objectif introuvable...');
            return $this->redirectToRoute('app_admin_gw2_wizard_vault_objectives');
        }

        $em->remove($objective);
        $em->flush();

        $this->addFlash('success', 'Objectif supprimé');
        return $this->redirectToRoute('app_admin_gw2_wizard_vault_objectives');
    }
}

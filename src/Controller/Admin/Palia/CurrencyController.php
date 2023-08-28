<?php

namespace App\Controller\Admin\Palia;

use App\Entity\Palia\Currency;
use App\Form\Admin\Palia\CurrencyType;
use App\Repository\Palia\CurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_PALIA')]
class CurrencyController extends AbstractController
{
    #[Route('/admin/palia/currencies/{id}', name: 'app_admin_palia_currencies', defaults: ['id' => null])]
    public function appAdminPaliaCurrencies(CurrencyRepository $currencyRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        $currencies = $currencyRepository->findAll();

        if($id) {
            $currency = $currencyRepository->findOneBy(['id' => $id]);

            if(!$currency) {
                $this->addFlash('error', 'Monnaie introuvable...');
                return $this->redirectToRoute('app_admin_palia_currencies');
            }
        } else {
            $currency = new Currency();
        }

        $form = $this->createForm(CurrencyType::class, $currency);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $skill = $form->getData();

            $em->persist($skill);
            $em->flush();

            $this->addFlash('success', 'Monnaie enregistrée');
            return $this->redirectToRoute('app_admin_palia_currencies');
        }

        return $this->render('admin/palia/currency/index.html.twig', [
            'currencies' => $currencies,
            'currency' => $currency,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/palia/currencies/delete/{id}', name: 'app_admin_palia_currency_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminPaliaSkillDelete(CurrencyRepository $currencyRepository, EntityManagerInterface $em, $id): RedirectResponse
    {
        if(!$id) {
            $this->addFlash('error', 'Monnaie introuvable...');
            return $this->redirectToRoute('app_admin_palia_currencies');
        }

        $currency = $currencyRepository->findOneBy(['id' => $id]);
        if(!$currency) {
            $this->addFlash('error', 'Monnaie introuvable...');
            return $this->redirectToRoute('app_admin_palia_currencies');
        }

        $em->remove($currency);
        $em->flush();

        $this->addFlash('success', 'Monnaie supprimée');
        return $this->redirectToRoute('app_admin_palia_currencies');
    }
}

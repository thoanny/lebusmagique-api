<?php

namespace App\Controller\Admin\Lbm\Ticket;

use App\Entity\Lbm\Ticket\Validate;
use App\Repository\Lbm\Ticket\ValidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/lbm/tickets/validates')]
class ValidateController extends AbstractController
{
    #[Route('/', name: 'app_admin_lbm_ticket_validate_index', methods: ['GET'])]
    public function index(ValidateRepository $validateRepository): Response
    {
        return $this->render('admin/lbm/ticket/validate/index.html.twig', [
            'validates' => $validateRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_lbm_ticket_validate_show', methods: ['GET'])]
    public function show(Validate $validate): Response
    {
        return $this->render('admin/lbm/ticket/validate/show.html.twig', [
            'validate' => $validate,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_lbm_ticket_validate_delete', methods: ['POST'])]
    public function delete(Request $request, Validate $validate, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$validate->getId(), $request->request->get('_token'))) {
            $entityManager->remove($validate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_lbm_ticket_validate_index', [], Response::HTTP_SEE_OTHER);
    }
}

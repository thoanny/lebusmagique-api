<?php

namespace App\Controller\Admin\Lbm\Ticket;

use App\Entity\Lbm\Ticket\Guild;
use App\Form\Admin\Lbm\Ticket\GuildType;
use App\Repository\Lbm\Ticket\GuildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/lbm/tickets/guilds')]
class GuildController extends AbstractController
{
    #[Route('/', name: 'app_admin_lbm_ticket_guild_index', methods: ['GET'])]
    public function index(GuildRepository $guildRepository): Response
    {
        return $this->render('admin/lbm/ticket/guild/index.html.twig', [
            'guilds' => $guildRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_lbm_ticket_guild_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $guild = new Guild();
        $form = $this->createForm(GuildType::class, $guild);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($guild);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_lbm_ticket_guild_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lbm/ticket/guild/new.html.twig', [
            'guild' => $guild,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_lbm_ticket_guild_show', methods: ['GET'])]
    public function show(Guild $guild): Response
    {
        return $this->render('admin/lbm/ticket/guild/show.html.twig', [
            'guild' => $guild,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_lbm_ticket_guild_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Guild $guild, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GuildType::class, $guild);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_lbm_ticket_guild_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lbm/ticket/guild/edit.html.twig', [
            'guild' => $guild,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_lbm_ticket_guild_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Guild $guild, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guild->getId(), $request->request->get('_token'))) {
            $entityManager->remove($guild);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_lbm_ticket_guild_index', [], Response::HTTP_SEE_OTHER);
    }
}

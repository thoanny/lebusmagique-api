<?php

namespace App\Controller\Admin\Lbm;

use App\Entity\Lbm\Ticket\Guild;
use App\Form\Admin\Lbm\Ticket\GuildType;
use App\Repository\Lbm\Ticket\GuildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    #[Route('/admin/lbm/tickets/requests', name: 'app_admin_lbm_tickets_requests')]
    public function appAdminLbmTicketsRequests(): Response
    {
        return $this->render('admin/lbm/ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }

    #[Route('/admin/lbm/tickets/blacklist', name: 'app_admin_lbm_tickets_blacklist')]
    public function appAdminLbmTicketsBlacklist(): Response
    {
        return $this->render('admin/lbm/ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }

    #[Route('/admin/lbm/tickets/validate', name: 'app_admin_lbm_tickets_validate')]
    public function appAdminLbmTicketsValidate(): Response
    {
        return $this->render('admin/lbm/ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }

    #[Route('/admin/lbm/tickets/guilds/{id}', name: 'app_admin_lbm_tickets_guilds', defaults: ['id' => null])]
    public function appAdminLbmTicketsGuilds(GuildRepository $guildRepository, Request $request, EntityManagerInterface $em, $id): Response
    {
        $guilds = $guildRepository->findBy([], ['sortOrder' => 'ASC', 'name' => 'ASC']);

        if($id) {
            $guild = $guildRepository->findOneBy(['id' => $id]);

            if(!$guild) {
                $this->addFlash('error', 'Guilde introuvable...');
                return $this->redirectToRoute('app_admin_lbm_tickets_guilds');
            }
        } else {
            $guild = new Guild();
        }

        $form = $this->createForm(GuildType::class, $guild);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $guild = $form->getData();

            // TODO : vérifier que la clé API est OK avec l'identifiant de la guilde

            $em->persist($guild);
            $em->flush();

            $this->addFlash('success', 'Guilde enregistrée');
            return $this->redirectToRoute('app_admin_lbm_tickets_guilds');
        }

        return $this->render('admin/lbm/ticket/guilds.html.twig', [
            'guilds' => $guilds,
            'guild' => $guild,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/lbm/tickets/guilds/{id}/delete', name: 'app_admin_lbm_tickets_guild_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function appAdminLbmTicketsGuildDelete($id, GuildRepository $guildRepository, EntityManagerInterface $em): Response
    {
        $guild = $guildRepository->findOneBy(['id' => $id]);
        if(!$guild) {
            $this->addFlash('error', 'Guilde introuvable...');
            return $this->redirectToRoute('app_admin_lbm_tickets_guilds');
        }

        $em->remove($guild);
        $em->flush();

        $this->addFlash('success', 'Guild supprimée');
        return $this->redirectToRoute('app_admin_lbm_tickets_guilds');
    }

    #[Route('/admin/lbm/tickets/guilds/{id}/toggle', name: 'app_admin_lbm_tickets_guild_toggle')]
    public function appAdminLbmTicketsGuildToggle($id, GuildRepository $guildRepository, EntityManagerInterface $em): Response
    {
        $guild = $guildRepository->findOneBy(['id' => $id]);
        if(!$guild) {
            $this->addFlash('error', 'Guilde introuvable...');
            return $this->redirectToRoute('app_admin_lbm_tickets_guilds');
        }

        $guild->setActive(!$guild->isActive());
        $em->persist($guild);
        $em->flush();

        $this->addFlash('success', sprintf('Guilde %s', ($guild->isActive() ? 'activée' : 'désactivée')));
        return $this->redirectToRoute('app_admin_lbm_tickets_guilds');
    }

}

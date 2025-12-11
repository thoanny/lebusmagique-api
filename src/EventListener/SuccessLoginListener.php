<?php namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SuccessLoginListener
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();
        $user->setLastLoginAt(new \DateTimeImmutable());
        $this->em->persist($user);
        $this->em->flush();
    }

}
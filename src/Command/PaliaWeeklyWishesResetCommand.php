<?php

namespace App\Command;

use App\Repository\Palia\CharacterWishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'palia:weekly-wishes-reset')]
class PaliaWeeklyWishesResetCommand extends Command
{
    public function __construct(private EntityManagerInterface $entityManager, private CharacterWishRepository $characterWishRepository, string $name = null)
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $wishes = $this->characterWishRepository->findAll();
        if($wishes) {
            foreach ($wishes as $wish) {
                $this->entityManager->remove($wish);
            }

            $this->entityManager->flush();
            $this->entityManager->clear();
        }

        $io->success('Palia characters\' wishes resetted.');
        return Command::SUCCESS;
    }
}

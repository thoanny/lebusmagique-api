<?php

namespace App\Command;

use App\Repository\Gw2Api\WizardVaultObjectiveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'gw2-wizard-vault:weekly-reset',
)]
class Gw2WizardVaultWeeklyResetCommand extends Command
{
    public function __construct(private EntityManagerInterface $entityManager, private WizardVaultObjectiveRepository $objectiveRepository, string $name = null)
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $objectives = $this->objectiveRepository->findBy([
            'active' => true,
            'period' => 'weekly'
        ]);

        if($objectives) {
            foreach ($objectives as $obj) {
                $obj->setActive(null);
            }

            $this->entityManager->flush();
            $this->entityManager->clear();
        }

        $io->success('Réinitialisation des objectifs hebdomadaires de la Chambre forte du sorcier terminée');

        return Command::SUCCESS;
    }
}

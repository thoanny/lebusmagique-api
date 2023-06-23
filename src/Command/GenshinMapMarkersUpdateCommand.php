<?php

namespace App\Command;

use App\Repository\Genshin\Map\MapRepository;
use App\Repository\Genshin\Map\MarkerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'genshin:map-markers-update',
    description: 'Update Genshin Map Makers coords',
)]
class GenshinMapMarkersUpdateCommand extends Command
{

    private MapRepository $mapRepository;
    private MarkerRepository $markerRepository;
    private $entityManager;

    public function __construct(MapRepository $mapRepository, MarkerRepository $markerRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->mapRepository = $mapRepository;
        $this->markerRepository = $markerRepository;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $question = new ChoiceQuestion(
            'Choisissez une carte :',
            $this->mapRepository->findBy([], ['name' => 'ASC']),
            0
        );
        $question->setErrorMessage('Carte %s invalide.');
        $map = $helper->ask($input, $output, $question);
        $output->writeln('Vous avez sélectionné la carte : '. $map);

        $output->writeln('Indiquez les valeurs que vous souhaitez ajouter (+n) ou retirer (-n) aux marqueurs de cette carte.');

        $question = new Question('Position X :', 0);
        $x = $helper->ask($input, $output, $question);

        $question = new Question('Position Y :', 0);
        $y = $helper->ask($input, $output, $question);

        $question = new ConfirmationQuestion("Êtes vous sûr de modifier la position des marqueurs, avec X ($x) et Y ($y) pour la carte $map ? (y/n)", false);
        if(!$helper->ask($input, $output, $question)) {
            $output->writeln('Mise à jour annulée.');
            return Command::SUCCESS;
        }

        $batchSize = 100;
        $markers = $this->markerRepository->findByMap($map->getId());

        $progressBar = new ProgressBar($output, count($markers));
        $progressBar->start();

        foreach($markers as $i => $m) {
            $m->setX(eval('return '.$m->getX().$x.';'));
            $m->setY(eval('return '.$m->getY().$y.';'));

            if (($i % $batchSize) === 0) {
                $this->entityManager->flush();
            }

            $progressBar->advance();
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

        $progressBar->finish();

        return Command::SUCCESS;
    }
}

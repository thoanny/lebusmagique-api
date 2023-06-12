<?php

namespace App\Command;

use App\Entity\Gw2Api\Item;
use App\Repository\Gw2Api\ItemRepository;
use App\Service\Gw2Api;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'gw2api:items:init',
    description: 'Init GW2 API items',
)]
class Gw2apiItemsInitCommand extends Command
{
    private Gw2Api $Gw2Api;
    private ItemRepository $itemRepository;
    private EntityManagerInterface $em;
    private ParameterBagInterface $parameterBag;
    public function __construct( Gw2Api $Gw2Api, ItemRepository $itemRepository, EntityManagerInterface $em, ParameterBagInterface $parameterBag, string $name = null)
    {
        parent::__construct($name);
        $this->Gw2Api = $Gw2Api;
        $this->itemRepository = $itemRepository;
        $this->em = $em;
        $this->parameterBag = $parameterBag;
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $items = $this->Gw2Api->getItems();
        $io->progressStart(count($items));

        $chunks = array_chunk($items, 200);
        foreach($chunks as $chunk) {
            $ids = implode(',', $chunk);
            $_items = $this->Gw2Api->getItems($ids);
            foreach($_items as $i) {
                $item = $this->itemRepository->findOneBy(['uid' => $i['id']]);
                if(!$item) {
                    $text = [];
                    if (isset($i['description'])) {
                        $text[] = $i['description'];
                    }
                    if (isset($i['details']['description'])) {
                        $text[] = $i['details']['description'];
                    }

                    $item = (new Item())
                        ->setUid($i['id'])
                        ->setName($i['name'])
                        ->setText(implode(' ', $text))
                        ->setType($i['type'])
                        ->setSubtype(($i['details']['type'] ?? null))
                        ->setRarity($i['rarity'])
                        ->setUpdatedAt(new \DateTimeImmutable('- 40 days'))
                        ->setData($i)
                    ;

                    $iconsDirectory = $this->parameterBag->get('api.uploads.gw2.items');
                    $iconFile = "$iconsDirectory/{$i['id']}.png";
                    if (!file_exists($iconFile)) {
                        $iconContent = @file_get_contents($i['icon']);
                        if ($iconContent) {
                            file_put_contents($iconFile, $iconContent);
                        }
                    }

                    $this->em->persist($item);
                }

                $io->progressAdvance();
            }

            $this->em->flush();
            $this->em->clear();

        }

        $io->progressFinish();

        $output->writeln('Items: ' . count($items));

        return Command::SUCCESS;
    }
}

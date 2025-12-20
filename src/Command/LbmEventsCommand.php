<?php

namespace App\Command;

use App\Entity\Lbm\Event\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'lbm:events',
    description: 'Update LBM events data',
)]
class LbmEventsCommand extends Command
{
    public function __construct(
        private ParameterBagInterface $parameter,
        private HttpClientInterface $client,
        private EntityManagerInterface $em,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $key = $this->parameter->get('aleeva.api.key');
            $discord = $this->parameter->get('lbm.discord.id');

            if(!$key) {
                throw new \Error('Aleeva API Key is missing');
            }

            if(!$discord) {
                throw new \Error('Discord ID is missing');
            }

            $response = $this->client->request(
                'GET',
                "https://api.aleeva.io/server/$discord/event", [
                    'auth_bearer' => $key,
                ],
            );

            $content = $response->getContent();
            $data = json_decode($content, true);

            foreach($data['content'] as $event) {
                $lbmEvent = $this->em->getRepository(Event::class)->findOneBy(['uid' => $event['id']]);
                if($lbmEvent)  {
                    if(sha1($lbmEvent->getData()) !== sha1($event)) {
                        $lbmEvent
                            ->setStartAt(new \DateTimeImmutable($event['dateTime']))
                            ->setEndAt(new \DateTimeImmutable($event['endDate']))
                            ->setData($event)
                        ;
                        $this->em->flush();
                    }
                } else {
                    $lbmEvent = (new Event())
                        ->setUid($event['id'])
                        ->setStartAt(new \DateTimeImmutable($event['dateTime']))
                        ->setEndAt(new \DateTimeImmutable($event['endDate']))
                        ->setData($event)
                    ;
                    $this->em->persist($lbmEvent);
                    $this->em->flush();
                }
            }

            $io->success('LBM Events updated.');
            return Command::SUCCESS;
        } catch (\Error $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}

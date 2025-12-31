<?php

namespace App\Command;

use App\Entity\Lbm\Event\Event;
use App\Repository\Lbm\Event\EventRepository;
use App\Service\ImageFromUrlUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Notifier\Bridge\Discord\DiscordOptions;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordEmbed;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordFieldEmbedObject;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
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
        private ImageFromUrlUploader $imageFromUrlUploader,
        private EventRepository $eventRepository,
        private ChatterInterface $chatter,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                name: 'clean',
                mode: InputOption::VALUE_NONE,
            )
        ;
        $this
            ->addOption(
                name: 'discord',
                mode: InputOption::VALUE_NONE,
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if($input->getOption('clean')) {
            return $this->execCleanEvents($input, $output);
        }

        if($input->getOption('discord')) {
            return $this->execDiscordEvents($input, $output);
        }

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

            $skipped = 0;
            $added = 0;
            $updated = 0;

            $progressBar = new ProgressBar($output, count($data['content']));
            $progressBar->start();

            foreach($data['content'] as $event) {
                $progressBar->advance();

                $lbmEvent = $this->eventRepository->findOneBy(['uid' => $event['id']]);
                if($lbmEvent)  {
                    if(
                        sha1(json_encode([
                            $lbmEvent->getTitle(),
                            $lbmEvent->getDescription(),
                            new \DateTimeImmutable($lbmEvent->getData()['dateTime']),
                            new \DateTimeImmutable($lbmEvent->getData()['endDate']),
                            $lbmEvent->getData()['image'],
                            $lbmEvent->getData()['subscriberCount'],
                            $lbmEvent->getData()['maxSubscribers'],
                        ])) !== sha1(json_encode([
                            $event['title'],
                            $event['description'],
                            new \DateTimeImmutable($event['dateTime']),
                            new \DateTimeImmutable($event['endDate']),
                            $event['image'],
                            $event['subscriberCount'],
                            $event['maxSubscribers'],
                        ]))
                    ) {

                        if ($event['image'] !== $lbmEvent->getData()['image']) {
                            $imageFile = $this->imageFromUrlUploader->downloadToTempFile($event['image']);
                            if ($imageFile) {
                                $lbmEvent->setImageFile($imageFile);
                            }
                        }

                        $lbmEvent
                            ->setStartAt(new \DateTimeImmutable($event['dateTime']))
                            ->setEndAt(new \DateTimeImmutable($event['endDate']))
                            ->setData($event);

                        $this->em->flush();
                        $updated++;
                    } else {
                        $skipped++;
                    }
                } else {
                    $lbmEvent = (new Event())
                        ->setUid($event['id'])
                        ->setStartAt(new \DateTimeImmutable($event['dateTime']))
                        ->setEndAt(new \DateTimeImmutable($event['endDate']))
                        ->setData($event)
                    ;

                    if($event['image']) {
                        $imageFile = $this->imageFromUrlUploader->downloadToTempFile($event['image']);
                        if($imageFile) {
                            $lbmEvent->setImageFile($imageFile);
                        }
                    }

                    $this->em->persist($lbmEvent);
                    $this->em->flush();

                    $added++;
                }
            }

            $progressBar->finish();
            $io->success(sprintf('LBM Events: %d skipped, %d added, %d updated', $skipped, $added, $updated));
            return Command::SUCCESS;
        } catch (\Error $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }
    }

    private function execCleanEvents(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $events = $this->eventRepository->findOutdatedEventsForCleanup();

        $progressBar = new ProgressBar($output, count($events));
        $progressBar->start();

        foreach($events as $event) {
            $this->em->remove($event);
            $this->em->flush();
            $progressBar->advance();
        }

        $progressBar->finish();
        $io->success(sprintf('LBM Events: %d cleaned', count($events)));
        return Command::SUCCESS;
    }

    /**
     * @throws \Symfony\Component\Notifier\Exception\TransportExceptionInterface
     */
    private function execDiscordEvents(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $chatMessage = (new ChatMessage(':oncoming_bus::busstop: Inscrivez-vous à tous nos événements dans le canal <#696050811108720790> de notre Discord.'))
            ->transport('discord');
        $embed = new DiscordEmbed();

        $events = $this->eventRepository->findNextDaysEvents(10);
        $data = [];

        foreach($events as $event) {
            $day = $event->getStartAt()->format('Y-m-d');
            if(!isset($data[$day])) {
                $data[$day] = [];
            }

            $eventData = $event->getData();
            $data[$day][] = [
                'title' => $event->getTitle(),
                'leader' => $event->getLeaderGw2(),
                'seats' => $event->getSeats(),
                'timestamp' => $event->getStartAt()->getTimestamp(),
                'deeplink' => $eventData['deepLink'],
            ];
        }

        foreach($data as $day => $events) {
            $t = (new \DateTimeImmutable($day))->getTimestamp();
            $name = "<t:$t:D>";
            $values = [];
            foreach($events as $event) {
                $values[] = "— <t:{$event['timestamp']}:t> **[{$event['title']}]({$event['deeplink']})** / {$event['leader']} ({$event['seats']})";
            }

            $embed->addField((new DiscordFieldEmbedObject())
                ->name($name)
                ->value(join("\n", $values))
            );
        }


        $discordOptions = (new DiscordOptions())
            ->addEmbed($embed)
        ;

        $chatMessage->options($discordOptions);
        $this->chatter->send($chatMessage);

        $io->success('LBM Events: pushed to Discord');
        return Command::SUCCESS;
    }
}

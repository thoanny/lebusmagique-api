<?php

namespace App\Command;

use App\Entity\Lbm\Event\Event;
use App\Service\ImageFromUrlUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
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
        private ImageFromUrlUploader $imageFromUrlUploader
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \DateMalformedStringException
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
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

            $skipped = 0;
            $added = 0;
            $updated = 0;

            $progressBar = new ProgressBar($output, count($data['content']));
            $progressBar->start();

            foreach($data['content'] as $event) {
                $progressBar->advance();

                $lbmEvent = $this->em->getRepository(Event::class)->findOneBy(['uid' => $event['id']]);
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
}

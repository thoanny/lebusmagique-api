<?php

namespace App\Controller\Api\Lbm;

use App\Entity\Lbm\Feed\Item;
use App\Repository\Lbm\Feed\ItemRepository;
use App\Service\Api;
use App\Service\TinifyManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

#[Route('/api/lbm/feed')]
final class FeedController extends AbstractController
{
    /**
     * @throws \DateMalformedStringException
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/item', name: 'app_api_lbm_feed_item', methods: ['POST'])]
    public function addFeedItem(Api $api, Request $request, ItemRepository $itemRepository, EntityManagerInterface $entityManager, TinifyManager $tinifyManager): JsonResponse
    {
        $request = $api->transformJsonBody($request);
        $token = $request->get('token');

        $title = $request->get('title');
        $link = $request->get('link');
        $pub_date = $request->get('pub_date');
        $description = $request->get('description');
        $image = $request->get('image');

        if(null === $token || $token !== $this->getParameter('api.admin.token')) {
            return $api->respondUnauthorized();
        }

        if(!$title || !$link || !$pub_date || !$description) {
            return $api->respondBadRequest('Missing required parameter(s)');
        }

        $item = $itemRepository->findOneBy(['link' => $link]);
        if($item) {
            return $api->respondConflict('Feed item already exist');
        }

        $item = (new Item())
            ->setTitle($title)
            ->setLink($link)
            ->setPubDate(new \DateTimeImmutable($pub_date))
            ->setGuid(Uuid::v4()->toRfc4122())
            ->setDescription($description)
        ;

        if($image) {
            $imageFile = $tinifyManager->convert($image);
            if ($imageFile) {
                $item->setImageFile($imageFile);
            }
        }

        $entityManager->persist($item);
        $entityManager->flush();

        return $api->respondCreated('Feed item added.');
    }

    #[Route('/xml', name: 'app_api_lbm_feed_xml', defaults: ['_format' => 'xml'], methods: ['GET'])]
    public function getFeedXml(ItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findBy([], ['id' => 'DESC'], 50);
        return $this->render('api/lbm/feed/feed.xml.twig', [
            'items' => $items
        ]);
    }
}

// TODO : créer une commande pour nettoyer les anciens items
<?php

namespace App\Controller\Api\Lbm;

use App\Entity\Lbm\Feed\Item;
use App\Repository\Lbm\Feed\ItemRepository;
use App\Repository\Lbm\Feed\SourceRepository;
use App\Service\Api;
use App\Service\TinifyManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
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
    public function addFeedItem(Api $api, Request $request, ItemRepository $itemRepository, SourceRepository $sourceRepository, EntityManagerInterface $entityManager, TinifyManager $tinifyManager): JsonResponse
    {
        $request = $api->transformJsonBody($request);
        $token = $request->get('token');

        $title = $request->get('title');
        $link = $request->get('link');
        $pub_date = $request->get('pub_date');
        $description = $request->get('description');
        $image = $request->get('image');
        $externalImageUrl = $request->get('external_image_url');
        $sourceId = (int) $request->get('source', 0);
        $guid = $request->get('guid');

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

        $source = null;
        if($sourceId > 0) {
            $source = $sourceRepository->findOneBy(['id' => $sourceId]);
            if(!$source) {
                return $api->respondBadRequest('Source unknown');
            }
        }

        $item = (new Item())
            ->setTitle($title)
            ->setLink($link)
            ->setPubDate(new \DateTimeImmutable($pub_date))
            ->setGuid($guid ?? Uuid::v4()->toRfc4122())
            ->setDescription($description)
            ->setExternalImageUrl($externalImageUrl)
        ;

        if($source) {
            $item->setType($source->getType());
            $item->setUsername($source->getName());

            $source->setUpdatedAt(new \DateTimeImmutable());
        }

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
        $items = $itemRepository->findBy(['type' => null], ['id' => 'DESC'], 50);
        return $this->render('api/lbm/feed/feed.xml.twig', [
            'items' => $items
        ]);
    }

    #[Route('/', name: 'app_api_lbm_feed', methods: ['GET'])]
    public function getFeed(ItemRepository $itemRepository, SerializerInterface $serializer): JsonResponse
    {
        $items = $itemRepository->findBy([], ['pubDate' => 'DESC', 'id' => 'DESC'], 200);
        return new JsonResponse($serializer->serialize($items, 'json', ['groups' => ['feed']]), 200, [], true);

    }

    #[Route('/sources', name: 'app_api_lbm_feed_sources', methods: ['GET'])]
    public function getFeedSources(SourceRepository $sourceRepository, SerializerInterface $serializer): JsonResponse
    {
        $sources = $sourceRepository->findBy(['active' => true]);
        return new JsonResponse($serializer->serialize($sources, 'json', ['groups' => ['source']]), 200, [], true);

    }
}

// TODO : créer une commande pour nettoyer les anciens items
<?php

namespace App\Controller\Admin\Enshrouded;

use App\Entity\Enshrouded\Item;
use App\Form\Admin\Enshrouded\ItemType;
use App\Repository\Enshrouded\ItemRepository;
use App\Service\LiipCacheManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/enshrouded/items')]
class ItemController extends AbstractController
{
    private string $liipPath = '/uploads/api/enshrouded/items';
    private array $liipFilters = [
        'enshrouded_item_icon_96',
        'enshrouded_item_icon_48',
        'enshrouded_item_icon_24'
    ];

    #[Route('/', name: 'app_admin_enshrouded_item_index', methods: ['GET'])]
    public function index(ItemRepository $itemRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $s = $request->query->get('s');
        $items = $paginator->paginate(
            $itemRepository->adminItems($s),
            $request->query->getInt('page', 1),
            25
        );
        return $this->render('admin/enshrouded/item/index.html.twig', [
            'items' => $items,
            's' => $s,
        ]);
    }

    #[Route('/new', name: 'app_admin_enshrouded_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, LiipCacheManager $cacheManager): Response
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($item);
            $entityManager->flush();

            if($form->get('iconFile')->getData()) {
                $cacheManager->generate("$this->liipPath/{$item->getIcon()}", $this->liipFilters);
            }

            return $this->redirectToRoute('app_admin_enshrouded_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/item/new.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_item_show', methods: ['GET'])]
    public function show(Item $item): Response
    {
        return $this->render('admin/enshrouded/item/show.html.twig', [
            'item' => $item,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_enshrouded_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Item $item, EntityManagerInterface $entityManager, LiipCacheManager $cacheManager): Response
    {
        $currentIcon = $item->getIcon();

        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            if($form->get('iconFile')->getData()) {
                if($currentIcon) {
                    $cacheManager->remove("$this->liipPath/$currentIcon", $this->liipFilters);
                }
                $cacheManager->generate("$this->liipPath/{$item->getIcon()}", $this->liipFilters);
            }

            return $this->redirectToRoute('app_admin_enshrouded_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/enshrouded/item/edit.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_enshrouded_item_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Item $item, EntityManagerInterface $entityManager, CacheManager $cacheManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $entityManager->remove($item);
            $entityManager->flush();

            if($item->getIcon()) {
                $cacheManager->remove("$this->liipPath/{$item->getIcon()}", $this->liipFilters);
            }
        }

        return $this->redirectToRoute('app_admin_enshrouded_item_index', [], Response::HTTP_SEE_OTHER);
    }
}

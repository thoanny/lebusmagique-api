<?php

namespace App\Controller\Admin\Gw2;

use App\Form\Admin\Gw2\ItemType;
use App\Repository\Gw2\Fish\FishRepository;
use App\Repository\Gw2Api\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_GW2')]
class ItemsController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/admin/gw2/items', name: 'app_admin_gw2_items')]
    public function appAdminGw2Items(ItemRepository $itemRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $filters = [
            'is' => (in_array($request->query->get('is'), ['fish', 'fish-bait', 'blackmarket'])) ? $request->query->get('is') : null,
            'type' => $request->query->get('type'),
            'subtype' => $request->query->get('subtype'),
        ];

        $types = $itemRepository->adminItemsTypes();
        $subtypes = $itemRepository->adminItemsSubtypes();

        $items = $paginator->paginate(
            $itemRepository->adminItems($filters),
            $request->query->getInt('page', 1),
            25
        );

        return $this->render('admin/gw2/items/index.html.twig', [
            'items' => $items,
            'types' => $types,
            'subtypes' => $subtypes,
            'filters' => $filters
        ]);
    }

    #[Route('/admin/gw2/items/{id}', name: 'app_admin_gw2_item_edit')]
    public function appAdminGw2ItemEdit($id, ItemRepository $itemRepository, Request $request, FishRepository $fishRepository): Response
    {
        $item = $itemRepository->findOneBy(['id' => $id]);
        if(!$item) {
            $this->addFlash('error', 'Objet introuvable.');
            return $this->redirectToRoute('app_admin_gw2_items');
        }

        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            if(!$form->get('isFish')->getData() && $item->getFish()) {
                $item->setFish(null);
            }

            if(!$form->get('isFishBait')->getData() && $item->getBait()) {
                $fishes = $fishRepository->findBy(['bait' => $item->getBait()]);
                foreach($fishes as $f) {
                    $f->setBait(null);
                }
                $item->setBait(null);
            }

            $this->em->persist($item);
            $this->em->flush();

            $this->addFlash('success', 'Objet enregistré');
            return $this->redirectToRoute('app_admin_gw2_items');
        }

        return $this->render('admin/gw2/items/edit.html.twig', [
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }
}

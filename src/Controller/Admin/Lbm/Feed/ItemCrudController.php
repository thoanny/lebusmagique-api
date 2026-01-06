<?php

namespace App\Controller\Admin\Lbm\Feed;

use App\Entity\Lbm\Feed\Item;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

#[AdminRoute(path: '/lbm/feeds/items', name: 'lbm_feed_item')]
class ItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Item::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::NEW, Action::EDIT)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $imgPath = $this->getParameter('lbm.feed.image');
        return [
            IdField::new('id'),
            TextField::new('title', 'Titre'),
            TextEditorField::new('description'),
            UrlField::new('link', 'Lien'),
            DateTimeField::new('pubDate', 'Publication'),
            ImageField::new('image')->setBasePath($imgPath),
            TextField::new('guid')->onlyOnDetail(),
        ];
    }
}

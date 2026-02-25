<?php

namespace App\Controller\Admin\Lbm\Feed;

use App\Entity\Lbm\Feed\Source;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminRoute(path: '/lbm/feeds/sources', name: 'lbm_feed_source')]
class SourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Source::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $imgPath = $this->getParameter('lbm.feed.image');
        return [
            IdField::new('id')->hideOnForm(),
            ChoiceField::new('type')->setChoices([
                'Flux RSS' => 'rss',
                'YouTube' => 'youtube',
                'Twitch' => 'twitch',
            ]),
            TextField::new('name', 'Nom de la chaîne/du flux'),
            TextField::new('uid', 'Identifiant/URL'),
            DateTimeField::new('updatedAt')->hideOnForm(),
            BooleanField::new('active'),
        ];
    }
}

<?php

namespace App\Repository;

use App\Entity\Enshrouded\RecipeSourceItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeSourceItem>
 *
 * @method RecipeSourceItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeSourceItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeSourceItem[]    findAll()
 * @method RecipeSourceItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeSourceItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeSourceItem::class);
    }

//    /**
//     * @return RecipeSourceItem[] Returns an array of RecipeSourceItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RecipeSourceItem
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

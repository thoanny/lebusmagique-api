<?php

namespace App\Repository\Enshrouded;

use App\Entity\Enshrouded\RecipeCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeCategory>
 *
 * @method RecipeCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeCategory[]    findAll()
 * @method RecipeCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeCategory::class);
    }

//    /**
//     * @return RecipeCategory[] Returns an array of RecipeCategory objects
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

//    public function findOneBySomeField($value): ?RecipeCategory
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository\Enshrouded;

use App\Entity\Enshrouded\RecipeSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeSource>
 *
 * @method RecipeSource|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeSource|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeSource[]    findAll()
 * @method RecipeSource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeSourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeSource::class);
    }

//    /**
//     * @return RecipeSource[] Returns an array of RecipeSource objects
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

//    public function findOneBySomeField($value): ?RecipeSource
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}

<?php

namespace App\Repository\Enshrouded;

use App\Entity\Enshrouded\RecipeSourceNpc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeSourceNpc>
 *
 * @method RecipeSourceNpc|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeSourceNpc|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeSourceNpc[]    findAll()
 * @method RecipeSourceNpc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeSourceNpcRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeSourceNpc::class);
    }

//    /**
//     * @return RecipeSourceNpc[] Returns an array of RecipeSourceNpc objects
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

//    public function findOneBySomeField($value): ?RecipeSourceNpc
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

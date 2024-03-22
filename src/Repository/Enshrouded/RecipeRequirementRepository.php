<?php

namespace App\Repository\Enshrouded;

use App\Entity\Enshrouded\RecipeRequirement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeRequirement>
 *
 * @method RecipeRequirement|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeRequirement|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeRequirement[]    findAll()
 * @method RecipeRequirement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRequirementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeRequirement::class);
    }

//    /**
//     * @return RecipeRequirement[] Returns an array of RecipeRequirement objects
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

//    public function findOneBySomeField($value): ?RecipeRequirement
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

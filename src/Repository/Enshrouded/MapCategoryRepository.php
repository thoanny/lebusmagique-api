<?php

namespace App\Repository\Enshrouded;

use App\Entity\Enshrouded\MapCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MapCategory>
 *
 * @method MapCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method MapCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method MapCategory[]    findAll()
 * @method MapCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MapCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MapCategory::class);
    }

//    /**
//     * @return MapCategory[] Returns an array of MapCategory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MapCategory
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

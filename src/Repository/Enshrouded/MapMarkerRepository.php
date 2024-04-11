<?php

namespace App\Repository\Enshrouded;

use App\Entity\Enshrouded\MapMarker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MapMarker>
 *
 * @method MapMarker|null find($id, $lockMode = null, $lockVersion = null)
 * @method MapMarker|null findOneBy(array $criteria, array $orderBy = null)
 * @method MapMarker[]    findAll()
 * @method MapMarker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MapMarkerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MapMarker::class);
    }

//    /**
//     * @return MapMarker[] Returns an array of MapMarker objects
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

//    public function findOneBySomeField($value): ?MapMarker
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

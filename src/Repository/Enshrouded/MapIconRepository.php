<?php

namespace App\Repository\Enshrouded;

use App\Entity\Enshrouded\MapIcon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MapIcon>
 *
 * @method MapIcon|null find($id, $lockMode = null, $lockVersion = null)
 * @method MapIcon|null findOneBy(array $criteria, array $orderBy = null)
 * @method MapIcon[]    findAll()
 * @method MapIcon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MapIconRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MapIcon::class);
    }

//    /**
//     * @return MapIcon[] Returns an array of MapIcon objects
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

//    public function findOneBySomeField($value): ?MapIcon
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

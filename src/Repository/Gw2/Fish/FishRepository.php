<?php

namespace App\Repository\Gw2\Fish;

use App\Entity\Gw2\Fish\Fish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fish>
 *
 * @method Fish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fish[]    findAll()
 * @method Fish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fish::class);
    }

//    /**
//     * @return Fish[] Returns an array of Fish objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Fish
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

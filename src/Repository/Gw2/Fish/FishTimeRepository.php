<?php

namespace App\Repository\Gw2\Fish;

use App\Entity\Gw2\Fish\FishTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FishTime>
 *
 * @method FishTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method FishTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method FishTime[]    findAll()
 * @method FishTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FishTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FishTime::class);
    }

//    /**
//     * @return FishTime[] Returns an array of FishTime objects
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

//    public function findOneBySomeField($value): ?FishTime
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

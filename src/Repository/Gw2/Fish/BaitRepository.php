<?php

namespace App\Repository\Gw2\Fish;

use App\Entity\Gw2\Fish\Bait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bait>
 *
 * @method Bait|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bait|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bait[]    findAll()
 * @method Bait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bait::class);
    }

//    /**
//     * @return Bait[] Returns an array of Bait objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Bait
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

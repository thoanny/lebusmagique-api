<?php

namespace App\Repository\Gw2;

use App\Entity\Gw2\Decoration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Decoration>
 *
 * @method Decoration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Decoration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Decoration[]    findAll()
 * @method Decoration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecorationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Decoration::class);
    }

//    /**
//     * @return Decoration[] Returns an array of Decoration objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Decoration
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

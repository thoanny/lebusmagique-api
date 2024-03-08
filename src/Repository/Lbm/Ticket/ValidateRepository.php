<?php

namespace App\Repository\Lbm\Ticket;

use App\Entity\Lbm\Ticket\Validate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Validate>
 *
 * @method Validate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Validate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Validate[]    findAll()
 * @method Validate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValidateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Validate::class);
    }

//    /**
//     * @return Validate[] Returns an array of Validate objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Validate
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

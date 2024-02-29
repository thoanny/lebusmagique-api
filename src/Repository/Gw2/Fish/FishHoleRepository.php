<?php

namespace App\Repository\Gw2\Fish;

use App\Entity\Gw2\Fish\FishHole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FishHole>
 *
 * @method FishHole|null find($id, $lockMode = null, $lockVersion = null)
 * @method FishHole|null findOneBy(array $criteria, array $orderBy = null)
 * @method FishHole[]    findAll()
 * @method FishHole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FishHoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FishHole::class);
    }

//    /**
//     * @return FishHole[] Returns an array of FishHole objects
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

//    public function findOneBySomeField($value): ?FishHole
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

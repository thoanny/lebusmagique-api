<?php

namespace App\Repository\Gw2;

use App\Entity\Gw2\Decoration;
use App\Entity\Gw2\DecorationCategory;
use App\Entity\Gw2Api\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DecorationCategory>
 *
 * @method DecorationCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method DecorationCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method DecorationCategory[]    findAll()
 * @method DecorationCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecorationCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DecorationCategory::class);
    }

//    /**
//     * @return DecorationCategory[] Returns an array of DecorationCategory objects
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

//    public function findOneBySomeField($value): ?DecorationCategory
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findAllForApi()
    {
        return $this->createQueryBuilder('c')
            ->select('c.id', 'c.name')
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}

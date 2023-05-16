<?php

namespace App\Repository\Gw2Api;

use App\Entity\Gw2Api\ItemPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ItemPrice>
 *
 * @method ItemPrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemPrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemPrice[]    findAll()
 * @method ItemPrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemPriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemPrice::class);
    }

    public function save(ItemPrice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ItemPrice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ItemPrice[] Returns an array of ItemPrice objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ItemPrice
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

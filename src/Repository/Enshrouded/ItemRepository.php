<?php

namespace App\Repository\Enshrouded;

use App\Entity\Enshrouded\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

//    /**
//     * @return Item[] Returns an array of Item objects
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

//    public function findOneBySomeField($value): ?Item
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getItemsCount()
    {
        return $this->createQueryBuilder('i')
            ->select('COUNT(i)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function adminItems(string|null $s): QueryBuilder
    {
        $q = $this->createQueryBuilder('i');

        if($s) {
            $q
                ->where('i.name LIKE :s')
                ->orWhere('i.description LIKE :s')
                ->orWhere('i.comment LIKE :s')
                ->setParameter('s', '%'.$s.'%')
            ;
        }

        $q
            ->orderBy('i.name', 'ASC')
            ->getQuery()
        ;

        return $q;
    }

    public function getItemsId()
    {
        return $this->createQueryBuilder('i')
            ->select('i.id')
            ->getQuery()
            ->getResult()
        ;
    }
}

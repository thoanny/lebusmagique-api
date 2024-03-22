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

    public function findAllForAPI()
    {
        return $this->createQueryBuilder('f')
            ->leftJoin('f.item', 'i')
            ->leftJoin('f.achievement', 'a')
            ->orderBy('i.name', 'ASC')
            ->addOrderBy('a.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}

<?php

namespace App\Repository\Genshin\Map;

use App\Entity\Genshin\Map\Map;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Map>
 *
 * @method Map|null find($id, $lockMode = null, $lockVersion = null)
 * @method Map|null findOneBy(array $criteria, array $orderBy = null)
 * @method Map[]    findAll()
 * @method Map[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Map::class);
    }

    public function save(Map $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Map $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Map[] Returns an array of Map objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Map
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findOneBySlug($slug = null)
    {

        if(!$slug) {
            return $this->createQueryBuilder('m')
                ->select('m.id', 'm.name', 'i.imageName AS iconUrl', 'm.bounds', 'm.center', 'm.zoom', 'm.tiles', 'm.minZoom', 'm.maxZoom')
                ->leftJoin('m.icon', 'i')
                ->where('m.active = :active')
                ->orderBy('m.position', 'ASC')
                ->setMaxResults(1)
                ->setParameter('active', true)
                ->getQuery()
                ->getSingleResult();
        } else {
            return $this->createQueryBuilder('m')
                ->select('m.id', 'm.name', 'i.imageName AS iconUrl', 'm.bounds', 'm.center', 'm.zoom', 'm.tiles', 'm.minZoom', 'm.maxZoom')
                ->leftJoin('m.icon', 'i')
                ->where('m.active = :active')
                ->andWhere('m.slug = :slug')
                ->orderBy('m.position', 'ASC')
                ->setMaxResults(1)
                ->setParameter('active', true)
                ->setParameter('slug', $slug)
                ->getQuery()
                ->getSingleResult();
        }

    }

    public function findOtherMaps($excluded) {
        return $this->createQueryBuilder('m')
            ->select('m.name', 'm.slug', 'i.imageName AS iconUrl')
            ->leftJoin('m.icon', 'i')
            ->orderBy('m.position', 'ASC')
            ->where('m.id != :excluded')
            ->andWhere('m.active = :active')
            ->setParameters([
                'excluded' => $excluded,
                'active' => true
            ])
            ->getQuery()
            ->getResult();
    }
}

<?php

namespace App\Repository\Genshin\Map;

use App\Entity\Genshin\Map\Marker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Marker>
 *
 * @method Marker|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marker|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marker[]    findAll()
 * @method Marker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarkerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marker::class);
    }

    public function save(Marker $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Marker $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Marker[] Returns an array of Marker objects
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

//    public function findOneBySomeField($value): ?Marker
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findByGroups(array $groupsIds)
    {
        return $this->createQueryBuilder('m')
            ->select('m.id', 'g.slug AS groupSlug', 'g.id AS groupId', 'i.id AS iconId', 'm.slug', 'm.title', 'm.text', 'm.format', 'm.imageName AS image', 'm.video', 'm.guide', 'm.x', 'm.y')
            ->leftJoin('m.markerGroup', 'g')
            ->leftJoin('m.icon', 'i')
            ->where('m.markerGroup IN (:groupsIds)')
            ->setParameters([
                'groupsIds' => $groupsIds,
            ])
            ->getQuery()
            ->getResult();
    }
}

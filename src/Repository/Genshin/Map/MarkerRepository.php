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
            ->select('m.id', 'g.id AS groupId', 'i.id AS iconId', 'm.title', 'm.text', 'm.format', 'm.imageName AS image', 'm.video', 'm.guide', 'm.x', 'm.y')
            ->leftJoin('m.markerGroup', 'g')
            ->leftJoin('m.icon', 'i')
            ->where('m.markerGroup IN (:groupsIds)')
            ->andWhere('m.active = :active')
            ->setParameters([
                'groupsIds' => $groupsIds,
                'active' => true,
            ])
            ->getQuery()
            ->getResult();
    }

    public function findByFilters($filters) {
        $q = $this->createQueryBuilder('m')
            ->leftJoin('m.markerGroup', 'g');

        if($filters['query']) {
            $q
                ->andWhere('m.id = :query OR m.title LIKE :likeQuery OR m.text LIKE :likeQuery OR g.text LIKE :likeQuery')
                ->setParameter('query', $filters['query'])
                ->setParameter('likeQuery', "%".$filters['query']."%")
            ;
        }

        if($filters['group']) {
            $q
                ->andWhere('g.id = :group')
                ->setParameter('group', $filters['group'])
            ;
        }

        if($filters['format']) {
            $q
                ->andWhere('m.format = :format OR (m.format IS NULL AND g.format = :format)')
                ->setParameter('format', $filters['format'])
            ;
        }

        if($filters['active']) {
            $q
                ->andWhere('m.active = :active')
                ->setParameter('active', !($filters['active'] < 0))
            ;
        }

        return $q->getQuery();
    }
}

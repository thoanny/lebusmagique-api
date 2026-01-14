<?php

namespace App\Repository\Genshin\Map;

use App\Entity\Genshin\Map\UserMarker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserMarker>
 *
 * @method UserMarker|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserMarker|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserMarker[]    findAll()
 * @method UserMarker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserMarkerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserMarker::class);
    }

    public function save(UserMarker $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserMarker $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserMarker[] Returns an array of UserMarker objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserMarker
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findMarkersId($map, $user): array
    {
        return $this->createQueryBuilder('um')
            ->select('m.id')
            ->leftJoin('um.marker', 'm')
            ->where('um.user = :user')
            ->andWhere('um.map = :map')
            ->setParameters([
                'user' => $user,
                'map' => $map
            ])
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getUserMarkersCount($user): int
    {
        return $this->createQueryBuilder('um')
            ->select('COUNT(um)')
            ->where('um.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}

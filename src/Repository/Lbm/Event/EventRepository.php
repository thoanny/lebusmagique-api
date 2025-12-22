<?php

namespace App\Repository\Lbm\Event;

use App\Entity\Lbm\Event\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    //    /**
    //     * @return Event[] Returns an array of Event objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findOutdatedEventsForCleanup(): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.startAt <= :past')
            ->setParameter('past', (new \DateTimeImmutable())->modify('-7 months'))
            ->getQuery()
            ->getResult()
        ;
    }

    public function findNextEvents(): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.startAt >= :now')
            ->andWhere('e.startAt <= :future')
            ->setParameter('now', new \DateTimeImmutable())
            ->setParameter('future', (new \DateTimeImmutable())->modify('+7 days'))
            ->orderBy('e.startAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}

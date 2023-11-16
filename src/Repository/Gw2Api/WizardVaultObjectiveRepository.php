<?php

namespace App\Repository\Gw2Api;

use App\Entity\Gw2Api\WizardVaultObjective;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WizardVaultObjective>
 *
 * @method WizardVaultObjective|null find($id, $lockMode = null, $lockVersion = null)
 * @method WizardVaultObjective|null findOneBy(array $criteria, array $orderBy = null)
 * @method WizardVaultObjective[]    findAll()
 * @method WizardVaultObjective[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WizardVaultObjectiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WizardVaultObjective::class);
    }

//    /**
//     * @return WizardVaultObjective[] Returns an array of WizardVaultObjective objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WizardVaultObjective
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findByFilters(array $filters): Query
    {
        $q = $this->createQueryBuilder('o');

        if($filters['s']) {
            $q
                ->andWhere('o.title LIKE :s OR o.tip LIKE :s')
                ->setParameter('s', "%{$filters['s']}%")
            ;
        }

        if(in_array($filters['p'], ['daily', 'weekly', 'special'])) {
            $q
                ->andWhere('o.period = :p')
                ->setParameter('p', $filters['p'])
            ;
        }

        if(in_array($filters['t'], ['pve', 'pvp', 'wvw'])) {
            $q
                ->andWhere('o.type = :t')
                ->setParameter('t', $filters['t'])
            ;
        }

        if($filters['a']) {
            $q
                ->andWhere('o.active = :a')
                ->setParameter('a', true)
            ;
        }

        return $q->getQuery();
    }
}

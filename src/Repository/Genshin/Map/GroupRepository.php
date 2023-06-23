<?php

namespace App\Repository\Genshin\Map;

use App\Entity\Genshin\Map\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Group>
 *
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }

    public function save(Group $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Group $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Group[] Returns an array of Group objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Group
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findBySections(array $sectionsIds)
    {
        return $this->createQueryBuilder('g')
            ->select('g.id', 's.id AS sectionId', 'g.title', 'i.imageName AS iconUrl', 'i.id AS iconId', 'g.text', 'g.format', 'g.guide', 'g.checkbox', 'g.x', 'g.y', 'g.z')
            ->leftJoin('g.icon', 'i')
            ->leftJoin('g.section', 's')
            ->where('g.section IN (:sectionsIds)')
            ->andWhere('g.active = :active')
            ->orderBy('s.position', 'ASC')
            ->addOrderBy('g.position', 'ASC')
            ->setParameters([
                'sectionsIds' => $sectionsIds,
                'active' => true
            ])
            ->getQuery()
            ->getResult();
    }

    public function findAllOrdered() {
        return $this->createQueryBuilder('g')
            ->select('m.id AS mapId, m.name AS mapName, g.id, g.title')
            ->leftJoin('g.section', 's')
            ->leftJoin('s.map', 'm')
            ->orderBy('m.name', 'ASC')
            ->addOrderBy('g.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByFilters($filters) {
        $q = $this->createQueryBuilder('g')
            ->leftJoin('g.section', 's')
            ->leftJoin('s.map', 'm')
            ->orderBy('m.name', 'ASC')
            ->addOrderBy('g.position', 'ASC')
        ;

        if($filters['query']) {
            $q
                ->andWhere('g.id = :query OR g.title LIKE :likeQuery OR g.text LIKE :likeQuery')
                ->setParameter('query', $filters['query'])
                ->setParameter('likeQuery', "%".$filters['query']."%")
            ;
        }

        if($filters['map']) {
            $q
                ->andWhere('m.id = :map')
                ->setParameter('map', $filters['map'])
            ;
        }

        if($filters['active']) {
            $q
                ->andWhere('g.active = :active')
                ->setParameter('active', !($filters['active'] < 0))
            ;
        }

        return $q->getQuery();
    }
}

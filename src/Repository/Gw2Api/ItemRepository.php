<?php

namespace App\Repository\Gw2Api;

use App\Entity\Gw2Api\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function save(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function adminItems($filters) {
        $q = $this->createQueryBuilder('i')
            ->orderBy('i.uid', 'DESC');

        if(isset($filters['is'])) {
            if($filters['is'] === 'fish') {
                $q->where('i.isFish = :true')
                    ->setParameter('true', true);
            } else if($filters['is'] === 'fish-bait') {
                $q->where('i.isFishBait = :true')
                    ->setParameter('true', true);
            } else if($filters['is'] === 'blackmarket') {
                $q->where('i.blackmarket = :true')
                    ->setParameter('true', true);
            }
        }

        return $q->getQuery()
            ->getResult();
    }

    public function findFishes()
    {
        return $this->createQueryBuilder('i')
            ->select('i.uid AS fishUid', 'i.name AS fishName', 'i.rarity AS fishRarity', 'i.fishPower', 'i.fishTime', 'i.fishSpecialization', 'i.isFishStrangeDietAchievement')
            ->addSelect('a.id AS achievementId', 'a.name AS achievementName', 'a.achievementId AS achievementUid', 'a.achievementRepeatId AS achievementRepeatUid')
            ->addSelect('h.id AS holeId', 'h.name AS holeName')
            ->addSelect('b.uid AS baitUid', 'b.name AS baitName')
            ->leftJoin('i.fishAchievement', 'a')
            ->leftJoin('i.fishHole', 'h')
            ->leftJoin('i.fishBaitItem', 'b')
            ->where('i.isFish = :true')
            ->setParameter('true', true)
            ->getQuery()
            ->getResult();
    }
}

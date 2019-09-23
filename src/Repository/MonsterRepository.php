<?php

namespace App\Repository;

use App\Entity\Monster;
use Doctrine\ORM\Query;
use App\Entity\MonsterSearch;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Monster|null find($id, $lockMode = null, $lockVersion = null)
 * @method Monster|null findOneBy(array $criteria, array $orderBy = null)
 * @method Monster[]    findAll()
 * @method Monster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonsterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Monster::class);
    }

    public function findAllWithSkill(MonsterSearch $search) : Query
    {
         $query = $this->createQueryBuilder('m')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(100)
            ->leftjoin('m.skillbdd', 'ms')
            ->addSelect('ms')
            //->getQuery()
            //->getResult()
        ;
        if ($search->getMaxHp() ) {
            $query = $query->andWhere('m.hp < :maxhp')
                        ->setParameter('maxhp', $search->getMaxHp());
        }
        if ($search->getMinHp() ) {
            $query = $query->andWhere('m.hp >= :minhp')
                        ->setParameter('minhp', $search->getMinHp());
        }
        if ($search->getMaxHp() ) {
            $query = $query->andWhere('m.hp < :maxhp')
                        ->setParameter('maxhp', $search->getMaxHp());
        }
        if ($search->getlikeAsc() ) {
            $query = $query->addOrderBy('m.likes', 'ASC');
        }
        if ($search->getlikeDesc() ) {
            $query = $query->addOrderBy('m.likes', 'DESC');
        }
        if ($search->getnameAsc() ) {
            $query = $query->addOrderBy('m.name', 'ASC');
        }
        if ($search->getnameDesc() ) {
            $query = $query->addOrderBy('m.name', 'DESC');
        }
        if ($search->getdateAsc() ) {
            $query = $query->addOrderBy('m.created_at', 'ASC');
        }
        if ($search->getdateDesc() ) {
            $query = $query->addOrderBy('m.created_at', 'DESC');
        }
        return $query->getQuery();
    }

    /*return $this
		->createQueryBuilder('c')
		->innerJoin('c.town', 'monstertown')
		->where('monstertown.id = :id')
		->setParameter('id', $town);*/

    // /**
    //  * @return Monster[] Returns an array of Monster objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Monster
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

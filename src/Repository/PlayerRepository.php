<?php

namespace App\Repository;

use App\Entity\Player;
use App\Entity\PlayerSearch;
use Doctrine\ORM\Query;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function findAllWithSkill(PlayerSearch $search) : Query
    {
         $query = $this->createQueryBuilder('m')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(100)
            ->leftjoin('m.skillbdd', 'ms')
            ->addSelect('ms')
            //->getQuery()
            //->getResult()
        ;
        if ($search->getMaxLevel() ) {
            $query = $query->andWhere('m.level < :maxlevel')
                        ->setParameter('maxlevel', $search->getMaxLevel());
        }
        if ($search->getMinLevel() ) {
            $query = $query->andWhere('m.level >= :minlevel')
                        ->setParameter('minlevel', $search->getMinLevel());
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
            $query = $query->addOrderBy('m.createdAt', 'ASC');
        }
        if ($search->getdateDesc() ) {
            $query = $query->addOrderBy('m.createdAt', 'DESC');
        }
        /*if ($search->getRegex() ) {
            $query = $query->andWhere('m.hp >= :minhp')
                        ->setParameter('minhp', $search->getMinHp());
        }*/
        return $query->getQuery();
    }


    /*public function findAllWithSkill()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(100)
            ->innerJoin('m.skillbdd', 'ms')
            ->addSelect('ms')
            ->getQuery()
            ->getResult()
        ;
    }*/

    

    // /**
    //  * @return Player[] Returns an array of Player objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Player
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Likes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Likes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Likes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Likes[]    findAll()
 * @method Likes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Likes::class);
    }

    public function findLikeWithIdMonster($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('ls.id = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->innerJoin('l.monsters', 'ls')
            ->addSelect('ls')
            ->setMaxResults(1000)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLikeWithIdQuest($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('lq.id = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->innerJoin('l.quests', 'lq')
            ->addSelect('lq')
            ->setMaxResults(1000)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLikeWithIdObjet($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('lo.id = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->innerJoin('l.objets', 'lo')
            ->addSelect('lo')
            ->setMaxResults(1000)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLikeWithIdPlayer($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('lp.id = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->innerJoin('l.players', 'lp')
            ->addSelect('lp')
            ->setMaxResults(1000)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLikeWithIdSkill($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('lp.id = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->innerJoin('l.skills', 'lp')
            ->addSelect('lp')
            ->setMaxResults(1000)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Likes[] Returns an array of Likes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Likes
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

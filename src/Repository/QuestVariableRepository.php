<?php

namespace App\Repository;

use App\Entity\QuestVariable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuestVariable|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestVariable|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestVariable[]    findAll()
 * @method QuestVariable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestVariableRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuestVariable::class);
    }

    public function findAllWithMonsterAndObject()
    {
        return $this->createQueryBuilder('q')
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(100)
            ->innerJoin('q.monsters', 'qm')
            ->addSelect('qm')
            ->innerJoin('q.objetreussite', 'qor')
            ->addSelect('qor')
            ->innerJoin('q.questrequismany', 'qorm')
            ->addSelect('qorm')
            ->getQuery()
            ->getResult()
        ;
    }


    public function findAllWithMonster()
    {
        return $this->createQueryBuilder('q')
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(100)
            ->innerJoin('q.monsters', 'qm')
            ->addSelect('qm')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return QuestVariable[] Returns an array of QuestVariable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestVariable
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

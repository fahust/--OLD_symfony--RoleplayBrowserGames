<?php

namespace App\Repository;

use App\Entity\Monster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

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

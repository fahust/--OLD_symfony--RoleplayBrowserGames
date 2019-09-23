<?php

namespace App\Repository;

use App\Entity\Objet;
use App\Entity\ObjetSearch;
use Doctrine\ORM\Query;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Objet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Objet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Objet[]    findAll()
 * @method Objet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Objet::class);
    }

    public function findAllWithSkill(ObjetSearch $search) : Query
    {
         $query = $this->createQueryBuilder('m')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(100)
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
        /*if ($search->getRegex() ) {
            $query = $query->andWhere('m.hp >= :minhp')
                        ->setParameter('minhp', $search->getMinHp());
        }*/
        return $query->getQuery();
    }

    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('sub_family')
            ->orderBy('sub_family.id', 'ASC');
    }

    // /**
    //  * @return Objet[] Returns an array of Objet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Objet
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

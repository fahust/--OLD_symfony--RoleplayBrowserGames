<?php

namespace App\Repository;

use App\Entity\QuestVariable;
use App\Entity\QuestSearch;
use Doctrine\ORM\Query;
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

    public function findAllLastDate()
    {
        return $this->createQueryBuilder('q')
            ->orderBy('q.updatedAt', 'ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    

    public function findAllWithSkill(QuestSearch $search) : Query
    {
         $query = $this->createQueryBuilder('m')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(100)
            ->leftjoin('m.monsters', 'qm')
            ->addSelect('qm')
            ->leftjoin('m.objetreussite', 'qor')
            ->addSelect('qor')
            ->leftjoin('m.questrequismany', 'qorm')
            ->addSelect('qorm')
            //->getQuery()
            //->getResult()
        ;
        if ($search->getMaxDeDifficult() ) {
            $query = $query->andWhere('m.dedifficult < :maxdifficult')
                        ->setParameter('maxdifficult', $search->getMaxDeDifficult());
        }
        if ($search->getMinDeDifficult() ) {
            $query = $query->andWhere('m.dedifficult >= :mindifficult')
                        ->setParameter('mindifficult', $search->getMinDeDifficult());
        }
        if ($search->getlikeAsc() ) {
            $query = $query->addOrderBy('m.likes', 'ASC');
        }
        if ($search->getlikeDesc() ) {
            $query = $query->addOrderBy('m.likes', 'DESC');
        }
        if ($search->getnameAsc() ) {
            $query = $query->addOrderBy('m.title', 'ASC');
        }
        if ($search->getnameDesc() ) {
            $query = $query->addOrderBy('m.title', 'DESC');
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

<?php

namespace App\Repository;

use App\Entity\Skill;
use Doctrine\ORM\Query;
use App\Entity\SkillSearch;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Skill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill[]    findAll()
 * @method Skill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Skill::class);
    }

    public function findAllWithSearch(SkillSearch $search,$user) : Query
    {
         $query = $this->createQueryBuilder('m')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(100)
            //->getQuery()
            //->getResult()
        ;
        if ($search->getMaxHp() ) {
            $query = $query->andWhere('m.skdgt < :skdgt')
                        ->setParameter('skdgt', $search->getMaxHp());
        }
        if ($search->getMinHp() ) {
            $query = $query->andWhere('m.skdgt >= :skdgt')
                        ->setParameter('skdgt', $search->getMinHp());
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
        if ($search->getLanguage() ) {
            $query = $query->andWhere('m.language = :language')
                        ->setParameter('language', $search->getLanguage());
        }
        if ($search->getType() ) {
            $query = $query->andWhere('m.type = :type')
                        ->setParameter('type', $search->getType());
        }
        if ($user){
            if ($search->getCreatedByMe() ) {
                $query = $query->andWhere('m.createdByMe = :createdByMe')
                            ->setParameter('createdByMe', $user->getId());
            }
        }
        /*if ($search->getRegex() ) {
            $query = $query->andWhere('m.hp >= :minhp')
                        ->setParameter('minhp', $search->getMinHp());
        }*/
        return $query->getQuery();
    }

    public function findByPlayers($playerid){
        
        $qb = $this->createQueryBuilder('s');
        $qb->where('t.id = :objplayer') 
           ->setParameter("objplayer", $playerid)
           ->Join('s.players', 't')
           ;
           echo $qb;
           
        return $qb->getQuery();
}
    

    // /**
    //  * @return Skill[] Returns an array of Skill objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Skill
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

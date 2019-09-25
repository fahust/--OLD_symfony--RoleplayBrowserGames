<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\QuestVariable;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestVariableUtils extends AbstractController
{
    public function fightcalculmonster( $quest,$request,$manager, UserInterface $user,$thiss){
        $userId = $thiss->getDoctrine()->getRepository(User::class)->find($user->getId());
        $questvariable = $thiss->getDoctrine()->getRepository(QuestVariable::class)->find($quest);
        $tour2 = $userId->getTour() ;
        $ciblevar = 0;$cibleobj = 0;
        if ($userId->getAction() == 4) {
            if($userId->getTour() <= $userId->getMonsterUsers()->count()) {
                for ($i = 1; $i <= 100; $i++) {
                    $ciblevar = rand(0,4);
                    if(empty($ciblevar = $userId->getPlayerfight()->get($ciblevar))){}else{
                        $cibleobj = $ciblevar;
                    }
                }
                $skillvar = 0;$skilluse = 0;
                for ($i = 1; $i <= 100; $i++) {
                    $skillvar = rand(0,4);
                    if(empty($skillvar = $userId->getMonsterUsers()->get($tour2-1)->getSkillbdd()->get($skillvar)) ){}else{
                        $skilluse = $skillvar;
                    }
                }
                $attaquant = $userId->getMonsterUsers()->get($tour2-1);
            }else{
                for ($i = 1; $i <= 100; $i++) {
                    $ciblevar = rand(0,4);
                    if(empty($ciblevar = $userId->getPlayerfight()->get($ciblevar)) ){}else{
                        $cibleobj = $ciblevar;
                    }
                }
                $skillvar = 0;$skilluse = 0;
                for ($i = 1; $i <= 100; $i++) {
                    $skillvar = rand(0,4);
                    if(empty($userId->getMonsterUsers()->get(($userId->getMonsterUsers()->count())-1)) ){}else{
                        echo $skillvar;
                        $skillauhasard = $thiss->getDoctrine()->getRepository(Skill::class)->find(1);
                        $skilluse = $skillauhasard;
                    }
                }
                $attaquant = $userId->getMonsterUsers()->get(($userId->getMonsterUsers()->count())-1);

        }
        //$skilluse->getDestinataire()

        }else{//CHOIX DE CIBLE DU JOUEUR 
                if($userId->getTour() < $userId->getPlayerfight()->count()) {
            $attaquant = $userId->getPlayerfight()->get($tour2-1);
            if($attaquant->getCible() == 0 ){
                $cibleobj = $attaquant;
            }else{
            $cibleobj = $userId->getMonsterUsers()->get(($userId->getPlayerfight()->get($tour2-1)->getCible())-1);}
            $skilluse = $userId->getPlayerfight()->get($tour2-1)->getSkillbdd()->get(($userId->getPlayerfight()->get($tour2-1)->getSkillnow())-1);
                }else{  
            $attaquant = $userId->getPlayerfight()->get($userId->getPlayerfight()->count()-1);
            if($attaquant->getCible() == 0 ){
                $cibleobj = $attaquant;
            }else{
            $cibleobj = $userId->getMonsterUsers()->get(($attaquant->getCible())-1);}
            $skilluse = $userId->getPlayerfight()->get(($userId->getPlayerfight()->count())-1)->getSkillbdd()->get(($userId->getPlayerfight()->get(($userId->getPlayerfight()->count())-1)->getSkillnow())-1);
                }
        }

        //Dé et reduction des dé par rapport a esquive de l'opposant
        $de = rand(0,100);$de2 = rand(-5,5);
        $de -= rand(0,$cibleobj->getEsq());
        if ($de < 0 ){$de = 0;}else if ($de > 100){$de = 100;}

        $subplayerhp = 0;
        $subattaquanthp = 0;
        $subplayeratk = 0;
        $subattaquantatk = 0;
        $subplayerdef = 0;
        $subattaquantdef = 0;
        $subplayeresq = 0;
        $subattaquantesq = 0;
        //$de = 28;
        if(empty($skilluse)){
            $array = ["Compétence non valide", "","Compétence non valide" ,"Compétence non valide","Compétence non valide" ];
        }else{
            if ($de >= 90) {
                $subplayerhp -= ($skilluse->getAtksc())*(($attaquant->getAtk()));
                $subplayerhp += ($skilluse->getHpsc());
                $subplayeratk += ($skilluse->getAtksc());
                $subplayerdef += ($skilluse->getDefsc());
                $subplayeresq += ($skilluse->getEsqsc());
                $array = ["Le résultat des dé est de " . $de . " / " . (($questvariable->getDedifficult())+$de2) . " , Réussite critique de " . $skilluse->getName(), $skilluse->getDialsc(), $cibleobj->getName() . " perd ". abs($subplayerhp) . " points de vie, il lui reste " . ($cibleobj->getHp()+$subplayerhp) , $attaquant->getName() . " attaque ". $cibleobj->getName() , $skilluse , $cibleobj ];
            
            }elseif ($de < 10) {
                if($attaquant->getCible() == 0 ){
                    $subattaquanthp -= ($skilluse->getAtkec())*(($attaquant->getAtk()));
                    $subplayerhp += ($skilluse->getHpec());
                    $subplayeratk += ($skilluse->getAtkec());
                    $subplayerdef += ($skilluse->getDefec());
                    $subplayeresq += ($skilluse->getEsqec());
                    $array = ["Le résultat des dé est de " . $de . " / " . (($questvariable->getDedifficult())+$de2) . " , Echec critique de " . $skilluse->getName(), $skilluse->getDialsc(),"" , "" , $skilluse , $attaquant  ];
                }else{
                    $subattaquanthp -= ($skilluse->getAtkec())*(($attaquant->getAtk()));
                    $subplayerhp += ($skilluse->getHpec());
                    $subplayeratk += ($skilluse->getAtkec());
                    $subplayerdef += ($skilluse->getDefec());
                    $subplayeresq += ($skilluse->getEsqec());
                    $array = ["Le résultat des dé est de " . $de . " / " . (($questvariable->getDedifficult())+$de2) . " , Echec critique de " . $skilluse->getName(), $skilluse->getDialsc(), $attaquant->getName() . " perd " . abs($subattaquanthp) . " points de vie , il lui reste " . ($attaquant->getHp()+$subattaquanthp) , $attaquant->getName() . " attaque ". $attaquant->getName() , $skilluse , $attaquant  ];
                }
            }elseif ($de >= ($questvariable->getDedifficult())+$de2) {
                $subplayerhp -= ($skilluse->getSkatk())*(($attaquant->getAtk()));
                $subplayerhp += ($skilluse->getSkhp());
                $subplayeratk += ($skilluse->getSkatk());
                $subplayerdef += ($skilluse->getSkdef());
                $subplayeresq += ($skilluse->getSkesq());
                $array = ["Le résultat des dé est de " . $de . " / " . (($questvariable->getDedifficult())+$de2) . " , Réussite de " . $skilluse->getName(), $skilluse->getDialsc(), $cibleobj->getName() . " perd " . abs($subplayerhp) . " points de vie, il lui reste " . ($cibleobj->getHp()+$subplayerhp) , $attaquant->getName() . " attaque ". $cibleobj->getName() , $skilluse , $cibleobj  ];
            }elseif ($de <= ($questvariable->getDedifficult())+$de2) {
                $subplayerhp = 0 ;
                $array = ["Le résultat des dé est de " . $de . " / " . (($questvariable->getDedifficult())+$de2) . " , Echec de " . $skilluse->getName(), ".. La compétence échoue", "", ""  , $skilluse , $cibleobj ];
            }
        
        }

        if($subplayerhp !== 0) {$cibleobj->setHp(($cibleobj->getHp())+$subplayerhp);}
        if($subattaquanthp !== 0) {$attaquant->setHp(($attaquant->getHp())+$subattaquanthp);}
        if($subplayeratk !== 0) {$cibleobj->setAtk(($cibleobj->getAtk())+$subplayeratk);}
        if($subattaquantatk !== 0) {$attaquant->setAtk(($attaquant->getAtk())+$subattaquantatk);}
        if($subplayerdef !== 0) {$cibleobj->setDef(($cibleobj->getDef())+$subplayerdef);}
        if($subattaquantdef !== 0) {$attaquant->setDef(($attaquant->getDef())+$subattaquantdef);}
        if($subplayeresq !== 0) {$cibleobj->setEsq(($cibleobj->getEsq())+$subplayeresq);}
        if($subattaquantesq !== 0) {$attaquant->setEsq(($attaquant->getEsq())+$subattaquantesq);}
        if ($userId->getAction() == 1) {}else{
            $manager->persist($attaquant);
            $manager->persist($cibleobj);
            $manager->flush();
        }

            if(!empty($userId->getPlayerfight()->get(($userId->getTour())-1))){
                if($userId->getPlayerfight()->get(($userId->getTour())-1)->getHp() <= 0) {//$manager->remove($player);
                    $thiss->addFlash('warning', 'joueur vaincu');
                    //$playerbase = $thiss->getDoctrine()->getRepository(Player::class)->findById($userId->getPlayerfight()->get(($userId->getTour())-1)->getIdPlayer());
                    //$manager->remove($playerbase);
                    $userId->removePlayerfight(($userId->getPlayerfight()->get(($userId->getTour())-1)));
                    $manager->persist($userId);
                }
            }
            if(!empty($cibleobj)){
                if($cibleobj->getHp() <= 0) {//$manager->remove($cibleobj);
                    $thiss->addFlash('succes', 'monstre vaincu');
                    $attaquant->setExperience(($attaquant->getExperience())+1);
                    if($attaquant->getExperience() > ($attaquant->getLevel())*10 ){
                        $attaquant->setLevel(($attaquant->getLevel())+1);
                        $attaquant->setSkillpnt(($attaquant->getSkillpnt())+1);
                        $attaquant->setAtk(($attaquant->getAtk())+1);
                        $attaquant->setExperience(1);
                        $thiss->addFlash('succes', 'Vous gagnez un niveau ! ');
                    }
                    $manager->persist($attaquant);
                    $manager->remove($cibleobj);
                }
            }
            $manager->flush();
        return $array;    
    }

    public function importMonsterUser($monstercollec,$userId,$manager){
    
    if($userId->getMonsterUsers()->count() > 2 ){}else{
        for ($i = 0; $i < $monstercollec->count(); ++$i) {
            $monsteruser = new MonsterUser();//Importer les monstres de la quête vers les monstres de l'action
            $monsteruser->setName($monstercollec->get($i)->getName());
            $monsteruser->setHp($monstercollec->get($i)->getHp());
            $monsteruser->setAtk($monstercollec->get($i)->getAtk());
            $monsteruser->setDgt($monstercollec->get($i)->getDgt());
            $monsteruser->setEsq($monstercollec->get($i)->getEsq());
            $monsteruser->setDef($monstercollec->get($i)->getDef());
            $monsteruser->setMaxhp($monstercollec->get($i)->getMaxhp());
            $monsteruser->setMaxatk($monstercollec->get($i)->getMaxatk());
            $monsteruser->setMaxdgt($monstercollec->get($i)->getMaxdgt());
            $monsteruser->setMaxesq($monstercollec->get($i)->getMaxesq());
            $monsteruser->setMaxdef($monstercollec->get($i)->getMaxdef());
            $monsteruser->setDescription($monstercollec->get($i)->getDescription());
            $monsteruser->setImage($monstercollec->get($i)->getImage());
            $monsteruser->setImageFile($monstercollec->get($i)->getImageFile());
            $monsteruser->setImageName($monstercollec->get($i)->getImageName());

if($monstercollec->get($i)->getSkillbdd()->count() > 0) {
    if(is_null($monstercollec->get($i)->getSkillbdd()->count())){}else{
        for ($i2 = 0; $i2 < $monstercollec->get($i)->getSkillbdd()->count(); ++$i2) 
            $monsteruser->addSkillbdd($monstercollec->get($i)->getSkillbdd()->get($i2));
}}
    $monsteruser->setUser($userId);
    $manager->persist($monsteruser);
}}

$userId->setTour(1);
$userId->setAction(0);
$manager->persist($userId);
$manager->flush();
}
    

    
}

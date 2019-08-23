<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Objet;
use App\Entity\Skill;
use App\Entity\Player;
use App\Entity\Monster;
use App\Entity\MonsterUser;
use App\Entity\QuestVariable;
use App\Form\QuestVariableType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class QuestController extends AbstractController
{
    

    

    /**
     * @Route("/quest", name="quest")
     */
    public function indexQuest(UserInterface $user)
    {
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->findByIdWithObjAndGroups($user->getId());
        //$user = $userrepo->findByIdWithObj($user->getId())[0];
        $repo = $this->getDoctrine()->getRepository(QuestVariable::class);
        $quest = $repo->findAllWithMonster();

        return $this->render('quest/index.html.twig', [
            'user' => $user,
            'controller_name' => 'PlayerController',
            'quest' => $quest
        ]);
    }


    /**
     * @Route("/quest/victoire/{id}-{action}-{quest}-{cible}-{tour}", name="victoire")
     */
    public function victoire($id, $action, $quest, $cible, $tour, Request $request, ObjectManager $manager, UserInterface $user){

        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($user->getId());
        $repo4 = $this->getDoctrine()->getRepository(QuestVariable::class);
        $questvariable = $repo4->find($quest);
        if(!empty($questvariable->getObjetreussite()->get(0))){
            ($user->addObjet($questvariable->getObjetreussite()->get(0)));
        }
        if(!empty($questvariable->getObjetreussite()->get(1))){
            ($user->addObjet($questvariable->getObjetreussite()->get(1)));
        }
        if(!empty($questvariable->getObjetreussite()->get(2))){
            ($user->addObjet($questvariable->getObjetreussite()->get(2)));
        }
        if(!empty($questvariable->getObjetreussite()->get(3))){
            ($user->addObjet($questvariable->getObjetreussite()->get(3)));
        }

        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('quest', [
            'id' => $id,
            'quest' => $quest,
            'cible' => $cible,
            'tour' => $tour,

        ]);



    }


    /**
     * @Route("/quest/questlaunch/{id}-{action}-{quest}-{cible}-{tour}", name="questlaunch")
     */
    public function questlaunch($id, $action, $quest, $cible, $tour, Request $request, ObjectManager $manager, UserInterface $user){

        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($user->getId());
        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($user->getId());
        $player = $userId->getPlayerfight()->get($tour);
        $playerall = $this->getDoctrine()->getRepository(Player::class);
        $playerall = $playerall->findAll();
        $repo2 = $this->getDoctrine()->getRepository(Skill::class);
        $playerskill = $repo2->findAll();
        $repo4 = $this->getDoctrine()->getRepository(QuestVariable::class);
        $questvariable = $repo4->find($quest);
        $monstercollec = $questvariable->getMonsters();

        $userId->setTour(1);
            $userId->setAction(0);
            $manager->persist($userId);
            $manager->flush();
        
        $monster = $userId->getMonsterUsers()->get($tour);
       
        $repo4 = $this->getDoctrine()->getRepository(QuestVariable::class);
        $questvariable = $repo4->find($quest);
        return $this->render('player/quest.html.twig', [
            'player' => $player,
            'monster' => $monster,
            'skill' => $playerskill,
            'action' => $action,
            'user' => $userId,
            'questvariable' => $questvariable,
            'playerall' => $playerall,
            
        ]);
    }

    

    /**
     * @Route("/quest/new/{id}", name="quest_create")
     * @Route("/quest/edit/{id}", name="quest_edit")
     */
    public function createQuest($id ,Request $request, ObjectManager $manager, UserInterface $user) {
        $objetall = $this->getDoctrine()->getRepository(Objet::class);
        $objetall = $objetall->findAll();
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->findByIdWithObjAndGroups($user->getId());
        if($id == 0){$quest = new QuestVariable();}else{
            $repo = $this->getDoctrine()->getRepository(QuestVariable::class);
            $quest = $repo->find($id);}
        $form = $this->createForm(QuestVariableType::class, $quest);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $quest->setCreateur($user->getId());
            $manager->persist($quest);
            $this->addFlash('succes', 'quête créé/édité avec succès');
            $manager->flush();
        }

        return $this->render('quest/create.html.twig', [
            'formQuest' => $form->createView()
        ]);
    }



    

    /**
     * @Route("/player/choixjoueur/{id}-{action}-{quest}-{cible}-{tour}", name="player_choixjoueur")
     */
    public function choixjoueur($id, $action, $quest, $cible, $tour, Request $request, ObjectManager $manager, UserInterface $user){

        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($user->getId());
        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($user->getId());
        $player = $userId->getPlayerfight()->get($tour);
        $playerall = $this->getDoctrine()->getRepository(Player::class);
        $playerall = $playerall->findAll();
        $repo2 = $this->getDoctrine()->getRepository(Skill::class);
        $playerskill = $repo2->findAll();
        $repo4 = $this->getDoctrine()->getRepository(QuestVariable::class);
        $questvariable = $repo4->find($quest);
        $monstercollec = $questvariable->getMonsters();
        $monster = $userId->getMonsterUsers()->get($tour);
        $repo4 = $this->getDoctrine()->getRepository(QuestVariable::class);
        $questvariable = $repo4->find($quest);

        //FORM DE L USER
        $formuser = $this->createFormBuilder($userId)
        ->add('email',HiddenType::class)
        ->add('username',HiddenType::class)
        ->add('password',HiddenType::class)
        ->add('playerfight', EntityType::class, [
            'class' => Player::class,
            'choices' => $userId->getPlayercreated(),
            'multiple' => true,
            'choice_label' => 'name',
            
        ])
        ->add('save', SubmitType::class, [
            'label' => 'Lancer la quête'
        ])
        ->getForm();

        $formuser->handleRequest($request);
        if($formuser->isSubmitted() && $formuser->isValid()){
                if($userId->getMonsterUsers()->count() > 2 ){}else{
        for ($i = 0; $i < $monstercollec->count(); ++$i) {
        $monsteruser = new MonsterUser();
        $monsteruser->setName($monstercollec->get($i)->getName());
        $monsteruser->setHp($monstercollec->get($i)->getHp());
        $monsteruser->setAtk($monstercollec->get($i)->getAtk());
        $monsteruser->setDgt($monstercollec->get($i)->getDgt());
        $monsteruser->setEsq($monstercollec->get($i)->getEsq());
        $monsteruser->setDef($monstercollec->get($i)->getDef());
        $monsteruser->setDescription($monstercollec->get($i)->getDescription());
        $monsteruser->setImage($monstercollec->get($i)->getImage());


        if($monstercollec->get($i)->getSkillbdd()->count() > 0) {
            if(is_null($monstercollec->get($i)->getSkillbdd()->count())){}else{
            
                for ($i2 = 0; $i2 < $monstercollec->get($i)->getSkillbdd()->count(); ++$i2) {
                    $monsteruser->addSkillbdd($monstercollec->get($i)->getSkillbdd()->get($i2));
        }}}
        $monsteruser->setUser($userId);

        $manager->persist($monsteruser);
        
        }}

        $manager->flush();
            $userId->setTour(1);
            $userId->setAction(0);
            $manager->persist($userId);
            $manager->flush();
            return $this->redirectToRoute('questlaunch', [
                'id' => $id,
                'quest' => $quest,
                'cible' => $cible,
                'tour' => $tour,
                'formUser' => $formuser->createView(),
                'player' => $player,
                'monster' => $monster,
                'skill' => $playerskill,
                'action' => $action,
                'user' => $userId,
                'questvariable' => $questvariable,
                'playerall' => $playerall,
                
            ]);
            }

            return $this->render('player/fight.html.twig', [
                'formUser' => $formuser->createView(),
                'player' => $player,
                'monster' => $monster,
                'skill' => $playerskill,
                'action' => $action,
                'user' => $userId,
                'questvariable' => $questvariable,
                'tour' => $tour,
                'playerall' => $playerall,
            ]);

    }


    
    public function fightcalculmonster($id, $action, $quest, $cible, $tour, Request $request, ObjectManager $manager, UserInterface $user){
        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($user->getId());
        $monsteruserall = $this->getDoctrine()->getRepository(MonsterUser::class);
        $monsteruserall = $monsteruserall->findAll();
        $playeruserall = $this->getDoctrine()->getRepository(Player::class);
        $playeruserall = $playeruserall->findAll();
        $repo4 = $this->getDoctrine()->getRepository(QuestVariable::class);
        $questvariable = $repo4->find($quest);
        $tour2 = $userId->getTour() ;
        $ciblevar = 0;
        $cibleobj = 0;
        if ($userId->getAction() == 4) {
            if($userId->getTour() <= $userId->getMonsterUsers()->count()) {
        for ($i = 1; $i <= 100; $i++) {
            $ciblevar = rand(0,4);
            if(empty($ciblevar = $userId->getPlayerfight()->get($ciblevar)) ){}else{
                $cibleobj = $ciblevar;
            }
        }
        $skillvar = 0;
        $skilluse = 0;
        for ($i = 1; $i <= 100; $i++) {
            $skillvar = rand(0,4);
            if(empty($skillvar = $userId->getMonsterUsers()->get($tour2-1)->getSkillbdd()->get($skillvar)) ){}else{
                $skilluse = $skillvar;
            }
        }
        $attaquant = $userId->getMonsterUsers()->get($tour2-1);}else{
            for ($i = 1; $i <= 100; $i++) {
                $ciblevar = rand(0,4);
                if(empty($ciblevar = $userId->getPlayerfight()->get($ciblevar)) ){}else{
                    $cibleobj = $ciblevar;
                }
            }
            $skillvar = 0;
            $skilluse = 0;
            for ($i = 1; $i <= 100; $i++) {
                $skillvar = rand(0,4);
                if(empty($userId->getMonsterUsers()->get(($userId->getMonsterUsers()->count())-1)) ){}else{
                    echo $skillvar;
                    $skillauhasard = $this->getDoctrine()->getRepository(Skill::class);
                    $skillauhasard = $skillauhasard->find(1);
                    $skilluse = $skillauhasard;
                }
            }
            $attaquant = $userId->getMonsterUsers()->get(($userId->getMonsterUsers()->count())-1);

        }
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
        $de = rand(0,100);
        $de2 = rand(-5,5);

        $subplayerhp = 0;
        $subattaquanthp = 0;
        //$de = 28;
        if(empty($skilluse)){$array = ["Compétence non valide", "","Compétence non valide" ,"Compétence non valide","Compétence non valide" ];
        }else{


        if ($de >= 90) {
            $subplayerhp -= ($skilluse->getAtksc())*(($attaquant->getAtk()));
            $subplayerhp += ($skilluse->getHpsc());
            $array = ["Le résultat des dé est de " . $de . " / " . (($questvariable->getDedifficult())+$de2) . " , Réussite critique de " . $skilluse->getName(), $skilluse->getDialsc(), $cibleobj->getName() . " perd ". abs($subplayerhp) . " points de vie, il lui reste " . ($cibleobj->getHp()+$subplayerhp) , $attaquant->getName() . " attaque ". $cibleobj->getName() , $skilluse->getImage() , $cibleobj ];
            
        }elseif ($de < 10) {
            if($attaquant->getCible() == 0 ){
                $subattaquanthp -= ($skilluse->getAtkec())*(($attaquant->getAtk()));
                $subplayerhp += ($skilluse->getHpec());
                $array = ["Le résultat des dé est de " . $de . " / " . (($questvariable->getDedifficult())+$de2) . " , Echec critique de " . $skilluse->getName(), $skilluse->getDialsc(),"" , "" , $skilluse->getImage() , $attaquant  ];
            }else{
                $subattaquanthp -= ($skilluse->getAtkec())*(($attaquant->getAtk()));
                $subplayerhp += ($skilluse->getHpec());
                $array = ["Le résultat des dé est de " . $de . " / " . (($questvariable->getDedifficult())+$de2) . " , Echec critique de " . $skilluse->getName(), $skilluse->getDialsc(), $attaquant->getName() . " perd " . abs($subattaquanthp) . " points de vie , il lui reste " . ($attaquant->getHp()+$subattaquanthp) , $attaquant->getName() . " attaque ". $attaquant->getName() , $skilluse->getImage() , $attaquant  ];
        }
        }elseif ($de >= ($questvariable->getDedifficult())+$de2) {
            $subplayerhp -= ($skilluse->getSkatk())*(($attaquant->getAtk()));
            $subplayerhp += ($skilluse->getSkhp());
            $array = ["Le résultat des dé est de " . $de . " / " . (($questvariable->getDedifficult())+$de2) . " , Réussite de " . $skilluse->getName(), $skilluse->getDialsc(), $cibleobj->getName() . " perd " . abs($subplayerhp) . " points de vie, il lui reste " . ($cibleobj->getHp()+$subplayerhp) , $attaquant->getName() . " attaque ". $cibleobj->getName() , $skilluse->getImage() , $cibleobj  ];
            
        }
        elseif ($de <= ($questvariable->getDedifficult())+$de2) {
            $subplayerhp = 0 ;
            $array = ["Le résultat des dé est de " . $de . " / " . (($questvariable->getDedifficult())+$de2) . " , Echec de " . $skilluse->getName(), ".. La compétence échoue", "", ""  , $skilluse->getImage() , $cibleobj ];
            
        }
        
    }

        if($subplayerhp == 0) {}else{ $cibleobj->setHp(($cibleobj->getHp())+$subplayerhp);}
        if($subattaquanthp == 0) {}else{ $attaquant->setHp(($attaquant->getHp())+$subattaquanthp);}
        if ($userId->getAction() == 1) {}else{
        $manager->persist($attaquant);
        $manager->persist($cibleobj);
        $manager->flush();
        }

        //if ($action == 3 ) {
            if(!empty($userId->getPlayerfight()->get(($userId->getTour())-1))){
                if($userId->getPlayerfight()->get(($userId->getTour())-1)->getHp() <= 0) {//$manager->remove($player);
                    $this->addFlash('succes', 'joueur vainqu');
                    $userId->removePlayerfight(($userId->getPlayerfight()->get(($userId->getTour())-1)));
                }
            }
            if(!empty($cibleobj)){
            if($cibleobj->getHp() <= 0) {//$manager->remove($cibleobj);
                $this->addFlash('succes', 'monstre vainqu');
                $attaquant->setExperience(($attaquant->getExperience())+1);
                if($attaquant->getExperience() > ($attaquant->getLevel())*10 ){
                    $attaquant->setLevel(($attaquant->getLevel())+1);
                    $attaquant->setSkillpnt(($attaquant->getSkillpnt())+1);
                    $attaquant->setAtk(($attaquant->getAtk())+1);
                    $attaquant->setExperience(1);
                    $this->addFlash('succes', 'Vous gagnez un niveau ! ');
                }
                $manager->persist($attaquant);
                $manager->remove($cibleobj);
            }
            }

            $manager->flush();
        

        return $array;    
        
    }


    /**
     * @Route("/player/fight/{id}-{action}-{quest}-{cible}-{tour}", name="player_fight")
     */
    public function fight($id, $action, $quest, $cible, $tour, Request $request, ObjectManager $manager, UserInterface $user){
        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($user->getId());

        if((empty($userId->getMonsterUsers()->get(0))) or (empty($userId->getPlayerfight()->get(0)))){
            if(empty($userId->getPlayerfight()->get(0))){
            $this->addFlash('succes', "Aucun joueurs dans l'équipe");
            }
            if((empty($userId->getMonsterUsers()->get(0)))){
            $this->addFlash('succes', 'Plus aucun monstre a affronté ');
                
            }
            return $this->redirectToRoute('questlaunch', [
                'id' => $id,
                'quest' => $quest,
                'cible' => $cible,
                'tour' => $tour,
                'action' => $action,
                
            ]);
        }else{

        

        $tour = $userId->getTour();
        $action = $userId->getAction();
        $infobattle = array() ;
        if($action == 2 or $action == 4){
        
        $infobattle = $this->fightcalculmonster($id, $action, $quest, $cible, $tour, $request,$manager,  $user);
        }

        //actualiser l action
        $userId->setAction($userId->getAction()+1) ;
        if($userId->getAction() > 5 ){
            $userId->setAction(1);
                //actualiser le tour
                $userId->setTour($userId->getTour()+1) ;
                if($userId->getTour() > $userId->getPlayerfight()->count() and $userId->getTour() > $userId->getMonsterUsers()->count() ){
                    $userId->setTour(1);
                }
                $manager->persist($userId);
                
                
        }
        $manager->persist($userId);
        $manager->flush();
        $action = $userId->getAction() ;
        $tour2 = $userId->getTour() ;
        //$tour2 = 3;//A ENLEVER

        if($userId->getTour() < $userId->getPlayerfight()->count()) {
        $player = $userId->getPlayerfight()->get(($userId->getTour())-1);
        }else{
            $player = $userId->getPlayerfight()->get(($userId->getPlayerfight()->count())-1);
        }
        

        $repo2 = $this->getDoctrine()->getRepository(Skill::class);
        $playerskill = $repo2->findAll();

        $skillall = $this->getDoctrine()->getRepository(Skill::class);
        $skillall = $skillall->find($player->getSkillnow());
        
        //$repo3 = $this->getDoctrine()->getRepository(Monster::class);
        $monster = $userId->getMonsterUsers()->get($tour2);

        $repo4 = $this->getDoctrine()->getRepository(QuestVariable::class);
        $questvariable = $repo4->find($quest);

        //var_dump($questvariable->getMonsters());
        $monstercollec = $questvariable->getMonsters();
        
        //FAIRE LA BOITE CHOICE DE COMPETENCE
        $choice = array();
        $choicecible = array();
        if($action == 4 ){//if($action > 2 AND  ){
            $form2 = $this->createFormBuilder($monster)
        ->add('name',TextType::class)
        ->add('hp',TextType::class)
        ->add('atk',TextType::class)
        ->add('dgt',TextType::class)
        ->add('esq',TextType::class)
        ->add('def',TextType::class)
        ->add('description',TextType::class)
        ->add('image',TextType::class)
        ->add('save', SubmitType::class, [
            'label' => 'continuer'
        ])
        ->getForm();
    

        $form2->handleRequest($request);

       
        //FORM DU MONSTER PAR TOUR
        if($form2->isSubmitted() && $form2->isValid()){
        //$player->setName($player);
        $manager->persist($monster);
        $manager->flush();
        return $this->render('player/fight.html.twig', [
            'formPlayer' => $form2->createView(),
            'player' => $player,
            'monster' => $monster,
            'skill' => $playerskill,
            'action' => $action,
            'user' => $userId,
            'questvariable' => $questvariable,
            'tour' => $tour2,
            'infobattle' => $infobattle,
            'skillall' => $skillall,
        ]);
        }

        
        return $this->render('player/fight.html.twig', [
            'formPlayer' => $form2->createView(),
            'player' => $player,
            'monster' => $monster,
            'skill' => $playerskill,
            'action' => $action,
            'user' => $userId,
            'questvariable' => $questvariable,  
            'cible' => $cible,
            'tour' => $tour2,
            'infobattle' => $infobattle,
            'skillall' => $skillall,
        ]);

        }else if ($action < 3){
if(!empty($player->getSkillbdd()->get(0))){ array_push($choice, 0); }else{array_push($choice, 0);}
if(!empty($player->getSkillbdd()->get(1))){ array_push($choice, 1); }else{array_push($choice, 0);}
if(!empty($player->getSkillbdd()->get(2))){ array_push($choice, 2); }else{array_push($choice, 0);}
if(!empty($player->getSkillbdd()->get(3))){ array_push($choice, 3); }else{array_push($choice, 0);}

if(!empty($userId->getMonsterUsers()->get(0))){ array_push($choicecible, 0); }else{array_push($choicecible, 0);}
if(!empty($userId->getMonsterUsers()->get(1))){ array_push($choicecible, 1); }else{array_push($choicecible, 0);}
if(!empty($userId->getMonsterUsers()->get(2))){ array_push($choicecible, 2); }else{array_push($choicecible, 0);}
if(!empty($userId->getMonsterUsers()->get(3))){ array_push($choicecible, 3); }else{array_push($choicecible, 0);}


            //if(!empty($player->getSkillbdd()->get(0))){ $choice[0] = $player->getSkillbdd()->get(0)}
        $form = $this->createFormBuilder($player)
        ->add('name',HiddenType::class)
        ->add('level',HiddenType::class)
        ->add('experience',HiddenType::class)
        ->add('skillpnt',HiddenType::class)
        ->add('hp',HiddenType::class)
        ->add('atk',HiddenType::class)
        ->add('image',HiddenType::class)
        ->add('cible',ChoiceType::class, [
            'choices' => [
                $player->getName() => 0,
                $userId->getMonsterUsers()->get($choicecible[0])->getName() => $choicecible[0]+1,
                $userId->getMonsterUsers()->get($choicecible[1])->getName() => $choicecible[1]+1,
                $userId->getMonsterUsers()->get($choicecible[2])->getName() => $choicecible[2]+1,
                $userId->getMonsterUsers()->get($choicecible[3])->getName() => $choicecible[3]+1,
                
        ],
        ])
        ->add('skillnow',ChoiceType::class, [
            'choices' => //$player->getSkillbdd() /*
            [
                $player->getSkillbdd()->get($choice[0])->getName() => $choice[0]+1 ,
                $player->getSkillbdd()->get($choice[1])->getName() => $choice[1]+1,
                $player->getSkillbdd()->get($choice[2])->getName() => $choice[2]+1,
                $player->getSkillbdd()->get($choice[3])->getName() => $choice[3]+1,
                
        ],
        ])
        
        ->add('save', SubmitType::class, [
            'label' => 'continuer'
        ])
        ->getForm();
    

        $form->handleRequest($request);

       
        //FORM DU PLAYER PAR TOUR
        if($form->isSubmitted() && $form->isValid()){
        $manager->persist($player);
        $manager->flush();
        return $this->render('player/fight.html.twig', [
            'formPlayer' => $form->createView(),
            'player' => $player,
            'monster' => $monster,
            'skill' => $playerskill,
            'action' => $action,
            'user' => $userId,
            'questvariable' => $questvariable,
            'tour' => $tour2,
            'infobattle' => $infobattle,
            'skillall' => $skillall,
        ]);
        }
        return $this->render('player/fight.html.twig', [
            'formPlayer' => $form->createView(),
            'player' => $player,
            'monster' => $monster,
            'skill' => $playerskill,
            'action' => $action,
            'user' => $userId,
            'questvariable' => $questvariable,  
            'cible' => $cible,
            'tour' => $tour2,
            'infobattle' => $infobattle,
            'skillall' => $skillall,
        ]);
    }else{
        return $this->render('player/fight.html.twig', [
            'player' => $player,
            'monster' => $monster,
            'skill' => $playerskill,
            'action' => $action,
            'user' => $userId,
            'questvariable' => $questvariable,  
            'cible' => $cible,
            'tour' => $tour2,
            'infobattle' => $infobattle,
            'skillall' => $skillall,
        ]);
    }

    }

        
        
        
    }



    /**
     * @Route("/quest/delete/{id}", name="quest.delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteQuest(QuestVariable $quest, Request $request, ObjectManager $manager){
        if ($this->isCsrfTokenValid('delete' . $quest->getId(), $request->get('_token'))) {
        $manager->remove($quest);
        $manager->flush();
        $this->addFlash('succes', 'Quête supprimé avec succès');
        return $this->redirectToRoute('quest');
        } 
    }
    


    

    
}

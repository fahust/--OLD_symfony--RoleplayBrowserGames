<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Objet;
use App\Entity\Skill;
use App\Entity\Player;
use App\Entity\Monster;
use App\Form\ObjetType;
use App\Form\SkillType;
use App\Form\PlayerType;
use App\Form\MonsterType;
use App\Entity\MonsterUser;
use App\Entity\QuestVariable;
use App\Form\MonsterUserType;
use App\Form\QuestVariableType;
use App\Repository\UserRepository;
use App\Repository\PlayerRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PlayerController extends AbstractController
{
    /**
     * @Route("/player", name="player")
     */
    public function index(UserInterface $user)
    {
        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->find($userId2);

        $repo = $this->getDoctrine()->getRepository(Player::class);
        $players = $repo->findAll();

        return $this->render('player/index.html.twig', [
            'user' => $user,
            'controller_name' => 'PlayerController',
            'players' => $players
        ]);
    }

    /**
     * @Route("/monster", name="monster")
     */
    public function indexMonster(UserInterface $user)
    {
        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->find($userId2);

        $repo = $this->getDoctrine()->getRepository(Monster::class);
        $monster = $repo->findAll();

        return $this->render('monster/index.html.twig', [
            'user' => $user,
            'controller_name' => 'PlayerController',
            'monster' => $monster
        ]);
    }

    /**
     * @Route("/quest", name="quest")
     */
    public function indexQuest(UserInterface $user)
    {
        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->find($userId2);

        $repo = $this->getDoctrine()->getRepository(QuestVariable::class);
        $quest = $repo->findAll();

        return $this->render('quest/index.html.twig', [
            'user' => $user,
            'controller_name' => 'PlayerController',
            'quest' => $quest
        ]);
    }

    /**
     * @Route("/skill", name="skill")
     */
    public function indexSkill(UserInterface $user)
    {
        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->find($userId2);

        $repo = $this->getDoctrine()->getRepository(Skill::class);
        $skill = $repo->findAll();

        return $this->render('skill/index.html.twig', [
            'user' => $user,
            'controller_name' => 'PlayerController',
            'skill' => $skill
        ]);
    }

    /**
     * @Route("/objet", name="objet")
     */
    public function indexObjet(UserInterface $user)
    {
        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->find($userId2);

        $repo = $this->getDoctrine()->getRepository(Objet::class);
        $objet = $repo->findAll();

        return $this->render('objet/index.html.twig', [
            'user' => $user,
            'controller_name' => 'PlayerController',
            'objet' => $objet
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home() {
        
        $repo = $this->getDoctrine()->getRepository(QuestVariable::class);
        $quest1 = $repo->find(1);
        $repo = $this->getDoctrine()->getRepository(QuestVariable::class);
        $quest2 = $repo->find(31);
        $repo = $this->getDoctrine()->getRepository(QuestVariable::class);
        $quest3 = $repo->find(39);

        return $this->render('player/home.html.twig', [
            'quest1' => $quest1,
            'quest2' => $quest2,
            'quest3' => $quest3,
            'title' => "Bienvenue ici les amis"
        ]);
    }

    /**
     * @Route("/quest/victoire/{id}-{action}-{quest}-{cible}-{tour}", name="victoire")
     */
    public function victoire($id, $action, $quest, $cible, $tour, Request $request, ObjectManager $manager, UserInterface $user){

        $userId2 = $user->getId(); 
        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($userId2);
        $userId2 = $user->getId(); 

        $repo4 = $this->getDoctrine()->getRepository(QuestVariable::class);
        $questvariable = $repo4->find($quest);
        //echo $questvariable->getObjetreussite()->get(0);
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

        
        $userId2 = $user->getId(); 
        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($userId2);
        $userId2 = $user->getId(); 
        

        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($userId2);
        //echo $userId->getUsername();
        //var_dump($userId->getPlayerfight()->get(0)->getId()) ;

        //$repo = $this->getDoctrine()->getRepository(Player::class);
        //$player = $repo->find($tour);
        $player = $userId->getPlayerfight()->get($tour);
        $playerall = $this->getDoctrine()->getRepository(Player::class);
        $playerall = $playerall->findAll();

        $repo2 = $this->getDoctrine()->getRepository(Skill::class);
        $playerskill = $repo2->findAll();

        $repo4 = $this->getDoctrine()->getRepository(QuestVariable::class);
        $questvariable = $repo4->find($quest);

        //var_dump($questvariable->getMonsters());
        $monstercollec = $questvariable->getMonsters();

        $userId->setTour(1);
            $userId->setAction(0);
            $manager->persist($userId);
            $manager->flush();
        
        //$repo3 = $this->getDoctrine()->getRepository(Monster::class);
        //$monster = $repo3->find($tour);
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
     * @Route("/player/new/{id}", name="player_create")
     * @Route("/player/edit/{id}", name="player_edit")
     */
    public function create($id, Request $request, ObjectManager $manager, UserInterface $user) {
        if($id == 0){$player = new Player();}else{
        $repo = $this->getDoctrine()->getRepository(Player::class);
        $player = $repo->find($id);}

        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->find($userId2);

        $repo = $this->getDoctrine()->getRepository(Skill::class);
        $skill = $repo->findAll();

        
        $form = $this->createFormBuilder($player)
        ->add('name')
        //->add('level')
        //->add('experience')
        //->add('skillpnt')
        //->add('hp')
        //->add('atk')
        ->add('skillbdd', EntityType::class, [
            'class' => Skill::class,
            //'choices' => $skill,
            'multiple' => true,
            'choice_label' => 'name',
        ]
        )
        
        ->add('image')
        ->add('save', SubmitType::class, [
            'label' => 'enregistrer'
        ])
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($id == 0){
            $player->setCreatedAt(new \DateTime());
            $player->setCreateur($user->getId());
            $player->setMaxhp(rand(50,100));
            $player->setCible(1);
            $player->setSkillnow(1);
            $player->setHp(50);
            $player->setAtk(rand(1,3));
            $player->setSkillpnt(1);
            $player->setLevel(1);
            $player->setExperience(1);
            }
            
            
            if($player->getSkillbdd()->count() < ($player->getSkillpnt())+1 ) {
                
                $user->addPlayercreated($player);
                $manager->persist($player);
                $manager->persist($user);
                $manager->flush();
                
                $this->addFlash('succes', "joueur édité/créé avec succes" );
            }else{
                var_dump( $player->getSkillbdd()->count());
                $this->addFlash('succes', "Vous avez sélectioner plus de compétences que vous n'avez de points, vous avez " . $player->getSkillpnt() . " points");
            }
                return $this->redirectToRoute('player_create', [
                    'id' => $player->getId(),
                    'player' => $player,
                    'id' => $id,
                    'user' => $user
                ]);
            
        }

        return $this->render('player/create.html.twig', [
            'user' => $user,
            'id' => $id,
            'player' => $player,
            'formPlayer' => $form->createView()
        ]);
    }

    /**
     * @Route("/skill/ajout/{id}", name="skill_ajout")
     */
    public function ajoutSkill($id ,Request $request, ObjectManager $manager, UserInterface $user) {
        

        $repo = $this->getDoctrine()->getRepository(Skill::class);
        $skill = $repo->findAll();
        $repo2 = $this->getDoctrine()->getRepository(Player::class);
        $player = $repo2->find($id);

        return $this->render('skill/ajout.html.twig', [
            'skill' => $skill,
            'player' => $player
        ]);

        
    }


    /**
     * @Route("/skill/new/{id}", name="skill_create")
     * @Route("/skill/edit/{id}", name="skill_edit")
     */
    public function createSkill($id , Request $request, ObjectManager $manager, UserInterface $user) {

        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->find($userId2);
        
        if($id == 0){$skill = new Skill();}else{
        $repo = $this->getDoctrine()->getRepository(Skill::class);
        $skill = $repo->find($id);}

        $form = $this->createForm(SkillType::class, $skill);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //$player->setCreatedAt(new \DateTime());
            
            $skill->setCreateur($user->getId());

            $manager->persist($skill);
            $this->addFlash('succes', "Compétence édité/créé avec succes" );
            $manager->flush();

            /*return $this->redirectToRoute('player_show', [
                'id' => $skill->getId()
            ]);*/
        }

        return $this->render('skill/create.html.twig', [
            'formSkill' => $form->createView()
        ]);
    }


    /**
     * @Route("/objet/new/{id}", name="objet_create")
     * @Route("/objet/edit/{id}", name="objet_edit")
     */
    public function createObjet($id , Request $request, ObjectManager $manager, UserInterface $user) {

        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->find($userId2);
        
        if($id == 0){$objet = new Objet();}else{
        $repo = $this->getDoctrine()->getRepository(Objet::class);
        $objet = $repo->find($id);}

        $form = $this->createForm(ObjetType::class, $objet);//createFormBuilder($objet)
        /*->add('name')
        ->add('image')
        ->add('description')
        ->add('save', SubmitType::class, [
            'label' => 'Lancer la quête'
        ])
        ->getForm();*/

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //$player->setCreatedAt(new \DateTime());
            
            $objet->setCreateur($user->getId());

            $manager->persist($objet);
            $this->addFlash('succes', "Objet édité/créé avec succes" );
            $manager->flush();

            /*return $this->redirectToRoute('player_show', [
                'id' => $skill->getId()
            ]);*/
        }

        return $this->render('objet/create.html.twig', [
            'formObjet' => $form->createView()
        ]);
    }

    /**
     * @Route("/monster/new/{id}", name="monster_create")
     * @Route("monster/edit/{id}", name="monster_edit")
     */
    public function createMonster($id , Request $request, ObjectManager $manager, UserInterface $user) {

        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->find($userId2);

        if($id == 0){$monster = new Monster();}else{
            $repo = $this->getDoctrine()->getRepository(Monster::class);
            $monster = $repo->find($id);}

        $form = $this->createForm(MonsterType::class, $monster);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //$player->setCreatedAt(new \DateTime());
            //$monster->addSkillbdd($monster);
            $monster->setCreateur($user->getId());
            $manager->persist($monster);
            $this->addFlash('succes', "Monstre édité/créé avec succes" );
            $manager->flush();

            /*return $this->redirectToRoute('player_show', [
                'id' => $skill->getId()
            ]);*/
        }

        return $this->render('monster/create.html.twig', [
            'formMonster' => $form->createView()
        ]);
    }

    /**
     * @Route("/quest/new/{id}", name="quest_create")
     * @Route("/quest/edit/{id}", name="quest_edit")
     */
    public function createQuest($id ,Request $request, ObjectManager $manager, UserInterface $user) {

        $objetall = $this->getDoctrine()->getRepository(Objet::class);
        $objetall = $objetall->findAll();

        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->find($userId2);
        
        if($id == 0){$quest = new QuestVariable();}else{
            $repo = $this->getDoctrine()->getRepository(QuestVariable::class);
            $quest = $repo->find($id);}

        $form = $this->createForm(QuestVariableType::class, $quest)
        ->add('questrequismany', EntityType::class ,[
            'label' => 'Objet de quête requis pour lancer la quête',
            'class' => (Objet::class),
            'choice_label' => 'name',
            'placeholder' => 'nothing2',
            'required'      => false,
            //'choice_value' => 'nothing'
            ])
        ->add('objetreussite', EntityType::class ,[
                'label' => 'Objet gagné en cas de victoire',
                'class' => (Objet::class),
                'choice_label' => 'name',
                'multiple' => true,
                'placeholder' => 'nothing2',
                'required'      => false,
                //'choice_value' => 'nothing'
                ])
            /*->add('objetrequis', EntityType::class, [
            'class' => Player::class,
            'choices' => $userId->getPlayercreated(),
            
            'choice_label' => 'id',
            
        ])*/;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //$player->setCreatedAt(new \DateTime());
            //$quest->addSkillbdd($quest);
            $quest->setCreateur($user->getId());

            //$quest->setObjetrequis($quest->getObjetrequis());

            $manager->persist($quest);
            $this->addFlash('succes', 'quête créé/édité avec succès');
            $manager->flush();

            /*return $this->redirectToRoute('player_show', [
                'id' => $skill->getId()
            ]);*/
        }

        return $this->render('quest/create.html.twig', [
            'formQuest' => $form->createView()
        ]);
    }



    /**
     * @Route("/player/{id}", name="player_show")
     */
    public function show($id){
        $repo = $this->getDoctrine()->getRepository(Player::class);
        $player = $repo->find($id);

        return $this->render('player/show.html.twig', [
            'player' => $player
        ]);
    }

    

    /**
     * @Route("/player/choixjoueur/{id}-{action}-{quest}-{cible}-{tour}", name="player_choixjoueur")
     */
    public function choixjoueur($id, $action, $quest, $cible, $tour, Request $request, ObjectManager $manager, UserInterface $user){

        
        $userId2 = $user->getId(); 
        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($userId2);
        $userId2 = $user->getId(); 

        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($userId2);
        //echo $userId->getUsername();
        //var_dump($userId->getPlayerfight()->get(0)->getId()) ;

        //$repo = $this->getDoctrine()->getRepository(Player::class);
        //$player = $repo->find($tour);
        $player = $userId->getPlayerfight()->get($tour);
        $playerall = $this->getDoctrine()->getRepository(Player::class);
        $playerall = $playerall->findAll();

        $repo2 = $this->getDoctrine()->getRepository(Skill::class);
        $playerskill = $repo2->findAll();

        $repo4 = $this->getDoctrine()->getRepository(QuestVariable::class);
        $questvariable = $repo4->find($quest);

        //var_dump($questvariable->getMonsters());
        $monstercollec = $questvariable->getMonsters();
        
        //$repo3 = $this->getDoctrine()->getRepository(Monster::class);
        //$monster = $repo3->find($tour);
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
            /*'query_builder' => function (PlayerRepository $er )  {
                 $er->createQueryBuilder('u')
                    ->orderBy('u.id', 'ASC')
                    ->andWhere('u.createur = 1')
                    ->setParameter('val', 1);
                    //return $er
            },*/
            'choice_label' => 'name',
            
        ])
        ->add('save', SubmitType::class, [
            'label' => 'Lancer la quête'
        ])
        ->getForm();

        $formuser->handleRequest($request);
        //echo $userId->getMonsterUsers()->count();
        
        if($formuser->isSubmitted() && $formuser->isValid()){
            //if ($action == 0) {
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

        $manager->flush();//}
            //$player->setName($player);
            //var_dump($userId->getPlayerfight()->get(0)->getName());
            $userId->setTour(1);
            $userId->setAction(0);
            $manager->persist($userId);
            $manager->flush();
                //{{ path('questlaunch', {id: user.id, action: '1', quest: questvariable.id, cible: '0', tour: '1'}) }}
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
        $userId2 = $user->getId(); 

        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($userId2);

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
                    
                        //echo $userId->getMonsterUsers()->get(($userId->getMonsterUsers()->count())-1)->getSkillbdd()->get($skillvar)->getName();
                }
            }
            $attaquant = $userId->getMonsterUsers()->get(($userId->getMonsterUsers()->count())-1);

        }
        }else{//CHOIX DE CIBLE DU JOUEUR 
            
             //if $userId->getTour() > $userId->getMonsterUsers()->count() ){
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
            $subplayerhp = 0 ;//-= ($skilluse->getSkatk())*(($attaquant->getAtk()));
            $array = ["Le résultat des dé est de " . $de . " / " . (($questvariable->getDedifficult())+$de2) . " , Echec de " . $skilluse->getName(), ".. La compétence échoue", "", ""  , $skilluse->getImage() , $cibleobj ];
            
        }
        
    }

        //echo $cible->getName() ;
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
            //echo $userId ;
            //echo ($cibleobj->getHp()) ;
            //echo $monsteruserall[0];
            if(!empty($cibleobj)){
            if($cibleobj->getHp() <= 0) {//$manager->remove($cibleobj);
                $this->addFlash('succes', 'monstre vainqu');
                $attaquant->setExperience(($attaquant->getExperience())+1);
                if($attaquant->getExperience() > ($attaquant->getLevel())*10 ){
                    $attaquant->setLevel(($attaquant->getLevel())+1);
                    $attaquant->setSkillpnt(($attaquant->getSkillpnt())+1);
                    $attaquant->setAtk(($attaquant->getAtk())+1);
                    $attaquant->setExperience(1);
                    //$attaquant->setAtk(($attaquant->getAtk())+1);
                    $this->addFlash('succes', 'Vous gagnez un niveau ! ');
                }
                $manager->persist($attaquant);
                $manager->remove($cibleobj);
                //$userId->removeMonsterUser(($userId->getMonsterUsers()->get(($userId->getTour())-0)));
                //$manager->persist($userId);

            }
            }
           
        //}
        
            $manager->flush();
        //}
        

        return $array;    
        
    }


    /**
     * @Route("/player/fight/{id}-{action}-{quest}-{cible}-{tour}", name="player_fight")
     */
    public function fight($id, $action, $quest, $cible, $tour, Request $request, ObjectManager $manager, UserInterface $user){

        $userId2 = $user->getId(); 
        $userId = $this->getDoctrine()->getRepository(User::class);
        $userId = $userId->find($userId2);

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
        //$manager->persist($cible);
        //$manager->flush();
        //var_dump($infobattle);
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
        //$repo = $this->getDoctrine()->getRepository(Player::class);
        //$player = $repo->find($tour2);
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
        
        //ajout des monstres dans le fight
        //$action = 4;
        


        

        



        //FAIRE LA BOITE CHOICE DE COMPETENCE
        $choice = array();
        $choicecible = array();
        

        //form pour monstre ou joueur
        //echo $monster->getId() ;
        //echo $action ;echo $tour2 ;
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
        //->add('skillbdd',HiddenType::class)
        //->add('user',HiddenType::class)
        
        
        ->add('save', SubmitType::class, [
            'label' => 'continuer'
        ])
        ->getForm();
    

        $form2->handleRequest($request);

       
        //FORM DU MONSTER PAR TOUR
        if($form2->isSubmitted() && $form2->isValid()){
        //$player->setName($player);
        $manager->persist($monster);
        //$manager->persist($quest);
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
        //$player->setName($player);
        $manager->persist($player);
        //$manager->persist($quest);
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

    //si encore des monstres
    }

        
        
        
    }

    /**
     * @Route("/new_action", name="new_action")
     */
    public function newAction(  ObjectManager $manager)
    {
        
        $repo = $this->getDoctrine()->getRepository(Player::class);
        $user = $repo->find(1);

        $repo2 = $this->getDoctrine()->getRepository(Skill::class);
        $user2 = $repo2->find(1);

        $user->addSkillbdd($user2);
        
        $manager->persist($user);
        $manager->flush();

        return $this->render('player/home.html.twig', [
            'title' => "Bienvenue ici les amis"
        ]);
        /*
        $genus->addGenusScientist($user);*/
    }


    /**
     * @Route("/monster/delete/{id}", name="monster.delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteMonster(Monster $monster, Request $request, ObjectManager $manager){
        if ($this->isCsrfTokenValid('delete' . $monster->getId(), $request->get('_token'))) {
        $manager->remove($monster);
        $manager->flush();
        $this->addFlash('succes', 'Monstre supprimé avec succès');
        return $this->redirectToRoute('monster');
        } 
    }
    /**
     * @Route("/player/delete/{id}", name="player.delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deletePlayer(Player $player, Request $request, ObjectManager $manager){
        if ($this->isCsrfTokenValid('delete' . $player->getId(), $request->get('_token'))) {
        $manager->remove($player);
        $manager->flush();
        $this->addFlash('succes', 'Joueur supprimé avec succès');
        return $this->redirectToRoute('player');
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
    /**
     * @Route("/skill/delete/{id}", name="skill.delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteSkill(Skill $skill, Request $request, ObjectManager $manager){
        if ($this->isCsrfTokenValid('delete' . $skill->getId(), $request->get('_token'))) {
        $manager->remove($skill);
        $manager->flush();
        $this->addFlash('succes', 'Compétence supprimé avec succès');
        return $this->redirectToRoute('skill');
        } 
    }

    /**
     * @Route("/objet/delete/{id}", name="objet.delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteObjet(Objet $objet, Request $request, ObjectManager $manager){
        if ($this->isCsrfTokenValid('delete' . $objet->getId(), $request->get('_token'))) {
        $manager->remove($objet);
        $manager->flush();
        $this->addFlash('succes', 'Objet supprimé avec succès');
        return $this->redirectToRoute('objet');
        } 
    }



    

    
}

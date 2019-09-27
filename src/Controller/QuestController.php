<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Likes;
use App\Entity\Skill;
use App\Entity\Player;
use App\Form\FightType1;
use App\Form\FightType2;
use App\Entity\QuestSearch;
use App\Entity\QuestVariable;
use App\Form\QuestSearchTypeLeft;
use App\Form\QuestSearchTypeRight;
use App\Form\QuestVariableType;
use App\Entity\QuestVariableUtils;
use App\Repository\LikesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestController extends AbstractController
{
    /**
     * @Route("/quest", name="quest")
     */
    public function indexQuest(UserInterface $user, PaginatorInterface $paginator, Request $request)
    {
        $search = new QuestSearch();
        $formLeft = $this->createForm(QuestSearchTypeLeft::class, $search);
        $formLeft->handleRequest($request);
        $user = $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId());
        $maxByPage = ($search->getChoiceNbrPerPage()) ? $search->getChoiceNbrPerPage() : 6;

        return $this->render('quest/index.html.twig', [
            'user' => $user,
            'controller_name' => 'PlayerController',
            'quest' => $paginator->paginate($this->getDoctrine()->getRepository(QuestVariable::class)->findAllWithSkill($search,$user),
            $request->query->getInt('page',1),$maxByPage),//$this->getDoctrine()->getRepository(QuestVariable::class)->findAllWithMonster()
            'formLeft' => $formLeft->createView(),
        ]);
    }

    /**
     * @Route("/unlogin/quest", name="questunlogin")
     */
    public function questunlogin( PaginatorInterface $paginator, Request $request)
    {
        $search = new QuestSearch();
        $formLeft = $this->createForm(QuestSearchTypeLeft::class, $search);
        $formLeft->handleRequest($request);
        $maxByPage = ($search->getChoiceNbrPerPage()) ? $search->getChoiceNbrPerPage() : 6;

        return $this->render('quest/index.html.twig', [
            'user' => null,//$this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId()),
            'controller_name' => 'PlayerController',
            'quest' => $paginator->paginate($this->getDoctrine()->getRepository(QuestVariable::class)->findAllWithSkill($search,null),
            $request->query->getInt('page',1),$maxByPage),//$this->getDoctrine()->getRepository(QuestVariable::class)->findAllWithMonster()
            'formLeft' => $formLeft->createView(),
        ]);
    }

    /**
     * ajout des objets de la quête / ajout de conscruct point pour faire des cartes / remettre les stat du joueur a son max
     * @Route("/quest/victory/{id}-{action}-{quest}-{cible}-{tour}", name="victoire")
     */
    public function victoire($id, $action, $quest, $cible, $tour, ObjectManager $manager, UserInterface $user)
    {
        $questvariable = $this->getDoctrine()->getRepository(QuestVariable::class)->find($quest);
        $userId = $this->getDoctrine()->getRepository(User::class)->find($user->getId());
        if(!empty($questvariable->getObjetreussite()->get(0)))
            ($userId->addObjet($questvariable->getObjetreussite()->get(0)));
        if(!empty($questvariable->getObjetreussite()->get(1)))
            ($userId->addObjet($questvariable->getObjetreussite()->get(1)));
        if(!empty($questvariable->getObjetreussite()->get(2)))
            ($userId->addObjet($questvariable->getObjetreussite()->get(2)));
        if(!empty($questvariable->getObjetreussite()->get(3)))
            ($userId->addObjet($questvariable->getObjetreussite()->get(3)));

        $userId->setConstructpnt(($userId->getConstructpnt())+1);

        foreach($userId->getPlayerfight() as $fighter){
            $fighter->setHp($fighter->getMaxhp());
            $fighter->setAtk($fighter->getMaxatk());
            $fighter->setEsq($fighter->getMaxesq());
            $fighter->setDef($fighter->getMaxdef());
            $fighter->setMana($fighter->getMaxmana());
            $manager->persist($fighter);
        }
        $manager->persist($userId);
        $manager->flush();

        return $this->redirectToRoute('quest', [
            'id' => $id,
            'quest' => $quest,
            'cible' => $cible,
            'tour' => $tour,
        ]);
    }

    /**
     * @Route("/quest/launch/{id}-{action}-{quest}-{cible}-{tour}", name="questlaunch")
     */
    public function questlaunch($id, $action, $quest, $cible, $tour, ObjectManager $manager, UserInterface $user)
    {
        $userId = $this->getDoctrine()->getRepository(User::class)->find($user->getId());

            $userId->setTour(1);
            $userId->setAction(0);
            $manager->persist($userId);
            $manager->flush();

        return $this->render('player/quest.html.twig', [
            'player' => $userId->getPlayerfight()->get($tour),
            'monster' => $userId->getMonsterUsers()->get($tour),
            'skill' => $this->getDoctrine()->getRepository(Skill::class)->findAll(),
            'action' => $action,
            'user' => $userId,
            'questvariable' => $this->getDoctrine()->getRepository(QuestVariable::class)->find($quest),
            'playerall' => $this->getDoctrine()->getRepository(Player::class)->findAll(),
            
        ]);
    }

    /**
     * @Route("/quest/new/{id}", name="quest_create")
     * @Route("/quest/edit/{id}", name="quest_edit")
     */
    public function createQuest($id ,Request $request, ObjectManager $manager, UserInterface $user) {
        $user = $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId());
        if($id == 0){$quest = new QuestVariable();
            $quest->setCreatedAt(new \DateTime());}else{
            $quest = $this->getDoctrine()->getRepository(QuestVariable::class)->find($id);}
        $form = $this->createForm(QuestVariableType::class, $quest);
        $quest->setImageFile(null);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if ($user->getConstructpnt() > 0  || $id != 0) {
                if ($id == 0){$user->setConstructpnt(($user->getConstructpnt()-1));}
                $manager->persist($user);
                $quest->setUpdatedAt(new \DateTime());
                $quest->setCreateur($user->getId());
                $quest->setImage(1);
                $manager->persist($quest);
                $this->addFlash('succes', 'quest successfully created/edited');
                $manager->flush();
                return $this->redirectToRoute('quest');
            }else{
                $this->addFlash('warning', "You no longer have map building points, do quests !");
            }
        }

        return $this->render('quest/create.html.twig', [
            'formQuest' => $form->createView()
        ]);
    }

    /**
     * @Route("/player/choice/{id}-{action}-{quest}-{cible}-{tour}", name="player_choixjoueur")
     */
    public function choixjoueur($id, $action, $quest, $cible, $tour, Request $request, ObjectManager $manager, UserInterface $user)
    {
        $userId = $this->getDoctrine()->getRepository(User::class)->find($user->getId());
        $player = $userId->getPlayerfight()->get($tour);
        $playerall = $this->getDoctrine()->getRepository(Player::class)->findAll();
        $playerskill = $this->getDoctrine()->getRepository(Skill::class)->findAll();
        $questvariable = $this->getDoctrine()->getRepository(QuestVariable::class)->find($quest);
        $monstercollec = $questvariable->getMonsters();
        $monster = $userId->getMonsterUsers()->get($tour);

        //FORM DE L USER
        $formuser = $this->createForm(FightType1::class)
        ->add('playerfight', EntityType::class, [
            'class' => Player::class,
            'choices' => $userId->getPlayercreated(),
            'multiple' => true,
            'choice_label' => 'name',
        ]);

        $formuser->handleRequest($request);
        if($formuser->isSubmitted() && $formuser->isValid()){
            QuestVariableUtils::importMonsterUser($monstercollec,$userId,$manager);
            return $this->redirectToRoute('questlaunch', [
                'id' => $id,
                'quest' => $quest,
                'cible' => $cible,
                'tour' => $tour,
                //'formUser' => $formuser->createView(),
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

    /**
     * @Route("/player/fight/{id}-{action}-{quest}-{cible}-{tour}", name="player_fight")
     */
    public function fight($id, $action, $quest, $cible, $tour, Request $request, ObjectManager $manager, UserInterface $user)
    {
        $userId = $this->getDoctrine()->getRepository(User::class)->findWithMonsterUserAndPlayerFighter($user->getId());
        if((empty($userId->getMonsterUsers()->get(0))) or (empty($userId->getPlayerfight()->get(0)))){
            if(empty($userId->getPlayerfight()->get(0)))
                $this->addFlash('succes', "No players in the team");
            if((empty($userId->getMonsterUsers()->get(0))))
                $this->addFlash('succes', 'No monster has ever faced');
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
                $infobattle = QuestVariableUtils::fightcalculmonster($quest, $request,$manager,$user,$this);
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
            if($userId->getTour() < $userId->getPlayerfight()->count()) {
                $player = $userId->getPlayerfight()->get(($userId->getTour())-1);
            }else{
                $player = $userId->getPlayerfight()->get(($userId->getPlayerfight()->count())-1);
            }
            $monster = $userId->getMonsterUsers()->get($tour2);
            
            //FAIRE LA BOITE CHOICE DE COMPETENCE
            $choice = array();
            $choicecible = array();
            if($action == 4 ){//if($action > 2 AND  ){
                $form2 = $this->createForm(FightType2::class);
            $form2->handleRequest($request);

            //FORM DU MONSTER PAR TOUR
            if($form2->isSubmitted() && $form2->isValid()){
                $manager->persist($monster);
                $manager->flush();
            }

            return $this->render('player/fight.html.twig', [
                'formPlayer' => $form2->createView(),
                'player' => $player,
                'monster' => $monster,
                'skill' => $this->getDoctrine()->getRepository(Skill::class)->findAll(),
                'action' => $action,
                'user' => $userId,
                'questvariable' => $this->getDoctrine()->getRepository(QuestVariable::class)->find($quest),  
                'cible' => $cible,
                'tour' => $tour2,
                'infobattle' => $infobattle,
                'skillall' => $this->getDoctrine()->getRepository(Skill::class)->find($player->getSkillnow()),
            ]);

            }else if ($action < 3){
                for ($i = 0; $i <= 3; $i++) {
                    if(!empty($player->getSkillbdd()->get($i))){ array_push($choice, $i); }else{array_push($choice, 0);}
                    if(!empty($userId->getMonsterUsers()->get($i))){ array_push($choicecible, $i); }else{array_push($choicecible, 0);}
                }
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
            }
            return $this->render('player/fight.html.twig', [
                'formPlayer' => $form->createView(),
                'player' => $player,
                'monster' => $monster,
                'skill' => $this->getDoctrine()->getRepository(Skill::class)->findAll(),
                'action' => $action,
                'user' => $userId,
                'questvariable' => $this->getDoctrine()->getRepository(QuestVariable::class)->find($quest),  
                'cible' => $cible,
                'tour' => $tour2,
                'infobattle' => $infobattle,
                'skillall' => $this->getDoctrine()->getRepository(Skill::class)->find($player->getSkillnow()),
            ]);
            }else{
            return $this->render('player/fight.html.twig', [
                'player' => $player,
                'monster' => $monster,
                'skill' => $this->getDoctrine()->getRepository(Skill::class)->findAll(),
                'action' => $action,
                'user' => $userId,
                'questvariable' => $this->getDoctrine()->getRepository(QuestVariable::class)->find($quest),  
                'cible' => $cible,
                'tour' => $tour2,
                'infobattle' => $infobattle,
                'skillall' => $this->getDoctrine()->getRepository(Skill::class)->find($player->getSkillnow()),
                ]);
            }
            }
        }


        /**
         * @Route("/quest/delete/{id}", name="quest.delete", methods="DELETE")
         * @param Property $property
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function deleteQuest(QuestVariable $quest, Request $request, ObjectManager $manager ,UserInterface $user){
            if ($this->isCsrfTokenValid('delete' . $quest->getId(), $request->get('_token'))) {
                $user = $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId());
                $user->setConstructpnt(($user->getConstructpnt())+1);
                $manager->persist($user);
                $manager->remove($quest);
                $manager->flush();
                $this->addFlash('succes', 'Quest successfully deleted');
                return $this->redirectToRoute('quest');
            } 
        }
        

        
/**
 * Permet de liker ou unliker un article
 * @Route("/quest/post/{id}/like", name="post_like_quest")
 *
 * @param QuestVariable $quest
 * @param ObjectManager $manager
 * @param LikesRepository $likeRepo
 */
public function like(QuestVariable $quest, ObjectManager $manager, LikesRepository $likeRepo ,UserInterface $user) : Response {
    $userrepo = $this->getDoctrine()->getRepository(User::class);
    $user = $userrepo->find($user->getId());

    if(!$user) return $this->json([
        'code' => 403,
        'message' => "Unauthorized"
    ],403);

    if($save = $quest->isLikedByUser($user)) {
        $manager->remove($save);
        $manager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'like bien supprimé',
            'likes' => count($likeRepo->findLikeWithIdQuest($quest->getId()))
        ],200);
    }

    $like = new Likes();
    $like->addQuest($quest)
        ->setByuser($user);
    $manager->persist($like);
    $manager->flush();
    return $this->json([
        'code' => 200, 
        'message' => 'Like bien ajouté',
        'likes' => count($likeRepo->findLikeWithIdQuest($quest->getId()))
    ], 200);

}

/**
 * Permet de recharger les nouveau like
 * @Route("/quest/post/{id}/likereload", name="post_likereload_quest")
 * @param QuestVariable $quest
 * @param ObjectManager $manager
 * @param LikesRepository $likeRepo
 */
public function likereload(QuestVariable $quest, ObjectManager $manager,UserInterface $user, LikesRepository $likeRepo) : Response {
    $user = $this->getDoctrine()->getRepository(User::class)->find($user->getId());

    $quest->setNbrlike($quest->getLikes()->count());
    $manager->persist($quest);
    $manager->flush();

    return $this->json([
        'code' => 200, 
        'message' => 'Like bien chargé',
        'likes' => count($likeRepo->findLikeWithIdQuest($quest->getId()))
    ], 200);

}  
    }

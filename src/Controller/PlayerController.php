<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Likes;
use App\Entity\Skill;
use App\Entity\Groups;
use App\Entity\Player;
use App\Form\PlayerType;
use App\Entity\PlayerSearch;
use App\Entity\QuestVariable;
use App\Form\PlayerSearchTypeLeft;
use App\Form\PlayerSearchTypeRight;
use App\Repository\LikesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route as route2;

class PlayerController extends AbstractController
{
    /**
     * @Route("/player", name="player")
     */
    public function index(UserInterface $user, PaginatorInterface $paginator, Request $request)
    {
        $search = new PlayerSearch();
        $formLeft = $this->createForm(PlayerSearchTypeLeft::class, $search);
        $formRight = $this->createForm(PlayerSearchTypeRight::class, $search);
        $formLeft->handleRequest($request);
        $formRight->handleRequest($request);
        $user = $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId());
        $maxByPage = ($search->getChoiceNbrPerPage()) ? $search->getChoiceNbrPerPage() : 6;

        return $this->render('player/index.html.twig', [
            'user' => $user,
            'controller_name' => 'PlayerController',
            'players' => $paginator->paginate($this->getDoctrine()->getRepository(Player::class)->findAllWithSkill($search,$user),
            $request->query->getInt('page',1),$maxByPage),//$this->getDoctrine()->getRepository(Player::class)->findAllWithSkill()
            'formLeft' => $formLeft->createView(),
            'formRight' => $formRight->createView()
        ]);
    }

    /**
     * @Route("/playerunlogin", name="playerunlogin")
     */
    public function playerunlogin(PaginatorInterface $paginator, Request $request)
    {
        $search = new PlayerSearch();
        $formLeft = $this->createForm(PlayerSearchTypeLeft::class, $search);
        $formRight = $this->createForm(PlayerSearchTypeRight::class, $search);
        $formLeft->handleRequest($request);
        $formRight->handleRequest($request);
        $maxByPage = ($search->getChoiceNbrPerPage()) ? $search->getChoiceNbrPerPage() : 6;

        return $this->render('player/index.html.twig', [
            'user' => null,//$this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId()),
            'controller_name' => 'PlayerController',
            'players' => $paginator->paginate($this->getDoctrine()->getRepository(Player::class)->findAllWithSkill($search,null),
            $request->query->getInt('page',1),$maxByPage),//$this->getDoctrine()->getRepository(Player::class)->findAllWithSkill()
            'formLeft' => $formLeft->createView(),
            'formRight' => $formRight->createView()
        ]);
    }


    /**
     * @Route("/", name="home")
     */
    public function home() 
    {
        //$repo = $this->getDoctrine()->getRepository(QuestVariable::class);
        $repo = $this->getDoctrine()->getRepository(QuestVariable::class)->findAllLastDate();

        return $this->render('player/home.html.twig', [
            'quest1' => $repo[0],
            'quest2' => $repo[1],
            'quest3' => $repo[2],
            'title' => "RollCardPlay - Le roleplay dont vous êtes le créateur"
        ]);
    }

    /**
     * @Route("/player/new/{id}", name="player_create")
     * @Route("/player/edit/{id}", name="player_edit")
     */
    public function create($id, Request $request, ObjectManager $manager, UserInterface $user) {
        if($id == 0){$player = new Player();}else{
        $player = $this->getDoctrine()->getRepository(Player::class)->find($id);}
        $player->setImageFile(null);

        $user = $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId());
        
        $form = $this->createForm(PlayerType::class, $player);//createFormBuilder($objet)

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($id == 0){
            $player->setCreatedAt(new \DateTime());
            $player->setCreateur($user->getId());
            $player->setMaxhp(rand(50,100));
            $player->setCible(1);
            $player->setSkillnow(1);
            $player->setHp($player->getMaxhp());
            $player->setAtk(rand(1,3));
            $player->setMana(rand(1,3));
            $player->setEsq(rand(1,3));
            $player->setDef(rand(1,3));
            $player->setMaxatk($player->getAtk());
            $player->setMaxmana($player->getMana());
            $player->setMaxesq($player->getEsq());
            $player->setMaxdef($player->getDef());
            $player->setSkillpnt(1);
            $player->setLevel(1);
            $player->setExperience(1);
            $player->setImage(1);
            }
            $player->setUpdatedAt(new \DateTime());
            if ($user->getConstructpnt() > 0  || $id != 0) {
                if($player->getSkillbdd()->count() < ($player->getSkillpnt())+1 ) {
                if ($id == 0){$user->setConstructpnt(($user->getConstructpnt()-1));}
                    $manager->persist($user);
                    $manager->persist($player);
                    $manager->flush();
                    //$player->setImageFile(null);
                    //$player->setImageName(null);
                    $user->addPlayercreated($player);
                    $manager->persist($user);
                    $manager->flush();
                    $this->addFlash('succes', "player successfully edited/created" );
                }else{
                    $this->addFlash('warning', "You have selected more skills than you have points, you have " . $player->getSkillpnt() . " points");
                }
            }else{
                $this->addFlash('warning', "You no longer have map building points, do quests !");
            }
        return $this->redirectToRoute('player');
        }
        return $this->render('player/create.html.twig', [
            'user' => $user,
            'id' => $id,
            'player' => $player,
            'formPlayer' => $form->createView()
        ]);
    }


    /**
     * @Route("/player/{id}", name="player_show")
     */
    public function show($id){
        return $this->render('player/show.html.twig', [
            'player' => $this->getDoctrine()->getRepository(Player::class)->find($id)
        ]);
    }

    /**
     * @Route("/player/delete/{id}", name="player.delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deletePlayer(Player $player, Request $request, ObjectManager $manager ,UserInterface $user){
        if ($this->isCsrfTokenValid('delete' . $player->getId(), $request->get('_token'))) {
            $user = $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId());
            $user->setConstructpnt(($user->getConstructpnt())+1);
            $manager->persist($user);
            $manager->remove($player);
            $manager->flush();
            $this->addFlash('succes', 'Player successfully deleted');
            return $this->redirectToRoute('player');
        } 
    }
   

    
/**
 * Permet de liker ou unliker un article
 * @Route("/player/post/{id}/like", name="post_like_player")
 * @param Player $player
 * @param ObjectManager $manager
 * @param LikesRepository $likeRepo
 */
public function like(Player $player, ObjectManager $manager, LikesRepository $likeRepo ,UserInterface $user) : Response {
    $userrepo = $this->getDoctrine()->getRepository(User::class);
    $user = $userrepo->find($user->getId());

    if(!$user) return $this->json([
        'code' => 403,
        'message' => "Unauthorized"
    ],403);

    if($save = $player->isLikedByUser($user)) {
        $manager->remove($save);
        $manager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'like bien supprimé',
            'likes' => count($likeRepo->findLikeWithIdPlayer($player->getId()))
        ],200);
    }

    $like = new Likes();
    $like->addPlayer($player)
        ->setByuser($user);
    $manager->persist($like);
    $manager->flush();
    return $this->json([
        'code' => 200, 
        'message' => 'Like bien ajouté',
        'likes' => count($likeRepo->findLikeWithIdPlayer($player->getId()))
    ], 200);
}


/**
 * Permet de recharger les nouveau like
 * @Route("/player/post/{id}/likereload", name="post_likereload_player")
 * @param Player $player
 * @param ObjectManager $manager
 * @param LikesRepository $likeRepo
 */
public function likereload(Player $player, ObjectManager $manager,UserInterface $user, LikesRepository $likeRepo) : Response {
    $user = $this->getDoctrine()->getRepository(User::class)->find($user->getId());

    $player->setNbrlike($player->getLikes()->count());
    $manager->persist($player);
    $manager->flush();

    return $this->json([
        'code' => 200, 
        'message' => 'Like bien chargé',
        'likes' => count($likeRepo->findLikeWithIdPlayer($player->getId()))
    ], 200);

}



/**
     * @Route("/groupe/new", name="groupe_create")
     */
    public function createGroupe( UserInterface $user, ObjectManager $manager){
        $group = new Groups();
        $group->setName("test");
        $manager->persist($group);
        
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->findByIdWithObjAndGroups($user->getId());
        $user->addGroup($group);
        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('home');
    }
    
}

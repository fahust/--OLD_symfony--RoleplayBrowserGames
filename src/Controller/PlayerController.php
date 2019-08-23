<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Skill;
use App\Entity\Player;
use App\Entity\QuestVariable;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->findByIdWithObjAndGroups($user->getId());
        $repo = $this->getDoctrine()->getRepository(Player::class);
        $players = $repo->findAllWithSkill();

        return $this->render('player/index.html.twig', [
            'user' => $user,
            'controller_name' => 'PlayerController',
            'players' => $players
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
     * @Route("/player/new/{id}", name="player_create")
     * @Route("/player/edit/{id}", name="player_edit")
     */
    public function create($id, Request $request, ObjectManager $manager, UserInterface $user) {
        if($id == 0){$player = new Player();}else{
        $repo = $this->getDoctrine()->getRepository(Player::class);
        $player = $repo->find($id);}

        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->findByIdWithObjAndGroups($userId2);
        $repo = $this->getDoctrine()->getRepository(Skill::class);
        $skill = $repo->findAll();

        $form = $this->createFormBuilder($player)
        ->add('name')
        ->add('skillbdd', EntityType::class, [
            'class' => Skill::class,
            //'choices' => $skill,
            'multiple' => true,
            'choice_label' => 'name',
        ])
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
   


    

    
}

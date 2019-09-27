<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Likes;
use App\Entity\Monster;
use App\Form\MonsterType;
use App\Entity\MonsterSearch;
use App\Form\MonsterSearchTypeLeft;
use App\Form\MonsterSearchTypeRight;
use App\Repository\LikesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MonsterController extends AbstractController
{
    

    /**
     * @Route("/monster", name="monster")
     */
    public function indexMonster(UserInterface $user, PaginatorInterface $paginator, Request $request)
    {
        
        $search = new MonsterSearch();
        $formLeft = $this->createForm(MonsterSearchTypeLeft::class, $search);
        $formLeft->handleRequest($request);
        $user = $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId());
        $maxByPage = ($search->getChoiceNbrPerPage()) ? $search->getChoiceNbrPerPage() : 6;

        return $this->render('monster/index.html.twig', [
            'user' => $user,
            'controller_name' => 'PlayerController',
            'monsters' => $paginator->paginate($this->getDoctrine()->getRepository(Monster::class)->findAllWithSkill($search,$user),
            $request->query->getInt('page',1),$maxByPage),
            'formLeft' => $formLeft->createView(),
        ]);
    }

    /**
     * @Route("/unlogin/monster", name="monsterunlogin")
     */
    public function monsterunlogin( PaginatorInterface $paginator, Request $request)
    {
        $search = new MonsterSearch();
        $formLeft = $this->createForm(MonsterSearchTypeLeft::class, $search);
        $formLeft->handleRequest($request);
        $maxByPage = ($search->getChoiceNbrPerPage()) ? $search->getChoiceNbrPerPage() : 6;

        return $this->render('monster/index.html.twig', [
            'user' => null,
            'controller_name' => 'PlayerController',
            'monsters' => $paginator->paginate($this->getDoctrine()->getRepository(Monster::class)->findAllWithSkill($search,null),
            $request->query->getInt('page',1),$maxByPage),
            'formLeft' => $formLeft->createView(),
        ]);
    }


    /**
     * @Route("/monster/new/{id}", name="monster_create")
     * @Route("/monster/edit/{id}", name="monster_edit")
     * @param int $id id du monstre a éditer
     */
    public function createMonster($id , Request $request, ObjectManager $manager, UserInterface $user) {
        $user = $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId());

        if($id == 0){$monster = new Monster();
            $monster->setCreatedAt(new \DateTime());}else{
            $monster = $this->getDoctrine()->getRepository(Monster::class)->find($id);}
            $monster->setImageFile(null);//supprimé l'image

        $form = $this->createForm(MonsterType::class, $monster);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if ($user->getConstructpnt() > 0  || $id != 0) {
                if ($id == 0){$user->setConstructpnt(($user->getConstructpnt()-1));}
                $manager->persist($user);
                $monster->setImage(1);
                $monster->setMaxhp($monster->getHp());
                $monster->setMaxatk($monster->getAtk());
                $monster->setMaxdef($monster->getDef());
                $monster->setMaxesq($monster->getEsq());
                $monster->setMaxdgt($monster->getDgt());
                $monster->setCreateur($user->getId());
                $monster->setUpdatedAt(new \DateTime());
                $manager->persist($monster);
                $this->addFlash('succes', "Successfully edited/created monster" );
                $manager->flush();
                return $this->redirectToRoute('monster');
            }else{
                $this->addFlash('warning', "You no longer have map building points, do quests !");
            }
        }

        return $this->render('monster/create.html.twig', [
            'formMonster' => $form->createView()
        ]);
    }



    /**
     * @Route("/monster/delete/{id}", name="monster.delete", methods="DELETE")
     * @param Monster $monster
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteMonster(Monster $monster, Request $request, ObjectManager $manager, UserInterface $user){
        if ($this->isCsrfTokenValid('delete' . $monster->getId(), $request->get('_token'))) {
            $user = $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId());
            $user->setConstructpnt(($user->getConstructpnt())+1);
            $manager->persist($user);
            $manager->remove($monster);
            $manager->flush();
            $this->addFlash('succes', 'Monster successfully deleted');
            return $this->redirectToRoute('monster');
        } 
    }


/**
 * Permet de liker ou unliker un article
 * @Route("/monster/post/{id}/like", name="post_like_monster")
 *
 * @param Monster $monster
 * @param ObjectManager $manager
 * @param LikesRepository $likeRepo
 */
public function like(Monster $monster, ObjectManager $manager, LikesRepository $likeRepo ,UserInterface $user) : Response {
    $userrepo = $this->getDoctrine()->getRepository(User::class);
    $user = $userrepo->find($user->getId());

    if(!$user) return $this->json([
        'code' => 403,
        'message' => "Unauthorized"
    ],403);

    if($save = $monster->isLikedByUser($user)) {
        $manager->remove($save);
        $manager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'like bien supprimé',
            'likes' => count($likeRepo->findLikeWithIdMonster($monster->getId()))
        ],200);
    }

    $like = new Likes();
    $like->addMonster($monster)
        ->setByuser($user);
    $manager->persist($like);
    $manager->flush();
    return $this->json([
        'code' => 200, 
        'message' => 'Like bien ajouté',
        'likes' => count($likeRepo->findLikeWithIdMonster($monster->getId()))
    ], 200);

}


/**
 * Permet de recharger les nouveau like
 * @Route("/monster/post/{id}/likereload", name="post_likereload_monster")
 * @param Monster $monster
 * @param ObjectManager $manager
 * @param LikesRepository $likeRepo
 */
public function likereload(Monster $monster, ObjectManager $manager,UserInterface $user, LikesRepository $likeRepo) : Response {
    $user = $this->getDoctrine()->getRepository(User::class)->find($user->getId());

    $monster->setNbrlike($monster->getLikes()->count());
    $manager->persist($monster);
    $manager->flush();

    return $this->json([
        'code' => 200, 
        'message' => 'Like bien chargé',
        'likes' => count($likeRepo->findLikeWithIdMonster($monster->getId()))
    ], 200);

}

    
}

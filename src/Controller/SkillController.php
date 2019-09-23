<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Likes;
use App\Entity\Skill;
use App\Form\SkillType;
use App\Entity\SkillSearch;
use App\Form\SkillSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\LikesRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SkillController extends AbstractController
{

    /**
     * @Route("/skill", name="skill")
     */
    public function indexSkill(UserInterface $user, PaginatorInterface $paginator, Request $request)
    {
        $search = new SkillSearch();
        $form = $this->createForm(SkillSearchType::class, $search);
        $form->handleRequest($request);

        return $this->render('skill/index.html.twig', [
            'user' => $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId()),
            'controller_name' => 'PlayerController',
            'skill' =>  $paginator->paginate($this->getDoctrine()->getRepository(Skill::class)->findAllWithSearch($search),
            $request->query->getInt('page',1),3),
        ]);
    }

    /**
     * @Route("/skill/add/{id}", name="skill_ajout")
     */
    public function ajoutSkill($id) 
    {
        return $this->render('skill/ajout.html.twig', [
            'skill' => $this->getDoctrine()->getRepository(Skill::class)->findAll(),
            'player' => $this->getDoctrine()->getRepository(Player::class)->find($id)
        ]);
    }

    /**
     * @Route("/skill/new/{id}", name="skill_create")
     * @Route("/skill/edit/{id}", name="skill_edit")
     */
    public function createSkill($id , Request $request, ObjectManager $manager, UserInterface $user) {
        if($id == 0){$skill = new Skill();
            $skill->setCreatedAt(new \DateTime());}else{$skill = $this->getDoctrine()->getRepository(Skill::class)->find($id);}
        $skill->setImageFile(null);//supprimé l'image
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $skill->setUpdatedAt(new \DateTime());
            $skill->setCreateur($this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId())->getId());
            $skill->setImage(1);
            $manager->persist($skill);
            $this->addFlash('succes', "Compétence édité/créé avec succes" );
            $manager->flush();
            return $this->redirectToRoute('skill');
        }

        return $this->render('skill/create.html.twig', [
            'formSkill' => $form->createView()
        ]);
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
     * Permet de liker ou unliker un article
     * @Route("/skill/post/{id}/like", name="post_like_skill")
     * @param Skill $skill
     * @param ObjectManager $manager
     * @param LikesRepository $likeRepo
     */
    public function like(Skill $skill, ObjectManager $manager, LikesRepository $likeRepo ,UserInterface $user) : Response {
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->find($user->getId());
    
        if(!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ],403);
    
        if($save = $skill->isLikedByUser($user)) {
            $manager->remove($save);
            $manager->flush();
            return $this->json([
                'code' => 200,
                'message' => 'like bien supprimé',
                'likes' => count($likeRepo->findLikeWithIdSkill($skill->getId()))
            ],200);
        }
    
        $like = new Likes();
        $like->addSkill($skill)
            ->setByuser($user);
        $manager->persist($like);
        $manager->flush();
        return $this->json([
            'code' => 200, 
            'message' => 'Like bien ajouté',
            'likes' => count($likeRepo->findLikeWithIdSkill($skill->getId()))
        ], 200);
    }
    
    
    /**
     * Permet de recharger les nouveau like
     * @Route("/skill/post/{id}/likereload", name="post_likereload_skill")
     * @param Skill $skill
     * @param ObjectManager $manager
     * @param LikesRepository $likeRepo
     */
    public function likereload(Skill $skill, ObjectManager $manager,UserInterface $user, LikesRepository $likeRepo) : Response {
        $user = $this->getDoctrine()->getRepository(User::class)->find($user->getId());
    
        $skill->setNbrlike($skill->getLikes()->count());
        $manager->persist($skill);
        $manager->flush();
    
        return $this->json([
            'code' => 200, 
            'message' => 'Like bien chargé',
            'likes' => count($likeRepo->findLikeWithIdSkill($skill->getId()))
        ], 200);
    
    }

    

    
}

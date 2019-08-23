<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Skill;
use App\Form\SkillType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SkillController extends AbstractController
{




    /**
     * @Route("/skill", name="skill")
     */
    public function indexSkill(UserInterface $user)
    {
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->findByIdWithObjAndGroups($user->getId());
        $repo = $this->getDoctrine()->getRepository(Skill::class);
        $skill = $repo->findAll();

        return $this->render('skill/index.html.twig', [
            'user' => $user,
            'controller_name' => 'PlayerController',
            'skill' => $skill
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
        $user = $userrepo->findByIdWithObjAndGroups($userId2);
        if($id == 0){$skill = new Skill();}else{
        $repo = $this->getDoctrine()->getRepository(Skill::class);
        $skill = $repo->find($id);}
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $skill->setCreateur($user->getId());
            $manager->persist($skill);
            $this->addFlash('succes', "Compétence édité/créé avec succes" );
            $manager->flush();
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

    

    
}

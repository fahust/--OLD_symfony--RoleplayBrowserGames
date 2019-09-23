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

class MessageController extends AbstractController
{

    /**
     * @Route("/message", name="message")
     */
    public function indexSkill(UserInterface $user)
    {
        return $this->render('skill/index.html.twig', [
            'user' => $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId()),
            'controller_name' => 'PlayerController',
            'skill' => $this->getDoctrine()->getRepository(Skill::class)->findAll()
        ]);
    }

    /**
     * @Route("/message/ajout/{id}", name="message_ajout")
     */
    public function ajoutSkill($id) 
    {
        return $this->render('skill/ajout.html.twig', [
            'skill' => $this->getDoctrine()->getRepository(Skill::class)->findAll(),
            'player' => $this->getDoctrine()->getRepository(Player::class)->find($id)
        ]);
    }

    /**
     * @Route("/message/new/{id}", name="message_create")
     * @Route("/message/edit/{id}", name="message_edit")
     */
    public function createSkill($id , Request $request, ObjectManager $manager, UserInterface $user) {
        if($id == 0){$skill = new Skill();}else{
        $skill = $this->getDoctrine()->getRepository(Skill::class)->find($id);}
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $skill->setCreateur($this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId())->getId());
            $manager->persist($skill);
            $this->addFlash('succes', "Compétence édité/créé avec succes" );
            $manager->flush();
        }

        return $this->render('skill/create.html.twig', [
            'formSkill' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/message/delete/{id}", name="message.delete", methods="DELETE")
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



    //message in group
    //create group

    

    
}

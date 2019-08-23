<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Objet;
use App\Form\ObjetType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ObjetController extends AbstractController
{

    /**
     * @Route("/objet", name="objet")
     */
    public function indexObjet(UserInterface $user)
    {
        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->findByIdWithObjAndGroups($userId2);
        $repo = $this->getDoctrine()->getRepository(Objet::class);
        $objet = $repo->findAll();

        return $this->render('objet/index.html.twig', [
            'user' => $user,
            'controller_name' => 'PlayerController',
            'objet' => $objet
        ]);
    }

    /**
     * @Route("/objet/new/{id}", name="objet_create")
     * @Route("/objet/edit/{id}", name="objet_edit")
     */
    public function createObjet($id , Request $request, ObjectManager $manager, UserInterface $user) {
        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->findByIdWithObjAndGroups($userId2);
        if($id == 0){$objet = new Objet();}else{
        $repo = $this->getDoctrine()->getRepository(Objet::class);
        $objet = $repo->find($id);}
        $form = $this->createForm(ObjetType::class, $objet);//createFormBuilder($objet)

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $objet->setCreateur($user->getId());
            $manager->persist($objet);
            $this->addFlash('succes', "Objet édité/créé avec succes" );
            $manager->flush();
        }

        return $this->render('objet/create.html.twig', [
            'formObjet' => $form->createView()
        ]);
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

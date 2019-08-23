<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Groups;
use App\Entity\Monster;
use App\Form\MonsterType;
use App\Entity\MonsterSearch;
use App\Form\MonsterSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MonsterController extends AbstractController
{
    

    /**
     * @Route("/monster", name="monster")
     */
    public function indexMonster(UserInterface $user, PaginatorInterface $paginator, Request $request)
    {
        
        $search = new MonsterSearch();
        $form = $this->createForm(MonsterSearchType::class, $search);
        $form->handleRequest($request);

        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->findByIdWithObjAndGroups($user->getId());
        $repo = $this->getDoctrine()->getRepository(Monster::class);
        $monsters = $paginator->paginate($repo->findAllWithSkill($search),
        $request->query->getInt('page',1),3
    );

        return $this->render('monster/index.html.twig', [
            'user' => $user,
            'controller_name' => 'PlayerController',
            'monsters' => $monsters,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/monster/new/{id}", name="monster_create")
     * @Route("monster/edit/{id}", name="monster_edit")
     */
    public function createMonster($id , Request $request, ObjectManager $manager, UserInterface $user) {
        $userId2 = $user->getId(); 
        $userrepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userrepo->findByIdWithObjAndGroups($userId2);

        if($id == 0){$monster = new Monster();}else{
            $repo = $this->getDoctrine()->getRepository(Monster::class);
            $monster = $repo->find($id);}
            $monster->setImageFile(null);//supprimé l'image

        $form = $this->createForm(MonsterType::class, $monster);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $monster->setCreateur($user->getId());
            $monster->setUpdatedAt(new \DateTime());
            $manager->persist($monster);
            $this->addFlash('succes', "Monstre édité/créé avec succes" );
            $manager->flush();
        }

        return $this->render('monster/create.html.twig', [
            'formMonster' => $form->createView()
        ]);
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

    
}

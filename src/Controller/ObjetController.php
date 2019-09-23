<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Likes;
use App\Entity\Objet;
use App\Form\ObjetType;
use App\Entity\ObjetSearch;
use App\Form\ObjetSearchType;
use App\Repository\LikesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ObjetController extends AbstractController
{

    /**
     * @Route("/object", name="objet")
     */
    public function indexObjet(UserInterface $user, PaginatorInterface $paginator, Request $request)
    {
        $search = new ObjetSearch();
        $form = $this->createForm(ObjetSearchType::class, $search);
        $form->handleRequest($request);

        return $this->render('objet/index.html.twig', [
            'user' => $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId()),
            'controller_name' => 'PlayerController',
            'objet' => $paginator->paginate($this->getDoctrine()->getRepository(Objet::class)->findAllWithSkill($search),
            $request->query->getInt('page',1),3),//$this->getDoctrine()->getRepository(Objet::class)->findAll()
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/object/new/{id}", name="objet_create")
     * @Route("/object/edit/{id}", name="objet_edit")
     */
    public function createObjet($id , Request $request, ObjectManager $manager, UserInterface $user) {
        $user = $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId());
        if($id == 0){$objet = new Objet();
            $objet->setCreatedAt(new \DateTime());}else{
        $objet = $this->getDoctrine()->getRepository(Objet::class)->find($id);}
        $form = $this->createForm(ObjetType::class, $objet);//createFormBuilder($objet)
        $objet->setImageFile(null);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $objet->setCreateur($user->getId());
            $objet->setImage(1);
            $objet->setUpdatedAt(new \DateTime());
            $manager->persist($objet);
            $this->addFlash('succes', "Objet édité/créé avec succes" );
            $manager->flush();
            return $this->redirectToRoute('objet');
        }

        return $this->render('objet/create.html.twig', [
            'formObjet' => $form->createView()
        ]);
    }


    /**
     * @Route("/object/delete/{id}", name="objet.delete", methods="DELETE")
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

/**
 * Permet de liker ou unliker un article
 * @Route("/object/post/{id}/like", name="post_like_objet")
 *
 * @param Objet $objet
 * @param ObjectManager $manager
 * @param LikesRepository $likeRepo
 */
public function like(Objet $objet, ObjectManager $manager, LikesRepository $likeRepo ,UserInterface $user) : Response {
    $userrepo = $this->getDoctrine()->getRepository(User::class);
    $user = $userrepo->find($user->getId());

    if(!$user) return $this->json([
        'code' => 403,
        'message' => "Unauthorized"
    ],403);

    if($save = $objet->isLikedByUser($user)) {
        $manager->remove($save);
        $manager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'like bien supprimé',
            'likes' => count($likeRepo->findLikeWithIdObjet($objet->getId()))
        ],200);
    }

    $like = new Likes();
    $like->addObjet($objet)
        ->setByuser($user);
    $manager->persist($like);
    $manager->flush();
    return $this->json([
        'code' => 200, 
        'message' => 'Like bien ajouté',
        'likes' => count($likeRepo->findLikeWithIdObjet($objet->getId()))
    ], 200);
}


/**
 * Permet de recharger les nouveau like
 * @Route("/object/post/{id}/likereload", name="post_likereload_objet")
 * @param Objet $objet
 * @param ObjectManager $manager
 * @param LikesRepository $likeRepo
 */
public function likereload(Objet $objet, ObjectManager $manager,UserInterface $user, LikesRepository $likeRepo) : Response {
    $user = $this->getDoctrine()->getRepository(User::class)->find($user->getId());

    $objet->setNbrlike($objet->getLikes()->count());
    $manager->persist($objet);
    $manager->flush();

    return $this->json([
        'code' => 200, 
        'message' => 'Like bien chargé',
        'likes' => count($likeRepo->findLikeWithIdObjet($objet->getId()))
    ], 200);

}
}

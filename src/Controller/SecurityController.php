<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Objet;
use App\Entity\Groups;
use App\Entity\Player;
use App\Entity\Monster;
use App\Entity\ObjetSearch;
use App\Entity\QuestSearch;
use App\Entity\PlayerSearch;
use App\Entity\MonsterSearch;
use App\Entity\QuestVariable;
use App\Form\RegistrationType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @route("/registration", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
        $user = new User();
        $groups = $this->getDoctrine()->getRepository(Groups::class)->find(1);
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setTour(0);
            $user->setAction(0);
            $user->setConstructpnt(3);
            $user->addGroup($groups);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('security_login');
        }

        return $this->render('user/registration.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @route("/account", name="account")
     */
    public function account(UserInterface $user, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
        $userEntity = $this->getDoctrine()->getRepository(User::class)->find($user->getId());
        $form = $this->createForm(RegistrationType::class, $userEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($userEntity, $userEntity->getPassword());
            $userEntity->setPassword($hash);
            $userEntity->setTour(0);
            $userEntity->setAction(0);
            $userEntity->setLocale('en');
            //$user->addGroup($groups);
            $manager->persist($userEntity);
            $manager->flush();
            return $this->redirectToRoute('security_login');
        }

        return $this->render('user/account.html.twig',[
            'form' => $form->createView(),
            'user' => $this->getDoctrine()->getRepository(User::class)->findByIdWithObjAndGroups($user->getId())
        ]);
    }

    /**
     * @Route("/fr_FR/index", name="french")
     */
    public function french()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/index", name="english")
     */
    public function english()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response{
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error){
        $this->addFlash('warning', 'Login/password error');
        }
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout() {}

    /**
     * @Route("/search", name="search_all")
     * chercher dans tout le site et récupérer monster/quest/player
     */
    public function search(UserInterface $user, PaginatorInterface $paginator, Request $request){
        //faire de nvo form searchtype2 avec uniquement name
        $monsterSearch = new MonsterSearch();
        $playerSearch = new PlayerSearch();
        $questSearch = new QuestSearch();
        $objetSearch = new ObjetSearch();
        return $this->render('user/registration.html.twig',[
            'monster' =>  $paginator->paginate($this->getDoctrine()->getRepository(Monster::class)->findAllWithSkill($monsterSearch),
            $request->query->getInt('page',1),6),
            'player' =>  $paginator->paginate($this->getDoctrine()->getRepository(Player::class)->findAllWithSkill($playerSearch),
            $request->query->getInt('page',1),6),
            'quest' =>  $paginator->paginate($this->getDoctrine()->getRepository(QuestVariable::class)->findAllWithSkill($questSearch),
            $request->query->getInt('page',1),6),
            'objet' =>  $paginator->paginate($this->getDoctrine()->getRepository(Objet::class)->findAllWithSkill($objetSearch),
            $request->query->getInt('page',1),6),
        ]);

    }

    /**
     * @Route("/delete_account", name="delete_account")
     */
    public function deleteAccount(UserInterface $user, ObjectManager $manager){
        $userToDelete = $this->getDoctrine()->getRepository(User::class)->find($user->getId());
        $manager->remove($userToDelete);
        $manager->flush();
        $this->addFlash('succes', 'Deleted account');
        return $this->render('user/login.html.twig');
    }

}

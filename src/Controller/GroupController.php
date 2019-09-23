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
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GroupController extends AbstractController
{
    
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

    /**
     * @Route("/sendmail", name="groupe_create")
     */
    public function sendMail(\Swift_Mailer $mailer, UserInterface $user, ObjectManager $manager){
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('kevin.dellova@hotmail.fr')
            ->setBody('test',
                /*$this->renderView(
                    // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    ['name' => $name]
                ),*/
                'text/html'
            )
    
            // you can remove the following code if you don't define a text version for your emails
            ->addPart('test2',
                /*$this->renderView(
                    // templates/emails/registration.txt.twig
                    'emails/registration.txt.twig',
                    ['name' => $name]
                ),*/
                'text/plain'
            )
        ;
    
        $mailer->send($message);
    
        return $this->redirectToRoute('home');
            }
    
}

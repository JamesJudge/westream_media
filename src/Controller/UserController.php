<?php
/**
 * Created by PhpStorm.
 * User: devel
 * Date: 3/17/2019
 * Time: 11:55 AM
 */
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Session\Session;


class UserController extends AbstractController
{
    /**
     * @Route("/signup")
     */
    public function new(Request $request)
    {
        $user = new User();

        $form = $this->createFormBuilder(null, ['csrf_protection' => false])
            ->add('email', TextType::class, ['label' => 'Email Address'])
            ->add('passwordHash', PasswordType::class, ['label' => 'Password'])
            ->add('nickname', TextType::class, ['label' => 'Display Name'])
            ->add('firstName', TextType::class, ['label' => 'First Name'])
            ->add('lastName', TextType::class, ['label' => 'Last Name'])
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userData = $form->getData();
            $repository = $this->getDoctrine()->getRepository(User::class);
            $emailCheck = $repository->findOneBy(['email'=>$userData['email']]);
            $nicknameCheck = $repository->findOneBy(['nickname'=>$userData['nickname']]);
            $process = true;


            if (!empty($emailCheck)) {
                $form->addError(new \Symfony\Component\Form\FormError("Email address already exists"));
                $process = false;
            }

            if (!empty($nicknameCheck)) {
                $form->addError(new \Symfony\Component\Form\FormError("Nickname already exists"));
                $process = false;
            }


            if ($process) {
                $entityManager = $this->getDoctrine()->getManager();

                $user->setEmail($userData['email']);
                $user->setPasswordHash($userData['passwordHash']);
                $user->setNickname($userData['nickname']);
                $user->setFirstName($userData['firstName']);
                $user->setLastName($userData['lastName']);

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirect('/signup/thank-you');
            }



        }


        return $this->render('signup/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/signup/thank-you")
     */
    public function thanks()
    {
        return $this->render('signup/thanks.html.twig', [
            'streamID' => '422686729988513539127548'
        ]);
    }



    /**
     * @Route("/login")
     */
    public function login(Request $request)
    {
        $form = $this->createFormBuilder(null, ['csrf_protection' => false])
            ->add('email', TextType::class, ['label' => 'Email Address'])
            ->add('passwordHash', PasswordType::class, ['label' => 'Password'])
            ->getForm();


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $userData = $form->getData();
            $repository = $this->getDoctrine()->getRepository(User::class);
            $user = $repository->findOneBy(['email'=>$userData['email'], 'passwordHash'=>$userData['passwordHash']]);
            if(!empty($user)){
                $this->get('session')->set('user', $user);
                return $this->redirect('/profile/'.$user->getNickname());
            }else{
                $form->addError(new \Symfony\Component\Form\FormError("Log-in Failed. Please try again."));
            }
        }





        return $this->render('login/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/profile/{nickname}")
     */
    public function viewProfile($nickname)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(['nickname'=>$nickname]);

        //$currentUser = $this->getSession()->get('user');
        //$nickname = empty($currentUser)?null:$currentUser->getNickname();

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'nickname' =>$nickname,
        ]);
    }


    /**
     * @Route("/profiles/")
     */
    public function listProfiles()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }





}
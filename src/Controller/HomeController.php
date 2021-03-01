<?php
/**
 * Created by PhpStorm.
 * User: devel
 * Date: 3/17/2019
 * Time: 11:55 AM
 */
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    private function getCurrentUser(){
        $currentUser = $this->get('session')->get('user');
        return $currentUser;
    }




    /**
     * @Route("/")
     */
    public function view()
    {


        return $this->render('home/home.html.twig', [
            'section' => 'home',
            'currentUser' => $this->getCurrentUser(),
        ]);
    }
}
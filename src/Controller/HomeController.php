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
    /**
     * @Route("/")
     */
    public function view()
    {


        return $this->render('home/home.html.twig', [
            //nothing to pass to home page
        ]);
    }
}
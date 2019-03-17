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

class StreamController extends AbstractController
{
    /**
     * @Route("/stream/view")
     */
    public function view()
    {

        return $this->render('stream/view.html.twig', [
            'streamID'=>'422686729988513539127548'
        ]);
    }
}
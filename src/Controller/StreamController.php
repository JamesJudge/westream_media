<?php
/**
 * Created by PhpStorm.
 * User: devel
 * Date: 3/17/2019
 * Time: 11:55 AM
 */
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;



/**
 * Class StreamController
 * @package App\Controller
 */
class StreamController extends AbstractController
{

    /**
     * @Route("/stream/view/{nickname}")
     * @param $nickname
     * @return mixed
     */
    public function view($nickname)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $streamingUser = $repository->findOneBy(['nickname'=>$nickname]);

        if(!empty($streamingUser)){
            $user = $this->get('session')->get('user');
            if(!empty($user)){
                $nickname = $user->getNickname();
            }else{
                $nickname = 'Guest'.rnd(5);
            }

            return $this->render('stream/view.html.twig', [
                'streamID'=>$streamingUser->getStreamingKey(),
                'streamer'=>$streamingUser->getNickname(),
                'nickname'=>$nickname,

            ]);
        }else{
            return $this->render('stream/notFound.html.twig', [
                //nothing to pass
            ]);
        }


    }




    /**
     * @Route("/stream/setup/instructions")

     * @return mixed
     */
    public function setupInstructions()
    {





        return $this->render('stream/setupInstructions.html.twig', [
            // nothing being passewd
        ]);



    }







    }
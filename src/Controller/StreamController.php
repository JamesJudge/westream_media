<?php
/**
 * Created by PhpStorm.
 * User: devel
 * Date: 3/17/2019
 * Time: 11:55 AM
 */
namespace App\Controller;

use App\Entity\User;
use App\Entity\Shows;

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
    private function getCurrentUser(){
        $currentUser = $this->get('session')->get('user');
        return $currentUser;
    }

    /**
     * @Route("/list/streams")
     * @return mixed
     */
    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $streamingUsers = $repository->findAll();
        //$streamingServer = "";

        return $this->render('stream/list.html.twig', [
            'streamingUsers'=>$streamingUsers,
            'section' => 'live',
            'currentUser' => $this->getCurrentUser(),
        ]);
    }

    /**
     * @Route("/stream/view/{venueName}")
     * @param $venueName
     * @return mixed
     */
    public function view($venueName)
    {
        $this->get('session')->remove('viewStreamRedirectUrl');

        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(['nickname'=>$venueName]);

        $currentUser = $this->getCurrentUser();
        
        if(!empty($user)) {

            if(!empty($currentUser)){
                $nickname = $currentUser->getNickname();

                //  venues (shows)
                $userShows = [];
                $ticksetPurchased = 0;
                $showsEvent = false;
                $currentTimeStamp = time();
                $showsRepo = $this->getDoctrine()->getRepository(Shows::class);
                $showsData = $showsRepo->findBy(['user' => $user], ['start' => 'DESC']);

                if (count($showsData)) {
                    foreach ($showsData as $shows) {
                        $showsOrders = $shows->getOrders();
                        foreach ($showsOrders as $showsOrder) {
                            if ($showsOrder->getUser()->getId() == $currentUser->getId()) {
                                $ticksetPurchased++;

                                if ($shows->getStart()->getTimeStamp() <= $currentTimeStamp && $currentTimeStamp <= $shows->getEnd()->getTimeStamp()) {
                                    $showsEvent = true;
                                }
                            }
                        }
                    }
                } else {
                    //return $this->redirect('/profile/'.$venueName);
                }

                return $this->render('stream/view.html.twig', [
                    'streamID' => $user->getStreamingKey(),
                    'streamer' => $venueName,
                    'nickname' => $nickname,
                    'section' => 'live',
                    'showsEvent' => $showsEvent,
                    'ticksetPurchased' => $ticksetPurchased,
                    'currentUser' => $currentUser,
                ]);

            } else {

                $redirectUrl = '/stream/view/'.$venueName;
                $this->get('session')->set('viewStreamRedirectUrl', base64_encode($redirectUrl));
                return $this->redirect('/login');

            }

        } else {

            return $this->render('stream/notFound.html.twig', [
                'section' => 'live',
                'currentUser' => $currentUser,
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
            'currentUser' => $this->getCurrentUser(),
        ]);
    }

}

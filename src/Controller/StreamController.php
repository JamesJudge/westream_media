<?php
/**
 * Created by PhpStorm.
 * User: devel
 * Date: 3/17/2019
 * Time: 11:55 AM
 */
namespace App\Controller;

use App\Entity\User;
use App\Entity\Show;

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
                $showEvent = false;
                $currentTimeStamp = time();
                $showRepo = $this->getDoctrine()->getRepository(Show::class);
                $shows = $showRepo->findBy(['user' => $user], ['start' => 'DESC']);

                if (count($shows)) {
                    foreach ($shows as $show) {
                        $showOrders = $show->getOrders();
                        foreach ($showOrders as $showOrder) {
                            if ($showOrder->getUser()->getId() == $currentUser->getId()) {
                                $ticksetPurchased++;

                                if ($show->getStart()->getTimeStamp() <= $currentTimeStamp && $currentTimeStamp <= $show->getEnd()->getTimeStamp()) {
                                    $showEvent = true;
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
                    'showEvent' => $showEvent,
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

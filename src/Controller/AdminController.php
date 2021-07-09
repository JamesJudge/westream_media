<?php
/**
 * Created by PhpStorm.
 * User: devel
 * Date: 3/17/2019
 * Time: 11:55 AM
 */
namespace App\Controller;

use App\Entity\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin")
     * @return mixed
     */
    public function dashboard()
    {
        return $this->render('admin/dashboard.html.twig', [
            'section' => 'Dashboard',
            //'currentUser' => $this->getCurrentUser(),
        ]);
    }


    /**
     * @Route(path="/admin/user/list", methods={"GET"})
     * @Security("is_granted('ROLE_USER')")
     * @return mixed
     */
    public function userList(Request $request)
    {
        $user = $this->getUser();
        $session = $request->getSession();

        $repository = $this->getDoctrine()->getRepository(UserType::class);
        $userTypes = $repository->findAll();

        return $this->render('admin/userList.html.twig', [
            'section' => $session->get('userType') != 'venue' ? 'Users' : 'Viewers',
            'nickname' => $user->getNickname(),
            'userTypes' => $userTypes,
            'userType' => $session->get('userType')
            //'currentUser' => $this->getCurrentUser(),
        ]);
    }

    /**
     * @Route(path="/admin/shows/list", methods={"GET"})
     * @return mixed
     */
    public function showsList(Request $request)
    {
        $session = $request->getSession();

        return $this->render('admin/showsList.html.twig', [
            'section' => 'Shows',
            'userType' => $session->get('userType')
        ]);
    }

    /**
     * @Route(path="/admin/userType/list", methods={"GET"})
     * @return mixed
     */
    public function userTypeList(Request $request)
    {
        $session = $request->getSession();

        return $this->render('admin/userTypeList.html.twig', [
            'section' => 'User Type',
            'userType' => $session->get('userType')
        ]);
    }

}
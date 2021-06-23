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
     * * @Route(path="/admin/user/list", methods={"GET"})
     * @return mixed
     */
    public function userList()
    {
        return $this->render('admin/userList.html.twig', [
            'section' => 'User List',
            //'currentUser' => $this->getCurrentUser(),
        ]);
    }

    /**
     * * @Route(path="/admin/shows/list", methods={"GET"})
     * @return mixed
     */
    public function showsList()
    {
        return $this->render('admin/showsList.html.twig', [
            'section' => 'Show List'
        ]);
    }

}
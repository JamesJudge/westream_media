<?php


namespace App\Controller;

use ContainerIozxIel\getJmsSerializerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use JMS\Serializer\SerializerBuilder;

/**
 * Class ApiController
 * @package App\Controller
 */
class ApiController extends AbstractController
{
    /**
     * * @Route(path="/api/users", methods={"GET"})
     * @return mixed
     */
    public function userList()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $companies = $repository->findAll();
        $serializer = SerializerBuilder::create()->build();

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/json');
        $response->setContent($serializer->serialize($companies, 'json'));

        return $response;
    }

    /**
     * * @Route(path="/api/user/{id}", methods={"GET"})
     * @param $id
     * @return mixed
     */
    public function getUser($id)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(array('id'=>$id));
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/json');

        $serializer = SerializerBuilder::create()->build();
        $response->setContent($serializer->serialize($user, 'json'));

        return $response;
    }
}
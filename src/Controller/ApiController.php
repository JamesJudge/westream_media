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
        $serializer = JMS\SerializerBuilder::create()->build();

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/json');
        $response->setContent($serializer->serialize($companies, 'json'));

        return $response;
    }


}
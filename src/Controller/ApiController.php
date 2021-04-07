<?php


namespace App\Controller;

use ContainerIozxIel\getJmsSerializerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


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
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($companies, 'json');

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/json');
        $response->setContent($serializer->serialize($jsonContent, 'json'));

        return $response;
    }


}
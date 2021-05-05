<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
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


    /**
     * * @Route(path="/api/user/{id}", methods={"GET"})

     * @return mixed
     */
    public function userView($id)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findBy(['id'=>$id]);
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($user, 'json');

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/json');
        $response->setContent($serializer->serialize($jsonContent, 'json'));

        return $response;
    }


    /**
     * * @Route(path="/api/user/post", methods={"POST"})
     * @param $request
     * @return mixed
     */
    public function userPost(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $id = $request->get('id');
        if($id){
            $user = $repository->findBy(['id'=>$id]);
            $user->setNickname($request->get('nickname'));
            // TODO: finish update code
            $user->save();
        }else{
            // TODO: write add record code
        }



        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($user, 'json');

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/json');
        $response->setContent($serializer->serialize($jsonContent, 'json'));

        return $response;
    }


    /**
     * * @Route(path="/api/user/profile/pic/", methods={"POST"})
     * @param $request
     * @return mixed
     */
    public function userPic(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(User::class);
        $id = $request->get('id');
        if($id){
            $user = $repository->findBy(['id'=>$id]);



        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions
        $path = dirname(dirname(__FILE__)).'/assets/profile/'; // upload directory
        if(!empty($_POST['nickname']) && $_FILES['image'])
        {
            $nickname = $_POST['nickname'];
            $img = $_FILES['image']['name'];
            $tmp = $_FILES['image']['tmp_name'];
            // get uploaded file's extension
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            // can upload same image using rand function
            $final_image = rand(1000,1000000).$img;
            // check's valid format
            if(in_array($ext, $valid_extensions))
            {
                $final_image = strtolower($final_image);
                $path = $path.strtolower($final_image);



                if(move_uploaded_file($tmp,$path))
                {
                    echo "<h3>Image Uploaded Successfully.</h3> <p><a href='/profile/$nickname'>Click here to go back to profile page</a></p> <img src='/assets/profile/$final_image' />";

//include database configuration file
/*
 * This is deprecated. Used for cheating. Do not re-use.
 */
                    //include_once 'db.php';
//insert form data in the database



                    $insert = $conn->query("
                        update user 
                        set profile_image = '$final_image' 
                        where nickname='nickname';");

//echo $insert?'ok':'err';
                }else{
                    echo('<p style="color:red">Upload Error<br/>Path: '.$path.'<br/>Temp: '.$tmp.'</p>');
                }
            }
            else
            {
                echo 'invalid';
            }
        }else{
            echo("Form Error");
        }


        /*








        $repository = $this->getDoctrine()->getRepository(User::class);
        $id = $request->get('id');
        if($id){
            $user = $repository->findBy(['id'=>$id]);
            $user->setNickname($request->get('nickname'));
            // TODO: finish update code
            $user->save();
        }else{
            // TODO: write add record code
        }

*/

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($user, 'json');

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/json');
        $response->setContent($serializer->serialize($jsonContent, 'json'));

        return $response;
    }



}
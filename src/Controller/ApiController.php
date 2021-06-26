<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Shows;

use ContainerIozxIel\getJmsSerializerService;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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
    private function getCurrentUser()
    {
        $currentUser = $this->get('session')->get('user');
        return $currentUser;
    }

    public function getResponse($dataObject, $responseCode = '')
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object;
            },
        ];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];
        $serializer = new Serializer($normalizers, $encoders);

        $responseCode = ($responseCode == '') ? Response::HTTP_OK : $responseCode;
        $response = new Response();
        $response->setStatusCode($responseCode);
        $response->headers->set('Content-Type', 'text/json');

        $jsonContent = $serializer->serialize($dataObject, 'json');
        $response->setContent($jsonContent, 'json');

        return $response;
    }

    /**
     * * @Route(path="/api/user/isUserLoggedIn", methods={"GET"})
     * @return mixed
     */
    public function isUserLoggedIn(Request $request)
    {
        $currentUser = $this->getCurrentUser();            
        $jsonContent = array(
            'isUserLoggedIn' => ((!empty($currentUser)) ? true : false),
            'currentTimestamp' => time()
        );

        if ($request->get('fromPurchaseTicket') && empty($currentUser)) {
            $redirectUrl = '/profile/'.$request->get('venueName');
            $this->get('session')->set('purchaseTicketRedirectUrl', base64_encode($redirectUrl));
        }

        $response = $this->getResponse($jsonContent);
        return $response;
    }

    /**
     * * @Route(path="/api/order/post/{showsId}", methods={"POST"})
     * @param $request
     * @return mixed
     */
    public function orderPost($showsId, Request $request)
    {
        $currentUser = $this->getCurrentUser();

        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepo->find($currentUser->getId());

        $showsRepo = $this->getDoctrine()->getRepository(Shows::class);
        $shows = $showsRepo->find($showsId);

        $data = $request->request->all();

        $order = new Order();
        $order->setUser($user);
        $order->setShows($shows);
        $order->setAmount($data['amount']);
        $order->setPaymentDate(new \DateTime($data['update_time']));
        $order->setPaymentStatus($data['status']);
        $order->setConfirmationCode($data['orderId']);
        $order->setPaymentResponse(json_encode($data));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();

        $response = $this->getResponse($jsonContent, Response::HTTP_CREATED);
        return $response;
    }

    /**
     * * @Route(path="/api/shows", methods={"GET"})
     * @return mixed
     */
    public function showsList()
    {
        $repository = $this->getDoctrine()->getRepository(Shows::class);
        $shows = $repository->findAll();

        $response = $this->getResponse($shows);
        return $response;
    }

    /**
     * * @Route(path="/api/shows/{id}", methods={"GET"})
     * @return mixed
     */
    public function showsView($id)
    {
        $repository = $this->getDoctrine()->getRepository(Shows::class);
        $shows = $repository->findBy(['id' => $id]);

        $response = $this->getResponse($shows);
        return $response;
    }

    /**
     * * @Route(path="/api/shows", methods={"POST"})
     * @param $request
     * @return mixed
     */
    public function showsPost(Request $request)
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepo->findOneBy(['id' => $request->get('user')]);

        $shows = new Shows();
        $shows->setEventName($request->get('event_name'));
        $shows->setRecordedLink($request->get('recorded_link'));
        $shows->setStart(new \DateTime($request->get('start')));
        $shows->setEnd(new \DateTime($request->get('end')));
        $shows->setAmount($request->get('amount'));
        $shows->setUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($shows);
        $entityManager->flush();

        $response = $this->getResponse($shows, Response::HTTP_CREATED);
        return $response;
    }

    /**
     * * @Route(path="/api/shows/{id}", methods={"PUT"})
     * @param $request
     * @return mixed
     */
    public function showsPut(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Shows::class);
        $id = $request->get('id');

        $shows = $repository->findOneBy(['id'=>$id]);
        $shows->setEventName($request->get('event_name'));
        $shows->setRecordedLink($request->get('recorded_link'));
        $shows->setStart(new \DateTime($request->get('start')));
        $shows->setEnd(new \DateTime($request->get('end')));
        $shows->setAmount($request->get('amount'));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($shows);
        $entityManager->flush();

        $response = $this->getResponse($shows);
        return $response;
    }

    /**
     * * @Route(path="/api/users/{userType}", methods={"GET"})
     * @return mixed
     */
    public function userTypeList($userType)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findUserByType($userType);

        $response = $this->getResponse($users);
        return $response;
    }

    /**
     * * @Route(path="/api/users/update/pass", methods={"GET"})
     * @return mixed
     */
    public function updatePass()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        $entityManager = $this->getDoctrine()->getManager();
        foreach ($users as $user) {
            $user->setPasswordHash(password_hash($user->getPasswordHash(), PASSWORD_DEFAULT));

            $entityManager->persist($user);
            $entityManager->flush();
        }

        $response = $this->getResponse($users);
        return $response;
    }

    /**
     * * @Route(path="/api/users", methods={"GET"})
     * @return mixed
     */
    public function userList()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        $response = $this->getResponse($users);
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

        $response = $this->getResponse($user);
        return $response;
    }

    /**
     * @param $request
     * @return array
     */
    public function validateUser(Request $request, $id = '')
    {
        $errors = [];
        $userRepo = $this->getDoctrine()->getRepository(User::class);

        $emailUsers = $userRepo->findBy(['email' => $request->get('email')]);
        foreach($emailUsers as $emailUser) {
            if (!$id || ($id && $emailUser->getId() != $id)) {
                $errors['email'] = 'Email already exists';
            }
        }

        $nicknameUsers = $userRepo->findBy(['nickname' => $request->get('nickname')]);
        foreach($nicknameUsers as $nicknameUser) {
            if (!$id || ($id && $nicknameUser->getId() != $id)) {
                $errors['nickname'] = 'Nickname already exists';
            }
        }

        return $errors;
    }

    /**
     * @param $user
     * @return array
     */
    public function setUserData(User $user, Request $request)
    {
        $user->setEmail($request->get('email'));
        $user->setNickname($request->get('nickname'));
        $user->setFirstName($request->get('firstName'));
        $user->setLastName($request->get('lastName'));
        $user->setUserType($request->get('userType'));

        if ($request->get('profileImage')) {
            $user->setProfileImage($request->get('profileImage'));
        }

        if ($request->get('passwordHash')) {
            $user->setPasswordHash(password_hash($request->get('passwordHash'), PASSWORD_DEFAULT));
        }

        $user->setStreamingKey($request->get('streamingKey'));
        $user->setStreamingServer($request->get('streamingServer'));
        $user->setCategory($request->get('category'));
        $user->setBio($request->get('bio'));

        return $user;
    }

    /**
     * * @Route(path="/api/user", methods={"POST"})
     * @param $request
     * @return mixed
     */
    public function userPost(Request $request)
    {
        $errors = $this->validateUser($request);
        if (count($errors)) {
            $response = $this->getResponse($errors, Response::HTTP_CONFLICT);
            return $response;
        }

        $user = new User();
        $user = $this->setUserData($user, $request);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $response = $this->getResponse($user, Response::HTTP_CREATED);
        return $response;
    }

    /**
     * * @Route(path="/api/user/{id}", methods={"PUT"})
     * @param $request
     * @return mixed
     */
    public function userPut(Request $request)
    {
        $id = $request->get('id');

        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(['id' => $id]);

        $errors = $this->validateUser($request, $id);
        if (count($errors)) {
            $response = $this->getResponse($errors, Response::HTTP_CONFLICT);
            return $response;
        }

        $user = $this->setUserData($user, $request);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $response = $this->getResponse($user);
        return $response;
    }

    /**
     * * @Route(path="/api/user/profileImage", methods={"POST"})
     * @param $request
     * @return mixed
     */
    public function imageUploadAction(Request $request)
    {
        ini_set('upload_max_filesize', '1G');
        ini_set('post_max_size', '1G');

        $imageName = $request->headers->get('X-File-Name');
        $imageType = $request->headers->get('X-File-Type');

        if (empty($imageName) || empty($imageType)) {
            $data = array('error' => 'Missing Data');
            $response = $this->getResponse($data, Response::HTTP_PRECONDITION_FAILED);
            return $response;
        }

        $validTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/bmp',
        ];
        if (!in_array($imageType, $validTypes)) {
            $data = array('error' => 'Invalid image type');
            $response = $this->getResponse($data, Response::HTTP_BAD_REQUEST);
            return $response;
        }

        $profileImage = uniqid().'.'.pathinfo($imageName, PATHINFO_EXTENSION);
        $profileImagePath = $this->getParameter('user_profile_path');

        $file = file_put_contents($profileImagePath.'/'.$profileImage, file_get_contents('php://input'));
        if (false === $file) {
            $data = array('error' => 'Error Processing Request');
            $response = $this->getResponse($data, Response::HTTP_BAD_REQUEST);
            return $response;
        }

        $data = array('profileImage' => $profileImage);
        $response = $this->getResponse($data);
        return $response;
    }

    /**
     * * @Route(path="/profile/{nickname}/photo", methods={"POST"})
     * @param $request
     * @param $nickname
     * @return mixed
     */
    public function userPic(Request $request, $nickname)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $nickname = $request->get('nickname');
        $currentUser = $this->getCurrentUser();
        if($nickname){
            $user = $repository->findBy(['nickname'=>$nickname]);
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions
            $path = dirname(dirname(__FILE__)).'/assets/profile/'; // upload directory
            if(!empty($request->get('nickname')) && $user->getNickname && $_FILES['image'])
            {
                throw new \Exception("Ready to upload");
            }
            else
            {
                throw new \Exception("Failed upload test");
            }
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

        $response = $this->getResponse($user, false);
        return $response;
    }

}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        $response = new Response();
        if($user) {
            $response->setContent(json_encode([
                'username' => $user->getUsername(),
                'role' => $user->getRoles()
            ]));
        } else {
            $response->setContent(json_encode([
                'error' => 'error',
            ]));
        }
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With,content-type');



        return $response;
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        //GET POST REQUEST PARAMETERS
        $data = json_decode($request->getContent(), true);
        $username=$data['username'];
        $password=$data['password'];
        if($username && $password) {
            $user= new User();
            $user->setUsername($username);
            $password = $passwordEncoder->encodePassword($user, $password);
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        $response = new Response();
        if($user) {
            $response->setContent(json_encode([
                'username' => $user->getUsername(),
                'role' => $user->getRoles()
            ]));
        } else {
            $response->setContent(json_encode([
                'error' => 'error',
            ]));
        }
        //header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        //header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
        // Allow all websites


        return $response;
    }

    /**
     * @Route("/if-username-exists", name="checkIfUsernameExists")
     * @param Request $request
     * @return Response
     */
    public function checkIfUsernameExistsAction(Request $request) {
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With,content-type');

        $data = json_decode($request->getContent(), true);
        $username=$data['username'];
        $userRepo=$this->getDoctrine()->getRepository(User::class);
        if($userRepo->findOneBy(['username' => $username])) {
            $response->setContent(json_encode([
                'status' => true,
            ]));
            return $response;
        } else {
            $response->setContent(json_encode([
                'status' => false,
            ]));
            return $response;
        }
    }

    /**
     * @Route("/test", name="api")
     */
    public function apiAction()
    {
        $response = new Response();
        $date = new DateTime();

        $response->setContent(json_encode([
            'id' => uniqid(),
            'time' => $date->format("Y-m-d")
        ]));

        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        // Or a predefined website
        //$response->headers->set('Access-Control-Allow-Origin', 'https://jsfiddle.net/');
        // You can set the allowed methods too, if you want    //$response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');
        return $response;
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in app/config/security.yml
     *
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new Exception('This should never be reached!');
    }
}

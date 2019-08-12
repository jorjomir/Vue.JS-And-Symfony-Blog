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
        // import AuthenticationUtils $authenticationUtils
        // get the login error if there is one
        /*
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('default/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
        */
        //$user = $this->getUser();

        /*
        return $this->json([
            'username' => $user->getUsername(),
        ]);
        */
        //$data = json_decode($request->getContent(), true);
        //return new JsonResponse($data);
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
                'error' => 'greshka moi',
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
     * @Route("/register", name="register")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            return $this->redirectToRoute('login');
        }
        return $this->render(
            'default/register.html.twig',
            ['form' => $form->createView()]
        );
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

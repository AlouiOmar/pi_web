<?php

namespace EspritBundle\Controller;


/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use AppBundle\Entity\User;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Controller managing the registration.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RegistrationController extends BaseController
{
    private $eventDispatcher;
    private $formFactory;
    private $userManager;
    private $tokenStorage;

    public function __construct(EventDispatcherInterface $eventDispatcher, FactoryInterface $formFactory, UserManagerInterface $userManager, TokenStorageInterface $tokenStorage)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
        $this->userManager = $userManager;
        $this->tokenStorage = $tokenStorage;
    }



    public function loginmAction(Request $request)
    {
        $response = new Response();
        $request->setMethod('POST');
        $request->headers->set("Content-Type","text/plain");

        $username = $request->get('username', '');
        $password = $request->get('password', '');

        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');

        $user = $user_manager->findUserByUsernameOrEmail($username);

        if ($user == Null){
            $response->setContent('Failed');
            return $response;
        }

        $encoder = $factory->getEncoder($user);



        if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())){
            $response->headers->set("Content-Type","application/json");
            $response->setContent(json_encode(array(
                        "id" => $user->getId(),
                        "username" => $user->getUsername(),
                        "nom" => $user->getNom(),
                        "prenom" => $user->getPrenom(),
                        "email" => $user->getEmail(),
                        "photo" => $user->getPhot(),
                        "roles" => $user->getRoles(),
                        "telephone" =>(string) $user->getTelephone(),
                    )
                )
            );
        }else{
            $response->setContent('Failed');
        }

        return $response;
    }

    public function registermAction(Request $request)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');

        $user = $user_manager->findUserByUsernameOrEmail($request->get('username'));
        $user1 = $user_manager->findUserByUsernameOrEmail($request->get('email'));
//        dump($user);
//        dump($user1);
//        die();
        if (($user==null)&&($user1==null))
        {
            $user=new User();
            $user->setNom($request->get('nom'));
            $user->setPrenom($request->get('prenom'));
            $user->setPhoto($request->get('photo'));
            $user->setTelephone($request->get('telephone'));
            $user->setEmail($request->get('email'));
            $user->setEmailCanonical($request->get('email'));
            $user->setUsername($request->get('username'));
            $user->setUsernameCanonical($request->get('username'));
            $user->setRoles(array ($request->get('roles')));

            $encoderService = $this->container->get('security.password_encoder');

            $user->setPassword($encoderService->encodePassword($user,$request->get('password')));

            $user->setEnabled(true);

            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $user_manager = $this->get('fos_user.user_manager');
            $user = $user_manager->findUserByUsernameOrEmail($request->get('username'));


            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize(array(
                "id" => $user->getId(),
                "username" => $user->getUsername(),
                "nom" => $user->getNom(),
                "prenom" => $user->getPrenom(),
                "email" => $user->getEmail(),
                "photo" => $user->getPhot(),
                "roles" => $user->getRoles(),
                "telephone" =>(string) $user->getTelephone(),
            ));
        }
        else
        {
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted= $serializer->normalize('Failed');
        }


        return new JsonResponse($formatted);
    }

    public function userInfoAction(Request $request)
    {
        $response = new Response();
        $request->setMethod('POST');
        $request->headers->set("Content-Type","text/plain");
//
//        $username = $request->get('username', '');
//        $password = $request->get('password', '');

        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');
        $idu=$request->get('idu');
        $user=$this->getDoctrine()->getRepository(User::class)->find($idu);
//        $user = $user_manager->find($idu);

        if ($user == Null){
            $response->setContent('Failed');
            return $response;
        }

//        $encoder = $factory->getEncoder($user);



        else if ($user!=null) {
            $response->headers->set("Content-Type","application/json");
            $response->setContent(json_encode(array(
                        "id" => $user->getId(),
                        "username" => $user->getUsername(),
                        "nom" => $user->getNom(),
                        "prenom" => $user->getPrenom(),
                        "email" => $user->getEmail(),
                        "photo" => $user->getPhot(),
                        "roles" => $user->getRoles(),
                        "telephone" =>(string) $user->getTelephone(),
                    )
                )
            );
        }else{
            $response->setContent('Failed');
        }

        return $response;
    }

}

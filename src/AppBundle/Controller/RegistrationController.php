<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

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

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function registerUserAction(Request $request)
    {

        //$user=new User();
//        dump('custom controller');
        $user = $this->userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            dump($user);

            if ($form->isValid()) {

                $event = new FormEvent($form, $request);
                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
                $file=$form['photo']->getData();
                $newImageName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('user_image'),$newImageName);

                $user->setPhoto($newImageName);


                $this->userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('@FOSUser/Registration/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @param Request $request
     *
     * @return Response
     */
    public function addAction(Request $request)
    {

        //$user=new User();
//        dump('custom controller');
//        die();
        $user = $this->userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->formFactory->createForm();
        $form  ->add('roles', ChoiceType::class, array(
            'attr' => array(
                'class' => 'form-control',
                'required' => false,
            ),
            'multiple' => true,
            'expanded' => false, // render check-boxes
            'choices' => [
                'admin' => 'ROLE_ADMIN',
                'user' => 'ROLE_USER',
            ]
        ))->add('Valider',SubmitType::class,
            ['attr'=>['formnovalidate'=>'formnovalidate','class'=>'form-control btn btn-primary','id'=>'a']]);
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
                $file=$form['photo']->getData();
                $newImageName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('user_image'),$newImageName);
                $user->setPhoto($newImageName);

                $this->userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('@VeloAnnonce/admin/addUser.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Tell the user to check their email provider.
     */
    public function checkEmailAction(Request $request)
    {
        $email = $request->getSession()->get('fos_user_send_confirmation_email/email');

        if (empty($email)) {
            return new RedirectResponse($this->generateUrl('fos_user_registration_register'));
        }

        $request->getSession()->remove('fos_user_send_confirmation_email/email');
        $user = $this->userManager->findUserByEmail($email);

        if (null === $user) {
            return new RedirectResponse($this->container->get('router')->generate('fos_user_security_login'));
        }

        return $this->render('@FOSUser/Registration/check_email.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user.
     *
     * @param Request $request
     * @param string  $token
     *
     * @return Response
     */
    public function confirmAction(Request $request, $token)
    {
        $userManager = $this->userManager;

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_registration_confirmed');
            $response = new RedirectResponse($url);
        }

        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

    /**
     * Tell the user his account is now confirmed.
     */
    public function confirmedAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('@FOSUser/Registration/confirmed.html.twig', array(
            'user' => $user,
            'targetUrl' => $this->getTargetUrlFromSession($request->getSession()),
        ));
    }

    /**
     * @return string|null
     */
    private function getTargetUrlFromSession(SessionInterface $session)
    {
        $key = sprintf('_security.%s.target_path', $this->tokenStorage->getToken()->getProviderKey());

        if ($session->has($key)) {
            return $session->get($key);
        }

        return null;
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
                "email" => $user->getEmail(),
                //"telephone" => $user->getTelephone(),
                "roles" => $user->getRoles(),
            ));
        }
        else
        {
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted= $serializer->normalize('Failed');
        }


        return new JsonResponse($formatted);
    }
}

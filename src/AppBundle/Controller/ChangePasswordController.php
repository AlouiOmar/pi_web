<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Controller\ChangePasswordController  as BaseController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Controller managing the password change.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */

class ChangePasswordController extends BaseController
{

    private $eventDispatcher;
    private $formFactory;
    private $userManager;

    public function __construct(EventDispatcherInterface $eventDispatcher, FactoryInterface $formFactory, UserManagerInterface $userManager)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
        $this->userManager = $userManager;
    }

    /**
     * Change user password.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function changePasswordAction(Request $request)
    {
        dump($request->getUri());
        $uri = $request->getUri();
        $usr= $this->container->get('security.token_storage')->getToken()->getUser();


//        die();
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->formFactory->createForm();
        if ($usr->getRoles()[0]=='ROLE_ADMIN') {
            $form ->add('Valider',SubmitType::class,
                ['attr'=>['formnovalidate'=>'formnovalidate','class'=>'form-control btn btn-primary']]);
        }
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

            $this->userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl(  'fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $this->eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }
//        die();

        if ($usr->getRoles()[0]=='ROLE_ADMIN') {
            dump('admin route');
            return $this->render('@VeloAnnonce/admin/changePassword.html.twig', array(
                'form' => $form->createView(),
            ));
        }else{
            dump('nope');
            return $this->render('@FOSUser/ChangePassword/change_password.html.twig', array(
                'form' => $form->createView(),
            ));
        }

    }
}

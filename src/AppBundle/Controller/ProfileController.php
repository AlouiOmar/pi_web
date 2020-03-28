<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
use FOS\UserBundle\Controller\ProfileController as BaseController;

class ProfileController extends BaseController
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
     * Show the user.
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Edit the user.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Request $request)
    {


        $usr= $this->container->get('security.token_storage')->getToken()->getUser();
//        dump($usr->getId());
//        die();
        $user = $this->getUser();
        $photo=$user->getPhot();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form=$this->createForm(ProfileType::class,$user);
//        $form ->add('Valider',SubmitType::class,
//                ['attr'=>['formnovalidate'=>'formnovalidate','class'=>'form-control btn btn-primary']]);
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
            $file=$form['photo']->getData();
            if($file!=null){
                $newImageName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('user_image'),$newImageName);
                $user->setPhoto($newImageName);
            }else{
                $user->setPhoto($photo);
            }
            $this->userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }
        if ($usr->getRoles()[0]=='ROLE_ADMIN') {
            return $this->redirectToRoute('velo_admin_edit_user', ['id' => $usr->getId()]);
        }else{
            return $this->render('@FOSUser/Profile/edit.html.twig', array(
                'form' => $form->createView(),
            ));
        }

    }
}

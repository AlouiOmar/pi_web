<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Event;
use EventBundle\Entity\Participation;
use EventBundle\Entity\User;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use EventBundle\Form\SubmitType;
use Dwr\OpenWeatherBundle\DwrOpenWeatherBundle;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Event controller.
 *
 */
class EventController extends Controller
{
    /**
     * Lists all event entities.
     *
     */
    public function IndexDashAction()
    {
        return $this->render('EventBundle:admin:indexdashboard.html.twig');

    }

    /**
     * Creates a new event entity.
     *
     */
    public function CreateEventAction(Request $request)
    {
        $event = new Event();
        $event->setCreator($this->getUser());
        $form = $this->createForm('EventBundle\Form\EventType', $event);
        $form->handleRequest($request);
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();

                return $this->redirectToRoute('event_show');
            }

            return $this->render('@Event/Default/addeventuser.html.twig', array(
                'Form' => $form->createView(),
            ));
        } else {
            return $this->RedirectToRoute('fos_user_security_login');
        }
    }



    /**
     * Finds and displays a event entity.
     *
     */
    public function ShowEventAction()
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EventBundle:Event')->findAll();

        return $this->render('@Event/Default/showeventuser.html.twig', array(
            'event' => $event

        ));


    }

    public function ShowEventDashAction()
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EventBundle:Event')->findAll();

        return $this->render('@Event/admin/showeventadmin.html.twig', array(
            'event' => $event

        ));


    }

    /**
     * Displays a form to edit an existing event entity.
     *
     */
    public function EditEventAction(Request $request, Event $event)
    {
        $editForm = $this->createForm('EventBundle\Form\EventType', $event);
        $editForm->handleRequest($request);
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('event_show');
            }

            return $this->render('@Event/Default/editeventuser.html.twig', array(
                'event' => $event,
                'Form' => $editForm->createView(),

            ));
        } else {
            return $this->RedirectToRoute('fos_user_security_login');
        }
    }

    /**
     * Deletes a event entity.
     *
     */
    public function DeleteEventAction($id, Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)

            $em = $this->getDoctrine()->getManager();
            $event = $em->getRepository('EventBundle:Event')->find($id);

            $em->remove($event);
            $em->flush();

            return $this->redirectToRoute('event_show');
        } else {
            return $this->render('@FOSUser/Security/login.html.twig');
        }
    }
    public function VosEventAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository(Event::class)->findAll();
        return $this->render('@Event/Default/showvoseventsuser.html.twig',array(
            //  'event' => $event
            'event' => $p,
            'creator' => $p,

        ));

    }

    /**
     * Creates a form to delete a event entity.
     *
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function searchtitreAction(Request $request)
    {
        $titre= $request->get('titre');
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('EventBundle:Event')->cherchertitre($titre);




        return $this->render('@Event/Default/showeventuser.html.twig', array(
            'event' => $posts
        ));
    }

}

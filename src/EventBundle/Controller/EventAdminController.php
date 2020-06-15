<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventAdminController extends Controller
{
    public function IndexDashAction()
    {
        return $this->render('EventBundle:admin:indexdashboard.html.twig');

    }
    public function CreateEventAdminAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('EventBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('show_dash');
        }

        return $this->render('@Event/admin/addeventadmin.html.twig', array(
            'Form' => $form->createView(),
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
    public function EditEventAdminAction(Request $request, Event $event)
    {
        $editForm = $this->createForm('EventBundle\Form\EventType', $event);
        $editForm->handleRequest($request);
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('show_dash');
            }

            return $this->render('@Event/admin/editeventadmin.html.twig', array(
                'event' => $event,
                'Form' => $editForm->createView(),

            ));
        } else {
            return $this->RedirectToRoute('fos_user_security_login');
        }
    }
    public function ParticipationAdminAction(Event $events)
    {
        $user=$this->getUser();
        $events->addparticipation($user);
        $this->getUser()->addeventuser($events);
        $events->setNbplaces($events->getNbplaces()-1);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('show_dash');



    }

    public function AfficherParticipantAdminAction(Request $request,$id)    {
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository(Event::class)->find($id);

        return $this->render('@Event/admin/showeventparticipantsadmin.html.twig',array(
            //  'event' => $event
            'events' => $p,
            'participant' => $p,
            'id' => $p->getId(),
            'region'=>$p->getRegion(),
            'titre'=>$p->getTitre(),
            'description'=>$p->getDescription(),
            'c'=>$p->getNameC()
        ));
    }

    public function AnnulerParticipationAdminAction (Event $event)
    {

        $user=$this->getUser();
        $event->addparticipation($user);
        $this->getUser()->removeParticipation($event);
        $event->setNbplaces($event->getNbplaces()+1);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('show_dash');
    }

    public function SearchTitreAdminAction(Request $request)
    {
        $titre= $request->get('titre');
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('EventBundle:Event')->cherchertitre($titre);




        return $this->render('@Event/Default/showeventadmin.html.twig', array(
            'event' => $posts
        ));
    }
    public function VosEventAdminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository(Event::class)->findAll();
        return $this->render('@Event/admin/showvoseventadmin.html.twig',array(
            //  'event' => $event
            'event' => $p,
            'creator' => $p,

        ));

    }
}

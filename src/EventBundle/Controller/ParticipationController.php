<?php

namespace EventBundle\Controller;
use EventBundle\Entity\User;
use EventBundle\Entity\Event;
use EventBundle\Entity\Participation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use EventBundle\Repository\UserRepository;
use EventBundle\Form\ParticipationType;
/**
 * Participation controller.
 *
 * @Route("participation")
 */
class ParticipationController extends Controller
{
    /**
     * Lists all participation entities.
     *
     * @Route("/", name="participation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $participations = $em->getRepository('EventBundle:Participation')->findAll();

        return $this->render('participation/index.html.twig', array(
            'participations' => $participations,
        ));
    }




         public function participationAction(Event $events)
    {
        $user=$this->getUser();
        $events->addparticipation($user);
        $this->getUser()->addeventuser($events);
        $events->setNbplaces($events->getNbplaces()-1);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('event_show');



    }

    public function afficherparticipantAction(Request $request,$id)    {
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository(Event::class)->find($id);

        return $this->render('@Event/Default/showeventparticipantuser.html.twig',array(
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

    public function annulerparticipationAction (Event $event)
{

    $user=$this->getUser();
    $event->addparticipation($user);
    $this->getUser()->removeParticipation($event);
    $event->setNbplaces($event->getNbplaces()+1);
    $this->getDoctrine()->getManager()->flush();
    return $this->redirectToRoute('event_show');
}
}

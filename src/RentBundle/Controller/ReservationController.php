<?php

namespace RentBundle\Controller;

use RentBundle\Entity\Reservation;
use RentBundle\Entity\Location;
use RentBundle\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


/**
 * Reservation controller.
 *
 */
class ReservationController extends Controller
{
    /**
     * Lists all reservation entities.
     *
     */
    public function indexAction()
    {
        // $user =$this->getUser();
    //if($user){
        $em = $this->getDoctrine()->getManager();
        $reservations = $em->getRepository('RentBundle:Reservation')->findAll();
    /*}else{
        $this->redirectToRoute('fos_user_security_login');
      }*/
        return $this->render('reservation/index.html.twig', array(
            'reservations' => $reservations,
        ));
          var_dump($reservations); die();
    }
      
    /**
     * Creates a new reservation entity.
     *
     */
    public function newAction(Request $request)
    {
         //$user =$this->getUser();
        //if($user){
        $em=$this->getDoctrine()->getEntityManager();
        $reservation = new Reservation();
        /*}else{
          $this->redirectToRoute('fos_user_security_login');
        }*/
        $form=$this->createFormBuilder($reservation)
            ->add('titre',TextType::class,array('attr'=>array('class'=>'col-md-4 form-control')))
            ->add('dateDeb',DateTimeType::class,array('attr'=>array('class'=>'col-md-4 form-control')))
            ->add('dateFin',DateTimeType::class,array('attr'=>array('class'=>'col-md-4 form-control')))
            ->add('Valider',SubmitType::class,array('attr'=>array('class'=>'col-md-4 form-control')))
            ->getForm();
  
   $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() )
        {
          //  $titre = $reservation->getTitre();
            $em=$this->getDoctrine()->getEntityManager();
           // $array_location = $em->getRepository(Location::class) ->findByTitre($titre);
          //  if ($array_location!= null )
         //   {
               // $one_location_objet = $array_location[0];
              //  $reservation->setLocation($one_location_objet);
                //reservation->setLocation($form['location']->getData());
            $reservation->setDateDeb($form['dateDeb']->getData());
            $reservation->setDateFin($form['dateFin']->getData());

                $em->persist ($reservation);
                $em->flush();

                $this->addFlash('success','reservation ajoutée avec succée  !');

                return $this->redirect ($this->generateUrl('homepage' ));
        //    } else {
         //       return new Response ('erreur d affectation');
        //    }
        }

        return $this->render('RentBundle:reservation:new.html.twig', array (
            'form'=>$form->createView()
        )) ;

    }
   
    
    /**
     * Finds and displays a reservation entity.
     *
     */
    public function showAction($id)
    {
      $em = $this->getDoctrine()->getEntityManager();
      $reservation = $em->getRepository('RentBundle:Reservation')->find($id);
      $reservations = $em->getRepository('RentBundle:Reservation')->findAll();
      return $this->render('RentBundle:reservation:show.html.twig',array(
        'reservation' => $reservation,
      ));
    }

    /**
     * Displays a form to edit an existing reservation entity.
     *
     */
    public function editAction(Request $request,Reservation $reservation,$id)
    {
       $deleteForm = $this->createDeleteForm($reservation);
        $editForm = $this->createForm('RentBundle\Form\ReservationType', $reservation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('reservation_edit', array('id' => $reservation->getId()));
        }

        return $this->render('reservation/edit.html.twig', array(
            'reservation' => $reservation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reservation entity.
     *
     */
    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getEntityManager();
        $reservation = $em->getRepository('RentBundle:Reservation')->find($id);
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('reservation_homepage');
    }

    /**
     * Creates a form to delete a reservation entity.
     *
     * @param Reservation $reservation The reservation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reservation $reservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservation_delete', array('id' => $reservation->getId())) )
            ->setMethod('DELETE') ->getForm() ;
    }

    public function  notifAction(Request $request, Reservation $reservation)
    {
        return $this->render('RentBundle:reservation:notification.html.twig');
    }


    public function reserverAction()
    {
       /* $data = array(
            'my-message' => "My custom message",
        );
        $pusher = $this->get('mrad.pusher.notificaitons');
        $pusher->trigger($data);*/
      return $this->render('RentBundle:reservation:calendrier.html.twig');
    }


    public function acceptAction ()
    {
       /* $em=$this->getDoctrine()->getEntityManager();
        $reservation = $em->getRepository('RentBundle:Reservation')->find($id);
        $em->remove($reservation);
        $em->flush();*/

        return $this->redirectToRoute('homepage');
    }
}

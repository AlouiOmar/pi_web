<?php


namespace Mobile\MobileAPIBundle\Controller;


use Mobile\MobileAPIBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ReservationController extends Controller
{
    public function allAction()
    {
        $reservations = $this->getDoctrine()->getManager()
            ->getRepository('MobileAPIBundle:Reservation')
            ->findAll();
        $serializer = new Serializer ([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reservations);
        return new JsonResponse($formatted);
    }

public function findAction($id)
{
    $reservations = $this->getDoctrine()->getManager()
        ->getRepository('MobileAPIBundle:Reservation')
        ->find($id);
    $serializer = new Serializer ([new ObjectNormalizer()]);
    $formatted = $serializer->normalize($reservations);
    return new JsonResponse($formatted);
}


    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager()  ;
        $reservation = new Reservation();
        $reservation->setTitre($request->get('titre'));
        $reservation->setDateDeb(new \DateTime('now'));
        $reservation->setDateFin(new \DateTime('now'));

        $em->persist($reservation);
        $em->flush();
        $serializer = new serializer ([new objectNormalizer()]);
        $formatted = $serializer->normalize($reservation);
        return new JsonResponse($formatted);
    }


    public function updateAction (Request $request, $id){
        $em = $this->getDoctrine()->getManager()  ;
        $reservation = $em->getRepository('MobileAPIBundle:Reservation')->find($id);

        $reservation->setTitre($request->get('titre'));
        $reservation->setDateDeb($request->get('dateDeb'));
        $reservation->setDateFin($request->get('dateFin'));
      $em->persist($reservation);
        $em->flush();
        $serializer = new serializer ([new objectNormalizer()]);
        $formatted = $serializer->normalize($reservation);
        return new JsonResponse($formatted);
    }


    public function deleteAction(Request $request)
    {
        $token = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $reservation = $this->getDoctrine()->getRepository(Reservation::class)->find($token);

        $em->remove($reservation);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reservation);
        return new JsonResponse($formatted);
    }
}

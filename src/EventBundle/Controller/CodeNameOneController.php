<?php

namespace EventBundle\Controller;

use EspritApiBundle\Entity\Task;
use EventBundle\Entity\Event;
use EventBundle\Entity\Participation;
use EventBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CodeNameOneController extends Controller
{
    public function CreateEventMobileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $event = new Event();
        $event->setTitre($request->get('titre'));
        $event->setDateE($request->get('dateE'));
        $event->setDescription($request->get('description'));
        $event->setRegion($request->get('region'));
        $event->setNameC($request->get('nameC'));
        $event->setNbplaces($request->get('nbplaces'));
        $event->setCreator($this->getUser());
        $em->persist($event);
        $em->flush();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);

    }

    public function ShowEventMobileAction()
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EventBundle:Event')->findAll();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $reservationss=array();
        foreach ($event as $events) {

            $r=array("id"=>$events->getId(),
                "titre"=>$events->getTitre(),
                "description"=>$events->getDescription(),
                "dateE"=>$events->getDateE(),
                "region"=>$events->getRegion(),
                "nameC"=>$events->getNameC(),
                "nbplaces"=>$events->getNbplaces(),
                "creator"=>$events->getCreator(),
               "participant"=>$events->getParticipant()
            );


            array_push($reservationss,$r);

        }
        $formatted=$serializer->normalize($reservationss);
        return new JsonResponse($formatted);

        }

    public function afficherparticipantMobileAction(Request $request,$id)    {
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository(Event::class)->find($id);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $reservationss=array();
        foreach ($p as $events) {

            $r=array('events' => $events,
                'participant' => $events->getParicipant(),

            );


            array_push($reservationss,$r);

        }
        $formatted=$serializer->normalize($reservationss);
        return new JsonResponse($formatted);

    }

    public function EditEventMobileAction(Request $request, Event $event)
    {
        $editForm = $this->createForm('EventBundle\Form\EventType', $event);
        $editForm->handleRequest($request);
        $event->setTitre($request->get('titre'));
        $event->setDateE($request->get('dateE'));
        $event->setDescription($request->get('description'));
        $event->setRegion($request->get('region'));
        $event->setNameC($request->get('nameC'));
        $event->setNbplaces($request->get('nbplaces'));
        $this->getDoctrine()->getManager()->flush();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);


        }
    public function DeleteEventMobileAction($id, Request $request)
    {

            $em = $this->getDoctrine()->getManager();
            $event = $em->getRepository('EventBundle:Event')->find($id);

            $em->remove($event);
            $em->flush();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);

    }
    public function participationMobileAction(Event $events)
    {
        $user=$this->getUser();
        $events->addparticipation($user);
        $this->getUser()->addeventuser($events);
        $this->getDoctrine()->getManager()->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);


    }

    public function annulerparticipationMobileAction (Event $event)
    {

        $user=$this->getUser();
        $event->addparticipation($user);
        $this->getUser()->removeParticipation($event);
        $this->getDoctrine()->getManager()->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
    }

    public function ShowUsersMobileAction()
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EventBundle:User')->findAll();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
        /**
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $reservationss=array();
        foreach ($event as $events) {

            $r=array("id"=>$events->getId(),
                "username"=>$events->getUsername(),
                "firstname"=>$events->getNom()

            );


            array_push($reservationss,$r);

        }
        $formatted=$serializer->normalize($reservationss);
        return new JsonResponse($formatted);
        */
    }
    public function loginMobileAction(Request $request)
    {
        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($session);
        return new JsonResponse($formatted);
    }
    public function weathergetAction(Request $request)
    {

        $weatherService = $this->get('pianosolo.weather');
        $weathersArray = $weatherService->getWeatherObject($request->get('cityname'));
        $weatherObject = $weathersArray[0];
        $city = $weatherObject->getCity();
        $date = $weatherObject->getWdate();
        $temperature = $weatherObject->getTemperature();
        $description = $weatherObject->getDescription();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($weatherObject);
        return new JsonResponse($formatted);
    }
}

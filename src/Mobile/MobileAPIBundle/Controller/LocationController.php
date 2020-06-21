<?php


namespace Mobile\MobileAPIBundle\Controller;

use Mobile\MobileAPIBundle\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class LocationController extends Controller
{

    public function allAction ()
    {      
        $locations = $this->getDoctrine()->getManager()
            ->getRepository('MobileAPIBundle:Location')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($locations);
        return new JsonResponse($formatted);
    }

    public function findAction($id)
    {
        $locations = $this->getDoctrine()->getManager()
            ->getRepository('MobileAPIBundle:Location')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($locations);
        return new JsonResponse($formatted);
    }


    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager()  ;
        $location = new Location();
        $location->setTitre($request->get('titre'));
        $location->setLieu($request->get('lieu'));
        $location->setPrix($request->get('prix'));
        $location->setPhoto($request->get('photo'));
        //$location->setRating($request->get('rating'));
        $location->setDateCreation($request->get('dateCreation'));
        // $location->setDateCreation(new \DateTime('now'));
        $location->setUsername($request->get('username'));
       // $location->setUser($request->get('id_user'));
       
        $em->persist($location);
        $em->flush();
        $serializer = new serializer ([new objectNormalizer()]);
        $formatted = $serializer->normalize($location);
        return new JsonResponse($formatted);
    }


    public function updateAction (Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager()  ;
        $location = $em->getRepository('MobileAPIBundle:Location')->find($id);

        $location->setTitre($request->get('titre'));
        $location->setLieu($request->get('lieu'));
        $location->setPrix($request->get('prix'));
        $location->setPhoto($request->get('photo'));
        // $location->setRating($request->get('rating'));
       // $location->setDateCreation($request->get('dateCreation'));
         $location->setDateCreation(new \DateTime('now'));

        $em->persist($location);
        $em->flush();
        $serializer = new serializer ([new objectNormalizer()]);
        $formatted = $serializer->normalize($location);
        return new JsonResponse($formatted);
    }


    public function deleteAction(Request $request)
    {
        $token = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $location = $this->getDoctrine()->getRepository(Location::class)->find($token);

        $em->remove($location);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($location);
        return new JsonResponse($formatted);
    }


    public function showAction($id,Request $request)
    {
        $em= $this->getDoctrine()->getManager();

        $location=$em->getRepository('MobileAPIBundle:Location')->findby(['location'=>$id]);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $data = $serializer->normalize($location,null, ['attributes' => ['id','location'=>['id','titre','lieu','prix','photo','dateCreation']
            ,'user'=> ['id','username','username_canonical','email','email_canonical','enabled','salt','password','last_login','confirmation_token','password_requested_at','roles','first_name','telephone','age','idtrans']
            ,'content']]);
        $formatted = $serializer->normalize($data);
        return new JsonResponse($formatted);
    }
}
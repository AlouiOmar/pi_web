<?php


namespace Mobile\MobileAPIBundle\Controller;

use Mobile\MobileAPIBundle\Entity\FosUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class UserController extends Controller
{

    public function allAction ()
    {      
        $users = $this->getDoctrine()->getManager()
            ->getRepository('MobileAPIBundle:FosUser')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($users);
        return new JsonResponse($formatted);
    }

    public function findAction($id)
    {
        $users = $this->getDoctrine()->getManager()
            ->getRepository('MobileAPIBundle:FosUser')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($users);
        return new JsonResponse($formatted);
    }


    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager()  ;
        $user = new User();

        $user->setUsername($request->get('username'));
        $user->setUsernameCanonical($request->get('enabled'));
        $user->setEmail($request->get('enabled'));
        $user->setEmailCanonical($request->get('enabled'));
        $user->setEnabled($request->get('enabled'));
        $user->setPassword($request->get('password'));
        $user->setRoles($request->get('roles'));
        $user->setTelephone($request->get('telephone'));


       
        $em->persist($user);
        $em->flush();
        $serializer = new serializer ([new objectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }


    public function updateAction (Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager()  ;
        $user = $em->getRepository('MobileAPIBundle:FosUser')->find($id);

        $user->setUsername($request->get('username'));
        $user->setUsernameCanonical($request->get('enabled'));
        $user->setEmail($request->get('enabled'));
        $user->setEmailCanonical($request->get('enabled'));
        $user->setEnabled($request->get('enabled'));
        $user->setPassword($request->get('password'));
        $user->setRoles($request->get('roles'));
        $user->setTelephone($request->get('telephone'));

        $em->persist($user);
        $em->flush();
        $serializer = new serializer ([new objectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }




    public function showAction($id,Request $request)
    {
        $em= $this->getDoctrine()->getManager();

        $user=$em->getRepository('MobileAPIBundle:FosUser')->findby(['user'=>$id]);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $data = $serializer->normalize($user,null, ['user'=> ['id','username','username_canonical','email','email_canonical','enabled','password','roles','telephone'],'content']);
        $formatted = $serializer->normalize($data);
        return new JsonResponse($formatted);
    }
}
<?php

namespace CircuitsBundle\Controller;

use CircuitsBundle\Entity\Circuit;
use Esprit\ApiBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class velooController extends Controller
{public function allAction()
{
    $circuit = $this->getDoctrine()->getManager()
        ->getRepository('CircuitsBundle:Circuit')
        ->findAll();
    $serializer = new Serializer([new ObjectNormalizer()]);
    $formatted = $serializer->normalize($circuit);
    return new JsonResponse($formatted);
}

    public function findAction($id)
    {
        $circuits = $this->getDoctrine()->getManager()
            ->getRepository('CircuitsBundle:Circuit')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($circuits);
        return new JsonResponse($formatted);
    }

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $circuit = new Circuit();
        $circuit->setName($request->get('name'));
        $circuit->setBegin($request->get('begin'));
        $circuit->setPause($request->get('pause'));
        $circuit->setEnd($request->get('end'));
        $circuit->setDifficulty($request->get('difficulty'));
        $em->persist($circuit);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($circuit);
        return new JsonResponse($formatted);
    }




}

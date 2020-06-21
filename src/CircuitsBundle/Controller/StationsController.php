<?php

namespace CircuitsBundle\Controller;

use CircuitsBundle\Entity\Station;
use CircuitsBundle\Form\StationType;
use LocationBundle\Entity\Pointlocation;
use LocationBundle\Form\PointlocationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\FloatNode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class StationsController extends Controller
{
    public function getStationsAction()
    {
        $stations = $this->getDoctrine()->getRepository(\CircuitsBundle\Entity\Station::class)->findAll();
        $ptrel = $this->getDoctrine()->getRepository('CircuitsBundle:Station')->findAll();
        return $this->render('@Circuits/Circuits/get_stations.html.twig', array('stations' => $stations,'ptrel'=>$ptrel));
    }
    public function getStationsUAction()
    {
        $stations = $this->getDoctrine()->getRepository(\CircuitsBundle\Entity\Station::class)->findAll();
        $ptrel = $this->getDoctrine()->getRepository('CircuitsBundle:Station')->findAll();
        return $this->render('@Circuits/CircuitsUser/get_stations.html.twig', array('stations' => $stations,'ptrel'=>$ptrel));
    }

    public function ajouterAction(Request $request)
    {
        $vel = $this->getDoctrine()->getRepository('CircuitsBundle:Station')->findAll();

        $ptll = new Station();
        $form = $this->createForm(StationType::class,$ptll) ;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {//ici
            $em = $this->getDoctrine()->getManager();
            $ptll->setNom($request->get('nom'));
            $ptll->setLongitude($long = $request->get('longitude'));
            $ptll->setLattitude($lat = $request->get('lattitude'));
            $ptll->setUserId($this->getUser());



            $em->persist($ptll);
            $this->addFlash('success', 'Points Relais ajoutée avec succés');
            $em->flush() ;
            return $this->redirectToRoute('get_stations');
        }
        return $this->render('@Circuits/Circuits/AjouterStation.html.twig', array('form' => $form->createView(),'ptrel'=>$vel));

        //$s = new Station();
        //$form = $this->createForm('CircuitsBundle\Form\StationType', $s);
        //$form->handleRequest($request);
        //if ($form->isValid())
       // {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($s);
//            $em->flush();
//            echo "<script> alert(\" Station ajouté avec succès \")</script>";
//        }
//
//        return $this->render('@Circuits/Circuits/AjouterStation.html.twig', array('form' => $form->createView()));
//        $this->addFlash("success", "projet creer avec succee");
      }

    public function deleteStationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository("CircuitsBundle:Station")->find($id);
        $em->remove($prod);
        $em->flush();
        return $this->redirectToRoute("get_stations");

    }

    public function updateStationAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $circuit = $em->getRepository(\CircuitsBundle\Entity\Station::class)->find($id);
        $f = $this->createForm(\CircuitsBundle\Form\StationType::class, $circuit);

        $f = $f->handleRequest($request);
        if ($f->isValid()) {


            //var_dump($file);


            $em = $this->getDoctrine()->getManager();
            $em->persist($circuit);
            $em->flush();
            return $this->redirectToRoute('get_stations');
        }
        return $this->render('@Circuits/Circuits/modifierStation.html.twig', array('f' => $f->createView()));
    }

    public function getStationMobileAction()
    {
        $station = $this->getDoctrine()->getManager()
            ->getRepository('CircuitsBundle:Station')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($station);
        return new JsonResponse($formatted);
    }
    public function findAction($id)
    {
        $stations = $this->getDoctrine()->getManager()
            ->getRepository('CircuitsBundle:Station')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($stations);
        return new JsonResponse($formatted);
    }


    public function addStationMobileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $station = new Station();

        $station->setNom($request->get('nom'));

        $station->setLattitude($request->get('lattitude'));
        $station->setLongitude($request->get('longitude'));
        $em->persist($station);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($station);
        return new JsonResponse($formatted);
    }

    public function deleteStationMobileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository("CircuitsBundle:Station")->find($id);
        $em->remove($prod);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($prod);
        return new JsonResponse($formatted);
    }
    public function indexAction()
    {

        return $this->render('@Circuits/Circuits/index.html.twig');

    }


}

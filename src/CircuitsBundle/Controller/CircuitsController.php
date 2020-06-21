<?php

namespace CircuitsBundle\Controller;

use BlogBundle\Entity\Commentaire;
use BlogBundle\Entity\Post;
use CircuitsBundle\Entity\Circuit;
use CircuitsBundle\Entity\CircuitsComments;
use CircuitsBundle\Entity\Station;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CircuitsBundle\Form\CircuitType;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use AppBundle\Entity\User;

class CircuitsController extends Controller
{
    public function getCircuitsAction()
    {
        $circuits = $this->getDoctrine()->getRepository(\CircuitsBundle\Entity\Circuit::class)->findAll();

        return $this->render('@Circuits/Circuits/get_circuits.html.twig', array('circuits' => $circuits));
    }


    public function getCircuitsUAction()
    {
        $circuits = $this->getDoctrine()->getRepository(\CircuitsBundle\Entity\Circuit::class)->findAll();

        return $this->render('@Circuits/CircuitsUser/get_circuits.html.twig', array('circuits' => $circuits));
    }


    public function circuitSingleAction($id)
    {

        $circuit = $this->getDoctrine()->getManager()->getRepository(Circuit::class)->find($id);

        $depart = $this->getDoctrine()->getManager()->getRepository(Station::class)->find($circuit->getDepart());
        $pause = $this->getDoctrine()->getManager()->getRepository(Station::class)->find($circuit->getPause());
        $end = $this->getDoctrine()->getManager()->getRepository(Station::class)->find($circuit->getEnd());
        $comments=$this->getDoctrine()->getManager()->getRepository(CircuitsComments::class)->findBy(['CircuitId'=>$circuit->getId()]);

        return $this->render('@Circuits/CircuitsUser/circuit_single.html.twig', array('circuit' => $circuit, 'depart' => $depart,'pause'=>$pause,'end'=>$end,'comments'=>$comments));
    }


    public function createAction(Request $request)
    {

        $c = new Circuit();
        $form = $this->createForm('CircuitsBundle\Form\CircuitType', $c);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $c->setUserId($this->getUser());
            $em->persist($c);
            $em->flush();
            echo "<script> alert(\" Circuit ajouté avec succès \")</script>";
            return $this->redirectToRoute("get_circuits");
        }

        return $this->render('@Circuits/Circuits/AjouterCircuit.html.twig', array('form' => $form->createView()));
        $this->addFlash("success", "projet creer avec succee");
    }


    public function createUAction(Request $request)
    {

        $c = new Circuit();
        $form = $this->createForm('CircuitsBundle\Form\CircuitType', $c);
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $c->setUserId($this->getUser());
            $em->persist($c);
            $em->flush();
            echo "<script> alert(\" Circuit ajouté avec succès \")</script>";
            foreach ($users as $u) {
                $message = (new \Swift_Message('velo.tn'))
                    ->setFrom('ezzeddine.chariout@esprit.tn')
                    ->setTo($u->getEmail())
                    ->setBody(
                        $this->renderView('@Circuits/CircuitsUser/mail.html.twig', ['nameReciever' => $u->getNom(), 'circuitName' => $c->getNom()]),
                        'text/html');
                $this->get('mailer')->send($message);
                return $this->redirectToRoute("get_circuitsU");
            }

        }

        return $this->render('@Circuits/CircuitsUser/AjouterCircuit.html.twig', array('form' => $form->createView()));
        $this->addFlash("success", "projet creer avec succee");
    }


    public function deleteCircuitAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository("CircuitsBundle:Circuit")->find($id);
        $em->remove($prod);
        $em->flush();
        return $this->redirectToRoute("get_circuits");

    }


    public function deleteCircuitByNameAction($name)
    {

        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository("CircuitsBundle:Circuit")->findOneBy(['nom' => $name]);
        $em->remove($prod);
        $em->flush();
        return $this->redirectToRoute("get_circuits");
    }

    public function deleteCircuitUAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository("CircuitsBundle:Circuit")->find($id);
        $em->remove($prod);
        $em->flush();
        return $this->redirectToRoute("get_circuitsU");

    }


    public function updateCircuitAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $circuit = $em->getRepository(Circuit::class)->find($id);
        $f = $this->createForm(CircuitType::class, $circuit);

        $f = $f->handleRequest($request);
        if ($f->isValid()) {


            //var_dump($file);


            $em = $this->getDoctrine()->getManager();
            $em->persist($circuit);
            $em->flush();
            return $this->redirectToRoute('get_circuits');
        }


        return $this->render('@Circuits/Circuits/modifierCircuit.html.twig', array('f' => $f->createView()));
    }

    public function updateCircuitUAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $circuit = $em->getRepository(Circuit::class)->find($id);
        $f = $this->createForm(CircuitType::class, $circuit);

        $f = $f->handleRequest($request);
        if ($f->isValid()) {


            //var_dump($file);


            $em = $this->getDoctrine()->getManager();
            $em->persist($circuit);
            $em->flush();
            return $this->redirectToRoute('get_circuitsU');
        }


        return $this->render('@Circuits/CircuitsUser/modifierCircuit.html.twig', array('f' => $f->createView()));
    }


    public function highCUAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('CircuitsBundle:Circuit')->findBy([], ['distance' => 'DESC']);
        return $this->render('@Circuits/CircuitsUser/get_circuits.html.twig', array('circuits' => $rep));
    }

    public function lowCUAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('CircuitsBundle:Circuit')->findBy([], ['distance' => 'ASC']);
        return $this->render('@Circuits/CircuitsUser/get_circuits.html.twig', array('circuits' => $rep));
    }


    public function getCircuitMobileAction()
    {
        $circuit = $this->getDoctrine()->getManager()
            ->getRepository('CircuitsBundle:Circuit')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($circuit);
        return new JsonResponse($formatted);
    }


    public function findAction($id)
    {
        $circuits = $this->getDoctrine()
            ->getManager()
            ->getRepository('CircuitsBundle:Circuit')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($circuits);
        return new JsonResponse($formatted);
    }

    public function addCircuitMobileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $circuit = new Circuit();
        $begin = $this->getDoctrine()->getManager()->getRepository(Station::class)->findOneBy(["nom" => $request->get('begin')]);
        $pause = $this->getDoctrine()->getManager()->getRepository(Station::class)->findOneBy(["nom" => $request->get('pause')]);
        $end = $this->getDoctrine()->getManager()->getRepository(Station::class)->findOneBy(["nom" => $request->get('end')]);
        $user = $em->getRepository(User::class)->find($request->get('userId'));
        $circuit->setUserId($user);
        $circuit->setNom($request->get('nom'));
        $circuit->setDepart($begin);
        $circuit->setPause($pause);
        $circuit->setEnd($end);
        $circuit->setDifficulty($request->get('difficulty'));
        $circuit->setDistance($request->get('distance'));
        $circuit->setUserId($user);
        $em->persist($circuit);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($circuit);
        return new JsonResponse($formatted);
    }

    public function deleteCircuitMobileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository("CircuitsBundle:Circuit")->find($id);
        $em->remove($prod);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($prod);
        return new JsonResponse($formatted);
    }

    public function updateCircuitMobileAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nbegin = $this->getDoctrine()->getManager()->getRepository(Station::class)->findOneBy(["nom" => $request->get('begin')]);
        $npause = $this->getDoctrine()->getManager()->getRepository(Station::class)->findOneBy(["nom" => $request->get('pause')]);
        $nend = $this->getDoctrine()->getManager()->getRepository(Station::class)->findOneBy(["nom" => $request->get('end')]);

        $circuit = $em->getRepository(Circuit::class)->find($id);

        $circuit->setNom($request->get('nom'));
        $circuit->setDepart($nbegin);
        $circuit->setPause($npause);
        $circuit->setEnd($nend);
        $circuit->setDifficulty($request->get('difficulty'));
        $circuit->setDistance($request->get('distance'));
        $em->persist($circuit);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($circuit);
        return new JsonResponse($formatted);
    }

    public function highDistMobileAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $circuit = $em->getRepository('CircuitsBundle:Circuit')->findBy([], ['distance' => 'DESC']);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($circuit);
        return new JsonResponse($formatted);
    }

    public function lowDistMobileAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $circuit = $em->getRepository('CircuitsBundle:Circuit')->findBy([], ['distance' => 'ASC']);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($circuit);
        return new JsonResponse($formatted);
    }

    public function showUserMobileAction()
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function addcommentsAction(Request $request)
    {
        $circuit = $this->getDoctrine()
            ->getRepository(Circuit::class)
            ->find($request->request->get('CircuitId'));

        $em = $this->getDoctrine()->getManager();

        $p = $em->getRepository(Circuit::class)->find($circuit);

        $comment = new CircuitsComments();
        $comment->setUserId($this->getUser());
        $comment->setCircuitId($circuit);
        $comment->setContent($request->request->get('comment'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        $this->addFlash(
            'info',
            'commentaire  est crée avec succées'
        );
        $depart = $this->getDoctrine()->getManager()->getRepository(Station::class)->find($circuit->getDepart());
        $pause = $this->getDoctrine()->getManager()->getRepository(Station::class)->find($circuit->getPause());
        $end = $this->getDoctrine()->getManager()->getRepository(Station::class)->find($circuit->getEnd());
        $comments=$this->getDoctrine()->getManager()->getRepository(CircuitsComments::class)->findBy(['CircuitId'=>$circuit->getId()]);
        return $this->render('@Circuits/CircuitsUser/circuit_single.html.twig', array(

            'circuit' => $circuit, 'depart' => $depart,'pause'=>$pause,'end'=>$end,'comments'=>$comments
        ));
    }



    public function deleteCommentAction(Request $request,$id,$idCircuit){
        $comment=$this->getDoctrine()->getManager()->getRepository(CircuitsComments::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();
        $circuit = $this->getDoctrine()
            ->getRepository(Circuit::class)
            ->find($idCircuit);
        $depart = $this->getDoctrine()->getManager()->getRepository(Station::class)->find($circuit->getDepart());
        $pause = $this->getDoctrine()->getManager()->getRepository(Station::class)->find($circuit->getPause());
        $end = $this->getDoctrine()->getManager()->getRepository(Station::class)->find($circuit->getEnd());
        $comments=$this->getDoctrine()->getManager()->getRepository(CircuitsComments::class)->findBy(['CircuitId'=>$circuit->getId()]);
        return $this->render('@Circuits/CircuitsUser/circuit_single.html.twig', array(

            'circuit' => $circuit, 'depart' => $depart,'pause'=>$pause,'end'=>$end,'comments'=>$comments
        ));

    }

}

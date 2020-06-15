<?php

namespace Velo\AnnonceBundle\Controller;

use AppBundle\Entity\Annonce;
use AppBundle\Entity\Signaler;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AnnonceMobileController extends Controller
{



    public function afficherAnnoncesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $user=$em->getRepository(User::class)->find($request->get('user'));
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->findAllActive();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $annoncess=array();
        foreach ($annonces as $annonce) {



            $date=$annonce->getDate();
            $date1=($date)->format('d/m/Y');
            $datep=$annonce->getDatep();
            $datep1=($date)->format('d/m/Y');

            $a=array(

                "ida" => $annonce->getIda(),
                "categorie" => $annonce->getCategorie(),
                "titre" => $annonce->getTitre(),
                "description" => $annonce->getDescription(),
                "photo" => $annonce->getPhot(),
                "date" => $date1,
                "datep"=> $datep1,
                "active" => $annonce->isActive(),
                "prix" => $annonce->getPrix(),
                "type" => $annonce->getType(),
                "type_velo" => $annonce->getTypevelo(),
                "couleur" => $annonce->getCouleur(),
                "gouvernorat" => $annonce->getGouvernorat(),
                "idu" => $annonce->getIdu()->getId()

            );
            array_push($annoncess,$a);

        }
        $formatted=$serializer->normalize($annoncess);
        return new JsonResponse($formatted);

    }

    public function afficherAnnoncesCatAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $user=$em->getRepository(User::class)->find($request->get('user'));
        $categorie=$request->get('categorie');
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->findCategorieActive($categorie);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $annoncess=array();
        foreach ($annonces as $annonce) {



            $date=$annonce->getDate();
            $date1=($date)->format('d/m/Y');
            $datep=$annonce->getDatep();
            $datep1=($date)->format('d/m/Y');

            $a=array(

                "ida" => $annonce->getIda(),
                "categorie" => $annonce->getCategorie(),
                "titre" => $annonce->getTitre(),
                "description" => $annonce->getDescription(),
                "photo" => $annonce->getPhot(),
                "date" => $date1,
                "datep"=> $datep1,
                "active" => $annonce->isActive(),
                "prix" => $annonce->getPrix(),
                "type" => $annonce->getType(),
                "type_velo" => $annonce->getTypevelo(),
                "couleur" => $annonce->getCouleur(),
                "gouvernorat" => $annonce->getGouvernorat(),
                "idu" => $annonce->getIdu()->getId()

            );
            array_push($annoncess,$a);

        }
        $formatted=$serializer->normalize($annoncess);
        return new JsonResponse($formatted);

    }

    public function afficherAnnoncesPrixAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $user=$em->getRepository(User::class)->find($request->get('user'));
        $choix=$request->get('choix');
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->triPrixActive($choix);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $annoncess=array();
        foreach ($annonces as $annonce) {



            $date=$annonce->getDate();
            $date1=($date)->format('d/m/Y');
            $datep=$annonce->getDatep();
            $datep1=($date)->format('d/m/Y');

            $a=array(

                "ida" => $annonce->getIda(),
                "categorie" => $annonce->getCategorie(),
                "titre" => $annonce->getTitre(),
                "description" => $annonce->getDescription(),
                "photo" => $annonce->getPhot(),
                "date" => $date1,
                "datep"=> $datep1,
                "active" => $annonce->isActive(),
                "prix" => $annonce->getPrix(),
                "type" => $annonce->getType(),
                "type_velo" => $annonce->getTypevelo(),
                "couleur" => $annonce->getCouleur(),
                "gouvernorat" => $annonce->getGouvernorat(),
                "idu" => $annonce->getIdu()->getId()

            );
            array_push($annoncess,$a);

        }
        $formatted=$serializer->normalize($annoncess);
        return new JsonResponse($formatted);

    }


    public function afficherAnnoncesDateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $user=$em->getRepository(User::class)->find($request->get('user'));
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->triDateActive();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $annoncess=array();
        foreach ($annonces as $annonce) {



            $date=$annonce->getDate();
            $date1=($date)->format('d/m/Y');
            $datep=$annonce->getDatep();
            $datep1=($date)->format('d/m/Y');

            $a=array(

                "ida" => $annonce->getIda(),
                "categorie" => $annonce->getCategorie(),
                "titre" => $annonce->getTitre(),
                "description" => $annonce->getDescription(),
                "photo" => $annonce->getPhot(),
                "date" => $date1,
                "datep"=> $datep1,
                "active" => $annonce->isActive(),
                "prix" => $annonce->getPrix(),
                "type" => $annonce->getType(),
                "type_velo" => $annonce->getTypevelo(),
                "couleur" => $annonce->getCouleur(),
                "gouvernorat" => $annonce->getGouvernorat(),
                "idu" => $annonce->getIdu()->getId()

            );
            array_push($annoncess,$a);

        }
        $formatted=$serializer->normalize($annoncess);
        return new JsonResponse($formatted);

    }

    public function afficherAnnoncesSignAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $user=$em->getRepository(User::class)->find($request->get('user'));
        $annonces=$this->getDoctrine()->getRepository(Signaler::class)->findCountSignaled();
//        dump($annonces);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $annoncess=array();
        foreach ($annonces as $annonce) {



            $date=$annonce['annonce']->getDate();
            $date1=($date)->format('d/m/Y');
            $datep=$annonce['annonce']->getDatep();
            $datep1=($date)->format('d/m/Y');

            $a=array(

                "ida" => $annonce['annonce']->getIda(),
                "categorie" => $annonce['annonce']->getCategorie(),
                "titre" => $annonce['annonce']->getTitre(),
                "description" => $annonce['annonce']->getDescription(),
                "photo" => $annonce['annonce']->getPhot(),
                "date" => $date1,
                "datep"=> $datep1,
                "active" => $annonce['annonce']->isActive(),
                "prix" => $annonce['annonce']->getPrix(),
                "type" => $annonce['annonce']->getType(),
                "type_velo" => $annonce['annonce']->getTypevelo(),
                "couleur" => $annonce['annonce']->getCouleur(),
                "gouvernorat" => $annonce['annonce']->getGouvernorat(),
                "idu" => $annonce['annonce']->getIdu()->getId()

            );
            array_push($annoncess,$a);

        }
        $formatted=$serializer->normalize($annoncess);
        return new JsonResponse($formatted);

    }

    public function afficherMesAnnoncesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $user=$em->getRepository(User::class)->find($request->get('user'));
        $id=$request->get('user');
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->findAllMyAnnonces($id);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $annoncess=array();
        foreach ($annonces as $annonce) {



            $date=$annonce->getDate();
            $date1=($date)->format('d/m/Y');
            $datep=$annonce->getDatep();
            $datep1=($date)->format('d/m/Y');

            $a=array(

                "ida" => $annonce->getIda(),
                "categorie" => $annonce->getCategorie(),
                "titre" => $annonce->getTitre(),
                "description" => $annonce->getDescription(),
                "photo" => $annonce->getPhot(),
                "date" => $date1,
                "datep"=> $datep1,
                "active" => $annonce->isActive(),
                "prix" => $annonce->getPrix(),
                "type" => $annonce->getType(),
                "type_velo" => $annonce->getTypevelo(),
                "couleur" => $annonce->getCouleur(),
                "gouvernorat" => $annonce->getGouvernorat(),
                "idu" => $annonce->getIdu()->getId()

            );
            array_push($annoncess,$a);

        }
        $formatted=$serializer->normalize($annoncess);
        return new JsonResponse($formatted);

    }
    public function rechercheAnnoncesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $user=$em->getRepository(User::class)->find($request->get('user'));
        $recherche=$request->get('recherche');
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->rechercheActive($recherche);
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $annoncess=array();
        foreach ($annonces as $annonce) {



            $date=$annonce->getDate();
            $date1=($date)->format('d/m/Y');
            $datep=$annonce->getDatep();
            $datep1=($date)->format('d/m/Y');

            $a=array(

                "ida" => $annonce->getIda(),
                "categorie" => $annonce->getCategorie(),
                "titre" => $annonce->getTitre(),
                "description" => $annonce->getDescription(),
                "photo" => $annonce->getPhot(),
                "date" => $date1,
                "datep"=> $datep1,
                "active" => $annonce->isActive(),
                "prix" => $annonce->getPrix(),
                "type" => $annonce->getType(),
                "type_velo" => $annonce->getTypevelo(),
                "couleur" => $annonce->getCouleur(),
                "gouvernorat" => $annonce->getGouvernorat(),
                "idu" => $annonce->getIdu()->getId()

            );
            array_push($annoncess,$a);

        }
        $formatted=$serializer->normalize($annoncess);
        return new JsonResponse($formatted);

    }
    public function ajouterAnnoncesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $idu=+($request->get('idu'));

        $user = $em->getRepository(User::class)->findById($idu);

        $em1 = $this->getDoctrine()->getManager();

        $annonce = new Annonce();
        $annonce->setTitre($request->get('titre'));
        $annonce->setCategorie($request->get('categorie'));
        if($request->get('categorie')=="Vélo"){
            $annonce->setTypevelo($request->get('type_velo'));
            $annonce->setCouleur($request->get('couleur'));
        }
        $annonce->setDate( new \DateTime ($request->get('date')));
        $date=new \DateTime();
        $annonce->setDatep($date);
        $annonce->setActive(true);
        $annonce->setDescription($request->get('description'));
        $annonce->setPrix($request->get('prix'));
        $annonce->setType($request->get('type'));
        $annonce->setIdu($user[0]);
        $annonce->setPhoto($request->get('photo'));
        $annonce->setGouvernorat($request->get('gouvernorat'));

        $em1->persist($annonce);
        $em1->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $date=$annonce->getDate();
        $date1=($date)->format('d/m/Y');
        $datep=$annonce->getDatep();
        $datep1=($date)->format('d/m/Y');
        $formatted = $serializer->normalize(
            array(

                "ida" => $annonce->getIda(),
                "categorie" => $annonce->getCategorie(),
                "titre" => $annonce->getTitre(),
                "description" => $annonce->getDescription(),
                "photo" => $annonce->getPhot(),
                "date" => $date1,
                "datep"=> $datep1,
                "active" => $annonce->isActive(),
                "prix" => $annonce->getPrix(),
                "type" => $annonce->getType(),
                "type_velo" => $annonce->getTypevelo(),
                "couleur" => $annonce->getCouleur(),
                "gouvernorat" => $annonce->getGouvernorat(),
                "idu" => $annonce->getIdu()->getId()

            ));
        return new JsonResponse($formatted);

    }

    public function supprimerAnnonceAction (Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository(Annonce::class)->find($request->get('ida'));
            $em->remove($annonce);
            $em->flush();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $date=$annonce->getDate();
        $date1=($date)->format('d/m/Y');
        $datep=$annonce->getDatep();
        $datep1=($date)->format('d/m/Y');
        $formatted = $serializer->normalize(
            array(

                "ida" => $annonce->getIda(),
                "categorie" => $annonce->getCategorie(),
                "titre" => $annonce->getTitre(),
                "description" => $annonce->getDescription(),
                "photo" => $annonce->getPhot(),
                "date" => $date1,
                "datep"=> $datep1,
                "active" => $annonce->isActive(),
                "prix" => $annonce->getPrix(),
                "type" => $annonce->getType(),
                "type_velo" => $annonce->getTypevelo(),
                "couleur" => $annonce->getCouleur(),
                "gouvernorat" => $annonce->getGouvernorat(),
                "idu" => $annonce->getIdu()->getId()

            )
        );
        return new JsonResponse($formatted);
    }

    public function modifierAnnonceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ida=+($request->get('ida'));
//        $user=new User();
//        $user = $em->getRepository(User::class)->findById($idu);
//        $user->setId($idu);
//        $user->setPhoto($usr->getPhoto());
//        dump($user);
//        die();
//        $image=new Image();
//        $image->setUrl($request->get('imageurl'));
//        $image->setAlt('png');
//        $em->persist($image);
//        $em->flush();
        $em1 = $this->getDoctrine()->getManager();
//        $image1 = $em1->getRepository('planBundle:Image')->findurl($request->get('imageurl'));
//        $annonce = new Annonce();
        $annonce = $em->getRepository(Annonce::class)->find($ida);
        dump($annonce);
        dump('##############');
//        die();
        $annonce->setTitre($request->get('titre'));
        $annonce->setCategorie($request->get('categorie'));
        if($request->get('categorie')=="Vélo"){
            $annonce->setTypevelo($request->get('type_velo'));
            $annonce->setCouleur($request->get('couleur'));
        }
        $annonce->setDate( new \DateTime ($request->get('date')));
        $date=new \DateTime();
        $annonce->setDatep($date);
        $annonce->setActive(true);
        $annonce->setDescription($request->get('description'));
        $annonce->setPrix($request->get('prix'));
        $annonce->setType($request->get('type'));
//        $annonce->setIdu($user[0]);
        $annonce->setPhoto($request->get('photo'));
        $annonce->setGouvernorat($request->get('gouvernorat'));

        $em1->persist($annonce);
        $em1->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $date=$annonce->getDate();
        $date1=($date)->format('d/m/Y');
        $datep=$annonce->getDatep();
        $datep1=($date)->format('d/m/Y');
        $formatted = $serializer->normalize(
            array(

                "ida" => $annonce->getIda(),
                "categorie" => $annonce->getCategorie(),
                "titre" => $annonce->getTitre(),
                "description" => $annonce->getDescription(),
                "photo" => $annonce->getPhot(),
                "date" => $date1,
                "datep"=> $datep1,
                "active" => $annonce->isActive(),
                "prix" => $annonce->getPrix(),
                "type" => $annonce->getType(),
                "type_velo" => $annonce->getTypevelo(),
                "couleur" => $annonce->getCouleur(),
                "gouvernorat" => $annonce->getGouvernorat(),
                "idu" => $annonce->getIdu()->getId()

            ));
        return new JsonResponse($formatted);

    }



    public function signalmAction(Request $request)
    {
        $signal=new Signaler();
        $id = $request->get('id');
        $cause = $request->get('cause');
//        dump($id);
//        dump($cause);
        $annonce=$this->getDoctrine()->getRepository(Annonce::class)->find($id);
        if($annonce!=null){
            if(   $cause=='Contenu indésirable' or $cause=='Harcèlement' or $cause=='Discours haineux'  or $cause=='Nudité' or $cause=='Violence' or $cause=='Autre' and  $annonce!=null){
                //persist
                $signal->setIda($annonce);
                $signal->setCause($cause);
                $em=$this->getDoctrine()->getManager();
                $em->persist($signal);
                $em->flush();
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted= $serializer->normalize('Success');
            }else{
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted= $serializer->normalize('Failed');
            }}else{
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted= $serializer->normalize('Failed');
        }



        return new JsonResponse($formatted);
    }

    public function statGouvAnnoncesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $user=$em->getRepository(User::class)->find($request->get('user'));
        $annonce=$this->getDoctrine()->getRepository(Annonce::class)->findCountGouvernorat();
//        dump($annonce);
//        die();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $annoncess=array();

        for ( $i=0;$i<sizeof($annonce);$i++){





            $a=array(

                "nombre" => $annonce[$i]['nombre'],
                "gouvernorat" => $annonce[$i]['gouvernorat'],


            );
            array_push($annoncess,$a);

        }
        $formatted=$serializer->normalize($annoncess);
        return new JsonResponse($formatted);

    }

    public function statSignalCatAnnoncesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $user=$em->getRepository(User::class)->find($request->get('user'));
        $annonce=$this->getDoctrine()->getRepository(Signaler::class)->findCountSignaledCategorie();
//        dump($annonce);
//        die();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $annoncess=array();

        for ( $i=0;$i<sizeof($annonce);$i++){





            $a=array(

                "categorie" => $annonce[$i]['categorie'],
                "nombre" => $annonce[$i]['nombre'],


            );
            array_push($annoncess,$a);

        }
        $formatted=$serializer->normalize($annoncess);
        return new JsonResponse($formatted);

    }

    public function statSignalCauseAnnoncesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $user=$em->getRepository(User::class)->find($request->get('user'));
        $annonce=$this->getDoctrine()->getRepository(Signaler::class)->findCountSignaledCause();
//        dump($annonce);
//        die();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $annoncess=array();

        for ( $i=0;$i<sizeof($annonce);$i++){





            $a=array(

                "cause" => $annonce[$i]['cause'],
                "nombre" => $annonce[$i]['nombre'],


            );
            array_push($annoncess,$a);

        }
        $formatted=$serializer->normalize($annoncess);
        return new JsonResponse($formatted);

    }

    public function statTypeAnnoncesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $user=$em->getRepository(User::class)->find($request->get('user'));
        $annonce=$this->getDoctrine()->getRepository(Annonce::class)->findCountType();
//        dump($annonce);
//        die();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $annoncess=array();

        for ( $i=0;$i<sizeof($annonce);$i++){





            $a=array(

                "type" => $annonce[$i]['type'],
                "nombre" => $annonce[$i]['nombre'],


            );
            array_push($annoncess,$a);

        }
        $formatted=$serializer->normalize($annoncess);
        return new JsonResponse($formatted);

    }

    public function causesAnnonceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id=$request->get('id');
//        $user=$em->getRepository(User::class)->find($request->get('user'));
        $annonce=$this->getDoctrine()->getRepository(Signaler::class)->findCause($id);
//        dump($annonce);
//        die();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $annoncess=array();

        for ( $i=0;$i<sizeof($annonce);$i++){





            $a=array(

                "cause" => $annonce[$i]['cause'],
                "nombre" => $annonce[$i]['nombre'],


            );
            array_push($annoncess,$a);

        }
        $formatted=$serializer->normalize($annoncess);
        return new JsonResponse($formatted);

    }
}

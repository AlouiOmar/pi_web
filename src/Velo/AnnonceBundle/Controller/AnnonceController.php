<?php

namespace Velo\AnnonceBundle\Controller;

use AppBundle\Entity\Annonce;
use AppBundle\Entity\Signaler;
use AppBundle\Form\AnnonceType;
use AppBundle\Form\EditAnnonceType;
use AppBundle\Service\UtilsService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
//use AppBundle\Service\UtilsService;


class AnnonceController extends Controller
{
    public function listAction( Request $request)
    {
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->findAllActive();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $annonces, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        $usr= $this->container->get('security.token_storage')->getToken()->getUser();
//        if($usr->getRoles()[0]=='ROLE_USER'){
//            dump('user connected');
//        }
//        if($usr->getRoles()[0]=='ROLE_ADMIN'){
//            dump('admin connected');
//        }
//        dump($usr->getRoles());
//        dump($usr);
//        dump($pagination);
//        die();
        return $this->render('@VeloAnnonce/user/listAnnonce.html.twig', array( 'annonces'=>$pagination));
    }

    public function myListAction()
    {
        $usr= $this->container->get('security.token_storage')->getToken()->getUser();
//        dump($usr);
        if($usr!='anon.') {
            $annonces = $this->getDoctrine()->getRepository(Annonce::class)->findAllMyAnnonces($usr->getId());
            return $this->render('@VeloAnnonce/user/mesAnnonces.html.twig', array( 'annonces'=>$annonces));

        }else{
           return $this->redirectToRoute('notfound');
        }
//        if($usr->getRoles()[0]=='ROLE_USER'){
//            dump('user connected');
//        }
//        if($usr->getRoles()[0]=='ROLE_ADMIN'){
//            dump('admin connected');
//        }
//        dump($usr->getRoles());
//        dump($usr);
//        dump($annonces);
//        die();
    }

    public function annonceAction($id)
    {
        $annonce=$this->getDoctrine()->getRepository(Annonce::class)->find($id);
        $annonce1=$this->getDoctrine()->getRepository(Annonce::class)->getAnnonce($id);
        dump($annonce);
        dump($annonce1);
//        die();
        return $this->render('@VeloAnnonce/user/annonce.html.twig', array( 'annonce'=>$annonce));
    }

    public function addAction(Request $request)
    {

        dump('envoi mail');
//        $utilsService=$this->container->get('AppBundle\Service\UtilsService');
//        $utilsService->sendMail('ah');
        $mailer=$this->container->get('swiftmailer.mailer');

//        die();
        $usr= $this->container->get('security.token_storage')->getToken()->getUser();
        $nomprenom=$usr->getNom().' '.$usr->getPrenom();
        $email=$usr->getEmail();
        $date=new \DateTime();
        $date1=(new \DateTime())->format('Y-m-d');
        dump($date1);
        dump($nomprenom);
        dump($email);
//        die();
        if( $usr!='anon.'){
        $annonce= new  Annonce();
        $form=$this->createForm(AnnonceType::class,$annonce);
        $form ->add('Valider',SubmitType::class,
            ['attr'=>['formnovalidate'=>'formnovalidate','class'=>'form-control btn btn-primary','id'=>'a']]);
        $form->handleRequest($request);
        //dump($usr->getId());
        if ($form ->isSubmitted() and $form->isValid())
        {
            $file=$form['photo']->getData();
            $newImageName=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('annonce1_image'),$newImageName);
            $annonce->setPhoto($newImageName);
            $annonce->setIdu($usr);
            $annonce->setDatep($date);
            dump($annonce);
//            die();
            $this->sendMail($nomprenom,$annonce->getTitre(),$annonce->getDatep(),$email,$mailer);
            $em=$this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('velo_list_annonce');
        }

        return $this->render("@VeloAnnonce/user/addAnnonce.html.twig",array("form"=>$form->createView()));
        }else{
            //redirect error page
            //dump('error champs invalides');
            return $this->redirectToRoute('notfound');
        }

    }

    public function editAction(Request $request,$id)
    {
        $usr= $this->container->get('security.token_storage')->getToken()->getUser();
        $annonce=$this->getDoctrine()->getRepository(Annonce::class)->find($id);
        if($annonce!=null and $usr!='anon.'){
            if(($usr->getRoles()[0]=='ROLE_ADMIN' or $usr->getId()==$annonce->getIdu()->getId())) {
        $photo=$annonce->getPhot();
        $form=$this->createForm(EditAnnonceType::class,$annonce);

                $form ->add('Valider',SubmitType::class,
                    ['attr'=>['formnovalidate'=>'formnovalidate','class'=>'form-control btn btn-primary','id'=>'a']]);

        $form->handleRequest($request);

        if ($form ->isSubmitted() and $form->isValid())
        {

            $file=$form['photo']->getData();
            if($file!=null){
                $newImageName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('annonce1_image'),$newImageName);
                $annonce->setPhoto($newImageName);
            }else{
                $annonce->setPhoto($photo);
            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('velo_list_annonce');
        }

        return $this->render("@VeloAnnonce/user/addAnnonce.html.twig",array("form"=>$form->createView()));
            }else{
                //redirect error page
                //dump('error champs invalides');
                return $this->redirectToRoute('notfound');
            }
        }else{
            //redirect error page
            //dump('error champs invalides');
            return $this->redirectToRoute('notfound');
        }

    }

    public function deleteAction(Request $request,$id)
    {
        $usr= $this->container->get('security.token_storage')->getToken()->getUser();
        $annonce = $this->getDoctrine()->getRepository(Annonce::class)->find($id);
//        dump($annonce);
//        dump($usr);
//        if($annonce!=null and $usr!='anon.'){
//        dump($annonce->getIdu()->getId());
//        dump($usr->getId());
//        if($usr->getRoles()[0]=='ROLE_ADMIN' or $usr->getId()==$annonce->getIdu()->getId()) {dump('success');}else{dump('error');}
//        }
//        die();
        if($annonce!=null and $usr!='anon.'){
        if(($usr->getRoles()[0]=='ROLE_ADMIN' or $usr->getId()==$annonce->getIdu()->getId())) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($annonce);
            $em->flush();
            return $this->listAction($request);
        }else{
            //redirect error page
            //dump('error champs invalides');
            return $this->redirectToRoute('notfound');
        }

        }else{
            //redirect error page
            //dump('error champs invalides');
            return $this->redirectToRoute('notfound');
        }
    }

    public function signalAction(Request $request,$id,$cause)
    {
        $signal=new Signaler();
        $annonce=$this->getDoctrine()->getRepository(Annonce::class)->find($id);
        $usr= $this->container->get('security.token_storage')->getToken()->getUser();
        if($annonce!=null and $usr!='anon.'){
        if(   $cause=='Contenu indésirable' or $cause=='Harcèlement' or $cause=='Discours haineux'  or $cause=='Nudité' or $cause=='Violence' or $cause=='Autre' and  $annonce!=null){
            //persist
            $signal->setIda($annonce);
            $signal->setCause($cause);
            $em=$this->getDoctrine()->getManager();
            $em->persist($signal);
            $em->flush();
            return $this->listAction($request);
        }else{
            //redirect error page
            //dump('error champs invalides');
            return $this->redirectToRoute('notfound');
        }}else{
            //redirect error page
            //dump('error champs invalides');
            return $this->redirectToRoute('notfound');
        }




    }


    public function rechercheCategorieAction($categorie,Request $request)
    {
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->findCategorieActive($categorie);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $annonces, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $this->render('@VeloAnnonce/user/listAnnonce.html.twig', array( 'annonces'=>$pagination));
    }

    public function rechercheTypeVeloAction($typeVelo,Request $request)
    {
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->findTypeVeloActive($typeVelo);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $annonces, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $this->render('@VeloAnnonce/user/listAnnonce.html.twig', array( 'annonces'=>$pagination));
    }

    public function triPrixAction($choix,Request $request)
    {
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->triPrixActive($choix);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $annonces, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $this->render('@VeloAnnonce/user/listAnnonce.html.twig', array( 'annonces'=>$pagination));
    }

    public function triDateAction(Request $request)
    {
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->triDateActive();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $annonces, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $this->render('@VeloAnnonce/user/listAnnonce.html.twig', array( 'annonces'=>$pagination));
    }

    public function rechercheAction($recherche,Request $request)
    {
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->rechercheActive($recherche);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $annonces, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $this->render('@VeloAnnonce/user/listAnnonce.html.twig', array( 'annonces'=>$pagination));
    }

    public function rechercheTypeAction($type,Request $request)
    {
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->rechercheTypeActive($type);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $annonces, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $this->render('@VeloAnnonce/user/listAnnonce.html.twig', array( 'annonces'=>$pagination));
    }

    public function sendMail($name,$titre,$date,$email,\Swift_Mailer $mailer)
    {
//        Velo\AnnonceBundle\Ressources\views\Emails\addAnnonceEmail.html.twig

        $message = (new \Swift_Message('Confirmation d\'Ajout'))
            ->setFrom('pidevtest2020@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    '@VeloAnnonce/Emails/addAnnonceEmail.html.twig',
                    ['name' => $name,'titre' => $titre, 'date' => $date]
                ),
//                'hah',
                'text/html'
            )

            // you can remove the following code if you don't define a text version for your emails
//            ->addPart(
//                $this->renderView(
//                    'Emails/registration.txt.twig',
//                    ['name' => $name]
//                ),
//                'text/plain'
//            )
        ;

        $mailer->send($message);

        // or, you can also fetch the mailer service this way
        // $this->get('mailer')->send($message);

//        return $this->render(...);
    }
}

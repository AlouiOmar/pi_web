<?php

namespace Velo\AnnonceBundle\Controller;

use AppBundle\Entity\Annonce;
use AppBundle\Entity\Signaler;
use AppBundle\Entity\User;
use AppBundle\Form\AnnonceType;
use AppBundle\Form\EditAnnonceType;
use AppBundle\Form\ProfileType;
use AppBundle\Form\ProfileTypeextends;
use AppBundle\Form\RegistrationType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use FOS\UserBundle\Form\Type\ProfileFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;


class AdminAnnonceController extends Controller
{
    public function indexAction()
    {
        return $this->render('@VeloAnnonce/admin/adminListAnnonce.html.twig');
    }



    public function listAction()
    {
        $user=$this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('@VeloAnnonce/admin/listUser.html.twig',array('user'=>$user));
    }

    public function deleteAction($id)
    {
        $userco= $this->container->get('security.token_storage')->getToken()->getUser();
        $user=$this->getDoctrine()->getRepository(User::class)->find($id);
        //dump($user);
        if($user!=null){
        if($userco!='anon.' and  $user->getId()!=$userco->getId()){
//            dump($user->getId());
//            dump($userco->getId());
//            dump('delete success');
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            return $this->listAction();
        }else{
//            dump($user->getId());
//            dump($userco->getId());
//            dump('delete error');
            $this->redirectToRoute('notfound');
        }}else{
//            dump('user not found');
            $this->redirectToRoute('notfound');

        }
//        die();

//        return $this->render('@VeloAnnonce/admin/listUser.html.twig',array('user'=>$user));
    }

    public function editAction(Request $request,$id)
    {
        $user=$this->getDoctrine()->getRepository(User::class)->find($id);
        $photo=$user->getPhot();
        $form=$this->createForm(ProfileType::class,$user);
        $form ->add('roles', ChoiceType::class, array('constraints' => [new NotBlank(),],
            'attr' => array(
                'class' => 'gg',
                'required' => false,
            ),
            'multiple' => true,
            'expanded' => true, // render check-boxes
            'choices' => [
                'admin' => 'ROLE_ADMIN',
                'user' => 'ROLE_USER',
            ]
        ))
            ->add('Valider',SubmitType::class,
            ['attr'=>['formnovalidate'=>'formnovalidate','class'=>'form-control btn btn-primary','id'=>'a']]);
        $form->handleRequest($request);

        if ($form ->isSubmitted() and $form->isValid())
        {
            $file=$form['photo']->getData();
            if($file!=null){
                $newImageName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('user_image'),$newImageName);
                $user->setPhoto($newImageName);
            }else{
                $user->setPhoto($photo);
            }
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->listAction();
        }
        return $this->render('@VeloAnnonce/admin/editUser.html.twig',array('form'=>$form->createView()));
    }

    public function addAction(Request $request)
    {
        $user=new User();
        $form=$this->createForm(RegistrationType::class,$user);
//        $form ->add('Valider',SubmitType::class,
//            ['attr'=>['formnovalidate'=>'formnovalidate','class'=>'form-control btn btn-primary','id'=>'a']]);
        $form->handleRequest($request);

        if ($form ->isSubmitted() and $form->isValid())
        {
            $file=$form['photo']->getData();
            if($file!=null){
                $newImageName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('user_image'),$newImageName);
                $user->setPhoto($newImageName);
            }else{
                dump('no file');
            }
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->listAction();
        }
        return $this->render('@VeloAnnonce/admin/addUser.html.twig',array('form'=>$form->createView()));
    }



    public function profileAction($id)
    {
        $user=$this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render('@VeloAnnonce/admin/profile.html.twig',array('user'=>$user));
    }


    public function listAnnonceAction()
    {
        $annonces=$this->getDoctrine()->getRepository(Annonce::class)->findAll();
        return $this->render('@VeloAnnonce/admin/listAnnonce.html.twig',array('annonces'=>$annonces));
    }

    public function afficheAnnonceAction($id)
    {
//        die();
        $annonce=$this->getDoctrine()->getRepository(Annonce::class)->find($id);
         $causes=$this->getDoctrine()->getRepository(Signaler::class)->findCause($id);

        return $this->render('@VeloAnnonce/admin/afficheAnnonce.html.twig',array('annonce'=>$annonce,'causes'=>$causes));
    }

    public function addAnnonceAction(Request $request)
    {
//        $usr= $this->container->get('security.token_storage')->getToken()->getUser();
        $date=new \DateTime();
        $date1=(new \DateTime())->format('Y-m-d');
        dump($date1);
        //die();

            $annonce= new  Annonce();
            $form=$this->createForm(AnnonceType::class,$annonce);
            $form->add('idu',null, array('constraints' => [new NotBlank(),]))
                ->add('Valider',SubmitType::class,
                    ['attr'=>['formnovalidate'=>'formnovalidate','class'=>'form-control btn btn-primary','id'=>'a']]);;
            $form->handleRequest($request);
            //dump($usr->getId());
            if ($form ->isSubmitted() and $form->isValid())
            {
                $file=$form['photo']->getData();
                $newImageName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('annonce1_image'),$newImageName);
                $annonce->setPhoto($newImageName);
//                $annonce->setIdu($usr);
                $annonce->setDatep($date);
                dump($annonce);
//            die();
                $em=$this->getDoctrine()->getManager();
                $em->persist($annonce);
                $em->flush();
                return $this->redirectToRoute('velo_admin_list_annonce');
            }

            return $this->render("@VeloAnnonce/admin/addAnnonce.html.twig",array("form"=>$form->createView()));

    }

    public function editAnnonceAction(Request $request,$id)
    {
        $usr= $this->container->get('security.token_storage')->getToken()->getUser();
        $date=new \DateTime();
        $date1=(new \DateTime())->format('Y-m-d');
        dump($date1);
        //die();

        $annonce= $this->getDoctrine()->getRepository(Annonce::class)->find($id);
        $photo=$annonce->getPhot();
        $form=$this->createForm(EditAnnonceType::class,$annonce);
        $form->add('idu')
            ->add('Valider',SubmitType::class,
                ['attr'=>['formnovalidate'=>'formnovalidate','class'=>'form-control btn btn-primary','id'=>'a']]);;
        $form->handleRequest($request);
        //dump($usr->getId());
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
            dump($annonce);
//            die();
            $em=$this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('velo_admin_list_annonce');
        }

        return $this->render("@VeloAnnonce/admin/addAnnonce.html.twig",array("form"=>$form->createView()));

    }
    public function deleteAnnonceAction($id)
    {
//        $usr= $this->container->get('security.token_storage')->getToken()->getUser();
        $annonce = $this->getDoctrine()->getRepository(Annonce::class)->find($id);
//        dump($annonce);
//        dump($usr);
//        if($annonce!=null and $usr!='anon.'){
//        dump($annonce->getIdu()->getId());
//        dump($usr->getId());
//        if($usr->getRoles()[0]=='ROLE_ADMIN' or $usr->getId()==$annonce->getIdu()->getId()) {dump('success');}else{dump('error');}
//        }
//        die();
        if($annonce!=null){


                $em = $this->getDoctrine()->getManager();
                $em->remove($annonce);
                $em->flush();
                return $this->listAnnonceAction();


        }else{
            //redirect error page
            //dump('error champs invalides');
            return $this->redirectToRoute('notfound');
        }
    }

    public function listAnnonceSignaleeAction()
    {
//        $annonces=$this->getDoctrine()->getRepository(Signaler::class)->findAllSignaled();
//        $count=$this->getDoctrine()->getRepository(Signaler::class)->countSignaled();
        $annonces=$this->getDoctrine()->getRepository(Signaler::class)->findCountSignaled();
//        $cause=$this->getDoctrine()->getRepository(Signaler::class)->findCause(10);


//
//        dump($cause);
//        $b=$a[0];
//        dump($a[0]);
//        dump($b);
//        die();
        return $this->render('@VeloAnnonce/admin/listAnnonceSignalee.html.twig',array('annonces'=>$annonces));
    }

    public function statAnnonceAction()
    {

        $ag=[
            ['Gouvernorat','Nombre']
        ];
        $annonce = $this->getDoctrine()->getRepository(Annonce::class)->findCountGouvernorat();
        for ( $i=0;$i<sizeof($annonce);$i++){

            array_push($ag,[$annonce[$i]['gouvernorat'],intval($annonce[$i]['nombre'])]);
//            dump($ag);
        }
        $pieChart1 = new PieChart();


        $pieChart1->getData()->setArrayToDataTable($ag);
        $pieChart1->getOptions()->setTitle('Nombre des annonces publiées par Gouvernorat');
        $pieChart1->getOptions()->setHeight(500);
        $pieChart1->getOptions()->setWidth('100%');
        $pieChart1->getOptions()->setIs3D(true);
        $pieChart1->getOptions()->getBackgroundColor('#ecf0f5');
        $pieChart1->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart1->getOptions()->getTitleTextStyle()->setColor('#3c8dbc');
        $pieChart1->getOptions()->getTitleTextStyle()->setItalic(false);
        $pieChart1->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart1->getOptions()->getTitleTextStyle()->setFontSize(20);

        $at=[
            ['Type','Nombre']
        ];
        $annonce = $this->getDoctrine()->getRepository(Annonce::class)->findCountType();
        for ( $i=0;$i<sizeof($annonce);$i++){

            array_push($at,[$annonce[$i]['type'],intval($annonce[$i]['nombre'])]);
//            dump($at);
        }
        $pieChart2 = new PieChart();


        $pieChart2->getData()->setArrayToDataTable($at);
        $pieChart2->getOptions()->setTitle('Nombre des annonces publiées par Type');
        $pieChart2->getOptions()->setHeight(500);
        $pieChart2->getOptions()->setWidth('100%');
        $pieChart2->getOptions()->setIs3D(true);
        $pieChart2->getOptions()->getBackgroundColor('#ecf0f5');
        $pieChart2->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart2->getOptions()->getTitleTextStyle()->setColor('#3c8dbc');
        $pieChart2->getOptions()->getTitleTextStyle()->setItalic(false);
        $pieChart2->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart2->getOptions()->getTitleTextStyle()->setFontSize(20);


        $asc=[
            ['Cause','Nombre']
        ];
        $annonce = $this->getDoctrine()->getRepository(Signaler::class)->findCountSignaledCause();
        for ( $i=0;$i<sizeof($annonce);$i++){

            array_push($asc,[$annonce[$i]['cause'],intval($annonce[$i]['nombre'])]);
//            dump($at);
        }
        $pieChart3 = new PieChart();


        $pieChart3->getData()->setArrayToDataTable($asc);
        $pieChart3->getOptions()->setTitle('Nombre des annonces signalées par Cause');
        $pieChart3->getOptions()->setHeight(500);
        $pieChart3->getOptions()->setWidth('100%');
        $pieChart3->getOptions()->setIs3D(true);
        $pieChart3->getOptions()->getBackgroundColor('#ecf0f5');
        $pieChart3->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart3->getOptions()->getTitleTextStyle()->setColor('#3c8dbc');
        $pieChart3->getOptions()->getTitleTextStyle()->setItalic(false);
        $pieChart3->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart3->getOptions()->getTitleTextStyle()->setFontSize(20);


        $ascat=[
            ['Catégorie','Nombre']
        ];
        $annonce = $this->getDoctrine()->getRepository(Signaler::class)->findCountSignaledCategorie();
        for ( $i=0;$i<sizeof($annonce);$i++){

            array_push($ascat,[$annonce[$i]['categorie'],intval($annonce[$i]['nombre'])]);
//            dump($at);
        }
        $pieChart4 = new PieChart();


        $pieChart4->getData()->setArrayToDataTable($ascat);
        $pieChart4->getOptions()->setTitle('Nombre des annonces signalées par Catégorie');
        $pieChart4->getOptions()->setHeight(500);
        $pieChart4->getOptions()->setWidth('100%');
        $pieChart4->getOptions()->setIs3D(true);
        $pieChart4->getOptions()->getBackgroundColor('#ecf0f5');
        $pieChart4->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart4->getOptions()->getTitleTextStyle()->setColor('#3c8dbc');
        $pieChart4->getOptions()->getTitleTextStyle()->setItalic(false);
        $pieChart4->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart4->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('@VeloAnnonce/admin/statAnnonce.html.twig', array('piechart1' => $pieChart1,'piechart2' => $pieChart2,'piechart3' => $pieChart3,'piechart4' => $pieChart4));
    }


}

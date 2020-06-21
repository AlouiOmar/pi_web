<?php
namespace RentBundle\Controller;

use RentBundle\RentBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class AdminController extends Controller
{
    public function homeAction(Request $request)
    {
      //  if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
          //  throw $this->createNotFoundException('You are not allowed to access this page');
     //   }
    
        return $this->render('RentBundle:admin:dashebord.html.twig');
    

       /* if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->render('RentBundle:Admin:index.html.twig');
        }else{
            return $this->render('RentBundle:admin:dashebord.html.twig');
        }*/
    }

    public function locationAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) { 
            throw $this->createNotFoundException('You are not allowed to access this page');  
        }
        return $this->render('RentBundle:admin:location.html.twig') ;

         /* if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->render('RentBundle:location:location.html.twig');
        }else{
            return $this->render('RentBundle:location:location.html.twig');
        }*/
    }

    public function reservationAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) { 
            throw $this->createNotFoundException('You are not allowed to access this page');  
        }  
        return $this->render('RentBundle:admin:reservation.html.twig') ;

         /* if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->render('EcommerceBundle:Dashebord:index.html.twig');    
        }else{
            return $this->render('EcommerceBundle:Ecommerce:index.html.twig'); 
        }*/
    }
}

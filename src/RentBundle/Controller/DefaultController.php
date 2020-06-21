<?php

namespace RentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Home
     *
    */
    public function homeAction()
    {
        return $this->render('RentBundle:Default:index.html.twig');
    }

}

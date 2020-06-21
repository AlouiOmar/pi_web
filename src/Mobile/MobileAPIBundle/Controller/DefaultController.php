<?php

namespace Mobile\MobileAPIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MobileAPIBundle:Default:index.html.twig');
    }
}

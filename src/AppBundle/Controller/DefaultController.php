<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route("/annonce/404", name="notfound")
     */
    public function quatsentquatAction()
    {
        return $this->render("AppBundle::accessDenied.html.twig");
    }

    /**
     * @Route("/home", name="redirected")
     */
    public function redirectToHomeAction()
    {
        $authChecker = $this->container->get('security.authorization_checker');
        if($authChecker->isGranted('ROLE_ADMIN')){
            return $this->render('@VeloAnnonce/admin/adminListAnnonce.html.twig');
        }else if($authChecker->isGranted('ROLE_USER')){
            return $this->render('default/index.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            ]);
        }else{
            return $this->render('@FOSUser/Security/login.html.twig');
        }
    }


}

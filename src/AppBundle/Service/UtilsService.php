<?php
/**
 * Created by PhpStorm.
 * User: Aloui Omar
 * Date: 03/27/2020
 * Time: 20:28
 */

namespace AppBundle\Service;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UtilsService extends Controller
{

    private $mailer;
    private  $fromEmail;
    public function __construct(\Swift_Mailer $mailer,$fromEmail)
    {
        $this->mailer= $mailer;
        $this->fromEmail=$fromEmail;
    }


    public function sendMail($name)
    {
//        Velo\AnnonceBundle\Ressources\views\Emails\addAnnonceEmail.html.twig
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom($this->fromEmail)
            ->setTo('pidevtest2020@gmail.com')
            ->setBody(
//                $this->renderView(
//                // app/Resources/views/Emails/registration.html.twig
//                    'Velo\AnnonceBundle\Resources\views\Emails\addAnnonceEmail.html.twig',
//                    ['name' => $name]
//                ),
                'hah',
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

        $this->mailer->send($message);

        // or, you can also fetch the mailer service this way
        // $this->get('mailer')->send($message);

//        return $this->render(...);
    }

}
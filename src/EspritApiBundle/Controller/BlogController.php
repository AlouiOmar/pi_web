<?php

namespace EspritApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Post;
use BlogBundle\Entity\Commentaire;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use EspritApiBundle\Repository\PostRepository;
use Doctrine\ORM\EntityManager;



class BlogController extends Controller
{



    public function allpostAction()
    {
        $em = $this->getDoctrine()->getManager();
        $reservations =$em->getRepository('BlogBundle:Post')->findAll();

       $normalizer = new ObjectNormalizer();
         $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $reservationss=array();
        foreach ($reservations as $reservation) {

            $r=array("id"=>$reservation->getId(),
                    "title"=>$reservation->getTitle(),
                    "description"=>$reservation->getDescription(),
                    "photo"=>$reservation->getPhoto(),
                    "rating"=>$reservation->getRating(),
                 //    "postdate"=>$reservation->getPostdate(),
                 //   "datep"=>$reservation->getPostdate(),
                   // "nbr"=>$reservation->getNbrpost()
                  //  "nbrpost"=>$reservation->getNbrpost(),
                //    "creator"=>$reservation->getCreator()->getUsername()
                );
                   
                   
            array_push($reservationss,$r);

        }
        $formatted=$serializer->normalize($reservationss);
        return new JsonResponse($formatted);

    }


    public function listBlogClientMobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $blogs = $em->getRepository('EspritApiBundle:Post')->findBlog();
        $serializer= new Serializer(([new ObjectNormalizer()]));
        $formatted = $serializer->normalize($blogs);
        return new JsonResponse($formatted);

    }





    



    

    public function findpostAction(Request $request)
    {
        $recherche=$request->get('recherche');
        
        
        $posts=$this->getDoctrine()->getRepository('BlogBundle:Post')->recherche($recherche);
        dump($posts);
        dump($request->get('recherche'));
        die();

        
   
        
     /*   $qb = $posts->createQueryBuilder('b')
            ->where('b.title like :query or b.description like :query or b.rating like :query')
            ->setParameter('query','%'.$recherche.'%')
            ->getQuery();
      
            $postss = $qb->getResult();*/








   $normalizer = new ObjectNormalizer();
         $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $reservationss=array();
        foreach ($postss as $reservation) {

            $r=array("id"=>$reservation->getId(),
                    "title"=>$reservation->getTitle(),
                    "description"=>$reservation->getDescription(),
               //     "photo"=>$reservation->getPhoto(),
                    "rating"=>$reservation->getRating(),
                     //"postdate"=>$reservation->getPostdate(),
                 //   "datep"=>$reservation->getPostdate(),
                   // "nbr"=>$reservation->getNbrpost()
              //      "nbrpost"=>$reservation->getNbrpost()
         //      "creator"=>$reservation->getCreator()
                );
                   
                   
            array_push($reservationss,$r);

        }
        $formatted=$serializer->normalize($reservationss);
        return new JsonResponse($formatted);


    }









    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


    

   $user = $request->get('creator');
        $userr = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($user);           
            $post = new Post();
       //   $file=$post->getPhoto();
      //   $filename= md5(uniqid()).'.'.$file->guessExtension();
    //$file->move($this->getParameter('photos_directory'),$filename);
       $post->setPhoto($request->get('photo'));
          $post->setCreator($userr);
       //     $post->setNbrpost($post->getNbrpost()+1);
         //   $post->setPostdate(new \DateTime('now'));
         $post->setDescription($request->get('description'));
         $post->setTitle($request->get('title'));
         $post->setRating($request->get('rating'));
         
      $datenow=  new \DateTime();
    $post->setPostdate($datenow);
      //   $post->setPhoto($request->get('photo'));

            $em->persist($post);
            $em->flush();                               
     
            $normalizer = new ObjectNormalizer();
            $normalizer->setCircularReferenceLimit(2);
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });
            $normalizers = array($normalizer);
            $serializer = new Serializer($normalizers);
            $formatted = $serializer->normalize($post);
            return new JsonResponse($formatted);
    }

    public function updateAction(Request $request,Post $event)
    {

       // $editForm = $this->createForm('BlogBundle\Form\PostType', $event);
       // $editForm->handleRequest($request);
        $event->setTitle($request->get('title'));
//        $event->setDateE($request->get('dateE'));
        $event->setDescription($request->get('description'));
        $event->setRating($request->get('rating'));
     //   $event->setPhoto($request->get('photo'));
     //   $event->setNameC($request->get('nameC'));
     //   $event->setNbplaces($request->get('nbplaces'));
        $this->getDoctrine()->getManager()->flush();
        
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);


    }

    
    public function deleteAction($id,Request $request)
    { 
        $em = $this->getDoctrine()->getManager();
        $Post = $em->getRepository('BlogBundle:Post')->find($id);
        $em->remove($Post);
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($Post);
        return new JsonResponse($formatted);
    }




     public function showdetailedAction($id,Request $request)
    {

        $em= $this->getDoctrine()->getManager();
        $post=$em->getRepository('BlogBundle:Commentaire')->findby(['post'=>$id]);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $data = $serializer->normalize($post,null, ['attributes' => ['id','post'=>['id','title','description','rating']
    //    ,'user'=> ['id','username','username_canonical','email','email_canonical','enabled','salt','password','last_login','confirmation_token','password_requested_at','roles','first_name','telephone','age','idtrans']
        ,'content']]);
        
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($data);
        return new JsonResponse($formatted);
    }












































    public function commentsallAction()
    {
        $em = $this->getDoctrine()->getManager();
        $reservations =$em->getRepository('EspritApiBundle:Commentaire')->findAll();

       $normalizer = new ObjectNormalizer();
         $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $reservationss=array();
        foreach ($reservations as $reservation) {

            $r=array("id"=>$reservation->getId(),
                    "contenu"=>$reservation->getContent(),
                    "datecomment"=>$reservation->getPostedAt()
                 
                );
                   
                   
            array_push($reservationss,$r);

        }
        $formatted=$serializer->normalize($reservationss);
        return new JsonResponse($formatted);

    }
    




    public function addCommentAction(Request $request,$user,$id,$Con)
    { 

        $post = $this->getDoctrine()
            ->getRepository('BlogBundle:Post')
            ->find($id);

            $userr = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($user);
       
       

        $comment = new Commentaire();

        $comment->setUser($userr);
        $comment->setPost($post);
        $comment->setContent($Con);
        $datenow=  new \DateTime();
        $comment->setPostedAt($datenow);

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($comment);
        return new JsonResponse($formatted);



    }


    public function updatetcommentAction(Request $request,$id,$coment)
    {
        $em=$this->getDoctrine()->getManager();
        $transp=$em->getRepository('BlogBundle:Commentaire')->find($id);
      
            $transp->setContent($coment);
            $em->flush();
        
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($transp);
        return new JsonResponse($formatted);
    }



    public function deletecommentAction(Request $request,$id)
    {
        
        $em= $this->getDoctrine()->getManager();
        $comment=$em->getRepository('BlogBundle:Commentaire')->find($id);
        $em->remove($comment);
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted = $serializer->normalize($comment);
        return new JsonResponse($formatted);
        
    }



    

























    public function alluserAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users =$em->getRepository(User::class)->findAll();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $userss=array();
        foreach ($users as $user) {

            $r=array("id"=>$user->getId(),
//                     "firstname"=>$user->getFirstname(),
                     "username"=>$user->getUsername(),
              //     "password"=>$user->getPassword(),
                     "email"=>$user->getEmail(),
                     "role"=>$user->getRoles(),
                     "password"=>$user->getPassword()

                   
                   
                );
                   
                   
            array_push($userss,$r);

        }
        $formatted=$serializer->normalize($userss);
        return new JsonResponse($formatted);

    }


    public function deleteuserAction($id,Request $request)
    {
        
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('EspritApiBundle:User')->find($id);
        $em->remove($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user); 
        return new JsonResponse($formatted);
    }


    public function allcommentaireAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users =$em->getRepository("EspritApiBundle:Commentaire")->findAll();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $userss=array();
        foreach ($users as $user) {

            $r=array("idcommentaire"=>$user->getId(),
                     "content"=>$user->getContent()
                    // "description"=>$user->getPostedAt(),
                    //"post"=>$user->getPost()
                   
                );
                   
                   
            array_push($userss,$r);

        }
        $formatted=$serializer->normalize($userss);
        return new JsonResponse($formatted);

    }
    




}

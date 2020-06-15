<?php

namespace ProductBundle\Controller;

use ProductBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;

class ProduitMobileController extends Controller
{

    public function AddProdAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produit= new Produit();
        $t=$request->get('type');
        $type=$this->getDoctrine()->getManager()->getRepository(\ProductBundle\Entity\Typeproduit::class)->findOneBy(["libelleTp"=>$t]);
       $produit->setTypeP($type);

        $produit->setidP($request->get('idP'));
        $produit->setNomP($request->get('nomP'));
        $produit->setMarqueP($request->get('marqueP'));
        $produit->setCategorieP($request->get('categorieP'));
        $produit->setCouleurP($request->get('couleurP'));
        $produit->setPrixP($request->get('prixP'));
        $produit->setDate(new \DateTime());
        $produit->setPhotoP($request->get('photoP'));
        $produit->setTel($request->get('tel'));

        $userid=$this->getDoctrine()->getManager()->getRepository('UserBundle:User')->find($request->get('userid'));
        $produit->setId($userid);
        $em->persist($produit);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }






    public function showProdMobileAction(){
        $produit = $this->getDoctrine()->getRepository(\ProductBundle\Entity\Produit::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produit);
        return new JsonResponse($formatted);

    }


    public function ShowMobileSingleAction($idP,Request $request)
    {
        $produit = $this->getDoctrine()->getRepository('ProductBundle:Produit')->find($idP);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produit);
        return new JsonResponse($formatted);



    }


    public function deleteProdMobileAction($idP)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(\ProductBundle\Entity\Produit::class)->find($idP);

        $em->remove($prod);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($prod);
        return new JsonResponse($formatted);

    }





    public function updateProdMobileAction($idP, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(\ProductBundle\Entity\Produit::class)->find($idP);
        $prod->setidP($request->get('idP'));
        $prod->setNomP($request->get('nomP'));
        $prod->setMarqueP($request->get('marqueP'));
        $prod->setCategorieP($request->get('categorieP'));
        $prod->setCouleurP($request->get('couleurP'));
        $prod->setPrixP($request->get('prixP'));
        $prod->setTel($request->get('tel'));
        $em->persist($prod);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($prod);
        return new JsonResponse($formatted);
    }


    public function highPriceMobileAction()
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository(\ProductBundle\Entity\Produit::class)->findBy([], ['prixP' => 'DESC']);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rep);
        return new JsonResponse($formatted);
    }

    public function lowPriceMobileAction()
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository(\ProductBundle\Entity\Produit::class)->findBy([], ['prixP' => 'ASC']);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rep);
        return new JsonResponse($formatted);
    }



    public function showTypeProdMobileAction(){
        $produit = $this->getDoctrine()->getRepository(\ProductBundle\Entity\Typeproduit::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produit);
        return new JsonResponse($formatted);

    }





    public function addPanierMobileAction($idP, SessionInterface $session)
    {
        // $session=$request->getSession();
        $panier = $session->get('panier', []);
        if (!empty($panier [$idP])) {
            $panier[$idP]++;
        } else {
            $panier[$idP] = 1;
        }

        $session->set('panier', $panier);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($session);
        return new JsonResponse($formatted);


    }





    public function AffichePanierMobileAction(SessionInterface $session)
    {
        $cart = $session->get('panier', []);
        $cartWithData = [];
        foreach ($cart as $idP => $quantity) {
            $cartWithData[] = [
                'product' => $this->getDoctrine()->getRepository('ProductBundle:Produit')->find($idP),
                'quantity' => $quantity];

        }
        dump($cartWithData);
        $total=0;
        foreach ($cartWithData as $item){
            $totalItem=$item['product']->getPrixP() * $item['quantity'];
            $total+=$totalItem;
        }
        return $this->render('@Product/Client/index.html.twig',['items' => $cartWithData ,'total'=>$total]);


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($cartWithData);
        $formatted=$serializer->normalize($total);
        return new JsonResponse($formatted);

    }



    public function RemovePanierMobileAction($idP, SessionInterface $session){
        $panier =$session->get('panier',[]);
        if(!empty($panier[$idP])){
            unset($panier[$idP]);

        }
        $session->set('panier',$panier);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($session);
        return new JsonResponse($formatted);

    }





    public function LoginMobileAction($email){
        $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(array('email'=>$email));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($user);
        return new JsonResponse($formatted);

    }

    public function showUserMobileAction(){
        $user = $this->getDoctrine()->getRepository(\UserBundle\Entity\User::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($user);
        return new JsonResponse($formatted);

    }





    public function loginUserAction (Request $request)
    {
        $username=$request->get('username');
        $user=$this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findOneBy(array('username'=>$username));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }






}

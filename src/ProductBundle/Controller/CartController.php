<?php

namespace ProductBundle\Controller;

use mysql_xdevapi\Session;
use ProductBundle\Entity\Typeproduit;
use ProductBundle\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use ProductBundle\ProductBundle;
use ProductBundle\Form\TypeproduitType;
use Symfony\Component\HttpFoundation\JsonResponse;


class CartController extends Controller
{
    public function indexAction(SessionInterface $session)
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
    }


    public function addAction($idP, SessionInterface $session)
    {
        // $session=$request->getSession();
        $panier = $session->get('panier', []);
        if (!empty($panier [$idP])) {
            $panier[$idP]++;
        } else {
            $panier[$idP] = 1;
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute("cart_aff");
    }


    public function removeAction($idP, SessionInterface $session){
        $panier =$session->get('panier',[]);
        if(!empty($panier[$idP])){
            unset($panier[$idP]);

        }
        $session->set('panier',$panier);
        return $this->redirectToRoute("cart_aff");
    }


    public function validateAction(SessionInterface $session){

        $cart = $session->get('panier', []);
        $cartWithData = [];
        foreach ($cart as $idP => $quantity) {
            $cartWithData[] = [
                'product' => $this->getDoctrine()->getRepository('ProductBundle:Produit')->find($idP),
                'quantity' => $quantity];

        }
        $total=0;
        foreach ($cartWithData as $item){
            $totalItem=$item['product']->getPrixP() * $item['quantity'];
            $total+=$totalItem;
        }
        $snappy=$this->get("knp_snappy.pdf");
        $fileName="My Cart";
        return new Response(
            $snappy->getOutputFromHtml($this->renderView("@Product/Client/pdf.html.twig", array(
                'items' => $cartWithData, 'total' => $total

            ))),
            200,
            array(
                'Content-Type'=> 'application/pdf',
                'Content-Disposition' =>'inline; filename="'.$fileName.'.pdf"'
            )
        );


    }

}

<?php

namespace ProductBundle\Controller;


use ProductBundle\Entity\Typeproduit;
use ProductBundle\Entity\Produit;
use ProductBundle\ProductBundle;
use ProduitBundle\Entity\CategoryProduit;
use ProduitBundle\Form\CategoryProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ProductBundle\Form\ProduitType;
use ProductBundle\Form\TypeproduitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use ProductBundle\Entity\Util;
use ProductBundle\Entity\Inutil;
use ProductBundle\Entity\Promotion;

class ProduitController extends Controller
{

    public function createAction(Request $request)
    {
      $user=$this->getUser();
        $produit = new Produit();
        $produit->setId($user);
        $form = $this->createForm('ProductBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);
        if ($form->isValid()) {
            //var_dump($request->files->get('productbundle_produit')['imageName']);
            $file=$request->files->get('productbundle_produit')['imageName'];
            //var_dump($file);
            $uploads_directory=$this->getParameter('uploads_directory');

            $fileName = $file->getClientOriginalName();
            //var_dump($fileName);

            $file->move(
                $uploads_directory,$fileName
            );
            $produit->setPhotoP($fileName);
            $produit->setDate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            echo "<script> alert(\" Produit ajouté avec succès \")</script>";
        }

        return $this->render('@Product/Admin/ajouterProduit.html.twig', array('form' => $form->createView()));
        $this->addFlash("success", "projet creer avec succee");

}

    public function create2Action(Request $request)
    {
        $user=$this->getUser();

        $produit = new Produit();
        $produit->setId($user);
        $form = $this->createForm('ProductBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);
        if ($form->isValid()) {
            //var_dump($request->files->get('productbundle_produit')['imageName']);
            $file=$request->files->get('productbundle_produit')['imageName'];
            //var_dump($file);
            $uploads_directory=$this->getParameter('uploads_directory');

            $fileName = $file->getClientOriginalName();
            //var_dump($fileName);

            $file->move(
                $uploads_directory,$fileName
            );
            $produit->setPhotoP($fileName);
            $produit->setDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            echo "<script> alert(\" Produit ajouté avec succès \")</script>";
        }

        return $this->render('@Product/Client/ajouterProduit.html.twig', array('form' => $form->createView()));
        $this->addFlash("success", "projet creer avec succee");

    }

    public function showProduitAction(Request $request)
    {
        $produits = $this->getDoctrine()->getRepository(\ProductBundle\Entity\Produit::class)->findAll();

        return $this->render('@Product/Admin/afficheProduitAdmin.html.twig', array('produits' => $produits));

    }

    public function deleteProdAction($idP)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository("ProductBundle:Produit")->find($idP);
        $em->remove($prod);
        $em->flush();
        return $this->redirectToRoute("showProd");

    }

    public function updateProdAction($idP, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(\ProductBundle\Entity\Produit::class)->find($idP);
        $f = $this->createForm(\ProductBundle\Form\ProduitType::class, $prod);

        $f = $f->handleRequest($request);
        if ($f->isValid()) {

            $file = $request->files->get('productbundle_produit')['imageName'];
            //var_dump($file);
            $uploads_directory = $this->getParameter('uploads_directory');

            $fileName = $file->getClientOriginalName();

            //var_dump($fileName);


            $file->move(
                $uploads_directory, $fileName
            );
            $prod->setPhotoP($fileName);
            $prod->setDate(date_create());
            $em = $this->getDoctrine()->getManager();
            $em->persist($prod);
            $em->flush();
            echo "<script> alert(\" Produit modifié avec succès \")</script>";
            return $this->redirectToRoute('showProd');
        }


        return $this->render('@Product/Admin/modifierProduitAdmin.html.twig', array('f' => $f->createView()));
    }



    public function createCategAction(Request $request)
    {
        $Categ = new Typeproduit();
        $f = $this->createForm(TypeproduitType::class, $Categ);
        $f = $f->handleRequest($request);
        if ($f->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Categ);
            $em->flush();
        }
        return $this->render('@Product/Admin/ajouterCategory.html.twig', array('f' => $f->createView()));
    }


    public function showCategoryProduitAction()
    {
        $produits = $this->getDoctrine()->getRepository(Typeproduit::class)->findAll();

        return $this->render('@Product/Admin/afficheCategoryProduitAdmin.html.twig', array('categorys' => $produits));
    }

    public function deleteCategProdAction($idTp)
    {
        $em = $this->getDoctrine()->getManager();
        $categ = $em->getRepository("ProductBundle:Typeproduit")->find($idTp);
        $em->remove($categ);
        $em->flush();

        return $this->redirectToRoute("showCategProd");
    }



    public function annulerAction($idP){
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository("ProductBundle:Produit")->find($idP);
        $em->remove($produits);
        $em->flush();


            return $this->redirectToRoute('showProd');
        }

    public function annulerClientAction($idP){
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository("ProductBundle:Produit")->find($idP);
        $em->remove($produits);
        $em->flush();


        return $this->redirectToRoute('showProdClient');
    }


    public function showHistoryProduitAction()
    {
        $produits = $this->getDoctrine()->getRepository(\ProductBundle\Entity\Produit::class)->findAll();
        return $this->render('@Product/Admin/afficheHistoryProduitAdmin.html.twig', array('produits' => $produits));

    }



    public function showProduitClientAction(Request $request)
    {
        $produits = $this->getDoctrine()->getRepository('ProductBundle:Produit')->findAll();
//        dump($produits);
//        die();
        $paginator = $this->get('knp_paginator');
        $resultt = $paginator->paginate(
            $produits,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)

        );

        return $this->render('@Product/Client/afficheProduit.html.twig', array('produits' => $resultt));

    }

    public function showProduitClientSingleAction($idP,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(\ProductBundle\Entity\Produit::class)->find($idP);
        $f = $this->createForm(\ProductBundle\Form\ProduitType::class, $prod);

        $f = $f->handleRequest($request);
        if ($f->isValid()) {

            $file = $request->files->get('productbundle_produit')['imageName'];
            //var_dump($file);
            $uploads_directory = $this->getParameter('uploads_directory');

            $fileName = $file->getClientOriginalName();

            //var_dump($fileName);


            $file->move(
                $uploads_directory, $fileName
            );
            $prod->setPhotoP($fileName);
            $prod->setDate(date_create());
            $em = $this->getDoctrine()->getManager();
            $em->persist($prod);
            $em->flush();
            echo "<script> alert(\" Produit modifié avec succès \")</script>";
        }


        return $this->render('@Product/Client/showSingle.html.twig', array('f' => $f->createView()));

        $this->addFlash("success", "Produit modifié avec succès");

    }




    public function updateClientAction($idP,Request $request)
    {
        $produits = $this->getDoctrine()->getRepository('ProductBundle:Produit')->find($idP);

        return $this->render('@Product/Client/updateProduit.html.twig', array('produits' => $produits));

    }


    public function highAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('ProductBundle:Produit')->findBy([], ['prixP' => 'DESC']);

        $paginator = $this->get('knp_paginator');
        $resultt = $paginator->paginate(
            $rep,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)

        );

        return $this->render( '@Product/Client/afficheProduit.html.twig', array('produits'=> $resultt));
    }
    public function lowAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('ProductBundle:Produit')->findBy([], ['prixP' => 'ASC']);

        $paginator = $this->get('knp_paginator');
        $resultt = $paginator->paginate(
            $rep,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)

        );


        return $this->render( '@Product/Client/afficheProduit.html.twig', array('produits'=> $resultt));
    }

}

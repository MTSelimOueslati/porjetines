<?php

namespace ShoppingCartBundle\Controller;

use ShoppingCartBundle\Entity\Shoppingcart;
use ShoppingCartBundle\Entity\Velovendre;
use ShoppingCartBundle\Form\ShoppingcartType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ShoppingCartController extends Controller
{
    public function afficherAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $cart = $em->getRepository('ShoppingCartBundle:Velovendre')->findAll();


        return $this->render('@ShoppingCart/ShoppingCart/cart.html.twig', array(
            'ShoppingCart' => $cart,
        ));
    }

    public function addAction(Request $request)
    {
        //1-preparation objet vide
        $cart=new Shoppingcart();
        $em=$this->getDoctrine()->getManager();




            //6-creation entity mannager


            $cart->setAmmount(0);

            //7-sauvgarder les donnes dans orm
            $em->persist($cart);
            //8-sauvgarde les donne dans la base de donne
            $em->flush();


        //envoi de notre formaulire au utilisateur
        return $this->render('@ShoppingCart/ShoppingCart/add.html.twig'
        );




        }

    public function AffichAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Velovendre::class)->findAll();

        return $this->render('@ShoppingCart/ShoppingCart/cart.html.twig',array(
            'produit' => $produit,
        ));


    }

    public function Affich2Action()
    {
        $em = $this->getDoctrine()->getManager();
        $sh = $em->getRepository(Shoppingcart::class)->findAll();

        return $this->render('@ShoppingCart/ShoppingCart/show2.html.twig',array(
            'sh' => $sh,
        ));


    }


    public function createAction(Request $request)
    {
        $shopping = new Shoppingcart();
        $form = $this->createForm(ShoppingcartType::class, $shopping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();


            $em->persist($shopping);
            $em->flush();

            return $this->redirectToRoute('show2');

        }
        return $this->render('@ShoppingCart/ShoppingCart/add.html.twig', array(
            'f' => $form->createView(),

        ));


    }

    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $sh = $em->getRepository(Shoppingcart::class)->find($id);
        $em->remove($sh);
        $em->flush();
        return $this->redirectToRoute("show2");
    }



    public function allAction(){
        $cart= $this->getDoctrine()->getManager()
            ->getRepository('ShoppingCartBundle:Shoppingcart')->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($cart);
        return new JsonResponse($formatted);
    }

    public function newAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $cart=new Shoppingcart();


        $cart->setAmmount($request->get('ammount'));

       
        $em->persist($cart);
        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($cart);
        return new JsonResponse($formatted);
    }









}
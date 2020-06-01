<?php

namespace ShoppingCartBundle\Controller;

use ShoppingCartBundle\Entity\Bill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BillController extends Controller
{
    public function afficherAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();

        $bill = $em->getRepository('ShoppingCartBundle:Bill')->findAll();


        return $this->render('@ShoppingCart/ShoppingCart/bill.html.twig', array(
            'Bill' => $bill,
        ));
    }

    public function allAction(){
        $bill= $this->getDoctrine()->getManager()
            ->getRepository('ShoppingCartBundle:Bill')->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($bill);
        return new JsonResponse($formatted);
    }

    public function newAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $bill=new Bill();
        $bill->setAmmount($request->get('ammount'));
        $bill->setName($request->get('name'));
        $bill->setLastName($request->get('lastName'));


        $em->persist($bill);
        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($bill);
        return new JsonResponse($formatted);
    }


}

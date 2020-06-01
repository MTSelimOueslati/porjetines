<?php

namespace ShoppingCartBundle\Controller;

use ShoppingCartBundle\Entity\Velovendre;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class VelovendreController extends Controller
{

    public function allAction(){
        $velo= $this->getDoctrine()->getManager()
            ->getRepository('ShoppingCartBundle:Velovendre')->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($velo);
        return new JsonResponse($formatted);
    }

    public function newAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $velo=new Velovendre();
        $velo->setPrice($request->get('price'));
        $velo->setMarque($request->get('marque'));
        $velo->SetNombre($request->get('nombre'));
        $velo->setPathPhoto($request->get('pathPhoto'));
        $em->persist($velo);
        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($velo);
        return new JsonResponse($formatted);
    }


}

<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Impressions;
use App\Entity\User;
use App\Form\ImpressionsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImpressionsController extends AbstractController
{
    /**
     * @Route("/impression/suppr/{id}", name="impression_suppr")
     */
    public function suppr(EntityManagerInterface $em, $id, Impressions $impression): Response
    {
        if($impression){
            $id = $impression->getFilm()->getId();
            $em->remove($impression);
            $em->flush();
            return $this->redirectToRoute('show_film', ['id'=>$id]);
        }

    return $this->redirectToRoute('films');

    }


    /**
     * @Route("/impression/new/{id}", name="impression_new")
     */
    public function new(Request $req, EntityManagerInterface $em, Film $film, Impressions $impression, $id):Response
    {
      
        $impression = new Impressions();

        $form = $this->createForm(ImpressionsType::class , $impression);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {   
            $impression->getFilm->$this->setUser($this->getUser());
            $impression = $form->getData();
            $impression->setCreatedAt(new \DateTime());
            $impression->setFilm($film);

            $em->persist($impression);
            $em->flush();
            return $this->redirectToRoute('show_film', ['id'=>$impression->getFilm()->getId()]);
        }
        return $this->redirectToRoute('films');
    }

    /**
     * @Route("/impression/change/{id}", name="impression_change")
     */
    public function change(Impressions $impression, Request $req, EntityManagerInterface $em)
    {
        $formulaire = $this->createForm(ImpressionsType::class, $impression);

        $formulaire->handleRequest($req);
        if($formulaire->isSubmitted() && $formulaire->isValid())
        {   
            $em->persist($impression);
            $em->flush();
            return $this->redirectToRoute("show_film", ['id'=>$impression->getFilm()->getId()]);
        }
        return $this->renderForm('impressions/change.html.twig', ['form'=> $formulaire]);
    }

}

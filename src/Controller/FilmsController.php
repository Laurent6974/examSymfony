<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmsType;
use App\Entity\Impressions;
use App\Form\ImpressionsType;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmsController extends AbstractController
{
    /**
     * @Route("/", name="films")
     */
    public function index(FilmRepository $repo): Response
    {
        return $this->render('films/index.html.twig', [
            'films' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/show/film/{id}", name="show_film")
     */
    public function show(Film $film): Response
    {   
        $impression = new Impressions;

        $formulaire = $this->createForm(ImpressionsType::class, $impression);

        return $this->renderForm('films/show.html.twig', [
            'film' => $film,
            'form' => $formulaire
        ]);
    }

    /**
     * @Route ("/film/new", name="new_film", priority="2")
     * 
     * @return Response
     */
    public function new(Request $req, EntityManagerInterface $em):Response
    {
      
        $film = new Film();

        $form = $this->createForm(FilmsType::class , $film);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {   
            $film->setCreatedAt(new \DateTime());
            $film = $form->getData();

            $em->persist($film);
            $em->flush();
            return $this->redirectToRoute('films');

        };

        return $this->renderForm('films/new.html.twig', ["formulaire"=> $form]);

    }

    /**
     * @Route ("/film/edit/{id}", name="edit_film", priority="2")
     * 
     * @return Response
     */
    public function change(Request $req, EntityManagerInterface $em, FilmRepository $repo, $id):Response
    {
      
        $film = $repo->find($id);

        $form = $this->createForm(FilmsType::class , $film);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $film = $form->getData();

            $em->persist($film);
            $em->flush();
            return $this->redirectToRoute('films');

        };

        return $this->renderForm('films/new.html.twig', ["formulaire"=> $form]);
    }

    /**
     * @Route ("/film/suppr/{id}", name="suppr_film" , priority="1")
     * 
     * @return Response
     */
    public function suppr(Film $chaussure = null,EntityManagerInterface $em):Response
    {
        if($chaussure){

        $em->remove($chaussure);
        $em->flush();

        }

        return $this->redirectToRoute('films');

    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProStageController extends AbstractController
{
    /**
    * @Route("/", name="pro_stage_accueil")
    */
    public function index(): Response
    {
        return $this->render('pro_stage/index.html.twig');
    }

    /**
    * @Route("/entreprises", name="pro_stage_entreprises")
    */
    public function entreprises(): Response
    {
      return $this->render('pro_stage/entreprises.html.twig');
    }

    /**
    * @Route("/formations", name="pro_stage_formations")
    */
    public function formations(): Response
    {
      return $this->render('pro_stage/formations.html.twig');
    }

    /**
    * @Route("/stages/{id}", name="pro_stage_stages")
    */
    public function stages($id): Response
    {
      return new Response('Cette page affichera le descriptif du stage ayant pour identifiant ' . $id);
    }
}

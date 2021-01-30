<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;
use App\Repository\StageRepository;

class ProStageController extends AbstractController
{
    /**
    * @Route("/", name="pro_stage_accueil")
    */
    public function index(StageRepository $repositoryStage): Response
    {
      // Récupérer le repository de l'entité Stage
      //$repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

      // Récupérer les stages enregistrés en BD
      $stages = $repositoryStage->findByDateDepot();

      // Envoyer les stages récupérés à la vue chargée de les afficher
      return $this->render('pro_stage/index.html.twig', ['stages' => $stages]);
    }

    /**
    * @Route("/entreprises", name="pro_stage_entreprises")
    */
    public function entreprises(EntrepriseRepository $repositoryEntreprise): Response
    {
      // Récupérer le repository de l'entité Entreprise
      //$repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

      // Récupérer les entreprises enregistrées en BD
      $entreprises = $repositoryEntreprise->findByNom();

      // Envoyer les entreprises récupérées à la vue chargée de les afficher
      return $this->render('pro_stage/entreprises.html.twig', ['entreprises' => $entreprises]);
    }

    /**
    * @Route("/formations", name="pro_stage_formations")
    */
    public function formations(FormationRepository $repositoryFormation): Response
    {
      // Récupérer le repository de l'entité Formation
      //$repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

      // Récupérer les formations enregistrées en BD
      $formations = $repositoryFormation->findByNom();

      // Envoyer les formations récupérées à la vue chargée de les afficher
      return $this->render('pro_stage/formations.html.twig', ['formations' => $formations]);
    }

    /**
    * @Route("/stages/{id}", name="pro_stage_stage")
    */
    public function afficherStage(Stage $stage): Response
    {
      // Récupérer le repository de l'entité Stage
      //$repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

      // Récupérer les stages enregistrés en BD
      //$stage = $repositoryStage->find($id);

      // Envoyer les stages récupérés à la vue chargée de les afficher
      return $this->render('pro_stage/stage.html.twig',
      ['stage' => $stage]);
    }

    /**
    * @Route("/entreprise/{id}", name="pro_stage_stagesEntreprise")
    */
    public function afficherStagesEntreprise(StageRepository $repositoryStage, Entreprise $entreprise): Response
    {
      // Récupérer le repository de l'entité Stage
      //$repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

      // Récupérer les stages enregistrés en BD
      $stagesEntreprise = $repositoryStage->findByEntreprise($entreprise);

      // Envoyer les stages récupérés à la vue chargée de les afficher
      return $this->render('pro_stage/stagesEntreprise.html.twig',
      ['stagesEntreprise' => $stagesEntreprise, 'entreprise' => $entreprise]);
    }

    /**
    * @Route("/formation/{id}", name="pro_stage_stagesFormation")
    */
    public function afficherStagesFormation(StageRepository $repositoryStage, Formation $formation): Response
    {
      // Récupérer le repository de l'entité Stage
      //$repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

      // Récupérer les stages enregistrés en BD
      //$stagesFormation = $repositoryStage->findByFormation($id);

      // Envoyer les stages récupérés à la vue chargée de les afficher
      return $this->render('pro_stage/stagesFormation.html.twig',
      ['stagesFormation' => $formation->getStage(), 'formation' => $formation]);
    }
}

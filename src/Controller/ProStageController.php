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
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\EntrepriseType;
use App\Form\StageType;

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
      $stages = $repositoryStage->findByDateDepotDQL();

      // Envoyer les stages récupérés à la vue chargée de les afficher
      return $this->render('pro_stage/index.html.twig', ['stages' => $stages]);
    }

    /**
    * @Route("/entreprises/ajouter", name="pro_stage_ajoutEntreprise")
    */
    public function ajouterEntreprise(Request $request, ManagerRegistry $managerRegistry): Response
    {
      // Création d'une entreprise vierge qui sera remplie par le formulaire
      $entreprise = new Entreprise();

      // Création du formulaire permettant de saisir une entreprise
      $formulaireEntreprise = $this ->createForm(EntrepriseType::class, $entreprise);

      /*On demande au formulaire d'analyser la dernière requête http. Si le tableau POST (car le formulaire est transmis par le protocole POST) contenu de cette requête contient des variables nom, adresse et site alors la méthode handleRequest() récupère les valeurs de ces variables et les affecte à l'objet $entreprise */
      $formulaireEntreprise->handleRequest($request);

      // Traiter les données du formulaire s'il a été soumis
      if ($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
      {
        // Enregistrer l'entreprise en BD
        $manager = $managerRegistry->getManager();
        $manager->persist($entreprise);
        $manager->flush();

        // Rediriger l'utilisateur vers la page des entreprises
        return $this->redirectToRoute('pro_stage_entreprises');
      }

      // Création de la représentation graphique du $formulaireEntreprise
      $vueFormulaireEntreprise = $formulaireEntreprise->createView();

      // Afficher la page présentant le formulaire d'ajout d'une entreprise
      return $this->render('pro_stage/ajoutModifEntreprise.html.twig', ['vueFormulaireEntreprise' => $vueFormulaireEntreprise, 'action' => "ajouter"]);
    }

    /**
    * @Route("/entreprises/modifier/{id}", name="pro_stage_modifEntreprise")
    */
    public function modifierEntreprise(Request $request, ManagerRegistry $managerRegistry, Entreprise $entreprise): Response
    {
      // Création du formulaire permettant de modifier une entreprise
      $formulaireEntreprise = $this ->createForm(EntrepriseType::class, $entreprise);

      /*On demande au formulaire d'analyser la dernière requête http. Si le tableau POST (car le formulaire est transmis par le protocole POST) contenu de cette requête contient des variables nom, adresse et site alors la méthode handleRequest() récupère les valeurs de ces variables et les affecte à l'objet $entreprise */
      $formulaireEntreprise->handleRequest($request);

      // Traiter les données du formulaire s'il a été soumis
      if ($formulaireEntreprise->isSubmitted())
      {
        // Enregistrer l'entreprise en BD
        $manager = $managerRegistry->getManager();
        $manager->persist($entreprise);
        $manager->flush();

        // Rediriger l'utilisateur vers la page des entreprises
        return $this->redirectToRoute('pro_stage_entreprises');
      }

      // Création de la représentation graphique du $formulaireEntreprise
      $vueFormulaireEntreprise = $formulaireEntreprise->createView();

      // Afficher la page présentant le formulaire de modification d'une entreprise
      return $this->render('pro_stage/ajoutModifEntreprise.html.twig', ['vueFormulaireEntreprise' => $vueFormulaireEntreprise, 'action' => "modifier"]);
    }

    /**
    * @Route("/stages/ajouter", name="pro_stage_ajoutStage")
    */
    public function ajouterStage(Request $request, ManagerRegistry $managerRegistry): Response
    {
      // Création d'un stage vierge qui sera remplie par le formulaire
      $stage = new Stage();

      // Création du formulaire permettant de saisir un stage
      $formulaireStage = $this ->createForm(StageType::class, $stage);

      /*On demande au formulaire d'analyser la dernière requête http. Si le tableau POST (car le formulaire est transmis par le protocole POST) contenu de cette requête contient des variables alors la méthode handleRequest() récupère les valeurs de ces variables et les affecte à l'objet $stage */
      $formulaireStage->handleRequest($request);

      // Traiter les données du formulaire s'il a été soumis
      if ($formulaireStage->isSubmitted() && $formulaireStage->isValid())
      {
        // Mémoriser la date d'ajout du stagesEntreprise
        $stage->setDateDepot(new \dateTime());
        // Enregistrer le stage en BD
        $manager = $managerRegistry->getManager();
        $manager->persist($stage);
        $manager->flush();

        // Rediriger l'utilisateur vers la page d'accueil
        return $this->redirectToRoute('pro_stage_accueil');
      }

      // Création de la représentation graphique du $formulaireStage
      $vueFormulaireStage = $formulaireStage->createView();

      // Afficher la page présentant le formulaire d'ajout d'un stage
      return $this->render('pro_stage/ajoutModifStage.html.twig', ['vueFormulaireStage' => $vueFormulaireStage, 'action' => "ajouter"]);
    }

    /**
    * @Route("/stages/modifier/{id}", name="pro_stage_modifStage")
    */
    public function modifierStage(Request $request, ManagerRegistry $managerRegistry, Stage $stage): Response
    {
      // Création du formulaire permettant de modifier un stage
      $formulaireStage = $this ->createForm(StageType::class, $stage);

      /*On demande au formulaire d'analyser la dernière requête http. Si le tableau POST (car le formulaire est transmis par le protocole POST) contenu de cette requête contient des variables alors la méthode handleRequest() récupère les valeurs de ces variables et les affecte à l'objet $stage */
      $formulaireStage->handleRequest($request);

      // Traiter les données du formulaire s'il a été soumis
      if ($formulaireStage->isSubmitted())
      {
        // Enregistrer le stage en BD
        $manager = $managerRegistry->getManager();
        $manager->persist($stage);
        $manager->flush();

        // Rediriger l'utilisateur vers la page d'accueil'
        return $this->redirectToRoute('pro_stage_accueil');
      }

      // Création de la représentation graphique du $formulaireStage
      $vueFormulaireStage = $formulaireStage->createView();

      // Afficher la page présentant le formulaire de modification d'un stage
      return $this->render('pro_stage/ajoutModifStage.html.twig', ['vueFormulaireStage' => $vueFormulaireStage, 'action' => "modifier"]);
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
    * @Route("/entreprise/{nom}", name="pro_stage_stagesEntreprise")
    */
    public function afficherStagesEntreprise(StageRepository $repositoryStage, Entreprise $entreprise): Response
    {
      // Récupérer le repository de l'entité Stage
      //$repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

      // Récupérer les stages enregistrés en BD
      $stagesEntreprise = $repositoryStage->findByDateDepotEntreprise($entreprise);

      // Envoyer les stages récupérés à la vue chargée de les afficher
      return $this->render('pro_stage/stagesEntreprise.html.twig',
      ['stagesEntreprise' => $stagesEntreprise, 'entreprise' => $entreprise]);
    }

    /**
    * @Route("/formation/{nom}", name="pro_stage_stagesFormation")
    */
    public function afficherStagesFormation(StageRepository $repositoryStage, Formation $formation): Response
    {
      // Récupérer le repository de l'entité Stage
      //$repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

      // Récupérer les stages enregistrés en BD
      $stagesFormation = $repositoryStage->findByDateDepotFormationDQL($formation);

      // Envoyer les stages récupérés à la vue chargée de les afficher
      return $this->render('pro_stage/stagesFormation.html.twig',
      ['stagesFormation' => $stagesFormation, 'formation' => $formation]);
    }
}

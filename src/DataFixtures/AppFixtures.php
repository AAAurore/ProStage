<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Entity\User;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    // Création de deux utilisateurs de gmp_testbit
    $patrick = new User();
    $patrick->setPrenom("Patrick");
    $patrick->setNom("ETCHEVERRY");
    $patrick->setEmail("patrick@free.fr");
    $patrick->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
    $patrick->setPassword('$2y$10$f0K4AjZNwgfxMdTMl9qJo.QbwHWzjGTO1UpbHmS8JX9KhkIgOCOwa');
    $manager->persist($patrick);

    $pantxika = new User();
    $pantxika->setPrenom("Pantxika");
    $pantxika->setNom("DAGORRET");
    $pantxika->setEmail("pantxika@free.fr");
    $pantxika->setRoles(['ROLE_USER']);
    $pantxika->setPassword('$2y$10$y2HhS8AcvwMO8mQRERNG3OnlshnUepBYzdIUsKKcr7ICl3Rebdhce');
    $manager->persist($pantxika);

    // Création d'un générateur de données Faker en français
    $faker = \Faker\Factory::create('fr_FR');

    // Nombre d'entreprises
    $nbEntreprise = 4;
    // Nombre de formations
    $nbFormation = 3;
    // Nombre de stages
    $nbStage = 4;


    // Création de formationDUTInfo
    $formationDUTInfo = new Formation();
    // Définition du nom de formationDUTInfo
    $formationDUTInfo->setNom("DUT Informatique");
    // Définition du lieu de formationDUTInfo
    $formationDUTInfo->setLieu("ANGLET");

    // Création de formationLPMultimedia
    $formationLPMultimedia = new Formation();
    // Définition du nom de formationLPMultimedia
    $formationLPMultimedia->setNom("LP Multimédia");
    // Définition du lieu de formationLPMultimedia
    $formationLPMultimedia->setLieu("BAYONNE");

    // Création de formationDUTIC
    $formationDUTIC = new Formation();
    // Définition du nom de formationDUTIC
    $formationDUTIC->setNom("DU TIC");
    // Définition du lieu de formationDUTIC
    $formationDUTIC->setLieu("BAYONNE");

    //Tableau contenant les objets de formations
    $tableauFormations = array($formationDUTInfo, $formationLPMultimedia, $formationDUTIC);

    foreach($tableauFormations as $formation){
      // Enregistrement de formationDUTIC enregistré
      $manager->persist($formation);
    }


    //Tableau contenant le nom de 4 entreprises
    $nomEntreprises = array("Kiabi", "Safran", "Microsoft", "ImmoB");
    $tableauEntreprises = array();

    for ($i = 0 ; $i < $nbEntreprise; $i++)
    {
      // Création d'une nouvelle entreprise
      $entreprise = new Entreprise();
      // Définition du nom d'entreprise
      $entreprise->setNom($nomEntreprises[$i]);
      // Définition d'une adresse d'entreprise
      $entreprise->setAdresse($faker->address);
      // Définition du site d'entreprise
      //$hyperTextTranfertProtocol = array("http", "https");
      //$nomDomaine = array("fr", "com");
      //$entreprise->setSite($faker->regexify($faker->randomElement($hyperTextTranfertProtocol).'://www.'.strtolower($nomEntreprise).'.'.$faker->randomElement($nomDomaine)));
      $entreprise->setSite($faker->url);
      $tableauEntreprises[$i] = $entreprise;
      // Enregistrement d'entreprise enregistré
      $manager->persist($entreprise);
    }

    //Tables contenant les objets de stage
    $tableauStages = array(
      "Refonte BD"
      => array("Suite aux nombreuses demandes en ligne, notre système de gestion de base de données devient obsolète. Nous aurions donc besoin d'un/e stagiaire pour optimiser notre base de données."
      => "Informatique"),

      "Vidéo Projet"
      => array("Un stage pour comprendre l’importance de la vidéo dans les modes d’expression des marques, leur stratégie digitale globale (et notamment SEO) et leurs relations avec leurs consommateurs"
      => "Audio-Visuelle"),

      "Amélioration Site Web"
      => array("L'objectif du stage est d'étudier le site Web existant, de proposer des améliorations à y apporter pour le rendre plus performant et plus attractif et de développer son référencement qui n'a pas encore été mis en place aujourd'hui."
      => "Communication"),

      "Refonte Site Web"
      => array("Nous recherchons pour notre entreprise évoluant dans l'agroalimentaire, un(e) stagiaire en marketing digital. En lien avec la direction, vous serez en charge de la refonte complète de notre site web."
      => "Informatique")
    );

    foreach ($tableauStages as $titreStage => $info)
    {
      // Création d'un nouveau stage
      $stage = new Stage();
      // Définition du titre de stage
      $stage->setTitre($titreStage);
      foreach ($info as $descriptionStage => $activiteStage)
      {
        // Définition du description de stage
        $stage->setDescription($descriptionStage);
        // Définition d'une activité d'entreprise
        $stage->setActivite($activiteStage);
        // Définition du date de dépôt de stage
      }
      // Définition du date de dépôt de stage
      $stage->setDateDepot($faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now', $timezone = 'Europe/Paris'));

      // Définition d'entreprise de stage
      $numEntrepriseAAjouter = $faker->numberBetween($min = 0, $max = 3);
      $stage->setEntreprise($tableauEntreprises[$numEntrepriseAAjouter]);
      $tableauEntreprises[$numEntrepriseAAjouter]->addStage($stage);
      $manager->persist($tableauEntreprises[$numEntrepriseAAjouter]);
      // Définition du formation de stage
      $nbFormationAAjouter = $faker->numberBetween($min = 1, $max = 2);
      for($j = 0; $j < $nbFormationAAjouter; $j++)
      {
        $formationAleatoire = $faker->numberBetween($min = 0, $max = $nbFormation-1);
        $stage->addFormation($tableauFormations[$formationAleatoire]);
        $tableauFormations[$formationAleatoire]->addStage($stage);

        // Enregistrement du stage enregistré
        $manager->persist($tableauFormations[$formationAleatoire]);
      }
      $manager->persist($stage);
    }
    // Envoyer les données en BD
    $manager->flush();
  }
}

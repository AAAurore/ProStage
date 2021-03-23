<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
    * @Route("/inscription", name="app_inscription")
    */
    public function inscription(Request $request, ManagerRegistry $managerRegistry, UserPasswordEncoderInterface $encoder): Response
    {
      // Création d'unutilisateur vide
      $utilisateur = new User();

      // Création du formulaire permettant de saisir un utilisateur
      $formulaireUtilisateur = $this ->createForm(UserType::class, $utilisateur);

      /*On demande au formulaire d'analyser la dernière requête http. Si le tableau POST (car le formulaire est transmis par le protocole POST) contenu de cette requête contient des variables prenom, nom, email et password alors la méthode handleRequest() récupère les valeurs de ces variables et les affecte à l'objet $utilisateur */
      $formulaireUtilisateur->handleRequest($request);

      // Traiter les données du formulaire s'il a été soumis
      if ($formulaireUtilisateur->isSubmitted() && $formulaireUtilisateur->isValid())
      {
        // Attribuer un rôle à l'utilisateur
        $utilisateur->setRoles(['ROLE_USER']);

        // Encoder le mot de passe de l'utilisateur
        $encoderPassword = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
        $utilisateur->setPassword($encoderPassword);

        // Enregistrer l'utilisateur en BD
        $manager = $managerRegistry->getManager();
        $manager->persist($utilisateur);
        $manager->flush();

        // Rediriger l'utilisateur vers la page de connexion
        return $this->redirectToRoute('app_login');
      }

      // Création de la représentation graphique du $vueFormulaireUtilisateur
      $vueFormulaireUtilisateur = $formulaireUtilisateur->createView();

      // Afficher la page présentant le formulaire d'inscription d'un utilisateur
      return $this->render('security/inscription.html.twig', ['vueFormulaireUtilisateur' => $vueFormulaireUtilisateur]);
    }
}

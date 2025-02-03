<?php

namespace Actions;


use Classes\Utilisateur;
use Classes\Etudiant;
use Classes\Enseignant;

session_start();

require_once '../classes/Utilisateur.php';
require_once '../classes/Enseignant.php';
require_once '../classes/Etudiant.php';
require_once '../classes/Database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        $_SESSION['error_password'] = "Les mots de passe ne correspondent pas.";
        header('Location: ../pages/Sinscrire.php');
        exit();
    }

      $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

      $utilisateurModel = new Utilisateur($nom, $email, $passwordHashed, $role);
      if ($utilisateurModel->getElementByEmail($email)) {
          $_SESSION['error_email'] = "Cet email est déjà utilisé.";
          header('Location: ../pages/Sinscrire.php');
          exit();
      }
      // Create user
      $id_utilisateur = $utilisateurModel->createNewUtilisateur($utilisateurModel, $passwordHashed);


    if ($role === 'etudiant') {
        $objEtudiant = new Etudiant($nom, $email, $passwordHashed, 1, $role, $id_utilisateur);
        $etudiantModel = $utilisateurModel->createNewEtudiant($objEtudiant);

        if ($etudiantModel) {

            $etudinat = $utilisateurModel->getElementById($id_utilisateur);
            $_SESSION['utilisateur'] = $etudinat;

            header('Location: ../index.php');
            exit();
        }

    } elseif ($role === 'enseignant') {
        $objEnseignant = new Enseignant($nom, $email, $passwordHashed, false, $role, $id_utilisateur);
        $enseignantModel = $utilisateurModel->createNewEnseignant($objEnseignant);

        if ($enseignantModel) {

            $_SESSION['success_register'] = "Votre compte enseignant a été créé avec succès.";
            header('Location: ../pages/seConnecter.php');
            exit();
        }
    }

    // If i get here, something went wrong
    $_SESSION['error_register'] = "Une erreur est survenue lors de l'inscription.";
    header('Location: ../pages/Sinscrire.php');
    exit();
}
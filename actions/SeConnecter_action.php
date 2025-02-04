<?php


namespace Actions;
use classes\Utilisateur;

session_start();

require_once '../classes/Utilisateur.php';
require_once '../classes/Utilisateur.php';
require_once '../classes/Enseignant.php';
require_once '../classes/Etudiant.php';
require_once '../classes/Database.php';

$utilisateurModel = new Utilisateur($nom, $email, $passwordHashed, $role);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];



    $utilisateur = $utilisateurModel->getElementByEmail($email);

    if (!$utilisateur) {
        $_SESSION['error_email'] = "Cet email n'existe pas.";
        header('Location: ../pages/seConnecter.php');
        exit();
    }

    if (!password_verify($password, $utilisateur['pw'])) {
        $_SESSION['error_password'] = "Le mot de passe est incorrect.";
        header('Location: ../pages/seConnecter.php');
        exit();
    }

    if ($utilisateur['role'] === 'enseignant') {
        $enseignant = $utilisateurModel->getUtilisateurEnseignantById($utilisateur['id_utilisateur']);

          if (!$enseignant || $enseignant['is_active'] == 0) {
            $_SESSION['error_enseignant'] = "Votre compte enseignant n'est pas encore activé. Veuillez contacter l'administrateur.";
            header('Location: ../pages/seConnecter.php');
            exit();
        }
        
        // Only set session and redirect if teacher is active
        $_SESSION['utilisateur'] = $enseignant;
        header('Location: ../enseignantPages/StatistiquesPanel.php');
        exit();

    } elseif ($utilisateur['role'] === 'etudiant') {
        $etudiant = $utilisateurModel->getElementById($utilisateur['id_utilisateur']);
        $_SESSION['utilisateur'] = $etudiant;
        header('Location: ../index.php');
        exit();
    } elseif ($utilisateur['role'] === 'administrateur') {

        $administrateur = $utilisateurModel->getElementById($utilisateur['id_utilisateur']);
        $_SESSION['utilisateur'] = $administrateur;
        header('Location: ../adminPages/StatistiquesPanel.php');
        exit();
    }

}
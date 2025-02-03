<?php

namespace Actions;

use Classes\Inscription;

use classes\Etudiant;

require_once '../classes/Inscription.php';
require_once '../classes/Etudiant.php';
require_once '../classes/Database.php';
session_start();


if (isset($_GET['id_cour'])) {

    $inscriptionModel = new Inscription("","");
    $etudiantModel = new Etudiant($nom, $email, $password, $is_active, $role, $id_utilisateur, $id_enseignant);

    $id_cour = $_GET['id_cour'];
    $utilisateur_id = $etudiantModel->SelectedEtudiant($_SESSION['utilisateur']['id_utilisateur']);



    $ObjInscription = new Inscription($utilisateur_id['id_etudiant'], $id_cour);
    $result = $inscriptionModel->AjouterNouvelleInscription($ObjInscription);

    if ($result) {
        $_SESSION['success'] = "Inscription effectuée avec succès !";
        header("Location: ../pages/CourseDetails.php?id=$id_cour");
        exit();
    } else {
        $_SESSION['error'] = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
        header("Location: ../pages/CourseDetails.php?id=$id_cour");
        exit();
    }
} 


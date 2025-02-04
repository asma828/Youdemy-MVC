<?php


namespace Actions;

use classes\Etudiant;
session_start();

require_once '../classes/Etudiant.php';
require_once '../classes/Database.php';
require_once '../classes/Utilisateur.php';

if (isset($_GET['id']) && isset($_GET['action'])) {

    $id_utilisateur = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 1) {
        $msg = "Etudinat Activer avec Success";
    } else {
        $msg = "Etudinat banner avec Success";
    }

    $etudiantModel = new Etudiant("","","");
    $result = $etudiantModel->SetBannedEtudiant($id_utilisateur, $action);

    if ($result) {
        $_SESSION['success_etudiant'] = $msg;
        header('Location: ../adminPages/UtilisateursPanel.php');
        exit();
    } else {
        $_SESSION['error_etudiant'] = "Une erreur s'est produite lors de la gestion de l'utilisateur.";
        header('Location: ../adminPages/UtilisateursPanel.php');
        exit();
    }
} else {
    $_SESSION['error_etudiant'] = "Une erreur s'est produite lors de la gestion de l'utilisateur.";
    header('Location: ../adminPages/UtilisateursPanel.php');
    exit();
}
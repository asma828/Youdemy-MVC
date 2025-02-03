<?php


namespace Actions;

use classes\Etudiant;
session_start();

require_once '../classes/Etudiant.php';
require_once '../classes/Database.php';

if (isset($_GET['utilisateurId'])) {

    $id = $_GET['utilisateurId'];

    $etudiantModel = new Etudiant("","","");

    $result = $etudiantModel->DeleteEtudiant($id);

    if ($result) {
        $_SESSION['success_etudiant'] = "L'etudiant a été supprimé avec succès !";
        header('Location: ../adminPages/UtilisateursPanel.php');
        exit();
    } else {
        $_SESSION['error_etudiant'] = "L'etudiant n'a pas pu être supprimé.";
        header('Location: ../adminPages/UtilisateursPanel.php');
        exit();
    }
} else {
    $_SESSION['error_etudiant'] = "Une erreur s'est produite lors de la suppression de l'etudiant.";
    header('Location: ../adminPages/UtilisateursPanel.php');
    exit();
}



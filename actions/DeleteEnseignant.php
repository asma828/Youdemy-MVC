<?php

namespace Actions;
use classes\Enseignant;
require_once '../classes/Utilisateur.php';
require_once '../classes/Enseignant.php';
require_once '../classes/Database.php';

session_start();
if (isset($_GET['utilisateurId'])) {
    $id = $_GET['utilisateurId'];

    $enseignantModel = new Enseignant($nom, $email, $password, $is_active, $role, $id_utilisateur, $id_enseignant);

    $result = $enseignantModel->DeleteEnseignant($id);

    if ($result) {
        $_SESSION['success_enseignant'] = "L'ensignant a été supprimé avec succès !";
        header('Location: ../adminPages/UtilisateursPanel.php');
        exit();
    } else {
        $_SESSION['error_enseignant'] = "L'enseignant n'a pas pu être supprimé.";
        header('Location: ../adminPages/UtilisateursPanel.php');
        exit();
    }
} else {
    $_SESSION['error_enseignant'] = "Une erreur s'est produite lors de la suppression de l'enseignant.";
    header('Location: ../adminPages/UtilisateursPanel.php');
    exit();
}


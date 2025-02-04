<?php

namespace Actions;
use classes\Enseignant;

require_once '../classes/Utilisateur.php';
require_once '../classes/Enseignant.php';
require_once '../classes/Database.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_utilisateur = $_POST['id'];
    $is_active = $_POST['is_active'];

    $enseignantModel = new Enseignant("","","","");

    $result = $enseignantModel->ActiverEnseignan($id_utilisateur,$is_active);

    if ($result) {
        $_SESSION['success_enseignant'] = "L'enseignant a été activé avec succès.";
        header('Location: ../adminPages/UtilisateursPanel.php');
        exit();
    } else {
        $_SESSION['error_enseignant'] = "Une erreur s'est produite lors de l'activation de l'enseignant.";
        header('Location: ../adminPages/UtilisateursPanel.php');
        exit();
    }
} else {
    $_SESSION['error_enseignant'] = "Une erreur s'est produite lors de l'activation de l'enseignant.";
    header('Location: ../adminPages/UtilisateursPanel.php');
    exit();
}

<?php

function AdminAcess()
{
    if (!isset($_SESSION['utilisateur'])) {
        $_SESSION['error_access'] = "Vous devez être connecté pour accéder à cette page.";
        header('Location: ../pages/seConnecter.php');
        exit();
    }

    if ($_SESSION['utilisateur']['role'] != 'administrateur') {

        $_SESSION['error_access'] = "Vous n'êtes pas autorisé à accéder à cette page.";
        header('Location: ../pages/seConnecter.php');
        exit();
    }
}
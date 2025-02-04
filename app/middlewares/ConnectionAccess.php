<?php


function ConnectionAccess()
{
    if (!isset($_SESSION['utilisateur'])) {
        $_SESSION['error_access'] = "Vous devez être connecté pour accéder à cette page.";
        header('Location: ../pages/seConnecter.php');
        exit();
    }
}
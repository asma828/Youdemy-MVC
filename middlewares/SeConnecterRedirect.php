<?php


function seConnecterRedirect()
{
    if (isset($_SESSION['utilisateur']) && isset($_SESSION['utilisateur']['role']) && $_SESSION['utilisateur']['role'] == 'enseignant') {
        header('Location: ../enseignantPages/CoursesPanel.php');
        exit();
    } elseif (isset($_SESSION['utilisateur']) && isset($_SESSION['utilisateur']['role']) && $_SESSION['utilisateur']['role'] == 'administrateur') {
        header('Location: ../adminPages/StatistiquesPanel.php');
        exit();
    } else if (isset($_SESSION['utilisateur']) && isset($_SESSION['utilisateur']['role']) && $_SESSION['utilisateur']['role'] == 'etudiant') {
        header('Location: ../index.php');
        exit();
    }
}
<?php

namespace Actions;

use classes\Category;
require_once '../classes/Category.php';
require_once '../classes/Database.php';

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $category_name = $_POST['category_name'];

    $CategoryModel = new Category();
    $result = $CategoryModel->addCategory($category_name);
    if ($result) {
        $_SESSION['success'] = "Catégorie ajoutée avec succès";
        header('Location: ../adminPages/CategoryPanel.php');
        exit;
    } else {
        $_SESSION['error'] = "Catégorie non ajoutée";
        header('Location: ../adminPages/CategoryPanel.php');
        exit;
    }
} else {
    $_SESSION['error'] = "Une erreur s'est produite lors de l'ajout de la catégorie. Veuillez réessayer.";
    header('Location: ../adminPages/CategoryPanel.php');
    exit;
}
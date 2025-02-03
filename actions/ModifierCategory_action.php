<?php

namespace Actions;

use classes\Category;

require_once '../classes/Category.php';
require_once '../classes/Database.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $category_name = $_POST['category_name'];
    $category_id = $_POST['category_id'];

    $CategoryModel = new Category();
    $result = $CategoryModel->updateCategory($category_id, $category_name);
    if ($result) {
        $_SESSION['success'] = "La catégorie a été modifiée avec succès";
        header('Location: ../adminPages/CategoryPanel.php');
        exit;
    } else {
        $_SESSION['error'] = "Catégorie non modifiée";
        header('Location: ../adminPages/CategoryPanel.php');
        exit;
    }
} else {
    $_SESSION['error'] = "Une erreur s'est produite lors de la modification de la catégorie. Veuillez réessayer.";
    header('Location: ../adminPages/CategoryPanel.php');
    exit;
}
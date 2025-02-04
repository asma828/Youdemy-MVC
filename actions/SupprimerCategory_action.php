<?php

namespace Actions;

use classes\Category;
require_once '../classes/Category.php';
require_once '../classes/Database.php';

session_start();

$CategoryModel = new Category();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = $CategoryModel->deleteCategory($id);

    if ($result) {
        $_SESSION['success'] = "Category deleted successfully.";
        header("Location: ../adminPages/CategoryPanel.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to delete Category.";
        header("Location: ../adminPages/CategoryPanel.php");
        exit();
    }

} else {
    $_SESSION['error'] = "Failed to delete Category.";
    header("Location: ../adminPages/CategoryPanel.php");
    exit();
}
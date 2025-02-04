<?php

namespace Actions;

use Classes\CourseModel;
require_once '../classes/CourseModel.php';

session_start();

if ($_SESSION['utilisateur']['role'] != 'enseignant') {
    $redirect = '../adminPages/CoursesPanel.php';
} else {
    $redirect = '../enseignantPages/CoursesPanel.php';
}


if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $courseModel = new CourseModel();

    $result = $courseModel->deleteCourse($id);

    if ($result) {
        $_SESSION['success'] = "Le cours a été supprimé avec succès !";
        header("Location: $redirect");
        exit();
    } else {
        $_SESSION['error'] = "Le cours n'a pas pu être supprimé.";
        header("Location: $redirect");
        exit();
    }


} else {
    $_SESSION['error'] = "Une erreur s'est produite lors de la suppression du cours.";
    header('Location: ../enseignantPages/CoursesPanel.php');
    exit();
}


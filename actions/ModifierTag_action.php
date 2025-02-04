<?php

namespace Actions;
use classes\Tag;
require_once '../classes/Database.php';
require_once '../classes/Tag.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tag_name = $_POST['tag_name'];
    $id_tag = $_POST['id_tag'];

    $TagModel = new Tag();

    $result = $TagModel->updateTag($id_tag, $tag_name);

    if ($result) {
        $_SESSION['success'] = "Tag modifié avec succès.";
        header('Location: ../adminPages/TagsPanel.php');
    } else {
        $_SESSION['error'] = "Tag non modifié.";
        header('Location: ../adminPages/TagsPanel.php');
    }

} else {
    $_SESSION['error'] = "Une erreur s'est produite lors de l'ajout du tag. Veuillez réessayer.";
    header('Location: ../adminPages/TagsPanel.php');
}
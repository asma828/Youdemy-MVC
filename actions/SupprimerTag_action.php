<?php

namespace Actions;

use classes\Tag;
require_once '../classes/Tag.php';
require_once '../classes/Database.php';

session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $TagModel = new Tag();

    $result = $TagModel->deleteTag($id);
    if ($result) {
        $_SESSION['success'] = "Le tag a été supprimé avec succès.";
        header('Location: ../adminPages/TagsPanel.php');
        exit();
    } else {
        $_SESSION['error'] = "Une erreur s'est produite lors de la suppression du tag.";
        header('Location: ../adminPages/TagsPanel.php');
        exit();
    }

} else {
    $_SESSION['error'] = "Id de tag introuvable | erreur.";
    header('Location: ../adminPages/TagsPanel.php');
    exit();
}
<?php

namespace Actions;
use classes\Tag;
require_once '../classes/Database.php';
require_once '../classes/Tag.php';
session_start();

$toutEffectue = true;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tag_name = $_POST['tag_name'];

    $TagModel = new Tag();

    foreach ($tag_name as $tag) {

        $result = $TagModel->createNewTag($tag);

        if (!$result) {
            $toutEffectue = false;
        }

    }

    if ($toutEffectue) {
        $_SESSION['success'] = "Le tag a été ajouté avec succès !";
        header('Location: ../adminPages/TagsPanel.php');
        exit();
    } else {
        $_SESSION['error'] = "Le tag n'a pas été ajouté. Veuillez réessayer.";
        header('Location: ../adminPages/TagsPanel.php');
    }
} else {
    $_SESSION['error'] = "Une erreur s'est produite lors de l'ajout du tag. Veuillez réessayer.";
    header('Location: ../adminPages/TagsPanel.php');
}
<?php
namespace Actions;

use classes\CourseModel;
use classes\Tag;
use Classes\DocumentCourseHandler;
use Classes\VideoCourseHandler;

require_once '../classes/CourseModel.php';
require_once '../classes/DocumentCourseHandler.php';
require_once '../classes/VideoCourseHandler.php';
require_once '../classes/Tag.php';
require_once '../classes/Database.php';

session_start();

$toutEffectue = true;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titre_cour = $_POST['titre_cour'];
    $imgPrincipale_cours = $_POST['imgPrincipale_cours'];
    $imgSecondaire_cours = $_POST['imgSecondaire_cours'];
    $description_cours = $_POST['description_cours'];
    $category_id = $_POST['category_id'];
    $tags = $_POST['tags'];

    $isVideo = 1;
    if (isset($_POST['contenu_cours_document']) || isset($_POST['contenu_cours_video'])) {

        if (empty($_POST['contenu_cours_document']) && !empty($_POST['contenu_cours_video'])) {
            $isVideo = 1;
        }

        if (empty($_POST['contenu_cours_video']) && !empty($_POST['contenu_cours_document'])) {
            $isVideo = 0;
        }

    }

    if ($isVideo == 1) {

        $videoCourseHandler = new VideoCourseHandler();
        $NouveauCourse = $videoCourseHandler->ajouterNouveauCourse(
            $titre_cour,
            $imgPrincipale_cours,
            $imgSecondaire_cours,
            $description_cours,
            $_POST['contenu_cours_video'],
            $category_id,
            $_SESSION['utilisateur']['id_enseignant'],
            $isVideo
        );

    } else {

        $documentCourseHandler = new DocumentCourseHandler();
        $NouveauCourse = $documentCourseHandler->ajouterNouveauCourse(
            $titre_cour,
            $imgPrincipale_cours,
            $imgSecondaire_cours,
            $description_cours,
            $_POST['contenu_cours_document'],
            $category_id,
            $_SESSION['utilisateur']['id_enseignant'],
            $isVideo
        );
    }

    // echo "<pre>";
    // print_r(value: $NouveauCourse);
    // echo "</pre>";

    $courseModel = new CourseModel();
    $lastCourseId = $courseModel->ajouterNouveauCourse($NouveauCourse);

    $Tag_courseModel = new Tag();



    foreach ($tags as $tag) {

        $result = $Tag_courseModel->Ajouter_Tag_Courses($tag, $lastCourseId);

        if (!$result) {
            $toutEffectue = false;
        }
    }

} else {
    $toutEffectue = false;
}

if ($toutEffectue) {
    $_SESSION['success'] = "Le cours a été ajouté avec succès !";
    header("Location: ../enseignantPages/CoursesPanel.php");
} else {
    $_SESSION['error'] = "Une erreur s'est produite lors de l'ajout du cours. Veuillez réessayer.";
    header("Location: ../enseignantPages/CoursesPanel.php");
}
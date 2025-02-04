<?php
namespace Actions;

use Classes\CourseModel;
use classes\Tag;
use Classes\Course;

require_once '../classes/CourseModel.php';
require_once '../classes/Tag.php';
require_once '../classes/Database.php';
require_once '../classes/Course.php';
session_start();

$toutEffectue = true;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titre_cour = $_POST['titre_cour'];
    $imgPrincipale_cours = $_POST['imgPrincipale_cours'];
    $imgSecondaire_cours = $_POST['imgSecondaire_cours'];
    $description_cours = $_POST['description_cours'];
    $category_id = $_POST['category_id'];
    $tags = $_POST['tags'];
    $id_cour = $_POST['id_cour'];
    $is_video = $_POST['is_video'];
    $utilisateur_id = $_SESSION['utilisateur']['id_enseignant'];
    if ($is_video) {
        $contenu = 'contenu_cours_video';
    } else {
        $contenu = 'contenu_cours_document';
    }
    $contenu_cours = $_POST[$contenu];

    $Tag_courseModel = new Tag();
    $courseModel = new CourseModel();

    $CourseOnject = new Course(
        $titre_cour,
        $imgPrincipale_cours,
        $imgSecondaire_cours,
        $description_cours,
        $contenu_cours,
        $category_id,
        $utilisateur_id,
        $is_video,
        $id_cour
    );

    $result = $courseModel->updateCourse($CourseOnject);
    $Tag_courseModel->DeleteCoursTags($id_cour);

    foreach ($tags as $tag) {
        $result = $Tag_courseModel->Ajouter_Tag_Courses($tag, $id_cour);

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
<?php

namespace Classes;
use Classes\Course;
use Classes\Ajoutercourse;
require_once '../classes/Course.php';
require_once '../classes/Ajoutercourse.php';

class DocumentCourseHandler extends Ajoutercourse
{

    public function ajouterNouveauCourse(
        $titre_cour,
        $imgPrincipale_cours,
        $imgSecondaire_cours,
        $description_cours,
        $contenu_cours,
        $category_id,
        $id_enseignant,
        $is_video
    ) {

        if ($is_video) {
            $_SESSION['error'] = "Le fichier n'est pas une document.";
            header("Location: ../pages/AjouterCours__form.php");
            exit();
        }

        $nouveauCourse = new Course(
            $titre_cour,
            $imgPrincipale_cours,
            $imgSecondaire_cours,
            $description_cours,
            $contenu_cours,
            $category_id,
            $id_enseignant,
            $is_video
        );

        return $nouveauCourse;
    }
}
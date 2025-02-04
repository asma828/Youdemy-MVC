<?php

namespace Classes;

abstract class Ajoutercourse
{

    abstract public function ajouterNouveauCourse(
        $titre_cour,
        $imgPrincipale_cours,
        $imgSecondaire_cours,
        $description_cours,
        $contenu_cours,
        $category_id,
        $id_enseignant,
        $is_video
    );
}
<?php

namespace Classes;

use Classes\Database;
use Classes\Course;

require_once '../classes/Database.php';
require_once '../classes/Course.php';

class CourseModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function ajouterNouveauCourse($CourseObj)
    {
        $sql = "INSERT INTO cours(
        titre_cour, 
        imgPrincipale_cours, 
        imgSecondaire_cours, 
        description_cours, 
        contenu_cours, 
        category_id, 
        id_enseignant, 
        is_video
        ) VALUES (
        :titre_cour, 
        :imgPrincipale_cours, 
        :imgSecondaire_cours, 
        :description_cours, 
        :contenu_cours, 
        :category_id, 
        :id_enseignant, 
        :is_video)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':titre_cour', $CourseObj->titre_cour);
        $stmt->bindValue(':imgPrincipale_cours', $CourseObj->imgPrincipale_cours);
        $stmt->bindValue(':imgSecondaire_cours', $CourseObj->imgSecondaire_cours);
        $stmt->bindValue(':description_cours', $CourseObj->description_cours);
        $stmt->bindValue(':contenu_cours', $CourseObj->contenu_cours);
        $stmt->bindValue(':category_id', $CourseObj->category_id);
        $stmt->bindValue(':id_enseignant', $CourseObj->id_enseignant);
        $stmt->bindValue(':is_video', $CourseObj->is_video);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function getAllCourses()
    {
        $sql = "SELECT * FROM cours co join categories ca on co.category_id = ca.id_category join enseignants en on co.id_enseignant = en.id_enseignant join utilisateurs u on en.id_utilisateur = u.id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $courses = $stmt->fetchAll();

        $coursesObj = [];

        foreach ($courses as $course) {
            $id_cours = $course['id_cour'];
            $title = $course['titre_cour'];
            $imgPrincipale_cours = $course['imgPrincipale_cours'];
            $imgSecondaire_cours = $course['imgSecondaire_cours'];
            $contenu_cours = $course['contenu_cours'];
            $description = $course['description_cours'];
            $category_id = $course['category_name'];
            $id_enseignant = $course['nom'];
            $id_utilisateur = $course['id_utilisateur'];
            $is_video = $course['is_video'];

            $coursesObj[] = new Course($title, $imgPrincipale_cours, $imgSecondaire_cours, $description, $contenu_cours, $category_id, $id_enseignant, $is_video, $id_cours);
        }

        return $coursesObj;
    }
    public function getAllEnseignantCourses($id)
    {
        $sql = "SELECT * FROM cours co join categories ca on co.category_id = ca.id_category join enseignants en on co.id_enseignant = en.id_enseignant join utilisateurs u on en.id_utilisateur = u.id_utilisateur WHERE en.id_utilisateur = :id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id);
        $stmt->execute();
        $courses = $stmt->fetchAll();

        $coursesObj = [];

        foreach ($courses as $course) {
            $id_cours = $course['id_cour'];
            $title = $course['titre_cour'];
            $imgPrincipale_cours = $course['imgPrincipale_cours'];
            $imgSecondaire_cours = $course['imgSecondaire_cours'];
            $contenu_cours = $course['contenu_cours'];
            $description = $course['description_cours'];
            $category_id = $course['category_name'];
            $id_enseignant = $course['nom'];
            $is_video = $course['is_video'];

            $coursesObj[] = new Course($title, $imgPrincipale_cours, $imgSecondaire_cours, $description, $contenu_cours, $category_id, $id_enseignant, $is_video, $id_cours);
        }

        return $coursesObj;
    }

    public function getCourseById($id_cours)
    {
        $sql = "SELECT * FROM cours co join categories ca on co.category_id = ca.id_category WHERE co.id_cour = :id_cour";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_cour', $id_cours);
        $stmt->execute();
        $course = $stmt->fetch();

        $id_cours = $course['id_cour'];
        $title = $course['titre_cour'];
        $imgPrincipale_cours = $course['imgPrincipale_cours'];
        $imgSecondaire_cours = $course['imgSecondaire_cours'];
        $contenu_cours = $course['contenu_cours'];
        $description = $course['description_cours'];
        $category_id = $course['category_id'];
        $id_enseignant = $course['id_enseignant'];
        $is_video = $course['is_video'];

        $courseObj = new Course($title, $imgPrincipale_cours, $imgSecondaire_cours, $description, $contenu_cours, $category_id, $id_enseignant, $is_video, $id_cours);

        return $courseObj;
    }

    public function deleteCourse($id_cours)
    {
        $sql = "DELETE FROM cours WHERE id_cour = :id_cour";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_cour', $id_cours);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function updateCourse($CourseObj)
    {
        $sql = "UPDATE cours SET 
        titre_cour = :titre_cour, 
        imgPrincipale_cours = :imgPrincipale_cours, 
        imgSecondaire_cours = :imgSecondaire_cours, 
        description_cours = :description_cours, 
        contenu_cours = :contenu_cours,
        category_id = :category_id, 
        id_enseignant = :id_enseignant, 
        is_video = :is_video
        WHERE id_cour = :id_cour";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':titre_cour', $CourseObj->titre_cour);
        $stmt->bindValue(':imgPrincipale_cours', $CourseObj->imgPrincipale_cours);
        $stmt->bindValue(':imgSecondaire_cours', $CourseObj->imgSecondaire_cours);
        $stmt->bindValue(':description_cours', $CourseObj->description_cours);
        $stmt->bindValue(':contenu_cours', $CourseObj->contenu_cours);
        $stmt->bindValue(':category_id', $CourseObj->category_id);
        $stmt->bindValue(':id_enseignant', $CourseObj->id_enseignant);
        $stmt->bindValue(':is_video', $CourseObj->is_video);
        $stmt->bindValue(':id_cour', $CourseObj->id_cour);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function MyCourses($id_utilisateur)
    {
        $sql = "SELECT * FROM cours c join inscription i on c.id_cour = i.id_cour JOIN etudiants e on e.id_etudiant = i.id_etudiant WHERE e.id_utilisateur = :id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
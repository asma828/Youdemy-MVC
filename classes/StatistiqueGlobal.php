<?php
namespace Classes;

use Classes\Database;

class StatistiqueGlobal
{

    private $db;


    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getData($table)
    {
        $sql = "SELECT count(*) AS 'total' FROM $table";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    public function Nombre_total_cours()
    {
        return $this->getData('cours');
    }
    public function Nombre_total_utilisateurs()
    {
        return $this->getData('utilisateurs');
    }
    public function Nombre_total_Inscriptions()
    {
        return $this->getData('inscription');
    }
    public function Nombre_total_Categories()
    {
        return $this->getData('categories');
    }
    public function Nombre_total_Tags()
    {
        return $this->getData('tags');
    }

    public function repartitionParCategorie()
    {
        $sql = "SELECT id_category,category_name,count(id_cour) AS 'totalCour' FROM cours join categories on category_id = categories.id_category GROUP BY category_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function CategoryCourses($id_category)
    {
        $sql = "SELECT * FROM cours c join enseignants e on c.id_enseignant = e.id_enseignant join utilisateurs u on e.id_utilisateur = u.id_utilisateur join categories ca on c.category_id = ca.id_category WHERE category_id = :id_category";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_category', $id_category);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function CoursPlusEtudinat()
    {
        $sql = "SELECT titre_cour, COUNT(i.id_etudiant) AS total FROM cours co JOIN inscription i ON i.id_cour = co.id_cour GROUP BY i.id_cour ORDER BY total DESC LIMIT 1;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function TopTreeEnseignants()
    {
        $sql = "SELECT nom, COUNT(co.id_cour) as 'topTree' from
                cours co join enseignants en on co.id_enseignant = en.id_enseignant 
                JOIN utilisateurs u on u.id_utilisateur = en.id_utilisateur 
                GROUP BY co.id_enseignant ORDER BY topTree DESC LIMIT 3";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
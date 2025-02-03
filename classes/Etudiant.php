<?php

namespace Classes;
use Classes\Utilisateur;
use Classes\Database;
require_once __DIR__ . '/Utilisateur.php'; 

class Etudiant extends Utilisateur{
    private $id_etudiant;
    private $is_baned;
    private $db;

    public function __construct($nom, $email, $password, $is_baned = 0, $role = 'etudiant', $id_utilisateur = null, $id_etudiant = null){
        $this->db = Database::getInstance();
        parent::__construct($nom, $email, $password, $role, $id_utilisateur);
        $this->id_etudiant = $id_etudiant;
        $this->is_baned = $is_baned;
    }

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function SetBannedEtudiant($id_utilisateur, $is_baned)
    {
        $sql = "UPDATE etudiants SET is_baned = :is_baned WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->bindValue(':is_baned', $is_baned);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function DeleteEtudiant($id_utilisateur)
    {
        $sql = "DELETE FROM utilisateurs WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function SelectedEtudiant($id)
    {
        $sql = "SELECT * FROM etudiants WHERE id_utilisateur = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }



}

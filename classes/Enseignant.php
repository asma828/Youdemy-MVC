<?php

namespace Classes;
use Classes\Utilisateur;
use Classes\Database;
require_once __DIR__ . '/Utilisateur.php'; 

class Enseignant extends Utilisateur{
    private $id_enseignant;
    private $is_active;
    private $db;

    public function __construct($nom, $email, $password, $is_active, $role = 'enseignant', $id_utilisateur = null, $id_enseignant = null){
        $this->db = Database::getInstance();
        parent::__construct($nom, $email, $password, $role, $id_utilisateur);
        $this->id_enseignant = $id_enseignant;
        $this->is_active = $is_active;
    }

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function ActiverEnseignan($id_utilisateur, $active)
    {
        $sql = "UPDATE enseignants SET is_active= :active WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->bindValue(':active', $active);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function DeleteEnseignant($id_utilisateur)
    {
        $sql = "DELETE FROM utilisateurs WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->execute();
        return $stmt->rowCount();
    }

   
}



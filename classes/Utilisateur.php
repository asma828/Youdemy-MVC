<?php

namespace Classes;
use Classes\Database;
require_once __DIR__ . '/Etudiant.php'; 
require_once __DIR__ . '/Enseignant.php';// Adjust the path based on your directory structure

class Utilisateur{

    protected $id_utilisateur;
    protected $nom;
    protected $email;
    protected $password;
    private $db;

    protected $role;
    public function __construct($nom, $email, $password, $role, $id_utilisateur = null){
        $this->db = Database::getInstance();
        $this->id_utilisateur = $id_utilisateur;
        $this->nom = $nom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
    }

    public function createNewUtilisateur($objUtilisateur, $hashedPassword)
    {
        $sql = "INSERT INTO utilisateurs (nom, email, role, pw) VALUES (:nom, :email, :role, :pw)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nom', $objUtilisateur->nom);
        $stmt->bindValue(':email', $objUtilisateur->email);
        $stmt->bindValue(':role', $objUtilisateur->role);
        $stmt->bindValue(':pw', $hashedPassword);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function createNewEtudiant($objEtudiant)
    {
        $sql = "INSERT INTO etudiants (id_utilisateur, is_baned) VALUES (:id_utilisateur,1)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $objEtudiant->id_utilisateur);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function createNewEnseignant($objEnseignant)
    {
        $sql = "INSERT INTO enseignants (id_utilisateur,is_active) VALUES (:id_utilisateur,0)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $objEnseignant->id_utilisateur);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getElementById($id_utilisateur)
    {
        $sql = "SELECT * FROM utilisateurs WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getElementByEmail($email)
    {
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }


    public function getAllUtilisateursEnseignant()
    {
        $sql = "SELECT * FROM utilisateurs u join enseignants e on u.id_utilisateur = e.id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $utilisateursEnseignant = $stmt->fetchAll();

        foreach ($utilisateursEnseignant as $utilisateur) {
            $nom = $utilisateur['nom'];
            $email = $utilisateur['email'];
            $role = $utilisateur['role'];
            $id_utilisateur = $utilisateur['id_utilisateur'];
            $is_active = $utilisateur['is_active'];

            $utilisateursObjEnseignant[] = new Enseignant($nom, $email, '', $is_active, $role, $id_utilisateur);
        }

        return $utilisateursObjEnseignant;
    }

    public function getUtilisateurEnseignantById($id_utilisateur)
    {
        $sql = "SELECT * FROM utilisateurs u join enseignants e on u.id_utilisateur = e.id_utilisateur WHERE u.id_utilisateur = :id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllUtilisateursEtudiant()
    {
        $sql = "SELECT * FROM utilisateurs u join etudiants e on u.id_utilisateur = e.id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $utilisateursEtudiant = $stmt->fetchAll();

        foreach ($utilisateursEtudiant as $utilisateur) {
            $nom = $utilisateur['nom'];
            $email = $utilisateur['email'];
            $role = $utilisateur['role'];
            $id_utilisateur = $utilisateur['id_utilisateur'];
            $is_baned = $utilisateur['is_baned'];

            $utilisateursObjEtudiant[] = new Etudiant($nom, $email, '', $is_baned, $role, $id_utilisateur);
        }

        return $utilisateursObjEtudiant;
    }

    public function deleteUtilisateur($id_utilisateur)
    {
        $sql = "DELETE FROM utilisateurs WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function activerEnseignant($id_utilisateur)
    {
        $sql = "UPDATE enseignants SET is_active = 1 WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
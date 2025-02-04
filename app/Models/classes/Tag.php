<?php

namespace Classes;

use Classes\Database;

class Tag {
    private $id_tag;
    private $tag_name;
    private $db;

    public function __construct($tag_name = null, $id_tag = null) {
            $this->db = Database::getInstance();
            $this->tag_name = $tag_name;
            $this->id_tag = $id_tag;
        
    }

    public function __get($attr) {
        return $this->$attr;
    }

    public function __set($attr, $value) {
        $this->$attr = $value;
    }

    public function getAllTags() {
        $sql = "SELECT * FROM tags";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $tags = $stmt->fetchAll();
        
        $tagsObj = [];
        foreach ($tags as $tag) {
            $tagsObj[] = new Tag($tag['tag_name'], $tag['id_tag']);
        }
        return $tagsObj;
    }

    public function getTagById($id_tag) {
        $sql = "SELECT * FROM tags WHERE id_tag = :id_tag";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_tag', $id_tag);
        $stmt->execute();
        $tag = $stmt->fetch();
        
        return new Tag($tag['tag_name'], $tag['id_tag']);
    }

    public function Ajouter_Tag_Courses($tag, $id_cours)
    {
        $sql = "INSERT INTO cours_tags(id_cour, id_tag) VALUES (:id_cour, :id_tag)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_cour', $id_cours);
        $stmt->bindValue(':id_tag', $tag);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getCoursTags($id_cours) {
        $sql = "SELECT * FROM cours_tags JOIN tags ON cours_tags.id_tag = tags.id_tag WHERE id_cour = :id_cour";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_cour', $id_cours);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function DeleteCoursTags($id_cour) {
        $sql = "DELETE FROM cours_tags WHERE id_cour = :id_cour";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_cour', $id_cour);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function createNewTag($tag_name) {
        $sql = "INSERT INTO tags (tag_name) VALUES (:tag_name)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':tag_name', $tag_name);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function deleteTag($id_tag){
        $sql = "DELETE FROM tags WHERE id_tag = :id_tag";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_tag', $id_tag);
        $stmt->execute();
        return $stmt->rowCount();
    }


    public function updateTag($id_tag, $tag){
        $sql = "UPDATE tags SET tag_name = :tag_name WHERE id_tag = :id_tag";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_tag', $id_tag);
        $stmt->bindValue(':tag_name', $tag);
        $stmt->execute();
        return $stmt->rowCount();
    }

}
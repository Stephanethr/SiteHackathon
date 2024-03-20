<?php
require_once 'connect.php';
class Etudiant{
    private $id;
    private $nom;
    private $prenom;
    private $promo;
    private $skills;

    public function __construct($id, $nom, $prenom, $promo, $skills){
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->promo = $promo;
        $this->skills = $skills;
    }

    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getPrenom(){
        return $this->prenom;
    }

    public function getPromo(){
        return $this->promo;
    }

    public function getSkills(){
        return $this->skills;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function setPrenom($prenom){
        $this->prenom = $prenom;
    }

    public function setPromo($promo){
        $this->promo = $promo;
    }

    public function setSkills($skills){
        $this->skills = $skills;
    }
}
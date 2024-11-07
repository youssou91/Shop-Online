<?php

class Utilisateur {
    private $id_utilisateur;
    private $nom_utilisateur;
    private $prenom;
    private $date_naissance;
    private $couriel;
    private $mot_de_pass;
    private $telephone;
    private $statut;
    private $rue;
    private $ville;
    private $code_postal;
    private $pays;
    private $numero;
    private $province;

    // Constructor to initialize the user object with data
    public function __construct($id_utilisateur, $nom_utilisateur, $prenom, $date_naissance, $couriel, $mot_de_pass, 
                                $telephone, $statut, $rue, $ville, $code_postal, $pays, $numero, $province) {
        $this->id_utilisateur = $id_utilisateur;
        $this->nom_utilisateur = $nom_utilisateur;
        $this->prenom = $prenom;
        $this->date_naissance = $date_naissance;
        $this->couriel = $couriel;
        $this->mot_de_pass = $mot_de_pass;
        $this->telephone = $telephone;
        $this->statut = $statut;
        $this->rue = $rue;
        $this->ville = $ville;
        $this->code_postal = $code_postal;
        $this->pays = $pays;
        $this->numero = $numero;
        $this->province = $province;
    }

    // Getter methods for the properties
    public function getIdUtilisateur() {
        return $this->id_utilisateur;
    }

    public function getNomUtilisateur() {
        return $this->nom_utilisateur;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getDateNaissance() {
        return $this->date_naissance;
    }

    public function getCouriel() {
        return $this->couriel;
    }

    public function getMotDePass() {
        return $this->mot_de_pass;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function getRue() {
        return $this->rue;
    }

    public function getVille() {
        return $this->ville;
    }

    public function getCodePostal() {
        return $this->code_postal;
    }

    public function getPays() {
        return $this->pays;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getProvince() {
        return $this->province;
    }

    // Setter methods for the properties
    public function setIdUtilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function setNomUtilisateur($nom_utilisateur) {
        $this->nom_utilisateur = $nom_utilisateur;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setDateNaissance($date_naissance) {
        $this->date_naissance = $date_naissance;
    }

    public function setCouriel($couriel) {
        $this->couriel = $couriel;
    }

    public function setMotDePass($mot_de_pass) {
        $this->mot_de_pass = $mot_de_pass;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
    }

    public function setRue($rue) {
        $this->rue = $rue;
    }

    public function setVille($ville) {
        $this->ville = $ville;
    }

    public function setCodePostal($code_postal) {
        $this->code_postal = $code_postal;
    }

    public function setPays($pays) {
        $this->pays = $pays;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setProvince($province) {
        $this->province = $province;
    }

    // Method to validate user email format
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // Method to check if the user is at least 16 years old
    public static function isOldEnough($birthDate) {
        $birthDate = new DateTime($birthDate);
        $today = new DateTime();
        $age = $today->diff($birthDate);
        return $age->y >= 16;
    }

    // Method to hash the password
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // Method to verify password against the stored hash
    public static function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }
}
?>

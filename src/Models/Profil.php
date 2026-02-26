<?php
namespace App\Models;
use App\Lib\Database;

class Profil {
    private $db;

    public function __construct() {
        // On utilise ici la bonne méthode de ta classe Database
        $this->db = Database::getPDO();
    }

    // Récupérer les informations du profil
    public function getProfil() {
        $stmt = $this->db->query("SELECT * FROM profil LIMIT 1");
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Mettre à jour les informations du profil
    public function updateProfil($data) {
        $sql = "UPDATE profil SET 
                nom = :nom, 
                prenom = :prenom, 
                titre_poste = :titre_poste, 
                description_hero = :description_hero, 
                description_about = :description_about, 
                email_contact = :email_contact, 
                lien_github = :lien_github, 
                lien_linkedin = :lien_linkedin, 
                localisation = :localisation, 
                lien_cv = :lien_cv 
                WHERE id = 1";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nom' => $data['nom'] ?? '',
            ':prenom' => $data['prenom'] ?? '',
            ':titre_poste' => $data['titre_poste'] ?? '',
            ':description_hero' => $data['description_hero'] ?? '',
            ':description_about' => $data['description_about'] ?? '',
            ':email_contact' => $data['email_contact'] ?? '',
            ':lien_github' => $data['lien_github'] ?? '',
            ':lien_linkedin' => $data['lien_linkedin'] ?? '',
            ':localisation' => $data['localisation'] ?? '',
            ':lien_cv' => $data['lien_cv'] ?? ''
        ]);
    }
}
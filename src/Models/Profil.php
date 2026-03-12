<?php
namespace App\Models;
use App\Lib\Database;

class Profil {
    private $db;

    public function __construct() {
        $this->db = Database::getPDO();
    }

    public function getProfil() {
        $stmt = $this->db->query("SELECT * FROM profil LIMIT 1");
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ?: [];
    }

    public function updateProfil($data) {
        $check = $this->db->query("SELECT COUNT(*) FROM profil")->fetchColumn();

        if ($check == 0) {
            $sql = "INSERT INTO profil (nom, prenom, titre_poste, entreprise, description_hero, description_about, email_contact, lien_github, lien_linkedin, localisation, lien_cv, image_profil) 
                    VALUES (:nom, :prenom, :titre_poste, :entreprise, :description_hero, :description_about, :email_contact, :lien_github, :lien_linkedin, :localisation, :lien_cv, :image_profil)";
        } else {
            $sql = "UPDATE profil SET 
                    nom = :nom, prenom = :prenom, titre_poste = :titre_poste, entreprise = :entreprise,
                    description_hero = :description_hero, description_about = :description_about, 
                    email_contact = :email_contact, lien_github = :lien_github, 
                    lien_linkedin = :lien_linkedin, localisation = :localisation, 
                    lien_cv = :lien_cv, image_profil = :image_profil 
                    LIMIT 1";
        }

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nom' => $data['nom'] ?? '',
            ':prenom' => $data['prenom'] ?? '',
            ':titre_poste' => $data['titre_poste'] ?? '',
            ':entreprise' => $data['entreprise'] ?? '',
            ':description_hero' => $data['description_hero'] ?? '',
            ':description_about' => $data['description_about'] ?? '',
            ':email_contact' => $data['email_contact'] ?? '',
            ':lien_github' => $data['lien_github'] ?? '',
            ':lien_linkedin' => $data['lien_linkedin'] ?? '',
            ':localisation' => $data['localisation'] ?? '',
            ':lien_cv' => $data['lien_cv'] ?? '',
            ':image_profil' => $data['image_profil'] ?? 'default_profil.png'
        ]);
    }
}
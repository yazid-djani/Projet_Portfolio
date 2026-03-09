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

        // Si la base est vide, on renvoie un tableau vide plutôt que "false" pour éviter les bugs
        return $result ?: [];
    }

    public function updateProfil($data) {
        // CORRECTION DE SÉCURITÉ :
        // Au lieu de mettre à jour l'ID 1 (qui pourrait avoir été supprimé accidentellement),
        // on vide complètement la table et on réinsère la nouvelle ligne.
        // Cela garantit qu'il n'y aura toujours qu'un seul et unique profil actif.
        $this->db->query("TRUNCATE TABLE profil");

        $sql = "INSERT INTO profil (nom, prenom, titre_poste, description_hero, description_about, email_contact, lien_github, lien_linkedin, localisation, lien_cv, image_profil) 
                VALUES (:nom, :prenom, :titre_poste, :description_hero, :description_about, :email_contact, :lien_github, :lien_linkedin, :localisation, :lien_cv, :image_profil)";

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
            ':lien_cv' => $data['lien_cv'] ?? '',
            ':image_profil' => $data['image_profil'] ?? 'default_profil.png'
        ]);
    }
}
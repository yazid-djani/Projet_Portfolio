<?php
namespace App\Models;
use App\Lib\Database;

class Parcours {
    private $db;

    public function __construct() {
        $this->db = Database::getPDO();
    }

    public function getFormations() {
        $stmt = $this->db->query("SELECT * FROM parcours WHERE type = 'formation' ORDER BY id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getExperiences() {
        $stmt = $this->db->query("SELECT * FROM parcours WHERE type = 'experience' ORDER BY id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->db->prepare("INSERT INTO parcours (type, titre, etablissement, date_periode, description) VALUES (:type, :titre, :etablissement, :date_periode, :description)");
        return $stmt->execute([
            ':type' => $data['type'],
            ':titre' => $data['titre'],
            ':etablissement' => $data['etablissement'],
            ':date_periode' => $data['date_periode'],
            ':description' => $data['description']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM parcours WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
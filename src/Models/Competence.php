<?php
namespace App\Models;
use App\Lib\Database;

class Competence {
    // Récupère toutes les compétences triées par pourcentage (du plus grand au plus petit)
    public static function findAll() {
        return Database::getPDO()->query("SELECT * FROM competences ORDER BY pourcentage DESC")->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Ajoute une compétence
    public static function add($nom, $pourcentage, $categorie) {
        $stmt = Database::getPDO()->prepare("INSERT INTO competences (nom, pourcentage, categorie) VALUES (?, ?, ?)");
        return $stmt->execute([$nom, $pourcentage, $categorie]);
    }

    // Supprime une compétence
    public static function delete($id) {
        $stmt = Database::getPDO()->prepare("DELETE FROM competences WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
<?php
namespace App\Models;
use App\Lib\Database;

class Competence extends Model {
    protected static string $table = 'competences';

    // On redéfinit findAll car le tri est différent (par pourcentage au lieu de l'ID)
    public static function findAll() {
        return Database::getPDO()->query("SELECT * FROM competences ORDER BY pourcentage DESC")->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function add($nom, $pourcentage, $categorie) {
        $stmt = Database::getPDO()->prepare("INSERT INTO competences (nom, pourcentage, categorie) VALUES (?, ?, ?)");
        return $stmt->execute([$nom, $pourcentage, $categorie]);
    }
}
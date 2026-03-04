<?php
namespace App\Models;
use App\Lib\Database;

class Outil {
    public static function findAll() {
        return Database::getPDO()->query("SELECT * FROM outils ORDER BY id DESC")->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function add($nom, $image_url) {
        $stmt = Database::getPDO()->prepare("INSERT INTO outils (nom, image_url) VALUES (?, ?)");
        return $stmt->execute([$nom, $image_url]);
    }

    public static function delete($id) {
        $stmt = Database::getPDO()->prepare("DELETE FROM outils WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
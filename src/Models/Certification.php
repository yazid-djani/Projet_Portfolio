<?php
namespace App\Models;
use App\Lib\Database;

class Certification {
    public static function findAll() {
        return Database::getPDO()->query("SELECT * FROM certifications ORDER BY id DESC")->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function add($nom, $description, $image_url) {
        $stmt = Database::getPDO()->prepare("INSERT INTO certifications (nom, description, image_url) VALUES (?, ?, ?)");
        return $stmt->execute([$nom, $description, $image_url]);
    }

    public static function delete($id) {
        $stmt = Database::getPDO()->prepare("DELETE FROM certifications WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
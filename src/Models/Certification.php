<?php
namespace App\Models;
use App\Lib\Database;

class Certification extends Model {
    protected static string $table = 'certifications';

    public static function add($nom, $description, $image_url) {
        $stmt = Database::getPDO()->prepare("INSERT INTO certifications (nom, description, image_url) VALUES (?, ?, ?)");
        return $stmt->execute([$nom, $description, $image_url]);
    }
}
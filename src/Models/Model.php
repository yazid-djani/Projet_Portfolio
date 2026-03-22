<?php
namespace App\Models;
use App\Lib\Database;

abstract class Model {
    protected static string $table = '';

    public static function findAll() {
        $db = Database::getPDO();
        return $db->query("SELECT * FROM " . static::$table . " ORDER BY id DESC")->fetchAll(\PDO::FETCH_ASSOC);
    }

    // --- CORRECTION DU BUG ICI : Méthode ajoutée ---
    public static function findById($id) {
        $db = Database::getPDO();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function delete($id) {
        $db = Database::getPDO();
        $stmt = $db->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
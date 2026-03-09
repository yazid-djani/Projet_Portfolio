<?php
namespace App\Models;
use App\Lib\Database;

abstract class Model {
    // Cette variable sera définie dans chaque classe enfant (ex: 'outils', 'competences')
    protected static string $table = '';

    // Récupère toutes les lignes de la table, triées par ordre décroissant
    public static function findAll() {
        $db = Database::getPDO();
        // L'utilisation de 'static::$table' permet de récupérer le nom de la table de la classe enfant
        return $db->query("SELECT * FROM " . static::$table . " ORDER BY id DESC")->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Supprime une ligne par son ID
    public static function delete($id) {
        $db = Database::getPDO();
        $stmt = $db->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
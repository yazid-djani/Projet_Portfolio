<?php
namespace App\Models;
use App\Lib\Database;

class Outil extends Model {
    protected static string $table = 'outils'; // On indique le nom de la table

    // La méthode add() reste ici car ses colonnes sont spécifiques
    public static function add($nom, $image_url) {
        $stmt = Database::getPDO()->prepare("INSERT INTO outils (nom, image_url) VALUES (?, ?)");
        return $stmt->execute([$nom, $image_url]);
    }
}
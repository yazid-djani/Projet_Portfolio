<?php
namespace App\Models;
use App\Lib\Database;

class Admin
{
    /**
     * Cherche un administrateur par son nom d'utilisateur
     * Retourne le tableau associatif ou false si non trouvé
     */
    public static function findByUsername(string $username): array|false
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();      // Retourne un tableau associatif ou false
    }
}
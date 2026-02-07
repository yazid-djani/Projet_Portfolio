<?php
    namespace App\Models;       // Espace de nom
    use App\Lib\Database;       // On a besoin de la classe Database créée juste avant

    class Projet
    {    /**
         * Récupère TOUS les projets de la table 'projets'
         * Triés par date de création (le plus récent en premier)
         */
        public static function findAll(): array
        {
            $pdo = Database::getPDO();                                      // 1. On récupère la connexion
            $sql = "SELECT * FROM projets ORDER BY date_creation DESC";     // 2. On écrit la requête SQL
            $stmt = $pdo->query($sql);                                      // 3. On prépare et exécute la requête
            return $stmt->fetchAll();                                       // 4. On renvoie tous les résultats sous forme de tableau
        }
    }

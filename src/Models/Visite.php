<?php
namespace App\Models;
use App\Lib\Database;

class Visite {
    public static function record($page, $userAgent, $type = 'vue') {
        $db = Database::getPDO();
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        $stmt = $db->prepare("INSERT INTO visites (page, type, ip_address, user_agent) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$page, $type, $ip, $userAgent]);
    }

    public static function findAllGroupedByIP() {
        $db = Database::getPDO();
        return $db->query("SELECT ip_address, GROUP_CONCAT(CONCAT(page, ' (', type, ')') SEPARATOR ' > ') as parcours, 
                           MAX(visited_at) as derniere_activite, COUNT(*) as total_actions 
                           FROM visites 
                           GROUP BY ip_address 
                           ORDER BY derniere_activite DESC")->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getStatsSummary() {
        $db = Database::getPDO();
        return $db->query("SELECT page, COUNT(*) as total FROM visites GROUP BY page ORDER BY total DESC")->fetchAll(\PDO::FETCH_ASSOC);
    }

    // NOUVEAU : Fonction pour vider toute la table
    public static function clearAll() {
        $db = Database::getPDO();
        return $db->query("TRUNCATE TABLE visites");
    }
}
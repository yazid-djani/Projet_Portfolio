<?php
namespace App\Models;
use App\Lib\Database;

class Visite
{
    public static function record(string $page, string $userAgent): bool
    {
        $pdo = Database::getPDO();
        // On récupère l'IP du visiteur
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

        $stmt = $pdo->prepare("INSERT INTO visites (page, ip_address, user_agent, visited_at) VALUES (:page, :ip, :ua, NOW())");
        return $stmt->execute([
            'page' => $page,
            'ip'   => $ip,
            'ua'   => $userAgent
        ]);
    }
}
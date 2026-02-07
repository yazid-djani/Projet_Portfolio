<?php
    declare(strict_types=1);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once __DIR__ . '/vendor/autoload.php';

    use Dotenv\Dotenv;
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // --- LOGIQUE DE ROUTAGE ---
    $host = $_SERVER['HTTP_HOST'];              // 1. On récupère le domaine actuel (ex: admin.yazid-djani.dev ou yazid-djani.dev)

    if (str_starts_with($host, 'admin.')) {     // 2. Si on est sur le sous-domaine "admin", on force la route admin
        $route = 'admin';
    } else {
        $route = $_GET['route'] ?? 'home';      // Sinon, on garde le comportement classique
    }

    try {
        switch ($route) {
            case 'admin':
                // \App\Controllers\AdminController())->index();
                echo "<h1>Bienvenue sur le Panel Admin Sécurisé</h1>";
                break;

            case 'home':
            default:
                \App\Controllers\ProjetController::index();
                break;
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo "<h1>Erreur Interne</h1>" . htmlspecialchars($e->getMessage());
    }
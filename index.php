<?php
    require_once __DIR__ . '/vendor/autoload.php';
    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(__DIR__);     // Charger les variables d'environnement
    $dotenv->load();

    $host = $_SERVER['HTTP_HOST'];
    $route = 'home';

    if (str_starts_with($host, 'admin.')) {
        $route = 'admin';
    }

    switch ($route) {
        case 'admin':
            echo "<h1>Panel Admin Sécurisé</h1>";
            break;
        default:
            echo "<h1>Portfolio Public</h1>";
            break;
    }
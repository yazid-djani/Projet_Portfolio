<?php
declare(strict_types=1); // Cette ligne DOIT être la toute première instruction PHP

// 1. Démarrage de la session (indispensable pour la partie Admin et la Navbar)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Chargement de l'autoloader de Composer pour gérer les classes automatiquement
require_once __DIR__ . '/vendor/autoload.php';

// 3. Chargement des variables d'environnement (fichier .env)
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 4. Récupération de la route demandée (par défaut 'home')
$route = $_GET['route'] ?? 'home';

try {
    // 5. Système de routage simple
    switch ($route) {
        case 'admin':
            // Si l'utilisateur demande l'administration (le contrôleur sera créé bientôt)
            // (new \App\Controllers\AdminController())->index();
            echo "<h1>Page Admin en construction</h1>";
            break;

        case 'home':
        default:
            // Par défaut, on appelle la méthode index du ProjetController
            // Note l'utilisation de la majuscule "Controllers" pour correspondre au dossier Linux
            \App\Controllers\ProjetController::index();
            break;
    }
} catch (Exception $e) {
    // Gestion des erreurs critiques
    http_response_code(500);
    echo "<h1>Erreur Interne du Serveur</h1>";
    echo "Détail de l'erreur : " . htmlspecialchars($e->getMessage());
}
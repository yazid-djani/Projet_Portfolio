<?php
declare(strict_types=1);

// --- 1. Démarrage de la session (si pas déjà active) ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- 2. Chargement des dépendances ---
require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;

// Chargement du fichier .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// --- 3. Détection du sous-domaine (Routing) ---
$host = $_SERVER['HTTP_HOST'];

// Par défaut, on est sur la partie "home" (visiteur)
$route = 'home';

// Si l'URL commence par "admin.", on bascule sur la route admin
if (str_starts_with($host, 'admin.')) {
    $route = 'admin';
}

// --- 4. Routeur Principal ---
try {
    switch ($route) {

        // ============================================================
        //  PARTIE ADMIN (admin.yazid-djani.dev)
        // ============================================================
        case 'admin':
            $page   = $_GET['page']   ?? 'dashboard';
            $action = $_GET['action'] ?? null;

            // Actions qui ne nécessitent pas forcément d'être connecté ou qui gèrent la session
            switch ($action) {
                case 'logout':
                    \App\Controllers\AdminController::logout();
                    exit;

                case 'login':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        \App\Controllers\AdminController::login();
                        exit;
                    }
                    break;
            }

            // Vérification : Est-ce que l'admin est connecté ?
            if (!isset($_SESSION['admin_id'])) {
                // Si non, on affiche le formulaire de login
                \App\Controllers\AdminController::showLogin();
                exit;
            }

            // Si connecté, on affiche la page demandée
            switch ($page) {
                case 'projets':
                    \App\Controllers\AdminController::projets();
                    break;

                case 'statistiques':
                    \App\Controllers\AdminController::statistiques();
                    break;

                case 'dashboard':
                default:
                    \App\Controllers\AdminController::dashboard();
                    break;
            }
            break;

        // ============================================================
        //  PARTIE VISITEUR (yazid-djani.dev)
        // ============================================================
        case 'home':
        default:
            $action = $_GET['action'] ?? null;

            // 1. Action : Tracking des visites (appelé par trafic.js)
            if ($action === 'track_visit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                \App\Controllers\ProjetController::trackVisit();
                exit;
            }

            // 2. Action : Formulaire de contact (POST)
            elseif ($action === 'contact' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                \App\Controllers\ProjetController::handleContact();
                exit;
            }

            // 3. Affichage standard de la page d'accueil
            else {
                \App\Controllers\ProjetController::index();
            }
            break;
    }

} catch (Exception $e) {
    // Gestion basique des erreurs serveur (500)
    http_response_code(500);
    echo "<h1>Erreur Interne</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
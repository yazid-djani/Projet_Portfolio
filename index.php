<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_SERVER['HTTP_HOST'];
$route = 'home';

if (str_starts_with($host, 'admin.')) {
    $route = 'admin';
}

try {
    switch ($route) {

        // ============================================================
        //  PARTIE ADMIN
        // ============================================================
        case 'admin':
            $page   = $_GET['page']   ?? 'dashboard';
            $action = $_GET['action'] ?? null;

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

            if (!isset($_SESSION['admin_id'])) {
                \App\Controllers\AdminController::showLogin();
                exit;
            }

            switch ($page) {
                case 'profil':
                    \App\Controllers\AdminController::profil();
                    break;

                case 'projets':
                    \App\Controllers\AdminController::projets();
                    break;

                case 'competences':
                    \App\Controllers\AdminController::competences();
                    break;

                case 'outils':
                    \App\Controllers\AdminController::outils();
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
        //  PARTIE VISITEUR
        // ============================================================
        case 'home':
        default:
            $action = $_GET['action'] ?? null;

            if ($action === 'track_visit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                \App\Controllers\ProjetController::trackVisit();
                exit;
            }
            elseif ($action === 'contact' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                \App\Controllers\ProjetController::handleContact();
                exit;
            }
            else {
                \App\Controllers\ProjetController::index();
            }
            break;
    }

} catch (Exception $e) {
    http_response_code(500);
    echo "<h1>Erreur Interne</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
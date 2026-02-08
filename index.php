<?php
    declare(strict_types=1);

    // --- Démarrage de la session ---
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // --- Autoload Composer + .env ---
    require_once __DIR__ . '/vendor/autoload.php';
    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // --- Détection du sous-domaine admin ---
    $host = $_SERVER['HTTP_HOST'];                      // RÉCUPÈRE le nom de domaine
    $route = 'home';                                    // Met la route par DÉFAUT à "home"
    if (str_starts_with($host, 'admin.')) {             // TESTE si ça commence par "admin."
        $route = 'admin';                               // Si oui, change la route en "admin"
    }

    // --- Routeur principal ---
    try {
        switch ($route) {
            // ============================================================
            //  CÔTÉ ADMIN (sous-domaine admin.xxxxx)
            // ============================================================
            case 'admin':
                $page   = $_GET['page']   ?? 'dashboard';
                $action = $_GET['action'] ?? null;

                // --- Actions spéciales (logout, login POST) ---
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

                // --- Si pas connecté → page de connexion ---
                if (!isset($_SESSION['admin_id'])) {
                    \App\Controllers\AdminController::showLogin();
                    exit;
                }

                // --- Admin connecté → routage des pages ---
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
            //  CÔTÉ VISITEUR (domaine principal)
            // ============================================================
            case 'home':
            default:
                \App\Controllers\ProjetController::index();
                break;
        }

    } catch (Exception $e) {
        http_response_code(500);
        echo "<h1>Erreur Interne</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
    }
<?php
declare(strict_types=1);

// Démarrage de la session si elle n'est pas déjà lancée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;

// Chargement des variables d'environnement (.env)
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// ==========================================
// ROUTAGE : AFFICHAGE DU CV PDF (?mon_cv)
// ==========================================
if (isset($_GET['mon_cv'])) {
    $profil = (new \App\Models\Profil())->getProfil();
    $cvFile = $profil['lien_cv'] ?? '';
    $path = __DIR__ . '/public/images/' . $cvFile;

    // On vérifie que le fichier existe et qu'il s'agit bien d'un PDF
    if (!empty($cvFile) && file_exists($path) && str_ends_with(strtolower($cvFile), '.pdf')) {
        // Force le navigateur à afficher le PDF proprement dans un nouvel onglet
        header('Content-Type: application/pdf');

        // Nettoie le nom de famille pour éviter les caractères spéciaux dans le nom du fichier téléchargé
        $nomFichier = preg_replace('/[^a-zA-Z0-9_-]/', '_', $profil['nom'] ?? 'Portfolio');
        header('Content-Disposition: inline; filename="CV_' . $nomFichier . '.pdf"');

        readfile($path);
        exit;
    } else {
        die("Le CV n'est pas encore disponible ou n'a pas été uploader au format PDF.");
    }
}

// ==========================================
// ROUTAGE : ACCÈS AU PANEL ADMINISTRATEUR
// ==========================================
$host = $_SERVER['HTTP_HOST'];
$route = 'home'; // Par défaut, on affiche le site public

// Par défaut, le panel s'ouvre via un sous-domaine (ex: admin.votre-site.com)
if (str_starts_with($host, 'admin.')) {
    $route = 'admin';
}

/* * -------------------------------------------------------------------
 * ASTUCE POUR LE DÉVELOPPEMENT LOCAL / UTILISATEURS GITHUB :
 * -------------------------------------------------------------------
 * Si vous n'avez pas de sous-domaine configuré (ex: en local avec XAMPP/WAMP),
 * vous pouvez commenter le bloc 'if' ci-dessus et décommenter
 * celui ci-dessous.
 * Vous accéderez alors à l'admin via l'URL : http://localhost/?admin
 */
/*
if (isset($_GET['admin'])) {
    $route = 'admin';
}
*/

// ==========================================
// CONTRÔLEUR FRONTAL (DISPATCHER)
// ==========================================
try {
    switch ($route) {

        // --- ROUTES DE L'ADMINISTRATION ---
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

            // Vérification de la session : si non connecté -> Page de connexion
            if (!isset($_SESSION['admin_id'])) {
                \App\Controllers\AdminController::showLogin();
                exit;
            }

            // Routage des pages internes de l'admin
            switch ($page) {
                case 'profil': \App\Controllers\AdminController::profil(); break;
                case 'projets': \App\Controllers\AdminController::projets(); break;
                case 'competences': \App\Controllers\AdminController::competences(); break;
                case 'outils': \App\Controllers\AdminController::outils(); break;
                case 'certifications': \App\Controllers\AdminController::certifications(); break;
                case 'statistiques': \App\Controllers\AdminController::statistiques(); break;
                case 'messages': \App\Controllers\AdminController::messages(); break; // <-- NOUVELLE LIGNE
                case 'dashboard':
                default:
                    \App\Controllers\AdminController::dashboard();
                    break;
            }
            break;

        // --- ROUTES DU SITE PUBLIC (VISITEUR) ---
        case 'home':
        default:
            $action = $_GET['action'] ?? null;

            // Route pour enregistrer les visites (appelée en AJAX via JS)
            if ($action === 'track_visit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                \App\Controllers\ProjetController::trackVisit();
                exit;
            }
            // Route pour traiter le formulaire de contact
            elseif ($action === 'contact' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                \App\Controllers\ProjetController::handleContact();
                exit;
            }
            // Affichage normal du portfolio
            else {
                \App\Controllers\ProjetController::index();
            }
            break;
    }

} catch (Exception $e) {
    // Gestion globale des erreurs fatales
    http_response_code(500);
    echo "<h1>Erreur Interne</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
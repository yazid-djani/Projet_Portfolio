<?php
declare(strict_types=1);

// Démarrage de la session si elle n'est pas déjà lancée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- CHARGEMENT DES CLASSES AVEC COMPOSER ---
require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;

// --- CHARGEMENT DU FICHIER .env (Base de données) ---
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

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

        // Nettoie le nom de famille pour éviter les caractères spéciaux dans le nom du fichier
        $nomFichier = preg_replace('/[^a-zA-Z0-9_-]/', '_', $profil['nom'] ?? 'Portfolio');
        header('Content-Disposition: inline; filename="CV_' . $nomFichier . '.pdf"');

        readfile($path);
        exit;
    } else {
        die("Le CV n'est pas encore disponible ou n'a pas été uploader au format PDF.");
    }
}

// ==========================================
// CONTRÔLEUR FRONTAL (DISPATCHER)
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
 * En local ou sans sous-domaine, ajoutez simplement ?admin dans l'URL.
 */
/*
if (isset($_GET['admin'])) {
    $route = 'admin';
}
*/

$page = $_GET['page'] ?? null;
$action = $_GET['action'] ?? null;

// Gestion globale de la déconnexion
if ($action === 'logout') {
    \App\Controllers\AdminController::logout();
    exit;
}

try {
    if ($route === 'admin') {
        // ==========================================
        // PARTIE ADMINISTRATION (Panel)
        // ==========================================
        $page = $page ?? 'dashboard';

        if ($page === 'login') {
            \App\Controllers\AdminController::login();
            exit;
        }

        // Sécurité : Vérification de la session Admin (Utilise admin_id comme dans le contrôleur)
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?admin&page=login');
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
            case 'messages': \App\Controllers\AdminController::messages(); break;
            case 'parcours': \App\Controllers\AdminController::parcours(); break; // <-- Le nouveau module !
            case 'dashboard':
            default:
                \App\Controllers\AdminController::dashboard();
                break;
        }

    } else {
        // ==========================================
        // PARTIE VISITEUR (Portfolio Public)
        // ==========================================

        // 1. Interception des requêtes AJAX (Permet à trafic.js de fonctionner en arrière-plan)
        if ($action === 'track_visit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            \App\Controllers\ProjetController::trackVisit();
            exit;
        }

        // 2. Traitement du formulaire de contact (si soumis)
        $contactMessageSuccess = null;
        if ($action === 'contact' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $sujet = $_POST['subject'] ?? 'Sans sujet';
            $message = $_POST['message'] ?? '';

            if (!empty($nom) && !empty($email) && !empty($message)) {
                \App\Models\Message::add($nom, $email, $sujet, $message);
                $contactMessageSuccess = "Votre message a bien été envoyé !";
            }
        }

        // 3. Enregistrement classique de la visite (Page d'accueil)
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Inconnu';
        \App\Models\Visite::record($_SERVER['REQUEST_URI'], $userAgent, 'vue');

        // 4. Récupération de toutes les données dynamiques
        $profilModel = new \App\Models\Profil();
        $profil = $profilModel->getProfil();

        $projets = \App\Models\Projet::findAll();
        $projetsDev = []; $projetsReseau = [];
        foreach ($projets as $p) {
            if ($p['categorie'] === 'developpement') $projetsDev[] = $p;
            elseif ($p['categorie'] === 'reseau') $projetsReseau[] = $p;
        }

        $competences = \App\Models\Competence::findAll();
        $competencesDev = []; $competencesReseau = [];
        foreach ($competences as $c) {
            if ($c['categorie'] === 'developpement') $competencesDev[] = $c;
            elseif ($c['categorie'] === 'reseau') $competencesReseau[] = $c;
        }

        $outils = \App\Models\Outil::findAll();
        $certifications = \App\Models\Certification::findAll();

        $parcoursModel = new \App\Models\Parcours();
        $formations = $parcoursModel->getFormations();
        $experiences = $parcoursModel->getExperiences();

        // 5. Affichage final du portfolio
        require_once __DIR__ . '/src/views/ViewerPage.php';
    }

} catch (Exception $e) {
    // Gestion globale des erreurs
    http_response_code(500);
    echo "<h1>Erreur Interne</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
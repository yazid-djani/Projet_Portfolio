<?php
session_start();

// --- CHARGEMENT DES CLASSES AVEC COMPOSER ---
require_once __DIR__ . '/vendor/autoload.php';

// --- CHARGEMENT DU FICHIER .env (Base de données) ---
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// --- ROUTEUR PRINCIPAL ---
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? null;

// Gestion de la déconnexion
if ($action === 'logout') {
    \App\Controllers\AdminController::logout();
    exit;
}

// --- PARTIE ADMINISTRATION (Panel) ---
$adminPages = ['dashboard', 'projets', 'competences', 'outils', 'certifications', 'messages', 'statistiques', 'profil', 'parcours'];

if (in_array($page, $adminPages) || $page === 'login') {

    if ($page === 'login') {
        \App\Controllers\AdminController::login();
        exit;
    }

    // Sécurité : Vérification de la session Admin
    if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
        header('Location: ?page=login');
        exit;
    }

    // Routage des pages de l'administration
    switch ($page) {
        case 'dashboard': \App\Controllers\AdminController::dashboard(); break;
        case 'projets': \App\Controllers\AdminController::projets(); break;
        case 'competences': \App\Controllers\AdminController::competences(); break;
        case 'outils': \App\Controllers\AdminController::outils(); break;
        case 'certifications': \App\Controllers\AdminController::certifications(); break;
        case 'messages': \App\Controllers\AdminController::messages(); break;
        case 'statistiques': \App\Controllers\AdminController::statistiques(); break;
        case 'profil': \App\Controllers\AdminController::profil(); break;
        case 'parcours': \App\Controllers\AdminController::parcours(); break; // <-- NOUVELLE ROUTE
    }
    exit;
}


// --- PARTIE VISITEUR (Portfolio Public) ---

// 1. Enregistrement de la visite pour le trafic (Appel statique avec le bon nom de méthode)
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Inconnu';
\App\Models\Visite::record($_SERVER['REQUEST_URI'], $userAgent);

// 2. Traitement du formulaire de contact (si soumis)
$contactMessageSuccess = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    $nom = $_POST['name'];
    $email = $_POST['email'];
    $sujet = $_POST['subject'] ?? 'Sans sujet';
    $message = $_POST['message'];

    \App\Models\Message::add($nom, $email, $sujet, $message);
    $contactMessageSuccess = "Votre message a bien été envoyé !";
}

// 3. Récupération de toutes les données de la base de données
$profilModel = new \App\Models\Profil();
$profil = $profilModel->getProfil();

// Récupération et tri des Projets (statique)
$projets = \App\Models\Projet::findAll();
$projetsDev = [];
$projetsReseau = [];
foreach ($projets as $p) {
    if ($p['categorie'] === 'developpement') $projetsDev[] = $p;
    elseif ($p['categorie'] === 'reseau') $projetsReseau[] = $p;
}

// Récupération et tri des Compétences (statique)
$competences = \App\Models\Competence::findAll();
$competencesDev = [];
$competencesReseau = [];
foreach ($competences as $c) {
    if ($c['categorie'] === 'developpement') $competencesDev[] = $c;
    elseif ($c['categorie'] === 'reseau') $competencesReseau[] = $c;
}

$outils = \App\Models\Outil::findAll();
$certifications = \App\Models\Certification::findAll();

// Récupération du Parcours (instancié car les méthodes ne sont pas statiques dans le modèle)
$parcoursModel = new \App\Models\Parcours();
$formations = $parcoursModel->getFormations();
$experiences = $parcoursModel->getExperiences();

// 4. Affichage de la vue Visiteur (qui intègrera toutes ces variables)
require_once __DIR__ . '/src/views/ViewerPage.php';
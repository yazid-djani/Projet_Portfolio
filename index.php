<?php
session_start();

// --- CHARGEMENT DES CLASSES AVEC COMPOSER ---
require_once __DIR__ . '/vendor/autoload.php';

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

// 1. Enregistrement de la visite pour le trafic
$visiteModel = new \App\Models\Visite();
$visiteModel->enregistrerVisite($_SERVER['REQUEST_URI']);

// 2. Traitement du formulaire de contact (si soumis)
$contactMessageSuccess = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'], $_POST['email'], $_POST['message'])) {
    $messageModel = new \App\Models\Message();
    $messageModel->add($_POST);
    $contactMessageSuccess = "Votre message a bien été envoyé !";
}

// 3. Récupération de toutes les données de la base de données
$profilModel = new \App\Models\Profil();
$profil = $profilModel->getProfil();

$projetModel = new \App\Models\Projet();
$projets = $projetModel->getAll();

$competenceModel = new \App\Models\Competence();
$competencesDev = $competenceModel->getByCategory('developpement');
$competencesReseau = $competenceModel->getByCategory('reseau');

$outilModel = new \App\Models\Outil();
$outils = $outilModel->getAll();

$certificationModel = new \App\Models\Certification();
$certifications = $certificationModel->getAll();

// NOUVEAU : Récupération du Parcours
$parcoursModel = new \App\Models\Parcours();
$formations = $parcoursModel->getFormations();
$experiences = $parcoursModel->getExperiences();

// 4. Affichage de la vue Visiteur (qui intègrera toutes ces variables)
require_once __DIR__ . '/src/views/ViewerPage.php';
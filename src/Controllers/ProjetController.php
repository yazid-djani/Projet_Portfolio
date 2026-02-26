<?php
namespace App\Controllers;

use App\Models\Projet;
use App\Models\Visite;
use App\Models\Profil; // <-- 1. Ajout de l'import du modèle Profil

class ProjetController
{
    public static function index() {
        // --- NOUVEAUTÉ : Récupération des données dynamiques du profil ---
        $profilModel = new Profil();
        $profil = $profilModel->getProfil();

        // --- GESTION DES PROJETS (inchangée) ---
        $projets = Projet::findAll();
        $projetsDev = [];
        $projetsReseau = [];

        foreach ($projets as $p) {
            // Sécurisation des données manquantes pour éviter les bugs d'affichage
            if (!isset($p['detail'])) $p['detail'] = $p['description'];
            if (!isset($p['image_url'])) $p['image_url'] = 'default.jpg';

            if ($p['categorie'] === 'developpement') {
                $projetsDev[] = $p;
            } elseif ($p['categorie'] === 'reseau') {
                $projetsReseau[] = $p;
            }
        }

        // --- AFFICHAGE DE LA VUE ---
        // Les variables $profil, $projetsDev et $projetsReseau seront transmises à ViewerPage.php
        require_once __DIR__ . '/../views/ViewerPage.php';
    }

    // --- MÉTHODE POUR LE TRACKING ---
    public static function trackVisit() {
        // On lit les données JSON envoyées par trafic.js
        $data = json_decode(file_get_contents('php://input'), true);

        if ($data) {
            $page = $data['page'] ?? '/';
            $ua   = $data['userAgent'] ?? 'Unknown';

            // On enregistre via le Modèle
            Visite::record($page, $ua);

            // On répond au JS que c'est ok
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
            exit;
        }
    }
}
<?php
namespace App\Controllers;
use App\Models\Projet;
use App\Models\Visite; // N'oublie pas d'importer le modèle Visite

class ProjetController
{
    public static function index() {
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
        require_once __DIR__ . '/../views/ViewerPage.php';
    }

    // --- NOUVELLE MÉTHODE POUR LE TRACKING ---
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
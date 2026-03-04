<?php
namespace App\Controllers;

use App\Models\Projet;
use App\Models\Visite;
use App\Models\Profil;
use App\Models\Competence; // NOUVEAU
use App\Models\Outil;      // NOUVEAU
use App\Lib\Database;

class ProjetController
{
    public static function index() {
        $profil = (new Profil())->getProfil();

        // Projets
        $projets = Projet::findAll();
        $projetsDev = []; $projetsReseau = [];
        foreach ($projets as $p) {
            if ($p['categorie'] === 'developpement') $projetsDev[] = $p;
            elseif ($p['categorie'] === 'reseau') $projetsReseau[] = $p;
        }

        // --- NOUVEAU : Récupération des compétences et outils ---
        $competences = Competence::findAll();
        $competencesDev = []; $competencesReseau = [];
        foreach ($competences as $c) {
            if ($c['categorie'] === 'developpement') $competencesDev[] = $c;
            elseif ($c['categorie'] === 'reseau') $competencesReseau[] = $c;
        }
        $outils = Outil::findAll();
        // --------------------------------------------------------

        require_once __DIR__ . '/../views/ViewerPage.php';
    }

    public static function trackVisit() { /* ... Inchangé ... */ }
    public static function handleContact() { /* ... Inchangé ... */ }
}
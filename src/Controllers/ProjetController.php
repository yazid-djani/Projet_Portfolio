<?php
    namespace App\Controllers;  // Espace de nom
    use App\Models\Projet;      // On va utiliser le modèle Projet

    class ProjetController
    {   /**
         * Méthode principale qui affiche la page d'accueil (ViewerPage)
         */
        public static function index() {
            $projets = Projet::findAll();       // 1. On demande au modèle de nous donner tous les projets
            $projetsDev = [];                   // 2. On sépare les projets en deux tableaux pour l'affichage (Dev vs Réseau)
            $projetsReseau = [];

            foreach ($projets as $p) {
                if ($p['categorie'] === 'developpement') {
                    $projetsDev[] = $p;
                } elseif ($p['categorie'] === 'reseau') {
                    $projetsReseau[] = $p;
                }
            }

            // 3. On charge la vue (le fichier HTML/PHP)
            // Les variables $projetsDev et $projetsReseau seront accessibles dans la vue
            require_once __DIR__ . '/../views/ViewerPage.php';
        }
    }

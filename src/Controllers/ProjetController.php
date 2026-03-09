<?php
namespace App\Controllers;

use App\Models\Projet;
use App\Models\Visite;
use App\Models\Profil;
use App\Models\Competence;
use App\Models\Outil;
use App\Models\Certification;
use App\Models\Message;
use App\Lib\Database;

class ProjetController
{
    public static function index() {
        $profil = (new Profil())->getProfil();

        $projets = Projet::findAll();
        $projetsDev = []; $projetsReseau = [];
        foreach ($projets as $p) {
            if ($p['categorie'] === 'developpement') $projetsDev[] = $p;
            elseif ($p['categorie'] === 'reseau') $projetsReseau[] = $p;
        }

        $competences = Competence::findAll();
        $competencesDev = []; $competencesReseau = [];
        foreach ($competences as $c) {
            if ($c['categorie'] === 'developpement') $competencesDev[] = $c;
            elseif ($c['categorie'] === 'reseau') $competencesReseau[] = $c;
        }

        $outils = Outil::findAll();
        $certifications = Certification::findAll();

        require_once __DIR__ . '/../views/ViewerPage.php';
    }

    public static function trackVisit() {
        // Le JS envoie les données en JSON dans le corps de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        if ($data) {
            $page = $data['page'] ?? 'inconnu';
            $type = $data['type'] ?? 'vue';
            $userAgent = $data['userAgent'] ?? $_SERVER['HTTP_USER_AGENT'];

            Visite::record($page, $userAgent, $type);
        }

        // Réponse HTTP 200 OK
        http_response_code(200);
        exit;
    }

    public static function handleContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $sujet = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if (!empty($nom) && !empty($email) && !empty($message)) {
                // Ajout dans la base de données
                Message::add($nom, $email, $sujet, $message);
            }
        }
        // Redirection vers la page d'accueil avec une ancre
        header('Location: /#contact');
        exit;
    }
}
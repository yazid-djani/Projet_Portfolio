<?php
namespace App\Controllers;

use App\Models\Projet;
use App\Models\Visite;
use App\Models\Profil;
use App\Models\Competence;
use App\Models\Outil;
use App\Models\Certification;
use App\Models\Message;

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
        $data = json_decode(file_get_contents('php://input'), true);

        if ($data) {
            $page = $data['page'] ?? 'inconnu';
            $type = $data['type'] ?? 'vue';
            $userAgent = $data['userAgent'] ?? $_SERVER['HTTP_USER_AGENT'];

            Visite::record($page, $userAgent, $type);
        }

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
                // 1. Ajout dans la base de données
                Message::add($nom, $email, $sujet, $message);

                // 2. Envoi de l'email à l'admin
                $profil = (new Profil())->getProfil();
                // Utilise l'email renseigné dans le profil admin, sinon un email par défaut
                $destinataire = !empty($profil['email_contact']) ? $profil['email_contact'] : 'ton.email@gmail.com';

                $headers = "From: $email\r\n";
                $headers .= "Reply-To: $email\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                $contenuMail = "Nouveau message depuis ton Portfolio !\n\n";
                $contenuMail .= "Nom : $nom\n";
                $contenuMail .= "Email : $email\n";
                $contenuMail .= "Sujet : $sujet\n\n";
                $contenuMail .= "Message :\n$message\n";

                // Le @ permet d'éviter d'afficher une erreur si le serveur local ne gère pas les mails
                @mail($destinataire, "Nouveau contact : $sujet", $contenuMail, $headers);
            }
        }
        header('Location: /#contact');
        exit;
    }
}
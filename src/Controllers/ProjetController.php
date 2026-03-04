<?php
namespace App\Controllers;

use App\Models\Projet;
use App\Models\Visite;
use App\Models\Profil;
use App\Lib\Database; // Ajout de l'import pour la base de données

class ProjetController
{
    public static function index() {
        $profilModel = new Profil();
        $profil = $profilModel->getProfil();

        $projets = Projet::findAll();
        $projetsDev = [];
        $projetsReseau = [];

        foreach ($projets as $p) {
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

    public static function trackVisit() {
        $data = json_decode(file_get_contents('php://input'), true);

        if ($data) {
            $page = $data['page'] ?? '/';
            $ua   = $data['userAgent'] ?? 'Unknown';

            Visite::record($page, $ua);

            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
            exit;
        }
    }

    // NOUVELLE MÉTHODE : Traitement du formulaire de contact public
    public static function handleContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération sécurisée des données du formulaire
            $nom = htmlspecialchars($_POST['name'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $sujet = htmlspecialchars($_POST['subject'] ?? '');
            $message = htmlspecialchars($_POST['message'] ?? '');

            // Si les champs obligatoires ne sont pas vides
            if (!empty($nom) && !empty($email) && !empty($message)) {
                $db = Database::getPDO();
                // Insertion dans la base de données
                $stmt = $db->prepare("INSERT INTO messages_contact (nom, email, sujet, message) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nom, $email, $sujet, $message]);
            }

            // On redirige l'utilisateur vers la page d'accueil (au niveau du contact)
            header('Location: /#contact');
            exit;
        }
    }
}
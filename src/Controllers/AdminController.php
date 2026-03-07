<?php
namespace App\Controllers;

use App\Models\Admin;
use App\Models\Profil;
use App\Models\Competence;
use App\Models\Outil;
use App\Lib\Database;

class AdminController
{
    public static function showLogin(): void
    {
        $error = null;
        require_once __DIR__ . '/../views/admin/AdminConnexion.php';
    }

    public static function login(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $admin = Admin::findByUsername($username);

        if ($admin && password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: ?page=dashboard');
            exit;
        }

        $error = "Nom d'utilisateur ou mot de passe incorrect.";
        require_once __DIR__ . '/../views/admin/AdminConnexion.php';
    }

    public static function logout(): void
    {
        session_destroy();
        header('Location: /');
        exit;
    }

    public static function dashboard(): void
    {
        require_once __DIR__ . '/../views/admin/AdminPage.php';
    }

    // --- CORRECTION DE L'UPLOAD ---
    private static function handleUpload($fileInputName, $defaultName) {
        $dir = __DIR__ . '/../../public/images/';

        // Force la création du dossier avec les permissions maximales s'il n'existe pas
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES[$fileInputName]['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $ext;
            $dest = $dir . $filename;

            if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $dest)) {
                return $filename;
            }
        }
        return $defaultName;
    }

    public static function projets(): void
    {
        $message = null;
        $error = null;

        if (isset($_GET['action']) && $_GET['action'] === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = $_POST['titre'] ?? '';
            $description = $_POST['description'] ?? '';
            $detail = $_POST['detail'] ?? '';
            $categorie = $_POST['categorie'] ?? '';
            $technologies = $_POST['technologies'] ?? '';
            $lien_github = $_POST['lien_github'] ?? '';

            $image_url = self::handleUpload('media_projet', 'default.jpg');

            try {
                $db = Database::getPDO();
                $stmt = $db->prepare("INSERT INTO projets (titre, description, detail, categorie, technologies, image_url, lien_github) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$titre, $description, $detail, $categorie, $technologies, $image_url, $lien_github]);
                $message = "Le projet et son média ont été ajoutés avec succès !";
            } catch (\Exception $e) {
                $error = "Erreur lors de l'ajout du projet : " . $e->getMessage();
            }
        }

        require_once __DIR__ . '/../views/admin/CreateProjet.php';
    }

    public static function statistiques(): void
    {
        // On récupère les données traitées par le modèle
        $parcoursUtilisateurs = \App\Models\Visite::findAllGroupedByIP();
        $resumeStats = \App\Models\Visite::getStatsSummary();

        require_once __DIR__ . '/../views/admin/TraficPanel.php';
    }

    public static function profil(): void
    {
        $profilModel = new Profil();
        $message = null;
        $profilActuel = $profilModel->getProfil();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ancienneImage = $profilActuel['image_profil'] ?? 'default_profil.png';
            $_POST['image_profil'] = self::handleUpload('photo_profil', $ancienneImage);

            $profilModel->updateProfil($_POST);
            $message = "Profil et photo mis à jour avec succès !";
            $profilActuel = $profilModel->getProfil();
        }

        $profil = $profilActuel;
        require_once __DIR__ . '/../views/admin/ParametresProfil.php';
    }

    public static function competences(): void
    {
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Competence::add($_POST['nom'], $_POST['pourcentage'], $_POST['categorie']);
            $message = "Compétence ajoutée !";
        }

        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            Competence::delete($_GET['id']);
            header('Location: ?page=competences'); exit;
        }

        $competences = Competence::findAll();
        require_once __DIR__ . '/../views/admin/AdminCompetences.php';
    }

    public static function outils(): void
    {
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image_url = self::handleUpload('image_outil', 'default_outil.png');
            Outil::add($_POST['nom'] ?? '', $image_url);
            $message = "Outil ajouté !";
        }

        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            Outil::delete($_GET['id']);
            header('Location: ?page=outils'); exit;
        }

        $outils = Outil::findAll();
        require_once __DIR__ . '/../views/admin/AdminOutils.php';
    }
}
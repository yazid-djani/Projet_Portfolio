<?php
namespace App\Controllers;

use App\Models\Admin;
use App\Models\Profil;
use App\Models\Projet;
use App\Models\Competence;
use App\Models\Outil;
use App\Models\Certification;
use App\Models\Visite;
use App\Lib\Database;

class AdminController
{
    // ==========================================
    // GESTION DE LA CONNEXION / DÉCONNEXION
    // ==========================================

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

    // ==========================================
    // FONCTION UTILITAIRE (UPLOAD D'IMAGES/MÉDIAS/PDF)
    // ==========================================

    private static function handleUpload($fileInputName, $defaultName) {
        $dir = __DIR__ . '/../../public/images/';

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES[$fileInputName]['name'], PATHINFO_EXTENSION));

            // SÉCURITÉ : Liste des extensions autorisées (ajout du pdf pour le CV)
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm', 'pdf'];
            if (!in_array($ext, $allowedExts)) {
                return $defaultName;
            }

            $filename = uniqid() . '.' . $ext;
            $dest = $dir . $filename;

            if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $dest)) {
                return $filename;
            }
        }
        return $defaultName;
    }

    // ==========================================
    // GESTION DES FICHIERS ORPHELINS
    // ==========================================

    private static function deleteOldFile($filename) {
        // Liste des fichiers par défaut à ne jamais supprimer
        $defaults = ['default_profil.png', 'default.jpg', 'default_certif.png', 'default_outil.png'];

        if ($filename && !in_array($filename, $defaults)) {
            $path = __DIR__ . '/../../public/images/' . $filename;
            if (file_exists($path)) {
                @unlink($path); // Supprime le fichier du serveur
            }
        }
    }

    // ==========================================
    // GESTION DES PAGES DU PANEL
    // ==========================================

    public static function projets(): void
    {
        $message = null;
        $error = null;
        $action = $_GET['action'] ?? 'list';

        // 1. SUPPRESSION D'UN PROJET
        if ($action === 'delete' && isset($_GET['id'])) {
            // Optionnel : Récupère l'image du projet avant de le supprimer pour nettoyer le serveur
            $projet = Projet::findById((int)$_GET['id']);
            if ($projet && !empty($projet['image_url'])) {
                self::deleteOldFile($projet['image_url']);
            }

            Projet::delete($_GET['id']); // Utilisation de la méthode héritée du Model
            header('Location: ?page=projets&success=deleted');
            exit;
        }

        // 2. CRÉATION D'UN PROJET
        if ($action === 'create') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $titre = $_POST['titre'] ?? '';
                $description = $_POST['description'] ?? '';
                $detail = $_POST['detail'] ?? '';
                $categorie = $_POST['categorie'] ?? '';
                $technologies = $_POST['technologies'] ?? '';
                $lien_github = $_POST['lien_github'] ?? '';

                $image_url = self::handleUpload('media_projet', 'default.jpg');

                try {
                    // Utilisation de la méthode create du modèle Projet
                    Projet::create($titre, $description, $detail, $categorie, $technologies, $image_url, $lien_github);
                    header('Location: ?page=projets&success=created');
                    exit;
                } catch (\Exception $e) {
                    $error = "Erreur : " . $e->getMessage();
                }
            }
            require_once __DIR__ . '/../views/admin/CreateProjet.php';
            return;
        }

        // 3. AFFICHAGE DE LA LISTE DES PROJETS (Par défaut)
        if (isset($_GET['success'])) {
            if ($_GET['success'] === 'created') $message = "Le projet a été ajouté avec succès !";
            if ($_GET['success'] === 'deleted') $message = "Le projet a été supprimé.";
        }

        $projets = Projet::findAll();
        require_once __DIR__ . '/../views/admin/ListProjets.php';
    }

    public static function statistiques(): void
    {
        $message = null;

        if (isset($_GET['action']) && $_GET['action'] === 'clear') {
            Visite::clearAll();
            $message = "Toutes les statistiques ont été effacées avec succès !";
        }

        $parcoursUtilisateurs = Visite::findAllGroupedByIP();
        $resumeStats = Visite::getStatsSummary();

        require_once __DIR__ . '/../views/admin/TraficPanel.php';
    }

    public static function profil(): void
    {
        $profilModel = new Profil();
        $message = null;
        $profilActuel = $profilModel->getProfil();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gestion de l'image de profil
            $ancienneImage = $profilActuel['image_profil'] ?? 'default_profil.png';
            $_POST['image_profil'] = self::handleUpload('photo_profil', $ancienneImage);

            // Si une nouvelle photo a été envoyée, on supprime l'ancienne pour faire de la place
            if ($_POST['image_profil'] !== $ancienneImage) {
                self::deleteOldFile($ancienneImage);
            }

            // Gestion du fichier CV (PDF)
            $ancienCv = $profilActuel['lien_cv'] ?? '';
            $_POST['lien_cv'] = self::handleUpload('fichier_cv', $ancienCv);

            // Si un nouveau CV a été envoyé, on supprime l'ancien PDF
            if ($_POST['lien_cv'] !== $ancienCv) {
                self::deleteOldFile($ancienCv);
            }

            $profilModel->updateProfil($_POST);
            $message = "Profil et fichiers mis à jour avec succès !";
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
            header('Location: ?page=competences');
            exit;
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
            header('Location: ?page=outils');
            exit;
        }

        $outils = Outil::findAll();
        require_once __DIR__ . '/../views/admin/AdminOutils.php';
    }

    public static function certifications(): void
    {
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image_url = self::handleUpload('image_certif', 'default_certif.png');
            Certification::add($_POST['nom'] ?? '', $_POST['description'] ?? '', $image_url);
            $message = "Certification ajoutée avec succès !";
        }

        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            Certification::delete($_GET['id']);
            header('Location: ?page=certifications');
            exit;
        }

        $certifications = Certification::findAll();
        require_once __DIR__ . '/../views/admin/AdminCertifications.php';
    }
}
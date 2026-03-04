<?php
namespace App\Controllers;
use App\Models\Admin;
use App\Models\Profil;
use App\Lib\Database; // Ajout pour insérer les projets en base de données

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

    // MISE À JOUR : Gestion de l'affichage ET de la sauvegarde des projets
    public static function projets(): void
    {
        $message = null;
        $error = null;

        // Si l'URL contient action=create et qu'on reçoit le formulaire
        if (isset($_GET['action']) && $_GET['action'] === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = $_POST['titre'] ?? '';
            $description = $_POST['description'] ?? '';
            $detail = $_POST['detail'] ?? '';
            $categorie = $_POST['categorie'] ?? '';
            $technologies = $_POST['technologies'] ?? '';
            $lien_github = $_POST['lien_github'] ?? '';

            try {
                $db = Database::getPDO();
                $stmt = $db->prepare("INSERT INTO projets (titre, description, detail, categorie, technologies, lien_github) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$titre, $description, $detail, $categorie, $technologies, $lien_github]);
                $message = "Le projet a été ajouté avec succès !";
            } catch (\Exception $e) {
                $error = "Erreur lors de l'ajout du projet : " . $e->getMessage();
            }
        }

        require_once __DIR__ . '/../views/admin/CreateProjet.php';
    }

    public static function statistiques(): void
    {
        require_once __DIR__ . '/../views/admin/TraficPanel.php';
    }

    public static function profil(): void
    {
        $profilModel = new Profil();
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profilModel->updateProfil($_POST);
            $message = "Profil mis à jour avec succès !";
        }

        $profil = $profilModel->getProfil();
        require_once __DIR__ . '/../views/admin/ParametresProfil.php';
    }
}
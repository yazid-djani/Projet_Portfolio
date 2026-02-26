<?php
namespace App\Controllers;
use App\Models\Admin;
use App\Models\Profil; // <-- ON AJOUTE ÇA : Permet d'utiliser notre modèle Profil

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

    public static function projets(): void
    {
        require_once __DIR__ . '/../views/admin/CreateProjet.php';
    }

    public static function statistiques(): void
    {
        require_once __DIR__ . '/../views/admin/TraficPanel.php';
    }

    // ==========================================
    // NOUVELLE MÉTHODE : GESTION DU PROFIL
    // ==========================================
    public static function profil(): void
    {
        $profilModel = new Profil(); // Instancie le modèle pour parler à la base de données
        $message = null;             // Prépare une variable vide pour un message de succès

        // Si le formulaire a été envoyé (clic sur Sauvegarder)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profilModel->updateProfil($_POST);       // Met à jour la BDD avec les données du formulaire
            $message = "Profil mis à jour !";         // Crée le message de réussite
        }

        $profil = $profilModel->getProfil();          // Récupère les données actuelles pour pré-remplir le formulaire
        require_once __DIR__ . '/../views/admin/ParametresProfil.php'; // Affiche la page HTML du formulaire
    }
}
<?php
namespace App\Controllers;
use App\Models\Admin;

class AdminController
{
    /**
     * Affiche la page de connexion
     */
    public static function showLogin(): void
    {
        $error = null;
        require_once __DIR__ . '/../views/admin/AdminConnexion.php';
    }

    /**
     * Traite le formulaire de connexion (POST)
     */
    public static function login(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Vérification via le modèle
        $admin = Admin::findByUsername($username);

        if ($admin && password_verify($password, $admin['password_hash'])) {
            // Connexion réussie → on crée la session
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            // Redirection vers le dashboard
            header('Location: ?page=dashboard');
            exit;
        }

        // Échec → on réaffiche le formulaire avec une erreur
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
        require_once __DIR__ . '/../views/admin/AdminConnexion.php';
    }

    /**
     * Déconnexion : détruit la session et redirige vers le login
     */
    public static function logout(): void
    {
        session_destroy();
        header('Location: /');
        exit;
    }

    /**
     * Dashboard admin (page principale avec les rectangles)
     */
    public static function dashboard(): void
    {
        require_once __DIR__ . '/../views/admin/AdminPage.php';
    }

    /**
     * Page de gestion des projets
     */
    public static function projets(): void
    {
        require_once __DIR__ . '/../views/admin/CreateProjet.php';
    }

    /**
     * Page des statistiques de trafic
     */
    public static function statistiques(): void
    {
        require_once __DIR__ . '/../views/admin/TraficPanel.php';
    }
}
<?php
namespace App\Controllers;

use App\Models\Admin;
use App\Models\Profil;
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

    /**
     * Fonction utilitaire pour gérer l'upload des images/vidéos
     */
    private static function handleUpload($fileInputName, $defaultName) {
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES[$fileInputName]['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $ext; // Crée un nom unique
            $dest = __DIR__ . '/../../public/images/' . $filename;
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

            // Gestion de l'upload du média
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
        require_once __DIR__ . '/../views/admin/TraficPanel.php';
    }

    public static function profil(): void
    {
        $profilModel = new Profil();
        $message = null;
        $profilActuel = $profilModel->getProfil();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Upload de la nouvelle photo de profil
            $ancienneImage = $profilActuel['image_profil'] ?? 'default_profil.png';
            $_POST['image_profil'] = self::handleUpload('photo_profil', $ancienneImage);

            $profilModel->updateProfil($_POST);
            $message = "Profil et photo mis à jour avec succès !";
            $profilActuel = $profilModel->getProfil(); // Recharger pour la vue
        }

        $profil = $profilActuel;
        require_once __DIR__ . '/../views/admin/ParametresProfil.php';
    }
}
<?php
// On déclare dans quel "dossier virtuel" (namespace) se trouve ce fichier pour bien l'organiser
namespace App\Controllers;

// On importe les "Modèles" pour pouvoir interagir avec les différentes tables de la base de données
use App\Models\Admin;
use App\Models\Profil;
use App\Models\Projet; // Ajouté pour gérer les projets
use App\Models\Competence;
use App\Models\Outil;
use App\Models\Certification;
use App\Models\Visite; // Nécessaire pour les statistiques
use App\Lib\Database; // Outil de connexion à la base de données

class AdminController
{
    // ==========================================
    // GESTION DE LA CONNEXION / DÉCONNEXION
    // ==========================================

    // Affiche simplement la page de connexion
    public static function showLogin(): void
    {
        $error = null; // Prépare une variable d'erreur vide
        require_once __DIR__ . '/../views/admin/AdminConnexion.php'; // Charge le fichier HTML de connexion
    }

    // Traite le formulaire quand tu cliques sur "Se connecter"
    public static function login(): void
    {
        $username = trim($_POST['username'] ?? ''); // Récupère le nom d'utilisateur saisi (sans les espaces)
        $password = $_POST['password'] ?? ''; // Récupère le mot de passe saisi
        $admin = Admin::findByUsername($username); // Cherche l'utilisateur dans la base de données

        // Vérifie si l'admin existe ET si le mot de passe correspond au hash (Bcrypt) de la BDD
        if ($admin && password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_id'] = $admin['id']; // Sauvegarde ton ID dans la session
            $_SESSION['admin_username'] = $admin['username']; // Sauvegarde ton nom dans la session
            header('Location: ?page=dashboard'); // Te redirige vers le tableau de bord
            exit; // Stoppe l'exécution du script
        }

        // Si le mot de passe est faux, on prépare un message d'erreur et on réaffiche la page
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
        require_once __DIR__ . '/../views/admin/AdminConnexion.php';
    }

    // Déconnecte l'utilisateur
    public static function logout(): void
    {
        session_destroy(); // Détruit toutes les données de ta session (te déconnecte)
        header('Location: /'); // Te renvoie sur la page d'accueil du site public
        exit;
    }

    // Affiche la page d'accueil de l'administration (les gros carrés)
    public static function dashboard(): void
    {
        require_once __DIR__ . '/../views/admin/AdminPage.php';
    }

    // ==========================================
    // FONCTION UTILITAIRE (UPLOAD D'IMAGES/MÉDIAS)
    // ==========================================

    // Cette fonction prend un fichier (photo, vidéo) et l'enregistre sur le serveur de façon sécurisée
    private static function handleUpload($fileInputName, $defaultName) {
        $dir = __DIR__ . '/../../public/images/'; // Chemin du dossier où sauvegarder l'image

        // Si le dossier "images" n'existe pas, on le crée avec les permissions 0755 (sécurisé)
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Vérifie si un fichier a été envoyé et s'il n'y a pas d'erreur
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES[$fileInputName]['name'], PATHINFO_EXTENSION)); // Récupère l'extension (.jpg, .png...)

            // CORRECTION DE SÉCURITÉ : Liste des extensions autorisées pour éviter l'upload de fichiers PHP malveillants
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm'];
            if (!in_array($ext, $allowedExts)) {
                return $defaultName; // Rejette le fichier si ce n'est pas une image/vidéo
            }

            $filename = uniqid() . '.' . $ext; // Crée un nom unique (ex: 64a8b.png) pour éviter d'écraser un autre fichier
            $dest = $dir . $filename; // Chemin final complet

            // Déplace le fichier temporaire vers son dossier final
            if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $dest)) {
                return $filename; // Retourne le nouveau nom pour le sauvegarder dans la BDD
            }
        }
        return $defaultName; // Si pas de fichier envoyé, on garde l'image par défaut
    }

    // ==========================================
    // GESTION DES PAGES DU PANEL
    // ==========================================

    // Gère la page "Projets" (Liste, Ajout, Suppression)
    public static function projets(): void
    {
        $message = null; // Variable pour le message de succès
        $error = null; // Variable pour le message d'erreur
        $action = $_GET['action'] ?? 'list'; // Par défaut, on affiche la liste

        // 1. SUPPRESSION D'UN PROJET
        if ($action === 'delete' && isset($_GET['id'])) {
            $db = Database::getPDO();
            $stmt = $db->prepare("DELETE FROM projets WHERE id = ?");
            $stmt->execute([$_GET['id']]);
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

                // Utilise notre fonction sécurisée pour sauvegarder l'image/vidéo du projet
                $image_url = self::handleUpload('media_projet', 'default.jpg');

                try {
                    $db = Database::getPDO(); // Connexion BDD
                    $stmt = $db->prepare("INSERT INTO projets (titre, description, detail, categorie, technologies, image_url, lien_github) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$titre, $description, $detail, $categorie, $technologies, $image_url, $lien_github]);

                    // Redirige vers la liste avec un message de succès
                    header('Location: ?page=projets&success=created');
                    exit;
                } catch (\Exception $e) {
                    $error = "Erreur lors de l'ajout du projet : " . $e->getMessage();
                }
            }
            // Affiche la page HTML pour créer un projet
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

    // Gère la page "Trafic Panel" (Statistiques)
    public static function statistiques(): void
    {
        $message = null;

        // Si on a cliqué sur le bouton rouge "Vider les stats"
        if (isset($_GET['action']) && $_GET['action'] === 'clear') {
            \App\Models\Visite::clearAll(); // Appelle le modèle pour vider la table
            $message = "Toutes les statistiques ont été effacées avec succès !";
        }

        // Récupère les données depuis la base pour les afficher dans le tableau
        $parcoursUtilisateurs = \App\Models\Visite::findAllGroupedByIP();
        $resumeStats = \App\Models\Visite::getStatsSummary();

        require_once __DIR__ . '/../views/admin/TraficPanel.php'; // Affiche la page HTML
    }

    // Gère la page "Profil"
    public static function profil(): void
    {
        $profilModel = new Profil();
        $message = null;
        $profilActuel = $profilModel->getProfil(); // Charge les données actuelles pour pré-remplir le formulaire

        // Si le formulaire de mise à jour est envoyé
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sauvegarde de l'ancienne image pour ne pas la perdre si on n'envoie pas de nouvelle photo
            $ancienneImage = $profilActuel['image_profil'] ?? 'default_profil.png';
            $_POST['image_profil'] = self::handleUpload('photo_profil', $ancienneImage);

            // Met à jour la BDD avec les nouvelles données
            $profilModel->updateProfil($_POST);
            $message = "Profil et photo mis à jour avec succès !";
            $profilActuel = $profilModel->getProfil(); // Recharge les données fraîches pour l'affichage
        }

        $profil = $profilActuel;
        require_once __DIR__ . '/../views/admin/ParametresProfil.php'; // Affiche la page HTML
    }

    // Gère la page "Compétences" (Ajout / Suppression)
    public static function competences(): void
    {
        $message = null;

        // Si on soumet le formulaire pour ajouter une compétence
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Competence::add($_POST['nom'], $_POST['pourcentage'], $_POST['categorie']);
            $message = "Compétence ajoutée !";
        }

        // Si on clique sur le bouton "Supprimer" (action=delete avec l'ID)
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            Competence::delete($_GET['id']);
            header('Location: ?page=competences'); // Recharge la page pour mettre à jour la liste
            exit;
        }

        // Récupère toutes les compétences pour les afficher
        $competences = Competence::findAll();
        require_once __DIR__ . '/../views/admin/AdminCompetences.php';
    }

    // Gère la page "Outils" (Ajout / Suppression avec image)
    public static function outils(): void
    {
        $message = null;

        // Si on ajoute un outil
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image_url = self::handleUpload('image_outil', 'default_outil.png'); // Gère l'image de l'outil
            Outil::add($_POST['nom'] ?? '', $image_url);
            $message = "Outil ajouté !";
        }

        // Si on supprime un outil
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            Outil::delete($_GET['id']);
            header('Location: ?page=outils'); exit;
        }

        $outils = Outil::findAll();
        require_once __DIR__ . '/../views/admin/AdminOutils.php';
    }

    // Gère la page "Certifications" (Ajout / Suppression avec image)
    public static function certifications(): void
    {
        $message = null;

        // Si on ajoute une certification
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image_url = self::handleUpload('image_certif', 'default_certif.png'); // Gère l'image du diplôme
            Certification::add($_POST['nom'] ?? '', $_POST['description'] ?? '', $image_url);
            $message = "Certification ajoutée avec succès !";
        }

        // Si on supprime une certification
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            Certification::delete($_GET['id']);
            header('Location: ?page=certifications'); exit;
        }

        $certifications = Certification::findAll();
        require_once __DIR__ . '/../views/admin/AdminCertifications.php';
    }
}
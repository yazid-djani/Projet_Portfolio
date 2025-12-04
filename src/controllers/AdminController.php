<?php
namespace App\Controllers;

// On utilise le modèle spécifique Administrateur qui contient la logique métier
use App\Models\Administrateur;

class AdminController {
    
    /**
     * Vérification de sécurité pour toutes les méthodes admin.
     * Si l'utilisateur n'est pas connecté ou n'est pas admin, on redirige.
     */
    private function isAdmin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?route=connexion');
            exit;
        }
    }

    /**
     * Instancie le modèle Administrateur avec l'ID de la session courante.
     * Cela permet d'utiliser les méthodes de gestion (voir utilisateurs, etc.).
     */
    private function getAdminModel() {
        // On passe l'ID de l'admin connecté pour respecter le constructeur de Utilisateur
        return new Administrateur(['user_id' => $_SESSION['user_id']]);
    }

    /**
     * Affiche le tableau de bord principal de l'administrateur.
     */
    public function dashboard() {
        $this->isAdmin();
        
        // Vous pourrez ici récupérer des statistiques globales via le modèle si besoin
        // $admin = $this->getAdminModel();
        // $stats = $admin->getGlobalStats();

        // Pour l'instant, on affiche une vue simple ou un menu
        require __DIR__ . '/../views/dashboard.php'; // Ou une vue spécifique admin_dashboard.php
    }

    /**
     * GESTION DES UTILISATEURS
     * Récupère la liste via le modèle et l'envoie à la vue.
     */
    public function gererUtilisateurs() {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        
        // Appel de la méthode du modèle (logique SQL déportée)
        $users = $admin->voirListeUtilisateurs();

        require __DIR__ . '/../views/admin_users.php';
    }

    /**
     * Active/Désactive un compte utilisateur (Bannissement).
     */
    public function toggleUserStatus($userId) {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        
        $admin->toggleStatutUtilisateur($userId);
        
        header('Location: index.php?route=admin_users');
        exit;
    }

    /**
     * Donne ou retire le droit de création de quiz (pour Écoles/Entreprises).
     */
    public function toggleQuizCreationRight($userId) {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        
        $admin->toggleDroitCreationQuiz($userId);
        
        header('Location: index.php?route=admin_users');
        exit;
    }

    /**
     * GESTION DES QUIZ
     * Affiche la liste de tous les quiz créés sur la plateforme.
     */
    public function gererQuiz() {
        $this->isAdmin();
        $admin = $this->getAdminModel();

        // Récupération de tous les quiz
        $quizzes = $admin->voirListeQuiz();

        // Vous devrez créer cette vue (sur le modèle de admin_users.php)
        require __DIR__ . '/../views/admin_quizzes.php'; 
    }

    /**
     * Archive un quiz (le rend inaccessible/désactivé).
     */
    public function archiverQuiz($quizId) {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        
        // On passe le statut à 'archived'
        $admin->changerStatutQuiz($quizId, 'archived');
        
        header('Location: index.php?route=admin_quizzes');
        exit;
    }
}
?>
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
     */
    private function getAdminModel() {
        return new Administrateur(['user_id' => $_SESSION['user_id']]);
    }

    /**
     * Affiche le tableau de bord principal de l'administrateur.
     */
    public function dashboard() {
        $this->isAdmin();
        require __DIR__ . '/../views/dashboard.php'; 
    }

    /**
     * GESTION DES UTILISATEURS
     * Gère le filtrage par rôle via l'URL
     */
    public function gererUtilisateurs() {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        
        // 1. Récupération du filtre depuis l'URL (ex: &type=ecole)
        $filter = $_GET['type'] ?? null;
        
        // Sécurité : on vérifie que le filtre est un rôle valide
        $allowedFilters = ['utilisateur', 'ecole', 'entreprise'];
        if ($filter && !in_array($filter, $allowedFilters)) {
            $filter = null;
        }

        // 2. Appel du modèle avec le filtre
        $users = $admin->voirListeUtilisateurs($filter);

        // 3. Définition du titre de la page selon le filtre actif
        $pageTitle = match($filter) {
            'ecole' => 'Liste des Écoles',
            'entreprise' => 'Liste des Entreprises',
            'utilisateur' => 'Liste des Joueurs',
            default => 'Gestion de tous les Utilisateurs'
        };

        require __DIR__ . '/../views/admin/admin_users.php';
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
     * Donne ou retire le droit de création de quiz (Méthode générique).
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
     */
    public function gererQuiz() {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        $quizzes = $admin->voirListeQuiz();
        require __DIR__ . '/../views/dashboard.php'; 
    }

    /**
     * Archive un quiz.
     */
    public function archiverQuiz($quizId) {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        $admin->changerStatutQuiz($quizId, 'archived');
        header('Location: index.php?route=admin_quizzes');
        exit;
    }

    // ============================================================
    // GESTION DES CRÉATEURS (Nouvelles méthodes)
    // ============================================================

    /**
     * Affiche la liste des utilisateurs qui ONT le droit de créer des quiz.
     */
    public function listeCreateurs() {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        
        // On récupère ceux qui ont le droit (1)
        $creators = $admin->recupererParDroitCreation(1);
        
        require __DIR__ . '/../views/admin/admin_creators.php';
    }

    /**
     * Affiche la liste des utilisateurs qui N'ONT PAS le droit (pour les ajouter).
     */
    public function pageAjoutCreateur() {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        
        // On récupère ceux qui n'ont pas le droit (0)
        $users = $admin->recupererParDroitCreation(0);
        
        require __DIR__ . '/../views/admin/admin_add_creator.php';
    }

    /**
     * Donne le droit de création à un utilisateur spécifique.
     */
    public function validerCreateur($userId) {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        
        // On donne le droit
        $admin->toggleDroitCreationQuiz($userId);
        
        // Retour à la page d'ajout
        header('Location: index.php?route=admin_add_creator');
        exit;
    }
    
    /**
     * Retire le droit de création (depuis la liste des créateurs).
     */
    public function retirerCreateur($userId) {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        
        // On retire le droit
        $admin->toggleDroitCreationQuiz($userId);
        
        header('Location: index.php?route=admin_creators');
        exit;
    }
}
?>
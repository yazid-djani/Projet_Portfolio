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
        
        // Pour l'instant, on affiche le dashboard standard
        require __DIR__ . '/../views/dashboard.php'; 
    }

    /**
     * GESTION DES UTILISATEURS
     * MODIFIÉ : Gère le filtrage par rôle via l'URL
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

        require __DIR__ . '/../views/admin_users.php';
    }

    /**
     * Active/Désactive un compte utilisateur (Bannissement).
     */
    public function toggleUserStatus($userId) {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        
        $admin->toggleStatutUtilisateur($userId);
        
        // On redirige vers la liste, en gardant le filtre s'il y en avait un (optionnel, ici retour simple)
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

        // Si vous avez créé la vue spécifique, utilisez admin_quizzes.php
        // Sinon, dashboard.php peut faire l'affaire temporairement
        // require __DIR__ . '/../views/admin_quizzes.php'; 
        require __DIR__ . '/../views/dashboard.php'; 
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
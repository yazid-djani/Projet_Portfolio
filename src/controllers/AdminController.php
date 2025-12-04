<?php
namespace App\Controllers;
use App\Models\Administrateur;

class AdminController {
    private function isAdmin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?route=connexion');
            exit;
        }
    }

    private function getAdminModel() {
        return new Administrateur(['user_id' => $_SESSION['user_id']]);
    }

    public function dashboard() {
        $this->isAdmin();
        require __DIR__ . '/../views/dashboard.php'; 
    }

    public function gererUtilisateurs() {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        
        $filter = $_GET['type'] ?? null;

        $allowedFilters = ['utilisateur', 'ecole', 'entreprise'];
        if ($filter && !in_array($filter, $allowedFilters)) {
            $filter = null;
        }

        $users = $admin->voirListeUtilisateurs($filter);

        $pageTitle = match($filter) {
            'ecole' => 'Liste des Écoles',
            'entreprise' => 'Liste des Entreprises',
            'utilisateur' => 'Liste des Joueurs',
            default => 'Gestion de tous les Utilisateurs'
        };

        require __DIR__ . '/../views/admin/admin_users.php';
    }

    public function toggleUserStatus($userId) {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        $admin->toggleStatutUtilisateur($userId);
        header('Location: index.php?route=admin_users');
        exit;
    }

    public function toggleQuizCreationRight($userId) {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        $admin->toggleDroitCreationQuiz($userId);
        header('Location: index.php?route=admin_users');
        exit;
    }

    public function gererQuiz() {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        $quizzes = $admin->voirListeQuiz();
        require __DIR__ . '/../views/dashboard.php'; 
    }

    public function archiverQuiz($quizId) {
        $this->isAdmin();
        $admin = $this->getAdminModel();
        $admin->changerStatutQuiz($quizId, 'archived');
        header('Location: index.php?route=admin_quizzes');
        exit;
    }

    public function listeCreateurs() {
        $this->isAdmin();
        $admin = $this->getAdminModel();

        $creators = $admin->recupererParDroitCreation(1);
        
        require __DIR__ . '/../views/admin/admin_creators.php';
    }

    public function pageAjoutCreateur() {
        $this->isAdmin();
        $admin = $this->getAdminModel();

        $users = $admin->recupererParDroitCreation(0);
        
        require __DIR__ . '/../views/admin/admin_add_creator.php';
    }

    public function validerCreateur($userId) {
        $this->isAdmin();
        $admin = $this->getAdminModel();

        $admin->toggleDroitCreationQuiz($userId);

        header('Location: index.php?route=admin_add_creator');
        exit;
    }

    public function retirerCreateur($userId) {
        $this->isAdmin();
        $admin = $this->getAdminModel();

        $admin->toggleDroitCreationQuiz($userId);
        
        header('Location: index.php?route=admin_creators');
        exit;
    }
}
?>
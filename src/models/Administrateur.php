<?php
namespace App\Models;

use App\Lib\Database;

class Administrateur extends Utilisateur
{
    public function __construct(array $data) {
        parent::__construct($data);
        $this->role = 'admin'; 
    }

    public function voirListeUtilisateurs(?string $roleFilter = null) {
        $pdo = Database::getPDO();
        
        $sql = "SELECT * FROM users WHERE role != 'admin'";
        $params = [];

        if ($roleFilter) {
            $sql .= " AND role = ?";
            $params[] = $roleFilter;
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function toggleStatutUtilisateur($userId) {
        $pdo = Database::getPDO();
        $sql = "UPDATE users 
                SET status = IF(status='active', 'desactive', 'active') 
                WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$userId]);
    }

    public function toggleDroitCreationQuiz($userId) {
        $pdo = Database::getPDO();
        $sql = "UPDATE users SET can_create_quiz = NOT can_create_quiz WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$userId]);
    }

    public function recupererParDroitCreation(int $etat) {
        $pdo = Database::getPDO();
        // On exclut l'admin de la liste
        $sql = "SELECT * FROM users WHERE can_create_quiz = ? AND role != 'admin' ORDER BY user_lastname ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$etat]);
        return $stmt->fetchAll();
    }

    public function voirListeQuiz() {
        $pdo = Database::getPDO();
        $sql = "SELECT q.*, u.user_firstname, u.user_lastname, u.user_email 
                FROM quiz q
                JOIN users u ON q.user_id = u.user_id
                ORDER BY q.created_at DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function changerStatutQuiz($quizId, $nouveauStatut) {
        $statutsValides = ['brouillon', 'published', 'archived'];
        if (!in_array($nouveauStatut, $statutsValides)) {
            return false;
        }

        $pdo = Database::getPDO();
        $sql = "UPDATE quiz SET status = ? WHERE id_quiz = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$nouveauStatut, $quizId]);
    }
}
?>
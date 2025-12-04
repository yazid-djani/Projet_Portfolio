<?php
namespace App\Models;

use App\Lib\Database;

class Administrateur extends Utilisateur
{
    public function __construct(array $data) {
        parent::__construct($data);
        // On s'assure que le rôle est bien ADMIN
        $this->role = 'admin'; 
    }

    // ============================================================
    // GESTION DES UTILISATEURS
    // ============================================================

    /**
     * Récupère la liste des utilisateurs inscrits (sauf l'admin).
     * Accepte un filtre optionnel pour le rôle.
     */
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

    /**
     * Active ou désactive un compte utilisateur (Bannissement).
     */
    public function toggleStatutUtilisateur($userId) {
        $pdo = Database::getPDO();
        $sql = "UPDATE users 
                SET status = IF(status='active', 'desactive', 'active') 
                WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$userId]);
    }

    /**
     * Donne ou retire le droit de création de quiz.
     */
    public function toggleDroitCreationQuiz($userId) {
        $pdo = Database::getPDO();
        $sql = "UPDATE users SET can_create_quiz = NOT can_create_quiz WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$userId]);
    }

    /**
     * Récupère les utilisateurs selon leur droit de création de quiz.
     * @param int $etat 1 pour les créateurs, 0 pour ceux qui ne le sont pas.
     */
    public function recupererParDroitCreation(int $etat) {
        $pdo = Database::getPDO();
        // On exclut l'admin de la liste
        $sql = "SELECT * FROM users WHERE can_create_quiz = ? AND role != 'admin' ORDER BY user_lastname ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$etat]);
        return $stmt->fetchAll();
    }

    // ============================================================
    // GESTION DES QUIZ
    // ============================================================

    /**
     * Récupère tous les quiz avec les infos du créateur.
     */
    public function voirListeQuiz() {
        $pdo = Database::getPDO();
        $sql = "SELECT q.*, u.user_firstname, u.user_lastname, u.user_email 
                FROM quiz q
                JOIN users u ON q.user_id = u.user_id
                ORDER BY q.created_at DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Change le statut d'un quiz.
     */
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
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
     * MODIFIÉ : Accepte un filtre optionnel pour le rôle.
     * * @param string|null $roleFilter 'ecole', 'entreprise' ou 'utilisateur'
     */
    public function voirListeUtilisateurs(?string $roleFilter = null) {
        $pdo = Database::getPDO();
        
        // Requête de base : on exclut toujours les admins
        $sql = "SELECT * FROM users WHERE role != 'admin'";
        $params = [];

        // Si un filtre est fourni, on ajoute la condition à la requête
        if ($roleFilter) {
            $sql .= " AND role = ?";
            $params[] = $roleFilter;
        }

        // On termine par le tri
        $sql .= " ORDER BY created_at DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Active ou désactive un compte utilisateur (Bannissement)
     * Bascule entre 'active' et 'desactive'
     */
    public function toggleStatutUtilisateur($userId) {
        $pdo = Database::getPDO();
        // Inverse le statut actuel
        $sql = "UPDATE users 
                SET status = IF(status='active', 'desactive', 'active') 
                WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$userId]);
    }

    /**
     * Donne ou retire le droit de création de quiz (pour Ecoles/Entreprises)
     */
    public function toggleDroitCreationQuiz($userId) {
        $pdo = Database::getPDO();
        $sql = "UPDATE users SET can_create_quiz = NOT can_create_quiz WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$userId]);
    }

    // ============================================================
    // GESTION DES QUIZ
    // ============================================================

    /**
     * Récupère tous les quiz avec les infos du créateur
     */
    public function voirListeQuiz() {
        $pdo = Database::getPDO();
        // Jointure pour afficher le nom du créateur du quiz
        $sql = "SELECT q.*, u.user_firstname, u.user_lastname, u.user_email 
                FROM quiz q
                JOIN users u ON q.user_id = u.user_id
                ORDER BY q.created_at DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Change le statut d'un quiz (Activer/Désactiver/Archiver)
     * @param int $quizId
     * @param string $nouveauStatut ('published', 'archived', 'brouillon')
     */
    public function changerStatutQuiz($quizId, $nouveauStatut) {
        // Vérification que le statut est valide selon l'ENUM de la BDD
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
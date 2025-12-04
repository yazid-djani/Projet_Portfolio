<?php
namespace App\Models;
use App\Lib\Database;

class Ecole extends Utilisateur
{
    // Redirige vers une vue ou un routeur spécifique
    public function accederDashboard() {
        return "index.php?route=dashboard_ecole";
    }

    // Récupère le nombre total de réponses sur TOUS les quiz créés par cette école
    public function voirNombreReponse() {
        $pdo = Database::getPDO();
        $sql = "SELECT COUNT(r.id_reponse) as total 
                FROM reponse r
                JOIN question q ON r.id_question = q.id_question
                JOIN quiz z ON q.id_quiz = z.id_quiz
                WHERE z.user_id = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->getId()]);
        return $stmt->fetchColumn();
    }

    // Retourne les quiz avec leur état (brouillon/publié)
    public function voirStatutQuiz() {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT titre, status, created_at FROM quiz WHERE user_id = ?");
        $stmt->execute([$this->getId()]);
        return $stmt->fetchAll();
    }

    // Affiche les résultats des élèves (utilisateurs) sur les quiz de l'école
    public function visualiserResultatsEleves() {
        $pdo = Database::getPDO();
        // Récupère : Nom de l'élève, Titre du Quiz, Score
        $sql = "SELECT u.user_lastname, u.user_firstname, q.titre, t.score_total, t.date_fin
                FROM tentative t
                JOIN users u ON t.user_id = u.user_id
                JOIN quiz q ON t.id_quiz = q.id_quiz
                WHERE q.user_id = ? 
                ORDER BY t.date_fin DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->getId()]);
        return $stmt->fetchAll();
    }
    
    // Ces méthodes sont gérées par le QuizController, on peut les laisser vides ou faire des alias
    public function creerQuiz() { return true; } 
    public function modifierQuiz() { return true; }
}
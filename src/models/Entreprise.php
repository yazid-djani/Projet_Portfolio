<?php
namespace App\Models;
use App\Lib\Database;

class Entreprise extends Utilisateur
{
    public function accederDashboard() {
        return "index.php?route=dashboard_entreprise";
    }

    public function voirNombreReponse() {
        $pdo = Database::getPDO();
        $sql = "SELECT COUNT(t.id_tentative) as total 
                FROM tentative t
                JOIN quiz z ON t.id_quiz = z.id_quiz
                WHERE z.user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->getId()]);
        return $stmt->fetchColumn();
    }

    public function voirStatutQuiz() {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT titre, status, date_lancement, date_cloture FROM quiz WHERE user_id = ?");
        $stmt->execute([$this->getId()]);
        return $stmt->fetchAll();
    }

    // Statistiques spécifiques pour l'entreprise (ex: moyenne des scores)
    public function visualiserResultatsEntreprise() {
        $pdo = Database::getPDO();
        $sql = "SELECT q.titre, AVG(t.score_total) as moyenne_score, COUNT(t.id_tentative) as nb_participants
                FROM quiz q
                LEFT JOIN tentative t ON q.id_quiz = t.id_quiz
                WHERE q.user_id = ?
                GROUP BY q.id_quiz";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$this->getId()]);
        return $stmt->fetchAll();
    }

    public function modifierQuiz() { return true; }
}
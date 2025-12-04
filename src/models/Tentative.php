<?php
namespace App\Models;

use App\Lib\Database;

class Tentative {
    private $id_tentative; 
    private $id_quiz;
    private $user_id;
    private $date_debut;
    private $date_fin;
    private $score_total;

    public function __construct(array $data){
        $this->id_tentative = $data['id_tentative'] ?? null;
        $this->id_quiz      = $data['id_quiz'] ?? null;
        $this->user_id      = $data['user_id'] ?? null;
        
        // Si aucune date n'est fournie, on prend la date actuelle
        $this->date_debut   = $data['date_debut'] ?? date('Y-m-d H:i:s');
        $this->date_fin     = $data['date_fin'] ?? null;
        $this->score_total  = $data['score_total'] ?? 0;
    }

    // --- GETTERS ---
    public function getIdTentative() { return $this->id_tentative; }
    public function getIdQuiz()      { return $this->id_quiz; }
    public function getUserId()      { return $this->user_id; }
    public function getDateDebut()   { return $this->date_debut; }
    public function getDateFin()     { return $this->date_fin; }
    public function getScoreTotal()  { return $this->score_total; }

    // --- SETTERS (si besoin pour mettre à jour après le constructeur) ---
    public function setScoreTotal($score) { $this->score_total = $score; }
    public function setDateFin($date)     { $this->date_fin = $date; }

    // --- SAUVEGARDE EN BDD ---
    public function save() {
        $pdo = Database::getPDO();
        
        // Si on a déjà un ID, c'est une mise à jour (fin de quiz)
        if ($this->id_tentative) {
            $stmt = $pdo->prepare("UPDATE tentative SET score_total = ?, date_fin = ? WHERE id_tentative = ?");
            return $stmt->execute([
                $this->score_total,
                $this->date_fin ?? date('Y-m-d H:i:s'),
                $this->id_tentative
            ]);
        } 
        // Sinon, c'est une nouvelle tentative (début de quiz)
        else {
            $stmt = $pdo->prepare("INSERT INTO tentative (id_quiz, user_id, date_debut, score_total) VALUES (?, ?, ?, ?)");
            $result = $stmt->execute([
                $this->id_quiz, 
                $this->user_id, 
                $this->date_debut,
                $this->score_total
            ]);
            
            // On récupère l'ID généré pour l'objet actuel
            if ($result) {
                $this->id_tentative = $pdo->lastInsertId();
            }
            return $result;
        }
    }
}
?>
<?php
namespace App\Models;
use App\Lib\Database;

class Quiz{
    private $id_quiz;
    private $user_id;
    private $titre;
    private $description;
    private $statut;
    private $proprietaire;
    private $date_lancement;
    private $date_cloture;
    private $created_at;
    
    public function __construct(array $data){
        $this->id_quiz          = $data['id_quiz'] ?? null;
        $this->user_id          = $data['user_id'];
        $this->titre            = $data['titre'];
        $this->description      = $data['description'] ?? null;
        $this->statut           = $data['statut'] ?? 'brouillon';
        $this->proprietaire     = $data['proprietaire'] ?? 'utilisateur'; // Correction typo
        // Correction de l'accès aux dates
        $this->date_lancement   = !empty($data['date_lancement']) ? $data['date_lancement'] : null;
        $this->date_cloture     = !empty($data['date_cloture']) ? $data['date_cloture'] : null;
        $this->created_at       = $data['created_at'] ?? null;
    }

    // Getters pour l'affichage
    public function getId() { return $this->id_quiz; }
    public function getTitre() { return $this->titre; }
    // ... autres getters si besoin

    public function save() {
        $pdo = Database::getPDO();
        $sql = "INSERT INTO quiz (user_id, titre, description, proprietaire, status, date_lancement, date_cloture) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $this->user_id,
            $this->titre,
            $this->description,
            $this->proprietaire,
            $this->statut,
            $this->date_lancement,
            $this->date_cloture
        ]);
    }

    public static function quizByUser($user_id) {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM quiz WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
    
    // Nouvelle méthode pour récupérer le dernier ID inséré
    public static function getLastId() {
        return Database::getPDO()->lastInsertId();
    }
}
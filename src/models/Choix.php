<?php
namespace App\Models;
use App\Lib\Database;

class Choix {
    private $id_choix;
    private $id_question; // Ajouté
    private $libelle;
    private $estCorrect;

    public function __construct(array $data){
        $this->id_choix = $data['id_choix'] ?? null;
        $this->id_question = $data['id_question']; // Important
        $this->libelle = $data['libelle'];
        $this->estCorrect = $data['est_correct'] ?? 0;
    }

    public function save(){
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO choix (id_question, libelle, est_correct) VALUES (?, ?, ?)");
        return $stmt->execute([
            $this->id_question,
            $this->libelle,
            $this->estCorrect
        ]);
    }
}
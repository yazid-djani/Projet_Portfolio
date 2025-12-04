<?php
    declare(strict_types=1);

    namespace App\Models;
    use App\Lib\Database;

    class Question{
        // CORRECTION 1 : Ajout du '?' devant int pour autoriser le NULL (nullable)
        private ?int $id_question;
        private int $id_quiz;
        private string $libelle;        
        
        // --- CONSTRUCTEUR ---
        public function __construct(array $data) {
            // Si pas d'id, on laisse null
            $this->id_question  = isset($data['id_question']) ? (int)$data['id_question'] : null;
            
            // CORRECTION 2 : Forçage du type (int) pour éviter l'erreur si c'est une string "12"
            $this->id_quiz      = (int)$data['id_quiz'];
            
            $this->libelle      = $data['libelle'];
        }
        
        // --- GETTERS ---
        // CORRECTION 3 : Le retour peut être null (?int)
        public function getIdQuestion() : ?int   { return $this->id_question; }
        public function getIdQuizz()    : int    { return $this->id_quiz; }

        // --- SETTERS ---
        public function setIdQuestion(int $id_question) : void { $this->id_question = $id_question; }
        public function setIdQuizz(int $id_quiz)        : void { $this->id_quiz = $id_quiz; }
        

        // --- METHODE ---
        public function save(){
            $pdo = Database::getPDO();
            $stmt = $pdo->prepare("INSERT INTO question (id_quiz, libelle) VALUES (?, ?)");
            return $stmt->execute([
                $this->id_quiz,
                $this->libelle
            ]);
        }
    }
?>
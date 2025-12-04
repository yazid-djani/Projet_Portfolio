<?php
    declare(strict_types=1);

    namespace App\Models;
    use App\Lib\Database;

    class Question{
        private ?int $id_question;
        private int $id_quiz;
        private string $libelle;        
        
        // --- CONSTRUCTEUR ---
        public function __construct(array $data) {
            $this->id_question  = isset($data['id_question']) ? (int)$data['id_question'] : null;
            $this->id_quiz      = (int)$data['id_quiz'];
            $this->libelle      = $data['libelle'];
        }
        
        // --- GETTERS ---
        public function getIdQuestion() : ?int   { return $this->id_question; }
        public function getIdQuiz()    : int    { return $this->id_quiz; }

        // --- SETTERS ---
        public function setIdQuestion(int $id_question) : void { $this->id_question = $id_question; }
        public function setIdQuiz(int $id_quiz)        : void { $this->id_quiz = $id_quiz; }

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
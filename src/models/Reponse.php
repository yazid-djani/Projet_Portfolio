<?php
    namespace App\Models;
    use App\Lib\Database;

    class Reponse {
        private $id_reponse; 
        private $est_correct;

        public function __construct(array $data){
            $this->id_reponse = $data['id_reponse'] ?? null;
            $this->est_correct = $data['est_correct'] ?? null;
        }

    // --- GETTERS ---
        public function getId_reponse(){ return $this->id_reponse; }
        public function getest_correct(){ return $this->est_correct; }

         // SAUVEGARDE DES SAISIES UTILISATEURS
        public function save(int $tentativeId, int $questionId, int $choixId, bool $estCorrect){
            $pdo = Database::getPDO();
            $stmt = $pdo->prepare("INSERT INTO reponse (est_correct, id_tentative, id_question, id_choix) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $estCorrect ? 1 : 0, 
                $tentativeId, 
                $questionId, 
                $choixId
            ]);
        }
    }
?>
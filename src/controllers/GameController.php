<?php
namespace App\Controllers;

use App\Models\Quiz;
use App\Models\Tentative;
use App\Models\Reponse;
use App\Lib\Database;

class GameController {

    // Affiche le quiz pour le jouer (UML : "jouerQuiz")
    public function play($id_quiz) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=connexion');
            exit;
        }

        $pdo = Database::getPDO();
        
        // 1. Récupérer le quiz
        $stmt = $pdo->prepare("SELECT * FROM quiz WHERE id_quiz = ?");
        $stmt->execute([$id_quiz]);
        $quiz = $stmt->fetch();

        // 2. Récupérer les questions et choix associés
        $stmt = $pdo->prepare("
            SELECT q.id_question, q.libelle as question_lib, 
                c.id_choix, c.libelle as choix_lib 
            FROM question q 
            LEFT JOIN choix c ON q.id_question = c.id_question 
            WHERE q.id_quiz = ?
        ");
        $stmt->execute([$id_quiz]);
        $rawResults = $stmt->fetchAll();

        // Organiser les données pour la vue
        $questions = [];
        foreach ($rawResults as $row) {
            $qid = $row['id_question'];
            if (!isset($questions[$qid])) {
                $questions[$qid] = [
                    'libelle' => $row['question_lib'],
                    'choix' => []
                ];
            }
            if ($row['id_choix']) {
                $questions[$qid]['choix'][] = [
                    'id' => $row['id_choix'],
                    'libelle' => $row['choix_lib']
                ];
            }
        }

        require __DIR__ . '/../views/play_quiz.php'; // Vue à créer
    }

    // Traite la soumission du formulaire (UML : classe "Tentative" et "Reponse")
    public function submit($id_quiz) {
        $userId = $_SESSION['user_id'];
        $reponsesEnvoyees = $_POST['reponse'] ?? []; // Tableau [id_question => id_choix]

        $pdo = Database::getPDO();
        $score = 0;

        // 1. Créer la Tentative (début)
        $stmt = $pdo->prepare("INSERT INTO tentative (id_quiz, user_id, date_debut) VALUES (?, ?, NOW())");
        $stmt->execute([$id_quiz, $userId]);
        $tentativeId = $pdo->lastInsertId();

        // 2. Vérifier chaque réponse
        foreach ($reponsesEnvoyees as $idQuestion => $idChoix) {
            // Vérifier si le choix est correct en BDD
            $stmt = $pdo->prepare("SELECT est_correct FROM choix WHERE id_choix = ?");
            $stmt->execute([$idChoix]);
            $isCorrect = $stmt->fetchColumn();

            if ($isCorrect) {
                $score++;
            }

            // 3. Sauvegarder la réponse détaillée (Table Reponse de l'UML)
            $stmt = $pdo->prepare("INSERT INTO reponse (est_correct, id_tentative, id_question, id_choix) VALUES (?, ?, ?, ?)");
            $stmt->execute([$isCorrect, $tentativeId, $idQuestion, $idChoix]);
        }

        // 4. Mettre à jour la tentative avec le score et la date de fin
        $stmt = $pdo->prepare("UPDATE tentative SET score_total = ?, date_fin = NOW() WHERE id_tentative = ?");
        $stmt->execute([$score, $tentativeId]);

        // Redirection vers les résultats
        header("Location: index.php?route=resultat&id=" . $tentativeId);
    }
}
<?php
    namespace App\Controllers;
    use App\Models\Utilisateur;
    use App\Models\Quiz;
    use App\Models\Ecole;
    use App\Models\Entreprise;
    use App\Lib\Database;

    class QuizController {

        public function dashboard() {
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?route=connexion');
                exit;
            }

            $user = Utilisateur::findByEmail($_SESSION['user_email']);
            
            $stats = [];
            $resultats = [];

            if ($user instanceof Ecole) {
                $stats['total_reponses'] = $user->voirNombreReponse();
                $resultats = $user->visualiserResultatsEleves();
            } 
            elseif ($user instanceof Entreprise) {
                $stats['total_reponses'] = $user->voirNombreReponse();
                $resultats = $user->visualiserResultatsEntreprise();
            }

            $userId = $_SESSION['user_id'];
            $createdQuizzes = Quiz::quizByUser($userId);

            $availableQuizzes = Quiz::getAvailableQuizzesForUser($user);

            require __DIR__ . '/../views/dashboard.php';            
        }

        public function creerQuizForm() {
            if (!isset($_SESSION['user_id'])) { header('Location: index.php?route=connexion'); exit; }
            $user = Utilisateur::findByEmail($_SESSION['user_email']);
            if ($_SESSION['role'] !== 'admin' && !$user->canCreateQuiz()) {
                return;
            }
            require __DIR__ . '/../views/quiz_form.php';
        }

        public function creerQuiz() {
            if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit; }
            
            $data = [
                'user_id' => $_SESSION['user_id'],
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'proprietaire' => $_SESSION['role'] === 'admin' ? 'ecole' : $_SESSION['role'],
                'date_lancement' => !empty($_POST['date_lancement']) ? $_POST['date_lancement'] : null,
                'date_cloture' => !empty($_POST['date_cloture']) ? $_POST['date_cloture'] : null,
                'visibility' => $_POST['visibility'] ?? 'public'
            ];

            $quiz = new Quiz($data);
            if($quiz->save()) {
                $idNewQuiz = Database::getPDO()->lastInsertId();
                header("Location: index.php?route=ajouter_question&id_quiz=" . $idNewQuiz);
            }
        }

        public function ajouterQuestionForm($id_quiz) {
            require __DIR__ . '/../views/add_question.php';
        }

        public function traitementAjoutQuestion() {
            if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit; }
            $idQuiz = $_POST['id_quiz'];
            $libelleQuestion = $_POST['libelle_question'];
            $question = new \App\Models\Question(['id_quiz' => $idQuiz, 'libelle' => $libelleQuestion]);
            $question->save();
            $idQuestion = Database::getPDO()->lastInsertId();
            
            if(isset($_POST['choix'])) {
                foreach($_POST['choix'] as $index => $texteChoix) {
                    if(!empty($texteChoix)) {
                        $estCorrect = (isset($_POST['correct']) && $_POST['correct'] == $index) ? 1 : 0;
                        (new \App\Models\Choix(['id_question' => $idQuestion, 'libelle' => $texteChoix, 'est_correct' => $estCorrect]))->save();
                    }
                }
            }
            if (isset($_POST['finish'])) header("Location: index.php?route=dashboard");
            else header("Location: index.php?route=ajouter_question&id_quiz=" . $idQuiz);
        }
    }
?>
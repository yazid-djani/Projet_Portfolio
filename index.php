<?php
    declare(strict_types=1);

    use Dotenv\Dotenv;
    use App\Controllers\UtilisateurController;
    use App\Controllers\QuizController;
    use App\Controllers\GameController;
    use App\Controllers\AdminController;

    require_once __DIR__ . '/vendor/autoload.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // --- ROUTAGE ---
    $route          = $_GET['route'] ?? 'accueil'; // On met 'accueil' par défaut
    $is_logged_in   = isset($_SESSION['user_id']);
    
    // AJOUT DE 'accueil' DANS LES ROUTES PUBLIQUES
    $public_routes  = ['home', 'accueil', 'auth', 'inscription', 'connexion'];

    if (!$is_logged_in && !in_array($route, $public_routes)) {
        header('Location: index.php?route=auth&mode=login&message=' . urlencode('Veuillez vous connecter.'));
        exit;
    }

    try {
        switch ($route) {
            
            // CORRECTION : AJOUT DE LA ROUTE ACCUEIL
            case 'accueil':
            case 'home':
                require __DIR__ . '/src/views/accueil.php';
                break;

            case 'auth':
                (new UtilisateurController())->inscription_form(); 
                break;
            
            // ... LE RESTE DE VOS ROUTES RESTE INCHANGÉ ...
            case 'inscription': 
                (new UtilisateurController())->inscription();
                break;

            case 'connexion':
                (new UtilisateurController())->connexion();
                break;

            case 'deconnexion':
                (new UtilisateurController())->deconnexion();
                break;

            case 'dashboard':
                (new QuizController())->dashboard();
                break;

            case 'creer_quiz':
                $quizController = new QuizController();
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $quizController->creerQuiz();
                } else {
                    $quizController->creerQuizForm();
                }
                break;

            case 'modifier_quiz':
                echo "Fonctionnalité de modification à implémenter."; 
                break;

            case 'ajouter_question':
                if (isset($_GET['id_quiz'])) {
                    (new QuizController())->ajouterQuestionForm($_GET['id_quiz']);
                }
                break;

            case 'traitement_question':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    (new QuizController())->traitementAjoutQuestion();
                }
                break;

            case 'jouer_quiz':
                if (isset($_GET['id'])) {
                    (new GameController())->play($_GET['id']);
                } else {
                    header('Location: index.php?route=dashboard');
                }
                break;

            case 'submit_quiz':
                if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                    (new GameController())->submit($_GET['id']);
                } else {
                    header('Location: index.php?route=dashboard');
                }
                break;
            
            case 'resultat':
                require __DIR__ . '/src/views/resultat.php';
                break;

            case 'admin_users':
                (new AdminController())->gererUtilisateurs(); 
                break;

            case 'admin_toggle_user':
                if (isset($_GET['id'])) {
                    (new AdminController())->toggleUserStatus($_GET['id']);
                }
                break;

            case 'admin_toggle_rights':
                if (isset($_GET['id'])) {
                    (new AdminController())->toggleQuizCreationRight($_GET['id']);
                }
                break;

            case 'admin_quizzes':
                (new AdminController())->gererQuiz();
                break;

            case 'admin_archive_quiz':
                if (isset($_GET['id'])) {
                    (new AdminController())->archiverQuiz($_GET['id']);
                }
                break;

            default:
                http_response_code(404);
                echo "<h1>Erreur 404</h1><p>Page introuvable.</p>";
                echo '<a href="index.php?route=accueil">Retour à l\'accueil</a>';
                break;
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo "<h1>Erreur Interne</h1>";
        echo "Détail : " . htmlspecialchars($e->getMessage());
    }
?>
<?php
    declare(strict_types=1);

    // Importation des classes nécessaires
    use Dotenv\Dotenv;
    use App\Controllers\UtilisateurController;
    use App\Controllers\QuizController;
    use App\Controllers\GameController;
    use App\Controllers\AdminController;

    // Chargement de l'autoloader Composer
    require_once __DIR__ . '/vendor/autoload.php';

    // Démarrage de la session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Chargement des variables d'environnement (.env)
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // --- ROUTAGE ---
    $route          = $_GET['route'] ?? 'accueil';
    $is_logged_in   = isset($_SESSION['user_id']);
    
    // Liste des routes accessibles sans être connecté
    $public_routes  = ['home', 'accueil', 'auth', 'inscription', 'connexion'];

    // Redirection si l'utilisateur n'est pas connecté et tente d'accéder à une page privée
    if (!$is_logged_in && !in_array($route, $public_routes)) {
        header('Location: index.php?route=connexion&error=auth_required');
        exit;
    }

    try {
        switch ($route) {
            // ==============================
            // ROUTES PUBLIQUES
            // ==============================
            
            case 'accueil':
            case 'home':
                require __DIR__ . '/src/views/accueil.php';
                break;

            case 'auth':
                (new UtilisateurController())->pageAuth('login'); 
                break;
            
            // --- INSCRIPTION ---
            case 'inscription': 
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    (new UtilisateurController())->inscription();
                } else {
                    (new UtilisateurController())->pageAuth('register');
                }
                break;

            // --- CONNEXION ---
            case 'connexion':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    (new UtilisateurController())->connexion();
                } else {
                    (new UtilisateurController())->pageAuth('login');
                }
                break;

            case 'deconnexion':
                (new UtilisateurController())->deconnexion();
                break;

            // ==============================
            // ROUTES TABLEAU DE BORD
            // ==============================
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

            // ==============================
            // ROUTES JEU & RÉSULTATS
            // ==============================
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

            // ==============================
            // ROUTES ADMINISTRATION
            // ==============================
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

            // --- NOUVELLES ROUTES CRÉATEURS ---
            case 'admin_creators':
                (new AdminController())->listeCreateurs();
                break;

            case 'admin_add_creator':
                (new AdminController())->pageAjoutCreateur();
                break;

            case 'admin_grant_right':
                if (isset($_GET['id'])) {
                    (new AdminController())->validerCreateur($_GET['id']);
                }
                break;
            
            case 'admin_revoke_right':
                if (isset($_GET['id'])) {
                    (new AdminController())->retirerCreateur($_GET['id']);
                }
                break;

            // ==============================
            // GESTION 404
            // ==============================
            default:
                http_response_code(404);
                echo "<h1>Erreur 404</h1><p>La page demandée n'existe pas.</p>";
                echo '<a href="index.php?route=accueil">Retour à l\'accueil</a>';
                break;
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo "<h1>Erreur Interne</h1>";
        echo "Détail : " . htmlspecialchars($e->getMessage());
    }
?>
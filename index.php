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

    // Démarrage de la session si elle n'est pas déjà active
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Chargement des variables d'environnement (.env)
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // --- ROUTAGE ---
    // Par défaut, on arrive sur la 'home' (Landing Page)
    $route          = $_GET['route'] ?? 'home';
    $is_logged_in   = isset($_SESSION['user_id']);
    
    // Liste des routes accessibles SANS être connecté
    $public_routes  = ['home', 'auth', 'inscription', 'connexion'];

    // Redirection si l'utilisateur n'est pas connecté et tente d'accéder à une page privée
    if (!$is_logged_in && !in_array($route, $public_routes)) {
        // On redirige vers la page d'auth (mode login)
        header('Location: index.php?route=auth&mode=login&message=' . urlencode('Veuillez vous connecter.'));
        exit;
    }

    try {
        switch ($route) {
            // ==============================
            // ROUTES PUBLIQUES
            // ==============================
            
            case 'home':
                // CORRECTION : Redirection vers auth car pageAccueil() n'existe pas dans le contrôleur
                header('Location: index.php?route=auth');
                exit;

            case 'auth':
                // Affiche la page de Connexion / Inscription
                (new UtilisateurController())->inscription_form(); 
                break;
            
            // ==============================
            // TRAITEMENT AUTHENTIFICATION
            // ==============================
            case 'inscription': 
                (new UtilisateurController())->inscription();
                break;

            case 'connexion':
                (new UtilisateurController())->connexion();
                break;

            case 'deconnexion':
                (new UtilisateurController())->deconnexion();
                break;

            // ==============================
            // ROUTES TABLEAU DE BORD (QuizController)
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
                // Fonctionnalité future (placeholder)
                echo "Fonctionnalité de modification à implémenter."; 
                break;

            case 'ajouter_question':
                // Affiche le formulaire pour ajouter une question à un quiz spécifique
                if (isset($_GET['id_quiz'])) {
                    (new QuizController())->ajouterQuestionForm($_GET['id_quiz']);
                }
                break;

            case 'traitement_question':
                // Traite l'ajout de la question via POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    (new QuizController())->traitementAjoutQuestion();
                }
                break;

            // ==============================
            // ROUTES DU JEU (GameController)
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
                // Affiche les résultats
                require __DIR__ . '/src/views/resultat.php';
                break;

            // ==============================
            // ROUTES ADMINISTRATION (AdminController)
            // ==============================
            case 'admin_users':
                (new AdminController())->gererUtilisateurs(); 
                break;

            case 'admin_toggle_user':
                // Active/Désactive un compte utilisateur (bannissement)
                if (isset($_GET['id'])) {
                    (new AdminController())->toggleUserStatus($_GET['id']);
                }
                break;

            case 'admin_toggle_rights':
                // Donne ou retire le droit de création de quiz (pour Ecoles/Entreprises)
                if (isset($_GET['id'])) {
                    (new AdminController())->toggleQuizCreationRight($_GET['id']);
                }
                break;

            case 'admin_quizzes':
                // Gestion des quiz par l'admin (liste complète)
                (new AdminController())->gererQuiz();
                break;

            case 'admin_archive_quiz':
                // Archive un quiz inapproprié
                if (isset($_GET['id'])) {
                    (new AdminController())->archiverQuiz($_GET['id']);
                }
                break;

            // ==============================
            // GESTION 404 (Page non trouvée)
            // ==============================
            default:
                http_response_code(404);
                echo "<h1>Erreur 404</h1><p>La page demandée n'existe pas.</p>";
                echo '<a href="index.php?route=dashboard">Retour au tableau de bord</a>';
                break;
        }
    } catch (Exception $e) {
        // Gestion globale des erreurs
        http_response_code(500);
        echo "<h1>Erreur Interne</h1>";
        echo "Détail : " . htmlspecialchars($e->getMessage());
    }
?>
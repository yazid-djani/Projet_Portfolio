<?php
// On vérifie si la session est active, sinon on la démarre (sécurité)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="global-navbar">
    <div class="nav-left">
        <a href="index.php?route=<?= isset($_SESSION['user_id']) ? 'dashboard' : 'accueil' ?>" class="brand-logo">
            Quizzeo
        </a>
    </div>

    <div class="nav-right">
        
        <?php if (isset($_SESSION['user_id'])): ?>
            
            <?php if ($_SESSION['role'] === 'admin'): ?>
                
                <a href="index.php?route=admin_creators" class="nav-link">Créateurs</a>
                
                <span style="color:#ccc">|</span>

                <a href="index.php?route=admin_quizzes" class="nav-link" style="color:var(--primary-color); font-weight:bold;">Tous les Quiz</a>
                
                <span style="color:#ccc">|</span>

                <a href="index.php?route=admin_users&type=utilisateur" class="nav-link">Joueurs</a>
                <a href="index.php?route=admin_users&type=ecole" class="nav-link">Écoles</a>
                <a href="index.php?route=admin_users&type=entreprise" class="nav-link">Entreprises</a>

            <?php else: ?>
                <a href="index.php?route=creer_quiz" class="nav-link">Créer un Quiz</a>
            <?php endif; ?>
            
            <a href="index.php?route=deconnexion" class="nav-btn btn-logout" style="margin-left:15px;">Déconnexion</a>

        <?php else: ?>
            <a href="index.php?route=informationentreprise" class="nav-link">Entreprises</a>
            <a href="index.php?route=informationecole" class="nav-link">Écoles</a>

            <a href="index.php?route=inscription" class="nav-link">Inscription</a>
            <a href="index.php?route=connexion" class="nav-btn btn-login">Connexion</a>

        <?php endif; ?>

        <button id="theme-toggle" class="theme-btn">
            🌙
        </button>
    </div>
</nav>
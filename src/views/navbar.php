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
            <a href="index.php?route=creer_quiz" class="nav-link">Créer un Quiz</a>
            
            <a href="index.php?route=deconnexion" class="nav-btn btn-logout">Déconnexion</a>

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
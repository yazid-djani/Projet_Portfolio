<nav class="global-navbar">
    <div class="nav-left">
        <a href="index.php" class="brand-logo">
            Yazid Djani
        </a>
    </div>

    <div class="nav-right">
        <a href="#dev-panel" class="nav-link">Développement</a>
        <a href="#reseau-panel" class="nav-link">Réseau & Système</a>

        <span style="color:#555">|</span>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php?route=admin" class="nav-link" style="color:var(--primary-color); font-weight:bold;">Console Admin</a>
            <a href="index.php?route=deconnexion" class="nav-btn btn-logout">Déconnexion</a>
        <?php else: ?>
            <a href="index.php?route=admin" class="nav-link">Connexion</a>
        <?php endif; ?>

    </div>
</nav>
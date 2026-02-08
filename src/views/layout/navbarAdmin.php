<nav class="navbar-admin">
    <div class="nav-admin-left">
        <span class="admin-logo">YD</span>
        <span class="admin-label">Admin Panel</span>
    </div>

    <div class="nav-admin-center">
        <a href="?page=dashboard" class="admin-link <?= ($_GET['page'] ?? 'dashboard') === 'dashboard' ? 'active' : '' ?>">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="?page=projets" class="admin-link <?= ($_GET['page'] ?? '') === 'projets' ? 'active' : '' ?>">
            <i class="fas fa-folder-open"></i> Projets
        </a>
        <a href="?page=statistiques" class="admin-link <?= ($_GET['page'] ?? '') === 'statistiques' ? 'active' : '' ?>">
            <i class="fas fa-chart-bar"></i> Statistiques
        </a>
    </div>

    <div class="nav-admin-right">
        <span class="admin-user"><i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
        <a href="?action=logout" class="admin-logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </div>
</nav>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Dashboard</title>
    <link rel="stylesheet" href="/public/css/couleur.css">
    <link rel="stylesheet" href="/public/css/styleNavbarAdmin.css">
    <link rel="stylesheet" href="/public/css/styleAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="admin-body">
<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>

<main class="admin-main">
    <div class="admin-header">
        <h1>Bienvenue, <span class="highlight"><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span></h1>
        <p>Tableau de bord — gérez votre portfolio depuis ici.</p>
    </div>

    <div class="dashboard-grid">
        <!-- Carte : Projets -->
        <a href="?page=projets" class="dashboard-card">
            <div class="card-icon-admin"><i class="fas fa-folder-open"></i></div>
            <h3>Projets</h3>
            <p>Créer, modifier ou supprimer vos projets.</p>
        </a>

        <!-- Carte : Statistiques -->
        <a href="?page=statistiques" class="dashboard-card">
            <div class="card-icon-admin"><i class="fas fa-chart-bar"></i></div>
            <h3>Statistiques</h3>
            <p>Voir le trafic et les visiteurs du site.</p>
        </a>

        <!-- Carte : Voir le site -->
        <a href="/" class="dashboard-card" target="_blank">
            <div class="card-icon-admin"><i class="fas fa-external-link-alt"></i></div>
            <h3>Voir le site</h3>
            <p>Ouvrir le portfolio dans un nouvel onglet.</p>
        </a>

        <!-- Carte : Déconnexion -->
        <a href="?action=logout" class="dashboard-card card-danger">
            <div class="card-icon-admin"><i class="fas fa-sign-out-alt"></i></div>
            <h3>Déconnexion</h3>
            <p>Se déconnecter du panel admin.</p>
        </a>
    </div>
</main>
</body>
</html>
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
        <a href="?page=profil" class="dashboard-card">
            <div class="card-icon-admin"><i class="fas fa-user-edit"></i></div>
            <h3>Profil</h3>
            <p>Modifier les textes et informations du site public.</p>
        </a>

        <a href="?page=projets" class="dashboard-card">
            <div class="card-icon-admin"><i class="fas fa-folder-open"></i></div>
            <h3>Projets</h3>
            <p>Créer, modifier ou supprimer vos projets.</p>
        </a>

        <a href="?page=competences" class="dashboard-card">
            <div class="card-icon-admin"><i class="fas fa-layer-group"></i></div>
            <h3>Compétences</h3>
            <p>Gérer les langages et pourcentages.</p>
        </a>

        <a href="?page=outils" class="dashboard-card">
            <div class="card-icon-admin"><i class="fas fa-toolbox"></i></div>
            <h3>Outils</h3>
            <p>Ajouter des icônes d'outils / logiciels.</p>
        </a>

        <a href="?page=statistiques" class="dashboard-card">
            <div class="card-icon-admin"><i class="fas fa-chart-bar"></i></div>
            <h3>Statistiques</h3>
            <p>Voir le trafic et les visiteurs du site.</p>
        </a>

        <a href="?action=logout" class="dashboard-card card-danger">
            <div class="card-icon-admin"><i class="fas fa-sign-out-alt"></i></div>
            <h3>Déconnexion</h3>
            <p>Se déconnecter du panel admin.</p>
        </a>
    </div>
</main>

</body>
</html>
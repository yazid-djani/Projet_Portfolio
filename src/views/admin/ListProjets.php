<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Listes des Projets </title>
    <?php require_once __DIR__ . '/../layout/headerAdmin.php'; ?>
</head>
<body class="admin-body">

<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>

<main class="admin-main">
    <div class="admin-header admin-header-flex">
        <div>
            <h1>Gestion des <span class="highlight">Projets</span></h1>
            <p>Gérez les projets affichés sur votre portfolio.</p>
        </div>
        <a href="?page=projets&action=create" class="btn-primary mb-10">
            <i class="fas fa-plus"></i> Nouveau Projet
        </a>
    </div>

    <?php if (!empty($message)) echo "<div class='admin-success'>$message</div>"; ?>

    <div class="dashboard-grid">
        <?php if (empty($projets)): ?>
            <p class="msg-empty">Aucun projet pour le moment.</p>
        <?php else: ?>
            <?php foreach ($projets as $p): ?>
                <div class="dashboard-card projet-card-admin">
                    <img src="/public/images/<?= htmlspecialchars($p['image_url']) ?>" class="projet-img-admin" alt="Projet">
                    <h3 class="projet-title-admin"><?= htmlspecialchars($p['titre']) ?></h3>
                    <p class="projet-cat-admin"><?= htmlspecialchars($p['categorie']) ?></p>

                    <a href="?page=projets&action=delete&id=<?= $p['id'] ?>" class="btn-secondary btn-danger w-100" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                        <i class="fas fa-trash"></i> Supprimer
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
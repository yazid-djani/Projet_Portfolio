<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Projets</title>
    <link rel="stylesheet" href="/public/css/couleur.css">
    <link rel="stylesheet" href="/public/css/styleNavbarAdmin.css">
    <link rel="stylesheet" href="/public/css/styleAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="admin-body">

<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>

<main class="admin-main">
    <div class="admin-header" style="display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1>Gestion des <span class="highlight">Projets</span></h1>
            <p>Gérez les projets affichés sur votre portfolio.</p>
        </div>
        <a href="?page=projets&action=create" class="btn-primary" style="margin-bottom: 10px;">
            <i class="fas fa-plus"></i> Nouveau Projet
        </a>
    </div>

    <?php if (!empty($message)) echo "<div class='admin-success'>$message</div>"; ?>

    <div class="dashboard-grid">
        <?php if (empty($projets)): ?>
            <p style="color: var(--text-paragraph);">Aucun projet pour le moment.</p>
        <?php else: ?>
            <?php foreach ($projets as $p): ?>
                <div class="dashboard-card" style="padding: 20px; display: flex; flex-direction: column; align-items: center; text-align: center;">
                    <img src="/public/images/<?= htmlspecialchars($p['image_url']) ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                    <h3 style="font-size: 18px; color: var(--text-headline); margin-bottom: 5px;"><?= htmlspecialchars($p['titre']) ?></h3>
                    <p style="font-size: 13px; color: var(--color-highlight); margin-bottom: 15px; text-transform: uppercase;"><?= htmlspecialchars($p['categorie']) ?></p>

                    <a href="?page=projets&action=delete&id=<?= $p['id'] ?>" class="btn-secondary" style="border-color:#ff5f57; color:#ff5f57; width: 100%;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                        <i class="fas fa-trash"></i> Supprimer
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
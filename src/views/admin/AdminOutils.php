<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Outils</title>
    <?php require_once __DIR__ . '/../layout/headerAdmin.php'; ?>
</head>
<body class="admin-body">

<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>

<main class="admin-main">
    <div class="admin-header">
        <h1>Gestion des <span class="highlight">Outils</span></h1>
    </div>

    <?php if (!empty($message)) echo "<div class='admin-success'>$message</div>"; ?>

    <div class="dashboard-card admin-form-container admin-form-left form-mb-30">
        <form action="?page=outils" method="POST" enctype="multipart/form-data" class="admin-form form-row-flex">
            <div class="form-group form-col-1">
                <label>Image/Icône :</label>
                <input type="file" name="image_outil" accept="image/*" required onchange="previewImg(event)">
            </div>
            <img id="img-preview" src="#" alt="Aperçu" class="img-preview-square" style="display:none;">
            <div class="form-group form-col-2">
                <label>Nom (Optionnel) :</label>
                <input type="text" name="nom" placeholder="Ex: Photoshop">
            </div>
            <button type="submit" class="btn-primary mb-0">Ajouter</button>
        </form>
    </div>

    <div class="outils-grid-admin">
        <?php foreach ($outils as $o): ?>
            <div class="dashboard-card outil-card-admin">
                <a href="?page=outils&action=delete&id=<?= $o['id'] ?>" class="btn-delete-corner" title="Supprimer cet outil" onclick="return confirm('Voulez-vous vraiment supprimer cet outil ?')">
                    <i class="fas fa-times"></i>
                </a>

                <img src="public/images/<?= htmlspecialchars($o['image_url']) ?>" class="outil-img-admin" alt="Outil">
                <h4 class="outil-title-admin"><?= htmlspecialchars($o['nom']) ?></h4>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
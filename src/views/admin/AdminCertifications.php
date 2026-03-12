<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Certification</title>
    <?php require_once __DIR__ . '/../layout/headerAdmin.php'; ?>
</head>
<body class="admin-body">
<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>
<main class="admin-main">
    <div class="admin-header"><h1>Gestion des <span class="highlight">Certifications</span></h1></div>
    <?php if (!empty($message)) echo "<div class='admin-success'>$message</div>"; ?>

    <div class="dashboard-card admin-form-container admin-form-left form-mb-30">
        <form action="?page=certifications" method="POST" enctype="multipart/form-data" class="admin-form">

            <div class="form-group">
                <label>Image du certificat :</label>
                <input type="file" name="image_certif" accept="image/*" required onchange="previewImg(event)">
                <img id="img-preview" src="#" alt="Aperçu" class="img-preview-rect" style="display:none;">
            </div>

            <div class="form-group">
                <label>Nom de la certification :</label>
                <input type="text" name="nom" required placeholder="Ex: Cisco CCNA">
            </div>

            <div class="form-group">
                <label>Petite description :</label>
                <textarea name="description" rows="3" placeholder="Ex: Validation des acquis sur le routage et la commutation..."></textarea>
            </div>

            <button type="submit" class="btn-primary">Ajouter la certification</button>
        </form>
    </div>

    <div class="dashboard-grid">
        <?php foreach ($certifications as $c): ?>
            <div class="dashboard-card certif-card-admin">
                <img src="public/images/<?= htmlspecialchars($c['image_url']) ?>" class="certif-img-admin" alt="Certificat">
                <h4 class="certif-title-admin"><?= htmlspecialchars($c['nom']) ?></h4>
                <p class="certif-desc-admin"><?= htmlspecialchars($c['description']) ?></p>
                <a href="?page=certifications&action=delete&id=<?= $c['id'] ?>" class="btn-secondary btn-danger w-100" onclick="return confirm('Supprimer ?')">
                    <i class="fas fa-trash"></i> Supprimer
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
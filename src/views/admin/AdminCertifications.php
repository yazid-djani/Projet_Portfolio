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

    <div class="dashboard-card admin-form-container" style="text-align: left; transform: none; margin-bottom: 30px;">
        <form action="?page=certifications" method="POST" enctype="multipart/form-data" class="admin-form">

            <div class="form-group">
                <label>Image du certificat :</label>
                <input type="file" name="image_certif" accept="image/*" required onchange="previewImg(event)">
                <img id="img-preview" src="#" alt="Aperçu" style="display:none; width:150px; margin-top:10px; border-radius:8px;">
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
            <div class="dashboard-card" style="padding: 15px; display: flex; flex-direction: column; align-items: center; gap: 15px;">
                <img src="public/images/<?= htmlspecialchars($c['image_url']) ?>" style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
                <h4 style="color:#fff; font-size:16px; margin: 0; text-align: center;"><?= htmlspecialchars($c['nom']) ?></h4>
                <p style="font-size: 13px; text-align: center; opacity: 0.8; margin: 0;"><?= htmlspecialchars($c['description']) ?></p>
                <a href="?page=certifications&action=delete&id=<?= $c['id'] ?>" class="btn-secondary" style="border-color:#ff5f57; color:#ff5f57; width: 100%; text-align: center;" onclick="return confirm('Supprimer ?')"><i class="fas fa-trash"></i> Supprimer</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
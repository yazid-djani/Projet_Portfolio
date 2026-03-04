<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><title>Outils</title>
    <link rel="stylesheet" href="/public/css/couleur.css"><link rel="stylesheet" href="/public/css/styleNavbar.css"><link rel="stylesheet" href="/public/css/styleAdmin.css"><link rel="stylesheet" href="/public/css/styleAdminForm.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        function previewImg(event) {
            document.getElementById('img-preview').src = URL.createObjectURL(event.target.files[0]);
            document.getElementById('img-preview').style.display = 'block';
        }
    </script>
</head>
<body class="admin-body">
<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>
<main class="admin-main">
    <div class="admin-header"><h1>Gestion des <span class="highlight">Outils</span></h1></div>
    <?php if (!empty($message)) echo "<div class='admin-success'>$message</div>"; ?>

    <div class="dashboard-card admin-form-container" style="text-align: left; transform: none; margin-bottom: 30px;">
        <form action="?page=outils" method="POST" enctype="multipart/form-data" class="admin-form" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">

            <div class="form-group" style="flex: 1; margin-bottom: 0;">
                <label>Image/Icône (Transparente de pref) :</label>
                <input type="file" name="image_outil" accept="image/*" required onchange="previewImg(event)">
            </div>

            <img id="img-preview" src="#" alt="Aperçu" style="display:none; width:50px; height:50px; object-fit:contain; border-radius:8px;">

            <div class="form-group" style="flex: 2; margin-bottom: 0;">
                <label>Nom (Optionnel) :</label><input type="text" name="nom" placeholder="Ex: Photoshop">
            </div>

            <button type="submit" class="btn-primary" style="margin-bottom: 0;">Ajouter</button>
        </form>
    </div>

    <div class="dashboard-grid">
        <?php foreach ($outils as $o): ?>
            <div class="dashboard-card" style="padding: 15px; display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <img src="/public/images/<?= htmlspecialchars($o['image_url']) ?>" style="width: 50px; height: 50px; object-fit: contain;">
                <h4 style="color:#fff; font-size:14px;"><?= htmlspecialchars($o['nom']) ?></h4>
                <a href="?page=outils&action=delete&id=<?= $o['id'] ?>" class="btn-secondary" style="border-color:#ff5f57; color:#ff5f57; width: 100%; text-align: center;" onclick="return confirm('Supprimer ?')"><i class="fas fa-trash"></i></a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
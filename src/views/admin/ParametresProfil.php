<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modifier le Profil</title>
    <?php require_once __DIR__ . '/../layout/headerAdmin.php'; ?>
</head>
<body class="admin-body">

<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>

<main class="admin-main">
    <div class="admin-header">
        <h1>Paramètres du <span class="highlight">Profil</span></h1>
        <a href="?page=dashboard" class="btn-secondary" style="margin-top: 15px;">Retour au Dashboard</a>
    </div>

    <?php if (!empty($message)) echo "<div class='admin-success'>$message</div>"; ?>

    <div class="dashboard-card admin-form-container" style="text-align: left; transform: none;">
        <form action="?page=profil" method="POST" enctype="multipart/form-data" class="admin-form">

            <div class="form-group">
                <label>Photo de profil :</label>
                <div style="margin-bottom: 10px;">
                    <img id="img-preview" src="public/images/<?= htmlspecialchars($profil['image_profil'] ?? 'default_profil.png') ?>" alt="Actuelle" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid var(--color-highlight);">
                </div>
                <input type="file" name="photo_profil" accept="image/*" onchange="previewImg(event)">
            </div>

            <div class="form-group">
                <label>Prénom:</label>
                <input type="text" name="prenom" value="<?= htmlspecialchars($profil['prenom'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Nom:</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($profil['nom'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Texte d'accueil - Hero :</label>
                <textarea name="description_hero" rows="4"><?= htmlspecialchars($profil['description_hero'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label>Texte de présentation - A propos:</label>
                <textarea name="description_about" rows="6"><?= htmlspecialchars($profil['description_about'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label>Email de contact :</label>
                <input type="email" name="email_contact" value="<?= htmlspecialchars($profil['email_contact'] ?? '') ?>" placeholder="contact@mon-site.com">
            </div>

            <div class="form-group">
                <label>Lien GitHub :</label>
                <input type="url" name="lien_github" value="<?= htmlspecialchars($profil['lien_github'] ?? '') ?>" placeholder="https://github.com/votre-profil">
            </div>

            <div class="form-group">
                <label>Lien LinkedIn :</label>
                <input type="url" name="lien_linkedin" value="<?= htmlspecialchars($profil['lien_linkedin'] ?? '') ?>" placeholder="https://linkedin.com/in/votre-profil">
            </div>

            <div class="form-group">
                <label>Localisation :</label>
                <input type="text" name="localisation" value="<?= htmlspecialchars($profil['localisation'] ?? '') ?>" placeholder="Ex: Paris, France">
            </div>

            <div class="form-group">
                <label>Uploader votre CV (Format PDF uniquement) :</label>
                <?php if(!empty($profil['lien_cv'])): ?>
                    <p style="font-size: 13px; margin-bottom: 5px; color: #28c840;">✅ Un CV est actuellement en ligne (<a href="/?mon_cv" target="_blank" style="color: #3b82f6;">Le voir</a>)</p>
                <?php endif; ?>
                <input type="file" name="fichier_cv" accept="application/pdf">
                <small style="color: var(--text-paragraph); margin-top: 5px;">Laissez vide pour conserver le CV actuel.</small>
            </div>

            <button type="submit" class="btn-primary">Sauvegarder les modifications</button>
        </form>
    </div>
</main>

</body>
</html>
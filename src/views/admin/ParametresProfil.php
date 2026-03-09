<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le Profil</title>
    <link rel="stylesheet" href="/public/css/couleur.css">
    <link rel="stylesheet" href="/public/css/styleNavbarAdmin.css">
    <link rel="stylesheet" href="/public/css/styleAdmin.css">
    <link rel="stylesheet" href="/public/css/styleAdminForm.css">
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
                    <img src="public/images/<?= htmlspecialchars($profil['image_profil'] ?? 'default_profil.png') ?>" alt="Actuelle" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid var(--color-highlight);">
                </div>
                <input type="file" name="photo_profil" accept="image/*">
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
                <label>Titre/Poste:</label>
                <input type="text" name="titre_poste" value="<?= htmlspecialchars($profil['titre_poste'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Description Hero (Texte d'accueil):</label>
                <textarea name="description_hero" rows="4"><?= htmlspecialchars($profil['description_hero'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label>À propos (Texte de présentation détaillé):</label>
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
                <label>Lien vers le CV (PDF) :</label>
                <input type="url" name="lien_cv" value="<?= htmlspecialchars($profil['lien_cv'] ?? '') ?>" placeholder="https://lien-vers-mon-cv.pdf">
            </div>

            <button type="submit" class="btn-primary">Sauvegarder les modifications</button>
        </form>
    </div>
</main>

</body>
</html>
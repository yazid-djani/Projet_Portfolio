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
        <a href="?page=dashboard" class="btn-secondary mt-15">Retour au Dashboard</a>
    </div>

    <?php if (!empty($message)) echo "<div class='admin-success'>$message</div>"; ?>

    <div class="dashboard-card admin-form-container admin-form-left">
        <form action="?page=profil" method="POST" enctype="multipart/form-data" class="admin-form">

            <div class="form-group">
                <label>Photo de profil :</label>
                <div class="mb-10">
                    <img id="img-preview" src="public/images/<?= htmlspecialchars($profil['image_profil'] ?? 'default_profil.png') ?>" alt="Actuelle" class="img-preview-round">
                </div>
                <input type="file" name="photo_profil" accept="image/*" onchange="previewImg(event)">
            </div>

            <div class="form-group">
                <label>Prénom:</label>
                <input type="text" name="prenom" value="<?= htmlspecialchars($profil['prenom'] ?? '') ?>">
            </div>

            <div class="form-group mb-10">
                <label>Nom:</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($profil['nom'] ?? '') ?>">
            </div>

            <div class="form-row-flex mb-10">
                <div class="form-group form-col-1">
                    <label>Poste :</label>
                    <input type="text" name="titre_poste" value="<?= htmlspecialchars($profil['titre_poste'] ?? '') ?>" placeholder="Ex: Étudiant">
                </div>
                <div class="form-group form-col-1">
                    <label>Entreprise / École :</label>
                    <input type="text" name="entreprise" value="<?= htmlspecialchars($profil['entreprise'] ?? '') ?>" placeholder="Ex: IPSSI Paris">
                </div>
            </div>

            <div class="form-group mt-15">
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

            <div class="form-group mt-15">
                <label>Uploader votre CV (Format PDF uniquement) :</label>

                <div class="cv-badge-container mb-10">
                    <?php if(!empty($profil['lien_cv'])): ?>
                        <a href="/public/images/<?= htmlspecialchars($profil['lien_cv']) ?>" target="_blank" class="cv-badge cv-badge-success">
                            <i class="fas fa-file-pdf"></i> Voir le CV
                        </a>
                        <a href="?page=profil&action=delete_cv" class="btn-delete-cv" title="Supprimer le CV" onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement votre CV actuel ?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    <?php else: ?>
                        <span class="cv-badge cv-badge-danger">
                            <i class="fas fa-times-circle"></i> Pas de CV
                        </span>
                    <?php endif; ?>
                </div>

                <input type="file" name="fichier_cv" accept="application/pdf">
                <small class="text-hint">Ajoutez un nouveau fichier pour remplacer l'ancien.</small>
            </div>

            <button type="submit" class="btn-primary mt-10">Sauvegarder les modifications</button>
        </form>
    </div>
</main>

</body>
</html>
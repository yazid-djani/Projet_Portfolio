<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Projets</title>
    <link rel="stylesheet" href="/public/css/couleur.css">
    <link rel="stylesheet" href="/public/css/styleNavbarAdmin.css">
    <link rel="stylesheet" href="/public/css/styleAdmin.css">
    <link rel="stylesheet" href="/public/css/styleAdminForm.css">
</head>
<body class="admin-body">

<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>

<main class="admin-main">
    <div class="admin-header">
        <h1>Créer un <span class="highlight">Projet</span></h1>
        <a href="?page=dashboard" class="btn-secondary" style="margin-top: 15px;">Retour au Dashboard</a>
    </div>

    <?php if (!empty($message)) echo "<div class='admin-success'>$message</div>"; ?>

    <div class="dashboard-card admin-form-container" style="text-align: left; transform: none;">
        <form action="?page=projets&action=create" method="POST" enctype="multipart/form-data" class="admin-form">

            <div class="form-group">
                <label>Titre du projet :</label>
                <input type="text" name="titre" required placeholder="Ex: Refonte d'un site web">
            </div>

            <div class="form-group">
                <label>Description courte :</label>
                <input type="text" name="description" required placeholder="Sera affichée sur la carte principale">
            </div>

            <div class="form-group">
                <label>Détail long :</label>
                <textarea name="detail" rows="5" placeholder="Sera affiché dans la modale"></textarea>
            </div>

            <div class="form-group">
                <label>Catégorie :</label>
                <select name="categorie" required>
                    <option value="developpement">Développement</option>
                    <option value="reseau">Réseau & Infrastructure</option>
                </select>
            </div>

            <div class="form-group">
                <label>Technologies :</label>
                <input type="text" name="technologies" placeholder="Ex: PHP, CSS, Docker">
            </div>

            <div class="form-group">
                <label>Média du projet (Image ou Vidéo) :</label>
                <input type="file" name="media_projet" accept="image/*,video/mp4">
            </div>

            <div class="form-group">
                <label>Lien GitHub (Optionnel) :</label>
                <input type="url" name="lien_github" placeholder="https://github.com/...">
            </div>

            <button type="submit" class="btn-primary">Ajouter le projet</button>
        </form>
    </div>
</main>

</body>
</html>
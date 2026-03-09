<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Compétences</title>
    <?php require_once __DIR__ . '/../layout/headerAdmin.php'; ?>
</head>
<body class="admin-body">

<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>

<main class="admin-main">
    <div class="admin-header">
        <h1>Gestion des <span class="highlight">Compétences</span></h1>
    </div>

    <?php if (!empty($message)) echo "<div class='admin-success'>$message</div>"; ?>

    <div class="dashboard-card admin-form-container" style="text-align: left; transform: none; margin-bottom: 30px;">
        <form action="?page=competences" method="POST" class="admin-form" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
            <div class="form-group" style="flex: 2; margin-bottom: 0;">
                <label>Nom :</label><input type="text" name="nom" required placeholder="Ex: PHP">
            </div>
            <div class="form-group" style="flex: 1; margin-bottom: 0;">
                <label>Niveau (%) :</label><input type="number" name="pourcentage" min="1" max="100" required placeholder="80">
            </div>
            <div class="form-group" style="flex: 2; margin-bottom: 0;">
                <label>Catégorie :</label>
                <select name="categorie" required>
                    <option value="developpement">Développement</option>
                    <option value="reseau">Réseau & Système</option>
                </select>
            </div>
            <button type="submit" class="btn-primary" style="margin-bottom: 0;">Ajouter</button>
        </form>
    </div>

    <div class="dashboard-grid">
        <?php foreach ($competences as $c): ?>
            <div class="dashboard-card" style="padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                <div style="text-align: left;">
                    <h4 style="color:#fff; margin-bottom: 5px;"><?= htmlspecialchars($c['nom']) ?> (<?= $c['pourcentage'] ?>%)</h4>
                    <span style="font-size: 12px; opacity:0.7;"><?= $c['categorie'] ?></span>
                </div>
                <a href="?page=competences&action=delete&id=<?= $c['id'] ?>" class="btn-secondary" style="border-color:#ff5f57; color:#ff5f57;" onclick="return confirm('Supprimer ?')"><i class="fas fa-trash"></i></a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
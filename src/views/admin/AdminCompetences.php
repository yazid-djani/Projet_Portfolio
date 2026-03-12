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

    <div class="dashboard-card admin-form-container admin-form-left form-mb-30">
        <form action="?page=competences" method="POST" class="admin-form form-row-flex">
            <div class="form-group form-col-2">
                <label>Nom :</label><input type="text" name="nom" required placeholder="Ex: PHP">
            </div>
            <div class="form-group form-col-1">
                <label>Niveau (%) :</label><input type="number" name="pourcentage" min="1" max="100" required placeholder="80">
            </div>
            <div class="form-group form-col-2">
                <label>Catégorie :</label>
                <select name="categorie" required>
                    <option value="developpement">Développement</option>
                    <option value="reseau">Réseau & Système</option>
                </select>
            </div>
            <button type="submit" class="btn-primary mb-0">Ajouter</button>
        </form>
    </div>

    <div class="dashboard-grid">
        <?php foreach ($competences as $c): ?>
            <div class="dashboard-card comp-card-admin">
                <div class="comp-info-admin">
                    <h4 class="comp-title-admin"><?= htmlspecialchars($c['nom']) ?> (<?= $c['pourcentage'] ?>%)</h4>
                    <span class="comp-cat-admin"><?= $c['categorie'] ?></span>
                </div>
                <a href="?page=competences&action=delete&id=<?= $c['id'] ?>" class="btn-secondary btn-danger" onclick="return confirm('Supprimer ?')"><i class="fas fa-trash"></i></a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
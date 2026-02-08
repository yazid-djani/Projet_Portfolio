<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Projets</title>
    <link rel="stylesheet" href="/public/css/couleur.css">
    <link rel="stylesheet" href="/public/css/styleNavbarAdmin.css">
    <link rel="stylesheet" href="/public/css/styleAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="admin-body">
<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>

<main class="admin-main">
    <div class="admin-header">
        <h1>Gestion des <span class="highlight">Projets</span></h1>
        <p>Ajoutez, modifiez ou supprimez vos projets.</p>
    </div>

    <!-- Message de succès / erreur -->
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Formulaire d'ajout / modification -->
    <div class="form-container">
        <h2><i class="fas fa-plus-circle"></i> <?= isset($editProjet) ? 'Modifier le projet' : 'Ajouter un projet' ?></h2>
        <form method="POST" action="?page=projets&action=<?= isset($editProjet) ? 'update' : 'create' ?>" class="admin-form">
            <?php if (isset($editProjet)): ?>
                <input type="hidden" name="id" value="<?= $editProjet['id'] ?>">
            <?php endif; ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="titre">Titre du projet</label>
                    <input type="text" id="titre" name="titre" required
                           value="<?= htmlspecialchars($editProjet['titre'] ?? '') ?>"
                           placeholder="Ex: Portfolio PHP">
                </div>
                <div class="form-group">
                    <label for="categorie">Catégorie</label>
                    <select id="categorie" name="categorie" required>
                        <option value="developpement" <?= (($editProjet['categorie'] ?? '') === 'developpement') ? 'selected' : '' ?>>Développement</option>
                        <option value="reseau" <?= (($editProjet['categorie'] ?? '') === 'reseau') ? 'selected' : '' ?>>Réseau</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required
                          placeholder="Décrivez votre projet..."><?= htmlspecialchars($editProjet['description'] ?? '') ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="technologies">Technologies (séparées par des virgules)</label>
                    <input type="text" id="technologies" name="technologies"
                           value="<?= htmlspecialchars($editProjet['technologies'] ?? '') ?>"
                           placeholder="Ex: PHP, MySQL, Docker">
                </div>
                <div class="form-group">
                    <label for="lien_github">Lien GitHub (optionnel)</label>
                    <input type="url" id="lien_github" name="lien_github"
                           value="<?= htmlspecialchars($editProjet['lien_github'] ?? '') ?>"
                           placeholder="https://github.com/...">
                </div>
            </div>

            <button type="submit" class="btn-admin-primary">
                <i class="fas fa-save"></i> <?= isset($editProjet) ? 'Mettre à jour' : 'Ajouter le projet' ?>
            </button>
        </form>
    </div>

    <!-- Liste des projets existants -->
    <div class="projets-list">
        <h2><i class="fas fa-list"></i> Projets existants</h2>
        <?php if (empty($projets)): ?>
            <p class="empty-msg">Aucun projet pour le moment.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Technologies</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($projets as $projet): ?>
                    <tr>
                        <td><?= $projet['id'] ?></td>
                        <td><?= htmlspecialchars($projet['titre']) ?></td>
                        <td><span class="badge badge-<?= $projet['categorie'] ?>"><?= ucfirst($projet['categorie']) ?></span></td>
                        <td><?= htmlspecialchars($projet['technologies'] ?? '—') ?></td>
                        <td class="actions">
                            <a href="?page=projets&action=edit&id=<?= $projet['id'] ?>" class="btn-edit"><i class="fas fa-pen"></i></a>
                            <a href="?page=projets&action=delete&id=<?= $projet['id'] ?>" class="btn-delete"
                               onclick="return confirm('Supprimer ce projet ?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<script src="/public/scriptJS/admin.js"></script>
</body>
</html>
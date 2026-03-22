<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Gestion du Parcours</title>
    <?php require_once __DIR__ . '/../layout/headerAdmin.php'; ?>
</head>
<body class="admin-body">
<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>

<main class="admin-main">
    <div class="admin-header">
        <h1>Mon <span class="highlight">Parcours</span></h1>
    </div>

    <?php if (!empty($message)) echo "<div class='admin-success'>$message</div>"; ?>

    <div class="dashboard-card admin-form-container admin-form-left form-mb-30">
        <form action="?page=parcours" method="POST" class="admin-form">
            <div class="form-row-flex">
                <div class="form-group form-col-1">
                    <label>Type :</label>
                    <select name="type" required>
                        <option value="formation">Formation</option>
                        <option value="experience">Expérience</option>
                    </select>
                </div>
                <div class="form-group form-col-2">
                    <label>Titre (ex: Développeur Web, BTS SIO...) :</label>
                    <input type="text" name="titre" required>
                </div>
            </div>
            <div class="form-row-flex">
                <div class="form-group form-col-1">
                    <label>Établissement / Entreprise :</label>
                    <input type="text" name="etablissement" required>
                </div>
                <div class="form-group form-col-1">
                    <label>Période (ex: Sept 2022 - Juin 2024) :</label>
                    <input type="text" name="date_periode" required>
                </div>
            </div>
            <div class="form-group mt-15">
                <label>Description :</label>
                <textarea name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn-primary mt-10">Ajouter au parcours</button>
        </form>
    </div>

    <div class="parcours-list-admin">
        <?php
        $toutLeParcours = array_merge($experiences, $formations);
        foreach ($toutLeParcours as $p):
            ?>
            <div class="dashboard-card parcours-item-admin">
                <div class="parcours-item-info">
                    <h4><?= htmlspecialchars($p['titre']) ?> <span style="display:inline-block; font-size:11px; padding:2px 8px; background:rgba(255,255,255,0.1); border-radius:10px; margin-left:10px;"><?= strtoupper($p['type']) ?></span></h4>
                    <span><?= htmlspecialchars($p['etablissement']) ?> | <?= htmlspecialchars($p['date_periode']) ?></span>
                    <p><?= nl2br(htmlspecialchars($p['description'])) ?></p>
                </div>
                <a href="?page=parcours&action=delete&id=<?= $p['id'] ?>" class="btn-delete-cv" onclick="return confirm('Supprimer cet élément ?')"><i class="fas fa-trash"></i></a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
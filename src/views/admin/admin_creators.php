<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="public/css/variables.css">
    <link rel="stylesheet" href="public/css/navbar.css">
    <link rel="stylesheet" href="public/css/dark_mode.css">
    <link rel="stylesheet" href="public/css/style_user.css">
    <link rel="stylesheet" href="public/css/style_admin.css">
    
    <title>Gestion des Créateurs</title>
</head>
<body>
    <?php require_once __DIR__ . '/../layout/navbar.php'; ?>

    <div class="app-container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
            <h2>Liste des Créateurs Autorisés</h2>
            <a href="index.php?route=admin_add_creator" class="btn-landing btn-primary" style="font-size:0.9rem;">
                + Ajouter nouveau créateur
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($creators)): ?>
                    <tr><td colspan="4" style="text-align:center;">Aucun créateur validé pour le moment.</td></tr>
                <?php else: ?>
                    <?php foreach ($creators as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['user_firstname'] . ' ' . $user['user_lastname']) ?></td>
                        <td><?= htmlspecialchars($user['user_email']) ?></td>
                        <td>
                            <span style="font-weight:bold; color:var(--primary-color);">
                                <?= ucfirst(htmlspecialchars($user['role'])) ?>
                            </span>
                        </td>
                        <td>
                            <a href="index.php?route=admin_revoke_right&id=<?= $user['user_id'] ?>" 
                                class="btn-action btn-danger"
                                onclick="return confirm('Retirer les droits de création à cet utilisateur ?');">
                                Retirer Droits
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="public/scriptJS/dark_mode.js"></script>
</body>
</html>
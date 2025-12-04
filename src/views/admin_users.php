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
    
    <title>Administration - Quizzeo</title>
</head>
<body>
    <?php require_once __DIR__ . '/navbar.php'; ?>

    <div class="app-container">
        <h2><?= isset($pageTitle) ? $pageTitle : 'Gestion des Utilisateurs' ?></h2>
        
        <?php if(isset($_GET['type'])): ?>
            <div style="text-align:center; margin-bottom:20px;">
                <a href="index.php?route=admin_users" class="btn-action" style="background:#ddd; color:#333;">Voir tout le monde</a>
            </div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom Complet</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Droit Création</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr><td colspan="7" style="text-align:center;">Aucun utilisateur trouvé dans cette catégorie.</td></tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td>#<?= $user['user_id'] ?></td>
                        <td><?= htmlspecialchars($user['user_firstname'] . ' ' . $user['user_lastname']) ?></td>
                        <td><?= htmlspecialchars($user['user_email']) ?></td>
                        <td>
                            <span style="font-weight:bold; color:var(--primary-color);">
                                <?= ucfirst(htmlspecialchars($user['role'])) ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-<?= $user['status'] ?>">
                                <?= $user['status'] == 'active' ? 'Actif' : 'Désactivé' ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($user['can_create_quiz']): ?>
                                <span style="color: green;">Oui</span>
                            <?php else: ?>
                                <span style="color: #999;">Non</span>
                            <?php endif; ?>

                            <?php if (in_array($user['role'], ['ecole', 'entreprise'])): ?>
                                <br>
                                <a href="index.php?route=admin_toggle_rights&id=<?= $user['user_id'] ?>" 
                                    style="font-size: 0.7em; text-decoration: underline;">
                                    <?= $user['can_create_quiz'] ? 'Révoquer' : 'Autoriser' ?>
                                </a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($user['role'] !== 'admin'): ?>
                                <a href="index.php?route=admin_toggle_user&id=<?= $user['user_id'] ?>" 
                                    class="btn-action <?= $user['status'] == 'active' ? 'btn-danger' : 'btn-warning' ?>">
                                    <?= $user['status'] == 'active' ? 'Désactiver' : 'Activer' ?>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
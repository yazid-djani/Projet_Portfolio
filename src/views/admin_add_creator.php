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
    
    <title>Ajouter un Créateur</title>
</head>
<body>
    <?php require_once __DIR__ . '/navbar.php'; ?>

    <div class="app-container">
        <div style="margin-bottom: 20px;">
            <a href="index.php?route=admin_creators" style="text-decoration:underline;">&larr; Retour à la liste des créateurs</a>
        </div>

        <h2>Donner les droits de création</h2>
        <p style="text-align:center; margin-bottom:30px; color:var(--text-muted);">
            Sélectionnez un utilisateur ci-dessous pour l'autoriser à créer des quiz.
        </p>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle Actuel</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr><td colspan="4" style="text-align:center;">Tous les utilisateurs sont déjà créateurs !</td></tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['user_firstname'] . ' ' . $user['user_lastname']) ?></td>
                        <td><?= htmlspecialchars($user['user_email']) ?></td>
                        <td><?= ucfirst(htmlspecialchars($user['role'])) ?></td>
                        <td>
                            <a href="index.php?route=admin_grant_right&id=<?= $user['user_id'] ?>" 
                                class="btn-action" 
                                style="background-color:var(--primary-color); color:white;">
                                Donner le droit
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
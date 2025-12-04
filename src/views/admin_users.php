<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/css/style_con_ins.css">
    <title>Administration Utilisateurs - Quizzeo</title>
    <style>
        .badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 600;
        }
        .badge-active {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-desactive {
            background-color: #f8d7da;
            color: #721c24;
        }
        .btn-action {
            font-size: 0.8em;
            padding: 5px 10px;
            margin: 0 2px;
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid #ccc;
            background-color: #f8f9fa;
            color: #333;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
            border-color: #ffc107;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .btn-info {
            background-color: #17a2b8;
            color: white;
            border-color: #17a2b8;
        }
        .btn-info:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><strong>Admin Panel</strong></li>
            <li><a href="index.php?route=dashboard">Dashboard</a></li>
            <li><a href="index.php?route=admin_quizzes">Gérer les Quiz</a></li>
            <li><a href="index.php?route=deconnexion">Déconnexion</a></li>
        </ul>
    </nav>

    <div class="app-container">
        <h2>Gestion des Utilisateurs</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom Complet</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Droit Création</th> <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr><td colspan="7">Aucun utilisateur trouvé.</td></tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td>#<?= $user['user_id'] ?></td>
                        <td><?= htmlspecialchars($user['user_firstname'] . ' ' . $user['user_lastname']) ?></td>
                        <td><?= htmlspecialchars($user['user_email']) ?></td>
                        <td><?= ucfirst(htmlspecialchars($user['role'])) ?></td>
                        <td>
                            <span class="badge badge-<?= $user['status'] ?>">
                                <?= $user['status'] == 'active' ? 'Actif' : 'Désactivé' ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($user['can_create_quiz']): ?>
                                <span style="color: green; font-weight: bold;">Oui</span>
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
                                    class="btn-action <?= $user['status'] == 'active' ? 'btn-warning' : '' ?>">
                                    <?= $user['status'] == 'active' ? 'Désactiver' : 'Activer' ?>
                                </a>
                            <?php else: ?>
                                <span>-</span>
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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/variables.css">
    <link rel="stylesheet" href="public/css/navbar.css">
    <link rel="stylesheet" href="public/css/dark_mode.css">
    <link rel="stylesheet" href="public/css/style_user.css">
    <title>Dashboard - Quizzeo</title>
</head>
<body>

    <?php require_once __DIR__ . '/layout/navbar.php'; ?>

    <div class="app-container">
        <h2>Quiz Disponibles</h2>
        <p style="margin-bottom:20px; color:var(--text-muted);">Voici les quiz auxquels vous pouvez participer.</p>
        
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Visibilité</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($availableQuizzes)): ?>
                    <tr><td colspan="4" style="text-align:center;">Aucun quiz disponible pour le moment.</td></tr>
                <?php else: ?>
                    <?php foreach ($availableQuizzes as $quiz): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($quiz['titre']) ?></strong><br>
                            <small><?= htmlspecialchars($quiz['description']) ?></small>
                        </td>
                        <td><?= htmlspecialchars($quiz['user_firstname'] . ' ' . $quiz['user_lastname']) ?></td>
                        <td>
                            <?php if($quiz['visibility'] === 'private'): ?>
                                <span style="color:var(--primary-color);">🔒 Privé (Groupe)</span>
                            <?php else: ?>
                                <span style="color:green;">🌍 Public</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?route=jouer_quiz&id=<?= $quiz['id_quiz'] ?>" class="btn-landing btn-primary" style="padding: 5px 15px; font-size: 0.8em;">
                                JOUER ▶
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($createdQuizzes) || $_SESSION['role'] !== 'utilisateur'): ?>
    <div class="app-container">
        <h2>Mes Créations</h2>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Statut</th>
                    <th>Date création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($createdQuizzes)): ?>
                    <tr><td colspan="4" style="text-align:center;">Vous n'avez pas encore créé de quiz.</td></tr>
                <?php else: ?>
                    <?php foreach ($createdQuizzes as $quiz): ?>
                    <tr>
                        <td><?= htmlspecialchars($quiz['titre']) ?></td>
                        <td><?= htmlspecialchars($quiz['status']) ?></td>
                        <td><?= htmlspecialchars($quiz['created_at']) ?></td>
                        <td>
                            <a href="index.php?route=modifier_quiz&id=<?= $quiz['id_quiz'] ?>" style="color:var(--accent-color);">Modifier</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
    
    <script src="public/scriptJS/dark_mode.js"></script>
</body>
</html>
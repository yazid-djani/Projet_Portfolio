<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="public/css/variables.css">
    
    <link rel="stylesheet" href="public/css/navbar.css">
    
    <link rel="stylesheet" href="public/css/dark_mode.css">
    
    <link rel="stylesheet" href="public/css/style_user.css">
    
    <title>Quizzeo</title>
</head>
<body>

    <?php require_once __DIR__ . '/navbar.php'; ?>

    <div class="app-container">
        <h2>Mes Quiz</h2>
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
                <?php if (empty($quizzes)): ?>
                    <tr><td colspan="4">Aucun quiz créé pour le moment.</td></tr>
                <?php else: ?>
                    <?php foreach ($quizzes as $quiz): ?>
                    <tr>
                        <td><?= htmlspecialchars($quiz['titre']) ?></td>
                        <td><?= htmlspecialchars($quiz['status']) ?></td>
                        <td><?= htmlspecialchars($quiz['created_at']) ?></td>
                        <td>
                            <a href="index.php?route=modifier_quiz&id=<?= $quiz['id_quiz'] ?>">Modifier</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
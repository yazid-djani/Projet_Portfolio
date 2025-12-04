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
        <h2><?= htmlspecialchars($quiz['titre']) ?></h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 30px;">
            <?= htmlspecialchars($quiz['description']) ?>
        </p>

        <form method="POST" action="index.php?route=submit_quiz&id=<?= $quiz['id_quiz'] ?>">
            
            <?php if (empty($questions)): ?>
                <p>Ce quiz n'a pas encore de questions.</p>
            <?php else: ?>
                <?php foreach ($questions as $idQuestion => $q): ?>
                    <div class="question-block">
                        <div class="question-title">
                            <?= htmlspecialchars($q['libelle']) ?>
                        </div>
                        
                        <div class="choices">
                            <?php foreach ($q['choix'] as $choix): ?>
                                <label class="choice-label">
                                    <input type="radio" 
                                        name="reponse[<?= $idQuestion ?>]" 
                                        value="<?= $choix['id'] ?>" required>
                                    <?= htmlspecialchars($choix['libelle']) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <button type="submit">Valider mes réponses</button>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
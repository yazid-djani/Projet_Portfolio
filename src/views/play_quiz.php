<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/style_con_ins.css">
    <title>Jouer : <?= htmlspecialchars($quiz['titre']) ?></title>
    <style>
        /* Ajout de styles spécifiques pour le quiz */
        .question-block {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border: 1px solid var(--border-color);
        }
        .question-title {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 1.1em;
        }
        .choice-label {
            display: block;
            margin: 10px 0;
            cursor: pointer;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.2s;
        }
        .choice-label:hover {
            background-color: var(--table-row-hover);
        }
        input[type="radio"] {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><strong>Quizzeo</strong></li>
            <li><a href="index.php?route=dashboard">Retour au Dashboard</a></li>
        </ul>
    </nav>

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
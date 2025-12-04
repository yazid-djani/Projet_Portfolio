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

    <div class="app-container" style="text-align: center;">
        <h1>Quiz Terminé !</h1>
        <?php 
            // Récupération rapide du score via SQL direct (pour l'exemple)
            // Idéalement à faire dans le Controller
            $pdo = \App\Lib\Database::getPDO();
            $stmt = $pdo->prepare("SELECT score_total FROM tentative WHERE id_tentative = ?");
            $stmt->execute([$_GET['id']]);
            $score = $stmt->fetchColumn();
        ?>
        
        <div style="font-size: 3em; margin: 20px 0; color: var(--primary-color);">
            Score : <?= $score ?>
        </div>

        <a href="index.php?route=dashboard" class="btn">Retour au tableau de bord</a>
    </div>
    <script src="public/scriptJS/dark_mode.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/css/style_con_ins.css">
    <title>Résultats</title>
</head>
<body>
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
</body>
</html>
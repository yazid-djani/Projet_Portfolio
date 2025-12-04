<!DOCTYPE html>
<html lang="en">
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

    <div class="landing-container">
        <h1 class="landing-title">Salut ! C'est Quizzeo, une plateforme qui propose des quiz à tous les niveaux</h1>
        <p class="landing-text">
            La plateforme ultime pour créer, partager et jouer à des quiz en temps réel.
            De l'école à l'entrepreneuriat, rejoignez-nous !
        </p>

        <div class="btn-group">
            <a href="index.php?route=connexion" class="btn-landing btn-primary">Connexion</a>

            <a href="index.php?route=inscription" class="btn-landing btn-secondary">Inscription</a>

            <a href="index.php?route=informationentreprise" class="btn-landing btn-secondary">Information entreprise</a>
            
            <a href="index.php?route=informationutilisateur" class="btn-landing btn-secondary">Information utilisateur</a>

            <a href="index.php?route=informationecole" class="btn-landing btn-secondary">Information école</a>

            <a href="index.php?route=classement" class="btn-landing btn-secondary">Classement</a>
        </div>
    </div>

    <script src="public/scriptJS/accueil.js"></script>
</body>
</html>
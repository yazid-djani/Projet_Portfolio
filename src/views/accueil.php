<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/accueil.css">

    <title>Accueil</title>
</head>
<body>

    <nav style="position:absolute; top:20px; left:20px;">
        <button id="theme-toggle">🌙 Mode Sombre</button>
    </nav>

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
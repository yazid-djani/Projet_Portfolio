<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="public/css/couleur.css">
    <link rel="stylesheet" href="public/css/styleAdminConnexion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="login-body">
<div class="login-container">
    <div class="login-header">
        <h2><i class="fas fa-lock lock-icon-login"></i> Accès <span class="highlight">Sécurisé</span></h2>
        <p>Veuillez vous identifier pour accéder au panel.</p>
    </div>

    <?php if (!empty($erreur)) echo "<div class='login-error'><i class='fas fa-exclamation-circle'></i> $erreur</div>"; ?>

    <form action="?action=login" method="POST" class="login-form">
        <div class="form-group">
            <label for="username">Identifiant</label>
            <input type="text" id="username" name="username" required autocomplete="username">
        </div>
        <div class="form-group form-group-last">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required autocomplete="current-password">
        </div>
        <button type="submit" class="login-btn">Se connecter</button>
    </form>
</div>
</body>
</html>
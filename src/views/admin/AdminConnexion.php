<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin | Connexion</title>

        <link rel="stylesheet" href="/public/css/couleur.css">
        <link rel="stylesheet" href="/public/css/styleAdmin.css">
    </head>
    <body class="login-body">

    <div class="login-container">
        <div class="login-header">
            <h1 class="login-logo">YD</h1>
            <h2>Panel Administrateur</h2>
            <p>Connectez-vous pour accéder au tableau de bord</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="login-error">
                ⚠️ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?action=login" class="login-form">

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                    autocomplete="username"
                    placeholder="Entrez votre identifiant"
                    value="<?= htmlspecialchars($username ?? '') ?>"
                >
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Entrez votre mot de passe"
                >
            </div>

            <button type="submit" class="login-btn">Se connecter</button>

        </form>
    </div>

    </body>
</html>
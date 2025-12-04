<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="public/css/variables.css">
    <link rel="stylesheet" href="public/css/navbar.css">
    <link rel="stylesheet" href="public/css/dark_mode.css">
    <link rel="stylesheet" href="public/css/style_user.css">
    
    <title>Quizzeo - Authentification</title>
</head>

<body>
    <?php require_once __DIR__ . '/navbar.php'; ?>

    <div class="container <?= isset($containerClass) ? $containerClass : '' ?>" id="container">
        
        <div class="form-container sign-up">
            <form method="POST" action="index.php?route=inscription">
                <h1>Inscription</h1>
                <?php if (isset($_GET['error'])): ?>
                    <p class="error-message">Erreur lors de l'inscription.</p>
                <?php endif; ?>

                <input type="text" name="prenom" placeholder="Prénom" required>
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="number" name="age" placeholder="Age" required min="1">
                
                <select name="role" required>
                    <option value="" disabled selected>Type de compte</option>
                    <option value="utilisateur">Joueur</option>
                    <option value="ecole">École</option>
                    <option value="entreprise">Entreprise</option>
                </select>

                <input type="password" name="password" placeholder="Mot de passe" required>
                <button type="submit">S'inscrire</button>
            </form>
        </div>

        <div class="form-container sign-in">
            <form method="POST" action="index.php?route=connexion">
                <h1>Connexion</h1>
                
                <?php if (isset($_GET['success'])): ?>
                    <p style="color:green; font-weight:bold;">Compte créé ! Connectez-vous.</p>
                <?php endif; ?>
                <?php if (isset($_GET['error']) && $_GET['error'] == 'login_failed'): ?>
                    <p class="error-message">Email ou mot de passe incorrect.</p>
                <?php endif; ?>

                <span>Utilisez votre email</span>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <a href="#">Mot de passe oublié ?</a>
                <button type="submit">Se Connecter</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Déjà membre ?</h1>
                    <p>Pour retrouver vos quiz, connectez-vous ici.</p>
                    <button class="hidden" id="login">Connexion</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Bonjour !</h1>
                    <p>Pas encore inscrit ? Rejoignez Quizzeo dès maintenant.</p>
                    <button class="hidden" id="register">S'inscrire</button>
                </div>
            </div>
        </div>
    </div>

    <script src="public/scriptJS/script_user.js"></script>
</body>
</html>
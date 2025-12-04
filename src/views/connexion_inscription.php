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
    <?php require_once __DIR__ . '/layout/navbar.php'; ?>

    <div class="container <?= isset($containerClass) ? $containerClass : '' ?>" id="container">
        
        <div class="form-container sign-up">
            <form method="POST" action="index.php?route=inscription">
                <h1>Inscription</h1>
                
                <?php if (isset($_GET['error'])): ?>
                    <p class="error-message" style="color:red; font-size:0.9em;">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </p>
                <?php endif; ?>

                <input type="text" name="prenom" placeholder="Prénom" required>
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="number" name="age" placeholder="Age" required min="1">
                
                <select name="role" id="role-select" required>
                    <option value="" disabled selected>Type de compte</option>
                    <option value="utilisateur">Utilisateur Standard</option>
                    <option value="ecole">École</option>
                    <option value="entreprise">Entreprise</option>
                </select>

                <div id="group-code-container" style="display:none; width:100%; margin-top:5px;">
                    <input type="text" name="group_code" placeholder="Code Groupe (ex: CLASS2025)" style="border: 2px dashed var(--primary-color);">
                    <span style="font-size: 10px; color:var(--text-muted); display:block; margin-top:-5px; margin-bottom:10px;">
                        Créez un code pour votre organisation ou entrez celui de votre établissement.
                    </span>
                </div>

                <input type="password" name="password" placeholder="Mot de passe" required>
                <button type="submit">S'inscrire</button>
            </form>
        </div>

        <div class="form-container sign-in">
            <form method="POST" action="index.php?route=connexion">
                <h1>Connexion</h1>
                
                <?php if (isset($_GET['success'])): ?>
                    <p style="color:green; font-weight:bold; font-size:0.9em;">Compte créé ! Connectez-vous.</p>
                <?php endif; ?>
                
                <?php if (isset($_GET['error'])): ?>
                    <?php if ($_GET['error'] == 'login_failed'): ?>
                        <p class="error-message" style="color:red; font-size:0.9em;">Email ou mot de passe incorrect.</p>
                    <?php elseif ($_GET['error'] == 'account_disabled'): ?>
                        <p class="error-message" style="color:red; font-size:0.9em;">Votre compte a été désactivé.</p>
                    <?php elseif ($_GET['error'] == 'auth_required'): ?>
                        <p class="error-message" style="color:orange; font-size:0.9em;">Veuillez vous connecter pour accéder à cette page.</p>
                    <?php endif; ?>
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

    <script src="public/scriptJS/dark_mode.js"></script>
    <script src="public/scriptJS/script_user.js"></script>
    <script src="public/scriptJS/script_role.js"></script>
</body>
</html>
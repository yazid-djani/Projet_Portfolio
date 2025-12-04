<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="public/css/style_con_ins.css">
<title>Connexion / Inscription</title>
</head>

<body>

<div class="container" id="container">
    <div class="form-container sign-up">

        <form method="POST" action="index.php?route=inscription">
            <h1>Inscription</h1>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="number" name="age" placeholder="Age" required min="1">
            
            <select name="role" required style="margin: 10px 0; padding: 15px 20px; width: 100%; border-radius: 8px; background-color: var(--input-bg); border: none; color: var(--text-main);">
                <option value="" disabled selected>Choisir votre type de compte</option>
                <option value="utilisateur">Utilisateur Simple (Joueur)</option>
                <option value="ecole">École (Créateur)</option>
                <option value="entreprise">Entreprise (Créateur)</option>
            </select>

            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">S'inscrire</button>
        </form>
    </div>

    <div class="form-container sign-in">
        <form method="POST" action="index.php?route=connexion">        <!-- Formulaire de connexion de l'utilisateur -->
            <h1>Connexion</h1>
            <?php if (isset($login_error)): ?>
                <p class="error-message" style="margin: 0;"><?= htmlspecialchars($login_error) ?></p>
            <?php endif; ?>
            
            <span>Utilisez votre email et mot de passe</span>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <a href="#">Mot de passe oublié?</a>
            <button type="submit">Se Connecter</button>
        </form>
    </div>

    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-left">
                <h1>Bienvenue!</h1>
                <p>Pour accéder à la gestion complète, veuillez vous connecter.</p>
                <button class="hidden" id="login">Connexion</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Bonjour, Adhérent!</h1>
                <p>Inscrivez-vous pour devenir un nouvel adhérent de la bibliothèque.</p>
                <button class="hidden" id="register">S'inscrire</button>
            </div>
        </div>
    </div>
</div>

<script src="public/scriptJS/script_con_ins.js"></script>
</body>
</html>
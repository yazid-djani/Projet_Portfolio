<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/variables.css">
    <link rel="stylesheet" href="public/css/navbar.css">
    <link rel="stylesheet" href="public/css/dark_mode.css">
    <link rel="stylesheet" href="public/css/style_user.css">
    <title>Quizzeo - Création</title>
</head>
<body>
    <?php require_once __DIR__ . '/navbar.php'; ?>

    <div class="container">
        <form method="POST" action="index.php?route=creer_quiz">
            <h1>Nouveau Quiz</h1>
            
            <input type="text" name="titre" placeholder="Titre du quiz" required>
            <input type="text" name="description" placeholder="Description courte">
            
            <div style="text-align:left; width:100%; margin: 15px 0;">
                <span style="font-weight:bold; color:var(--text-muted); font-size:0.9em;">Visibilité :</span>
                <div style="margin-top: 5px;">
                    <label style="margin-right: 15px; cursor:pointer;">
                        <input type="radio" name="visibility" value="public" checked> 
                        Public 🌍 <small>(Visible par tous)</small>
                    </label>
                    <label style="cursor:pointer;">
                        <input type="radio" name="visibility" value="private"> 
                        Privé 🔒 <small>(Visible uniquement par mon groupe)</small>
                    </label>
                </div>
            </div>

            <span style="display:block; text-align:left; margin-top:10px;">Dates (Optionnel)</span>
            <input type="datetime-local" name="date_lancement" placeholder="Date de début">
            <input type="datetime-local" name="date_cloture" placeholder="Date de fin">
            
            <button type="submit">Créer le Quiz</button>
            <a href="index.php?route=dashboard" style="margin-top: 15px; display:inline-block; font-size:0.9em;">Annuler</a>
        </form>
    </div>

    <script src="public/scriptJS/dark_mode.js"></script>
</body>
</html>
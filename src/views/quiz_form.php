<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/css/style_con_ins.css">
    <title>Créer un Quiz</title>
</head>
<body>
    <div class="container">
        <form method="POST" action="index.php?route=creer_quiz">
            <h1>Nouveau Quiz</h1>
            <input type="text" name="titre" placeholder="Titre du quiz" required>
            <input type="text" name="description" placeholder="Description courte">
            
            <span>Dates (Optionnel)</span>
            <input type="datetime-local" name="date_lancement" placeholder="Date de début">
            <input type="datetime-local" name="date_cloture" placeholder="Date de fin">
            
            <button type="submit">Créer le Quiz</button>
            <a href="index.php?route=dashboard" style="margin-top: 15px; display:inline-block;">Annuler</a>
        </form>
    </div>
</body>
</html>
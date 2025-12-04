<!DOCTYPE html>
<html lang="fr">
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
    <?php require_once __DIR__ . '/layout/navbar.php'; ?>
    <div class="app-container">
        <h2>Ajouter une question</h2>
        <form method="POST" action="index.php?route=traitement_question">
            <input type="hidden" name="id_quiz" value="<?= htmlspecialchars($id_quiz) ?>">

            <label>Question :</label>
            <input type="text" name="libelle_question" required placeholder="Intitulé de la question">
            
            <h3>Réponses possibles (cochez la bonne réponse)</h3>
            
            <div style="text-align:left; margin: 10px 0;">
                <input type="radio" name="correct" value="0" required> 
                <input type="text" name="choix[0]" placeholder="Choix 1" required style="width:80%; display:inline-block">
            </div>
            
            <div style="text-align:left; margin: 10px 0;">
                <input type="radio" name="correct" value="1"> 
                <input type="text" name="choix[1]" placeholder="Choix 2" required style="width:80%; display:inline-block">
            </div>

            <div style="text-align:left; margin: 10px 0;">
                <input type="radio" name="correct" value="2"> 
                <input type="text" name="choix[2]" placeholder="Choix 3" style="width:80%; display:inline-block">
            </div>

            <div style="text-align:left; margin: 10px 0;">
                <input type="radio" name="correct" value="3"> 
                <input type="text" name="choix[3]" placeholder="Choix 4" style="width:80%; display:inline-block">
            </div>

            <button type="submit" name="next">Enregistrer et ajouter une autre</button>
            <button type="submit" name="finish" style="background-color:#4CAF50;">Terminer le Quiz</button>
        </form>
    </div>
    <script src="public/scriptJS/dark_mode.js"></script>
</body>
</html>
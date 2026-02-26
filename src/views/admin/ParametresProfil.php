<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le Profil</title>
    <link rel="stylesheet" href="/public/css/styleAdmin.css">
</head>
<body>
<h2>Paramètres du Profil</h2>

<?php if (isset($message)) echo "<p style='color:green'>$message</p>"; ?>

<form action="?page=profil" method="POST">
    <label>Prénom:</label>
    <input type="text" name="prenom" value="<?= htmlspecialchars($profil['prenom'] ?? '') ?>"><br>

    <label>Nom:</label>
    <input type="text" name="nom" value="<?= htmlspecialchars($profil['nom'] ?? '') ?>"><br>

    <label>Titre:</label>
    <input type="text" name="titre_poste" value="<?= htmlspecialchars($profil['titre_poste'] ?? '') ?>"><br>

    <label>Description Hero:</label>
    <textarea name="description_hero"><?= htmlspecialchars($profil['description_hero'] ?? '') ?></textarea><br>

    <label>À propos:</label>
    <textarea name="description_about"><?= htmlspecialchars($profil['description_about'] ?? '') ?></textarea><br>

    <button type="submit">Sauvegarder</button>
</form>
</body>
</html>
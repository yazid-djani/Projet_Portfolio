<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($profil['prenom'] ?? '') ?> <?= htmlspecialchars($profil['nom'] ?? '') ?> | Portfolio</title>
    <meta name="description" content="Portfolio de <?= htmlspecialchars($profil['prenom'] ?? '') ?> <?= htmlspecialchars($profil['nom'] ?? '') ?>. Découvrez mes projets, compétences et parcours.">

    <link rel="stylesheet" href="public/css/couleur.css">
    <link rel="stylesheet" href="public/css/styleNavbar.css">
    <link rel="stylesheet" href="public/css/styleViewer.css">
    <link rel="stylesheet" href="public/css/styleResDev.css">
    <link rel="stylesheet" href="public/css/styleOpenProject.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<?php require_once __DIR__ . '/layout/navbarViewer.php'; ?>

<?php require_once __DIR__ . '/viewer/hero.php'; ?>
<?php require_once __DIR__ . '/viewer/projets.php'; ?>
<?php require_once __DIR__ . '/viewer/competences.php'; ?>
<?php require_once __DIR__ . '/viewer/outils.php'; ?>
<?php require_once __DIR__ . '/viewer/certifications.php'; ?>
<?php require_once __DIR__ . '/viewer/cv.php'; ?>
<?php require_once __DIR__ . '/viewer/contact.php'; ?>

<?php require_once __DIR__ . '/layout/footer.php'; ?>

<script src="public/scriptJS/navbar.js"></script>
<script src="public/scriptJS/viewer.js"></script>
<script src="public/scriptJS/trafic.js"></script>
<script src="public/scriptJS/ResDevPanel.js"></script>
<script src="public/scriptJS/openProjet.js"></script>

</body>
</html>
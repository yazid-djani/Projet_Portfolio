<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Yazid Djani | Portfolio</title>

        <link rel="stylesheet" href="public/css/couleur.css">
        <link rel="stylesheet" href="public/css/styleNavbar.css">
        <link rel="stylesheet" href="public/css/styleViewer.css">
    </head>
    <body>
        <?php require_once __DIR__ . '/layout/navbarViewer.php'; ?>

        <main class="main-container">
            <section id="dev-panel" class="panel">
                <h1>Développement</h1>
                <div class="projet-grid">
                    <?php foreach ($projetsDev as $projet): ?>
                        <div class="card" onclick="openProjet(<?= $projet['id'] ?>)">
                            <h3><?= htmlspecialchars($projet['titre']) ?></h3>
                            <p><?= htmlspecialchars($projet['description']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section id="reseau-panel" class="panel">
                <h1>Réseau & Système</h1>
                <div class="projet-grid">
                    <?php foreach ($projetsReseau as $projet): ?>
                        <div class="card" onclick="openProjet(<?= $projet['id'] ?>)">
                            <h3><?= htmlspecialchars($projet['titre']) ?></h3>
                            <p><?= htmlspecialchars($projet['description']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>

        <script src="public/scriptJS/ResDevPanel.js"></script>
        <script src="public/scriptJS/openProjet.js"></script>
    </body>
</html>
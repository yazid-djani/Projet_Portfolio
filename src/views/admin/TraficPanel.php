<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin | Trafic Panel</title>
    <link rel="stylesheet" href="/public/css/couleur.css">
    <link rel="stylesheet" href="/public/css/styleNavbarAdmin.css">
    <link rel="stylesheet" href="/public/css/styleAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="admin-body">

<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>

<main class="admin-main">
    <div class="admin-header" style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <h1>Trafic <span class="highlight">Panel</span></h1>
            <p>Analyse des visites et des interactions en temps réel.</p>
        </div>
        <a href="?page=statistiques&action=clear" class="btn-secondary" style="border-color:#ff5f57; color:#ff5f57; margin-top: 10px;" onclick="return confirm('Êtes-vous sûr de vouloir effacer TOUT l\'historique des visites ? Cette action est irréversible.')">
            <i class="fas fa-trash"></i> Vider les statistiques
        </a>
    </div>

    <?php if (!empty($message)) echo "<div class='admin-success'>$message</div>"; ?>

    <div class="dashboard-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 40px;">
        <?php if (empty($resumeStats)): ?>
            <p style="color: var(--text-paragraph);">Aucune donnée à afficher pour le moment.</p>
        <?php else: ?>
            <?php foreach ($resumeStats as $stat): ?>
                <div class="dashboard-card" style="padding: 20px;">
                    <h4 style="font-size: 14px; opacity: 0.8;"><?= strtoupper(str_replace('_', ' ', $stat['page'])) ?></h4>
                    <p style="font-size: 28px; font-weight: 800; color: var(--color-highlight);"><?= $stat['total'] ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if (!empty($parcoursUtilisateurs)): ?>
        <div class="dashboard-card" style="text-align: left; padding: 30px; overflow-x: auto;">
            <h3 style="margin-bottom: 20px;"><i class="fas fa-users"></i> Parcours par Utilisateur (IP)</h3>
            <table style="width: 100%; border-collapse: collapse; color: var(--text-paragraph);">
                <thead>
                <tr style="border-bottom: 1px solid var(--border-glass); text-align: left;">
                    <th style="padding: 15px;">Adresse IP</th>
                    <th style="padding: 15px;">Dernière Activité</th>
                    <th style="padding: 15px;">Actions / Parcours</th>
                    <th style="padding: 15px;">Total</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($parcoursUtilisateurs as $user): ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 15px; font-family: monospace; color: var(--text-headline);"><?= $user['ip_address'] ?></td>
                        <td style="padding: 15px; font-size: 13px;"><?= date('d/m H:i', strtotime($user['derniere_activite'])) ?></td>
                        <td style="padding: 15px; font-size: 13px; max-width: 400px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($user['parcours']) ?>">
                            <?= htmlspecialchars($user['parcours']) ?>
                        </td>
                        <td style="padding: 15px;"><span class="highlight" style="font-weight: bold;"><?= $user['total_actions'] ?></span></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

</body>
</html>
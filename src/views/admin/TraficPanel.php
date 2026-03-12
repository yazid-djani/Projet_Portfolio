<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Admin | Trafic Panel</title>
    <?php require_once __DIR__ . '/../layout/headerAdmin.php'; ?>
</head>
<body class="admin-body">

<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>

<main class="admin-main">
    <div class="admin-header admin-header-flex-start">
        <div>
            <h1>Trafic <span class="highlight">Panel</span></h1>
            <p>Analyse des visites et des interactions en temps réel.</p>
        </div>
        <a href="?page=statistiques&action=clear" class="btn-secondary btn-danger mt-10" onclick="return confirm('Êtes-vous sûr de vouloir effacer TOUT l\'historique des visites ? Cette action est irréversible.')">
            <i class="fas fa-trash"></i> Vider les statistiques
        </a>
    </div>

    <?php if (!empty($message)) echo "<div class='admin-success'>$message</div>"; ?>

    <div class="dashboard-grid stats-grid-compact">
        <?php if (empty($resumeStats)): ?>
            <p class="msg-empty">Aucune donnée à afficher pour le moment.</p>
        <?php else: ?>
            <?php foreach ($resumeStats as $stat): ?>
                <div class="dashboard-card stat-card">
                    <h4 class="stat-title"><?= strtoupper(str_replace('_', ' ', $stat['page'])) ?></h4>
                    <p class="stat-value"><?= $stat['total'] ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if (!empty($parcoursUtilisateurs)): ?>
        <div class="dashboard-card table-container">
            <h3 class="mb-10"><i class="fas fa-users"></i> Parcours par Utilisateur (IP)</h3>
            <table class="admin-table">
                <thead>
                <tr>
                    <th>Adresse IP</th>
                    <th>Dernière Activité</th>
                    <th>Actions / Parcours</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($parcoursUtilisateurs as $user): ?>
                    <tr>
                        <td class="ip-col"><?= $user['ip_address'] ?></td>
                        <td class="date-col"><?= date('d/m H:i', strtotime($user['derniere_activite'])) ?></td>
                        <td class="path-col" title="<?= htmlspecialchars($user['parcours']) ?>">
                            <?= htmlspecialchars($user['parcours']) ?>
                        </td>
                        <td><span class="highlight font-bold"><?= $user['total_actions'] ?></span></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

</body>
</html>
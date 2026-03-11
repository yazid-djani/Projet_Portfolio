<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Boîte de réception</title>
    <?php require_once __DIR__ . '/../layout/headerAdmin.php'; ?>
</head>
<body class="admin-body">

<?php require_once __DIR__ . '/../layout/navbarAdmin.php'; ?>

<main class="admin-main">
    <div class="admin-header">
        <h1>Boîte de <span class="highlight">Réception</span></h1>
        <p>Vos derniers messages de contact.</p>
    </div>

    <div style="display: flex; flex-direction: column; gap: 20px; max-width: 1000px; margin: 0 auto;">
        <?php if (empty($messages)): ?>
            <p style="text-align: center; color: var(--text-paragraph);">Aucun message reçu pour le moment.</p>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <div class="dashboard-card" style="text-align: left; padding: 25px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; border-bottom: 1px solid var(--border-glass); padding-bottom: 15px;">
                        <div>
                            <h3 style="font-size: 18px; margin-bottom: 5px;"><?= htmlspecialchars($msg['sujet']) ?: 'Sans sujet' ?></h3>
                            <p style="font-size: 13px; color: var(--text-paragraph);">
                                <i class="fas fa-user"></i> <?= htmlspecialchars($msg['nom']) ?> &nbsp;|&nbsp;
                                <i class="fas fa-envelope"></i> <a href="mailto:<?= htmlspecialchars($msg['email']) ?>" style="color: var(--color-highlight); text-decoration: none;"><?= htmlspecialchars($msg['email']) ?></a>
                            </p>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 12px; color: var(--text-paragraph); display: block; margin-bottom: 10px;">
                                <?= date('d/m/Y à H:i', strtotime($msg['created_at'])) ?>
                            </span>
                            <a href="?page=messages&action=delete&id=<?= $msg['id'] ?>" class="btn-secondary" style="border-color:#ff5f57; color:#ff5f57; padding: 6px 12px; font-size: 12px;" onclick="return confirm('Supprimer ce message ?')">
                                <i class="fas fa-trash"></i> Supprimer
                            </a>
                        </div>
                    </div>

                    <p style="font-size: 14px; line-height: 1.8; color: var(--text-headline); white-space: pre-wrap;"><?= htmlspecialchars($msg['message']) ?></p>

                    <div style="margin-top: 20px;">
                        <a href="mailto:<?= htmlspecialchars($msg['email']) ?>?subject=Re: <?= htmlspecialchars($msg['sujet']) ?>" class="btn-primary" style="padding: 10px 20px; font-size: 13px;">
                            <i class="fas fa-reply"></i> Répondre par mail
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
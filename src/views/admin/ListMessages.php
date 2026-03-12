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

    <div class="msg-list-container">
        <?php if (empty($messages)): ?>
            <p class="msg-empty">Aucun message reçu pour le moment.</p>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <div class="dashboard-card msg-card">
                    <div class="msg-header">
                        <div>
                            <h3 class="msg-title"><?= htmlspecialchars($msg['sujet']) ?: 'Sans sujet' ?></h3>
                            <p class="msg-meta">
                                <i class="fas fa-user"></i> <?= htmlspecialchars($msg['nom']) ?> &nbsp;|&nbsp;
                                <i class="fas fa-envelope"></i> <a href="mailto:<?= htmlspecialchars($msg['email']) ?>"><?= htmlspecialchars($msg['email']) ?></a>
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="msg-date">
                                <?= date('d/m/Y à H:i', strtotime($msg['created_at'])) ?>
                            </span>
                            <a href="?page=messages&action=delete&id=<?= $msg['id'] ?>" class="btn-secondary btn-danger btn-sm" onclick="return confirm('Supprimer ce message ?')">
                                <i class="fas fa-trash"></i> Supprimer
                            </a>
                        </div>
                    </div>

                    <p class="msg-body"><?= htmlspecialchars($msg['message']) ?></p>

                    <div class="msg-actions">
                        <a href="mailto:<?= htmlspecialchars($msg['email']) ?>?subject=Re: <?= htmlspecialchars($msg['sujet']) ?>" class="btn-primary msg-reply-btn">
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
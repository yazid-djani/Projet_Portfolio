<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-brand">
            <span class="footer-logo"><?= htmlspecialchars(strtoupper(substr($profil['prenom'] ?? 'Y', 0, 1) . substr($profil['nom'] ?? 'D', 0, 1))) ?></span>
            <p><?= htmlspecialchars($profil['prenom'] ?? '') ?> <?= htmlspecialchars($profil['nom'] ?? '') ?> — Portfolio</p>
        </div>
        <div class="footer-links">
            <a href="#hero">Accueil</a>
            <a href="#about">À propos</a>
            <a href="#projets">Projets</a>
            <a href="#contact">Contact</a>
        </div>
        <div class="footer-socials">
            <?php if (!empty($profil['lien_github'])): ?>
                <a href="<?= htmlspecialchars($profil['lien_github']) ?>" target="_blank"><i class="fab fa-github"></i></a>
            <?php endif; ?>
            <?php if (!empty($profil['lien_linkedin'])): ?>
                <a href="<?= htmlspecialchars($profil['lien_linkedin']) ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
            <?php endif; ?>
            <?php if (!empty($profil['email_contact'])): ?>
                <a href="mailto:<?= htmlspecialchars($profil['email_contact']) ?>"><i class="fas fa-envelope"></i></a>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($profil['prenom'] ?? '') ?> <?= htmlspecialchars($profil['nom'] ?? '') ?>. Tous droits réservés.</p>
        <p style="font-size: 12px; opacity: 0.6; margin-top: 5px;">Template original créé par <a href="https://github.com/yazid-djani" target="_blank" style="color: inherit; text-decoration: underline;">Yazid Djani</a></p>
    </div>
</footer>
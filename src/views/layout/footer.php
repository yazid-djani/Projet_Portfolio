<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-brand">
            <span class="footer-logo text-primary">PORTFOLIO</span><span class="footer-logo text-white">.</span>
            <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($profil['prenom'] ?? '') ?> <?= htmlspecialchars($profil['nom'] ?? '') ?>.</p>
        </div>
        <div class="footer-socials">
            <?php if (!empty($profil['lien_github'])): ?>
                <a href="<?= htmlspecialchars($profil['lien_github']) ?>" target="_blank">GitHub</a>
            <?php endif; ?>
            <?php if (!empty($profil['lien_linkedin'])): ?>
                <a href="<?= htmlspecialchars($profil['lien_linkedin']) ?>" target="_blank">LinkedIn</a>
            <?php endif; ?>
            <?php if (!empty($profil['email_contact'])): ?>
                <a href="mailto:<?= htmlspecialchars($profil['email_contact']) ?>">Contact</a>
            <?php endif; ?>
        </div>
    </div>
</footer>
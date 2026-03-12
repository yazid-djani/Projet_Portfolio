<footer class="footer-viewer">
    <div class="footer-content">
        <div class="footer-logo">
            <img src="public/images/logo.png" alt="Logo" height="35">
        </div>
        <p class="footer-text">&copy; <?= date('Y') ?> <?= htmlspecialchars($profil['prenom'] ?? '') ?> <?= htmlspecialchars($profil['nom'] ?? '') ?>. Tous droits réservés.</p>

        <div class="footer-socials">
            <?php if(!empty($profil['lien_github'])): ?>
                <a href="<?= htmlspecialchars($profil['lien_github']) ?>" target="_blank" title="Mon GitHub"><i class="fab fa-github"></i></a>
            <?php endif; ?>
            <?php if(!empty($profil['lien_linkedin'])): ?>
                <a href="<?= htmlspecialchars($profil['lien_linkedin']) ?>" target="_blank" title="Mon LinkedIn"><i class="fab fa-linkedin"></i></a>
            <?php endif; ?>
        </div>
    </div>
</footer>
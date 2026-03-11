<section id="contact" class="contact-section">
    <div class="section-header">
        <h2 class="section-title">Contact</h2>
        <p class="section-subtitle">Démarrons une discussion</p>
    </div>
    <div class="contact-content">
        <div class="contact-info animate-fade-up">
            <?php if (!empty($profil['email_contact'])): ?>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h4>Email</h4>
                        <a href="mailto:<?= htmlspecialchars($profil['email_contact']) ?>"><?= htmlspecialchars($profil['email_contact']) ?></a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($profil['lien_github'])): ?>
                <div class="contact-item">
                    <i class="fab fa-github"></i>
                    <div>
                        <h4>GitHub</h4>
                        <a href="<?= htmlspecialchars($profil['lien_github']) ?>" target="_blank">Mon profil GitHub</a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($profil['lien_linkedin'])): ?>
                <div class="contact-item">
                    <i class="fab fa-linkedin"></i>
                    <div>
                        <h4>LinkedIn</h4>
                        <a href="<?= htmlspecialchars($profil['lien_linkedin']) ?>" target="_blank">Mon profil LinkedIn</a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($profil['localisation'])): ?>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h4>Localisation</h4>
                        <p><?= htmlspecialchars($profil['localisation']) ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <form class="contact-form animate-fade-up delay-1" method="POST" action="?action=contact">
            <div class="form-row">
                <div class="form-group">
                    <label for="contact-name">Nom</label>
                    <input type="text" id="contact-name" name="name" required placeholder="Votre nom">
                </div>
                <div class="form-group">
                    <label for="contact-email">Email</label>
                    <input type="email" id="contact-email" name="email" required placeholder="votre@email.com">
                </div>
            </div>
            <div class="form-group">
                <label for="contact-subject">Sujet</label>
                <input type="text" id="contact-subject" name="subject" required placeholder="Sujet de votre message">
            </div>
            <div class="form-group">
                <label for="contact-message">Message</label>
                <textarea id="contact-message" name="message" rows="6" required placeholder="Votre message..."></textarea>
            </div>
            <button type="submit" class="btn-primary w-100">
                <i class="fas fa-paper-plane"></i> Envoyer
            </button>
        </form>
    </div>
</section>
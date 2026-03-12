<div class="hero-wrapper" id="hero">

    <div class="safari-window animate-fade-up">
        <div class="safari-header">
            <div class="traffic-lights">
                <div class="traffic-light tl-red"></div>
                <div class="traffic-light tl-yellow"></div>
                <div class="traffic-light tl-green"></div>
            </div>
            <div class="safari-title">
                <div class="safari-title-badge"><i class="fas fa-lock lock-icon"></i> profil.dev</div>
            </div>
            <div class="safari-actions">
                <i class="fas fa-share"></i>
            </div>
        </div>

        <div class="hero-window-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    Bienvenue sur mon <span class="highlight text-transparent bg-clip-text">portfolio</span>
                </h1>
                <p class="hero-desc">
                    Je suis <?= htmlspecialchars($profil['prenom'] ?? '') ?> <?= htmlspecialchars($profil['nom'] ?? '') ?>, étudiant chez IPSSI Paris.
                </p>
                <div class="hero-buttons">
                    <a href="#projets" class="btn-primary btn-glow">Voir mes projets</a>
                    <a href="#contact" class="btn-secondary">Me contacter</a>
                </div>
            </div>
            <div class="hero-img-container">
                <img src="public/images/<?= htmlspecialchars($profil['image_profil'] ?? 'default_profil.png') ?>" alt="Photo de profil" class="hero-img">
                <div class="hero-status-badge">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="safari-window animate-fade-up delay-1" id="about">
        <div class="safari-header">
            <div class="traffic-lights">
                <div class="traffic-light tl-red"></div>
                <div class="traffic-light tl-yellow"></div>
                <div class="traffic-light tl-green"></div>
            </div>
            <div class="safari-title">
                <div class="safari-title-badge"><i class="fas fa-user user-icon"></i> a-propos.txt</div>
            </div>
            <div class="safari-actions"></div>
        </div>

        <div class="about-window-content">
            <h2 class="about-title">À propos <span class="highlight">de moi</span></h2>
            <p class="about-desc">
                <?= nl2br(htmlspecialchars($profil['description_hero'] ?? '')) ?><br><br>
                <?= nl2br(htmlspecialchars($profil['description_about'] ?? '')) ?>
            </p>

            <div class="about-stats">
                <div class="stat-item">
                    <span class="stat-number highlight" data-target="10">0</span><span class="stat-number highlight">+</span>
                    <span class="stat-label">Projets réalisés</span>
                </div>
            </div>
        </div>
    </div>

</div>
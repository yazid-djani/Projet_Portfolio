<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($profil['prenom'] ?? '') ?> <?= htmlspecialchars($profil['nom'] ?? '') ?> | Portfolio</title>
    <meta name="description" content="Portfolio de <?= htmlspecialchars($profil['prenom'] ?? '') ?> <?= htmlspecialchars($profil['nom'] ?? '') ?> — <?= htmlspecialchars($profil['titre_poste'] ?? '') ?>. Découvrez mes projets, compétences et parcours.">
    <link rel="stylesheet" href="public/css/couleur.css">
    <link rel="stylesheet" href="public/css/styleNavbar.css">
    <link rel="stylesheet" href="public/css/styleViewer.css">
    <link rel="stylesheet" href="public/css/styleResDev.css">
    <link rel="stylesheet" href="public/css/styleOpenProject.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php require_once __DIR__ . '/layout/navbarViewer.php'; ?>

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
                    Bienvenue sur le <span class="highlight text-transparent bg-clip-text">portfolio</span>
                </h1>
                <p class="hero-desc">
                    Je suis <?= htmlspecialchars($profil['prenom'] ?? '') ?> <?= htmlspecialchars($profil['nom'] ?? '') ?>, <strong><?= htmlspecialchars($profil['titre_poste'] ?? '') ?></strong>.
                </p>
                <div class="hero-buttons">
                    <a href="#contact" class="btn-primary btn-glow">Démarrer un projet</a>
                    <a href="#projets" class="btn-secondary">Explorer le travail</a>
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

<section id="projets" class="projets-section">
    <div class="section-header">
        <h2 class="section-title">Projets Récents</h2>
        <p class="section-subtitle">Sélection d'œuvres techniques</p>
    </div>

    <div class="projets-filter">
        <button class="filter-btn active" id="btn-dev" data-target="dev">Développement</button>
        <button class="filter-btn" id="btn-reseau" data-target="reseau">Réseau</button>
    </div>
    <div class="projects-viewport">
        <div class="projects-slider" id="projectsSlider">
            <div class="projects-panel panel-dev">
                <div class="projet-grid">
                    <?php if (empty($projetsDev)): ?>
                        <p class="no-projets">Aucun projet dev.</p>
                    <?php else: ?>
                        <?php foreach ($projetsDev as $projet): ?>
                            <div class="projet-card"
                                 data-titre="<?= htmlspecialchars($projet['titre']) ?>"
                                 data-desc="<?= htmlspecialchars($projet['description']) ?>"
                                 data-detail="<?= htmlspecialchars($projet['detail'] ?? $projet['description']) ?>"
                                 data-image="<?= htmlspecialchars($projet['image_url'] ?? 'default.jpg') ?>"
                                 data-github="<?= htmlspecialchars($projet['lien_github'] ?? '') ?>"
                                 data-tags="<?= htmlspecialchars($projet['technologies'] ?? '') ?>">
                                <div class="card-icon"><i class="fas fa-code"></i></div>
                                <h3 class="card-title"><?= htmlspecialchars($projet['titre']) ?></h3>
                                <p class="card-description"><?= htmlspecialchars($projet['description']) ?></p>
                                <button class="btn-details">En savoir plus <i class="fas fa-arrow-right icon-small"></i></button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="projects-panel panel-reseau">
                <div class="projet-grid">
                    <?php if (empty($projetsReseau)): ?>
                        <p class="no-projets">Aucun projet réseau.</p>
                    <?php else: ?>
                        <?php foreach ($projetsReseau as $projet): ?>
                            <div class="projet-card"
                                 data-titre="<?= htmlspecialchars($projet['titre']) ?>"
                                 data-desc="<?= htmlspecialchars($projet['description']) ?>"
                                 data-detail="<?= htmlspecialchars($projet['detail'] ?? $projet['description']) ?>"
                                 data-image="<?= htmlspecialchars($projet['image_url'] ?? 'default.jpg') ?>"
                                 data-github="<?= htmlspecialchars($projet['lien_github'] ?? '') ?>"
                                 data-tags="<?= htmlspecialchars($projet['technologies'] ?? '') ?>">
                                <div class="card-icon"><i class="fas fa-network-wired"></i></div>
                                <h3 class="card-title"><?= htmlspecialchars($projet['titre']) ?></h3>
                                <p class="card-description"><?= htmlspecialchars($projet['description']) ?></p>
                                <button class="btn-details">En savoir plus <i class="fas fa-arrow-right icon-small"></i></button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="projectModal" class="modal-overlay">
    <div class="modal-container glass-card modal-bg">
        <button class="modal-close" id="modalClose">&times;</button>
        <div class="modal-content">
            <div class="modal-media"></div>
            <div class="modal-info">
                <h3 id="modalTitle">Titre du projet</h3>
                <div class="modal-tags" id="modalTags"></div>
                <p id="modalDesc">Description détaillée...</p>
                <a href="#" target="_blank" class="btn-primary modal-link-btn" id="modalLink">
                    <i class="fab fa-github"></i> Voir le code
                </a>
            </div>
        </div>
    </div>
</div>

<section id="competences" class="competences-section">
    <div class="section-header">
        <h2 class="section-title">Expertise</h2>
        <p class="section-subtitle">Compétences techniques & Domaines d'application</p>
    </div>
    <div class="competences-grid">
        <div class="competence-category animate-fade-up">
            <h3><i class="fas fa-code"></i> Développement</h3>
            <div class="skills-list">
                <?php if(empty($competencesDev)) echo "<p>Aucune compétence.</p>"; ?>
                <?php foreach ($competencesDev as $c): ?>
                    <div class="skill-item">
                        <div class="skill-info"><span><?= htmlspecialchars($c['nom']) ?></span><span><?= $c['pourcentage'] ?>%</span></div>
                        <div class="skill-bar"><div class="skill-progress" data-width="<?= $c['pourcentage'] ?>"></div></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="competence-category animate-fade-up delay-1">
            <h3><i class="fas fa-network-wired"></i> Réseau & Système</h3>
            <div class="skills-list">
                <?php if(empty($competencesReseau)) echo "<p>Aucune compétence.</p>"; ?>
                <?php foreach ($competencesReseau as $c): ?>
                    <div class="skill-item">
                        <div class="skill-info"><span><?= htmlspecialchars($c['nom']) ?></span><span><?= $c['pourcentage'] ?>%</span></div>
                        <div class="skill-bar"><div class="skill-progress" data-width="<?= $c['pourcentage'] ?>"></div></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php if(!empty($outils)): ?>
    <section id="outils" class="outils-section">
        <div class="section-header text-center">
            <h2 class="section-title">Technologies</h2>
        </div>
        <div class="outils-grid">
            <?php foreach ($outils as $outil): ?>
                <div class="outil-card animate-fade-up">
                    <img src="/public/images/<?= htmlspecialchars($outil['image_url']) ?>" alt="Outil" class="outil-img">
                    <?php if (!empty($outil['nom'])): ?>
                        <span class="outil-name"><?= htmlspecialchars($outil['nom']) ?></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

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

<section id="cv" class="cv-section">
    <div class="cv-content animate-fade-up">
        <?php if (!empty($profil['lien_cv'])): ?>
            <a href="/?mon_cv" target="_blank" class="btn-secondary cv-download-btn">
                <i class="fas fa-download"></i> Consulter / Télécharger mon CV
            </a>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/layout/footer.php'; ?>

<script src="public/scriptJS/navbar.js"></script>
<script src="public/scriptJS/viewer.js"></script>
<script src="public/scriptJS/trafic.js"></script>
<script src="public/scriptJS/ResDevPanel.js"></script>
<script src="public/scriptJS/openProjet.js"></script>

</body>
</html>
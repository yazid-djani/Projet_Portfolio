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

<section id="hero" class="hero-section">
    <div class="hero-left-col">

        <div class="hero-window hero-pic-window animate-fade-up">
            <div class="code-header">
                <span class="dot red"></span><span class="dot yellow"></span><span class="dot green"></span>
                <span class="code-filename">profil.jpg</span>
            </div>
            <img src="public/images/<?= htmlspecialchars($profil['image_profil'] ?? 'default_profil.png') ?>" alt="Photo de profil" class="hero-profile-pic-full">
        </div>

        <div class="hero-window hero-text-window animate-fade-up delay-1">
            <div class="code-header">
                <span class="dot red"></span><span class="dot yellow"></span><span class="dot green"></span>
                <span class="code-filename">infos.txt</span>
            </div>
            <div class="hero-text-content">
                <p class="hero-greeting">Bonjour, je suis</p>
                <h1 class="hero-title">
                    <?= htmlspecialchars($profil['prenom'] ?? '') ?> <span class="highlight"><?= htmlspecialchars($profil['nom'] ?? '') ?></span>
                </h1>
                <p class="hero-subtitle">
                    <?= htmlspecialchars($profil['titre_poste'] ?? '') ?>
                </p>
                <p class="hero-description">
                    <?= nl2br(htmlspecialchars($profil['description_hero'] ?? '')) ?>
                </p>
                <div class="hero-buttons">
                    <a href="#projets" class="btn-primary">Voir mes projets</a>
                    <a href="#contact" class="btn-secondary">Me contacter</a>
                </div>
            </div>
        </div>

    </div>

    <div class="hero-right-col animate-fade-up delay-2">
        <div class="hero-window hero-code-block">
            <div class="code-header">
                <span class="dot red"></span><span class="dot yellow"></span><span class="dot green"></span>
                <span class="code-filename">profil.php</span>
            </div>
            <pre class="code-content"><code><span class="code-keyword">&lt;?php</span>
<span class="code-variable">$profil</span> = [
    <span class="code-string">'nom'</span>     => <span class="code-string">'<?= htmlspecialchars($profil['prenom'] ?? '') ?> <?= htmlspecialchars($profil['nom'] ?? '') ?>'</span>,
    <span class="code-string">'poste'</span>   => <span class="code-string">'<?= htmlspecialchars($profil['titre_poste'] ?? '') ?>'</span>,
    <span class="code-string">'passion'</span> => <span class="code-keyword">true</span>,
];
<span class="code-keyword">echo</span> <span class="code-string">"Let's build something!"</span>;</code></pre>
        </div>
    </div>
</section>

<section id="about" class="about-section">
    <div class="section-header">
        <h2 class="section-title">À propos <span class="highlight">de moi</span></h2>
        <div class="section-line"></div>
    </div>
    <div class="about-content">
        <div class="about-text">
            <p>
                <?= nl2br(htmlspecialchars($profil['description_about'] ?? '')) ?>
            </p>
            <div class="about-stats">
                <div class="stat-item">
                    <span class="stat-number" data-target="10">0</span>+
                    <span class="stat-label">Projets réalisés</span>
                </div>
            </div>
        </div>
        <div class="about-image">
            <div class="about-card">
                <i class="fas fa-user-graduate about-icon"></i>
                <h3>Parcours</h3>
                <p>Mon parcours professionnel</p>
            </div>
        </div>
    </div>
</section>

<section id="projets" class="projets-section">
    <div class="section-header">
        <h2 class="section-title">Mes <span class="highlight">Projets</span></h2>
        <div class="section-line"></div>
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
                                <button class="btn-details">En savoir plus <i class="fas fa-arrow-right"></i></button>
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
                                <button class="btn-details">En savoir plus <i class="fas fa-arrow-right"></i></button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="projectModal" class="modal-overlay">
    <div class="modal-container">
        <button class="modal-close" id="modalClose">&times;</button>
        <div class="modal-content">
            <div class="modal-media"></div>
            <div class="modal-info">
                <h3 id="modalTitle">Titre du projet</h3>
                <div class="modal-tags" id="modalTags"></div>
                <p id="modalDesc">Description détaillée...</p>
                <a href="#" target="_blank" class="btn-primary" id="modalLink">
                    <i class="fab fa-github"></i> Voir le code
                </a>
            </div>
        </div>
    </div>
</div>

<section id="competences" class="competences-section">
    <div class="section-header">
        <h2 class="section-title">Mes <span class="highlight">Compétences</span></h2>
        <div class="section-line"></div>
    </div>
    <div class="competences-grid">
        <div class="competence-category">
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
        <div class="competence-category">
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
        <div class="section-header">
            <h2 class="section-title">Mes <span class="highlight">Outils</span></h2>
            <div class="section-line"></div>
        </div>
        <div class="outils-grid">
            <?php foreach ($outils as $outil): ?>
                <div class="outil-card">
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
        <h2 class="section-title">Me <span class="highlight">Contacter</span></h2>
        <div class="section-line"></div>
    </div>
    <div class="contact-content">
        <div class="contact-info">
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
        <form class="contact-form" method="POST" action="?action=contact">
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
            <button type="submit" class="btn-primary">
                <i class="fas fa-paper-plane"></i> Envoyer
            </button>
        </form>
    </div>
</section>

<section id="cv" class="cv-section">
    <div class="section-header">
        <h2 class="section-title">Mon <span class="highlight">CV</span></h2>
        <div class="section-line"></div>
    </div>
    <div class="cv-content">
        <?php if (!empty($profil['lien_cv'])): ?>
            <div class="cv-download">
                <a href="/?mon_cv" target="_blank" class="btn-primary">
                    <i class="fas fa-download"></i> Consulter / Télécharger mon CV
                </a>
            </div>
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
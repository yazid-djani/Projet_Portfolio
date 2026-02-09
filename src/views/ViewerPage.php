<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yazid Djani | Portfolio</title>

    <!-- SEO -->
    <meta name="description" content="Portfolio de Yazid Djani — Développeur & Technicien Réseau. Découvrez mes projets, compétences et parcours.">
    <meta name="author" content="Yazid Djani">

    <!-- CSS -->
    <link rel="stylesheet" href="public/css/couleur.css">
    <link rel="stylesheet" href="public/css/styleNavbar.css">
    <link rel="stylesheet" href="public/css/styleViewer.css">

    <!-- Font Awesome (icônes) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php require_once __DIR__ . '/layout/navbarViewer.php'; ?>

<!-- ============================================
     SECTION HERO — Présentation
     ============================================ -->
<section id="hero" class="hero-section">
    <div class="hero-content">
        <p class="hero-greeting animate-fade-up">Bonjour, je suis</p>
        <h1 class="hero-title animate-fade-up delay-1">Yazid <span class="highlight">Djani</span></h1>
        <p class="hero-subtitle animate-fade-up delay-2">Développeur Web & Technicien Réseau</p>
        <p class="hero-description animate-fade-up delay-3">
            Passionné par le développement et l'infrastructure réseau,
            je crée des solutions modernes et performantes.
        </p>
        <div class="hero-buttons animate-fade-up delay-4">
            <a href="#projets" class="btn-primary">Voir mes projets</a>
            <a href="#contact" class="btn-secondary">Me contacter</a>
        </div>
    </div>
    <div class="hero-visual animate-fade-up delay-3">
        <div class="hero-code-block">
            <div class="code-header">
                <span class="dot red"></span>
                <span class="dot yellow"></span>
                <span class="dot green"></span>
                <span class="code-filename">yazid.php</span>
            </div>
            <pre class="code-content"><code><span class="code-keyword">&lt;?php</span>
<span class="code-variable">$developpeur</span> = [
    <span class="code-string">'nom'</span>     => <span class="code-string">'Yazid Djani'</span>,
    <span class="code-string">'stack'</span>   => [<span class="code-string">'PHP'</span>, <span class="code-string">'JS'</span>, <span class="code-string">'SQL'</span>],
    <span class="code-string">'reseau'</span>  => [<span class="code-string">'Cisco'</span>, <span class="code-string">'Linux'</span>],
    <span class="code-string">'passion'</span> => <span class="code-keyword">true</span>,
];
<span class="code-keyword">echo</span> <span class="code-string">"Let's build something!"</span>;</code></pre>
        </div>
    </div>
</section>

<!-- ============================================
     SECTION À PROPOS
     ============================================ -->
<section id="about" class="about-section">
    <div class="section-header">
        <h2 class="section-title">À propos <span class="highlight">de moi</span></h2>
        <div class="section-line"></div>
    </div>
    <div class="about-content">
        <div class="about-text">
            <p>
                Je suis étudiant passionné par l'informatique, avec une double compétence
                en <strong>développement web</strong> et en <strong>administration réseau</strong>.
            </p>
            <p>
                Mon parcours m'a permis d'acquérir des compétences solides aussi bien
                côté code (PHP, JavaScript, SQL) que côté infrastructure (Cisco, Linux, Docker).
            </p>
            <p>
                J'aime créer des projets concrets, apprendre de nouvelles technologies
                et résoudre des problèmes complexes.
            </p>
            <div class="about-stats">
                <div class="stat-item">
                    <span class="stat-number" data-target="10">0</span>+
                    <span class="stat-label">Projets réalisés</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-target="5">0</span>+
                    <span class="stat-label">Technologies</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-target="2">0</span>+
                    <span class="stat-label">Années d'expérience</span>
                </div>
            </div>
        </div>
        <div class="about-image">
            <div class="about-card">
                <i class="fas fa-user-graduate about-icon"></i>
                <h3>Étudiant en BTS SIO</h3>
                <p>Option SISR & SLAM</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     SECTION PROJETS
     ============================================ -->
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
            <div class="modal-media">
                <img src="" alt="Aperçu du projet" id="modalImg">
            </div>
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
<!-- ============================================
     SECTION COMPÉTENCES
     ============================================ -->
<section id="competences" class="competences-section">
    <div class="section-header">
        <h2 class="section-title">Mes <span class="highlight">Compétences</span></h2>
        <div class="section-line"></div>
    </div>
    <div class="competences-grid">
        <!-- Dev -->
        <div class="competence-category">
            <h3><i class="fas fa-code"></i> Développement</h3>
            <div class="skills-list">
                <div class="skill-item">
                    <div class="skill-info"><span>PHP</span><span>80%</span></div>
                    <div class="skill-bar"><div class="skill-progress" data-width="80"></div></div>
                </div>
                <div class="skill-item">
                    <div class="skill-info"><span>JavaScript</span><span>70%</span></div>
                    <div class="skill-bar"><div class="skill-progress" data-width="70"></div></div>
                </div>
                <div class="skill-item">
                    <div class="skill-info"><span>HTML / CSS</span><span>90%</span></div>
                    <div class="skill-bar"><div class="skill-progress" data-width="90"></div></div>
                </div>
                <div class="skill-item">
                    <div class="skill-info"><span>SQL</span><span>75%</span></div>
                    <div class="skill-bar"><div class="skill-progress" data-width="75"></div></div>
                </div>
                <div class="skill-item">
                    <div class="skill-info"><span>Python</span><span>50%</span></div>
                    <div class="skill-bar"><div class="skill-progress" data-width="50"></div></div>
                </div>
            </div>
        </div>
        <!-- Réseau -->
        <div class="competence-category">
            <h3><i class="fas fa-network-wired"></i> Réseau & Système</h3>
            <div class="skills-list">
                <div class="skill-item">
                    <div class="skill-info"><span>Cisco (Packet Tracer)</span><span>75%</span></div>
                    <div class="skill-bar"><div class="skill-progress" data-width="75"></div></div>
                </div>
                <div class="skill-item">
                    <div class="skill-info"><span>Linux (Debian/Ubuntu)</span><span>70%</span></div>
                    <div class="skill-bar"><div class="skill-progress" data-width="70"></div></div>
                </div>
                <div class="skill-item">
                    <div class="skill-info"><span>Docker</span><span>60%</span></div>
                    <div class="skill-bar"><div class="skill-progress" data-width="60"></div></div>
                </div>
                <div class="skill-item">
                    <div class="skill-info"><span>Windows Server</span><span>65%</span></div>
                    <div class="skill-bar"><div class="skill-progress" data-width="65"></div></div>
                </div>
                <div class="skill-item">
                    <div class="skill-info"><span>Active Directory</span><span>60%</span></div>
                    <div class="skill-bar"><div class="skill-progress" data-width="60"></div></div>
                </div>
            </div>
        </div>
        <!-- Outils -->
        <div class="competence-category">
            <h3><i class="fas fa-tools"></i> Outils & Méthodes</h3>
            <div class="skills-list">
                <div class="skill-item">
                    <div class="skill-info"><span>Git / GitHub</span><span>80%</span></div>
                    <div class="skill-bar"><div class="skill-progress" data-width="80"></div></div>
                </div>
                <div class="skill-item">
                    <div class="skill-info"><span>PhpStorm / VS Code</span><span>85%</span></div>
                    <div class="skill-bar"><div class="skill-progress" data-width="85"></div></div>
                </div>
                <div class="skill-item">
                    <div class="skill-info"><span>phpMyAdmin / MySQL</span><span>75%</span></div>
                    <div class="skill-bar"><div class="skill-progress" data-width="75"></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     SECTION CONTACT
     ============================================ -->
<section id="contact" class="contact-section">
    <div class="section-header">
        <h2 class="section-title">Me <span class="highlight">Contacter</span></h2>
        <div class="section-line"></div>
    </div>
    <div class="contact-content">
        <div class="contact-info">
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <h4>Email</h4>
                    <a href="mailto:yazid.djani@example.com">yazid.djani@example.com</a>
                </div>
            </div>
            <div class="contact-item">
                <i class="fab fa-github"></i>
                <div>
                    <h4>GitHub</h4>
                    <a href="https://github.com/yazid-djani" target="_blank">github.com/yazid-djani</a>
                </div>
            </div>
            <div class="contact-item">
                <i class="fab fa-linkedin"></i>
                <div>
                    <h4>LinkedIn</h4>
                    <a href="https://linkedin.com/in/yazid-djani" target="_blank">linkedin.com/in/yazid-djani</a>
                </div>
            </div>
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <h4>Localisation</h4>
                    <p>France</p>
                </div>
            </div>
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

<!-- ============================================
     SECTION CV
     ============================================ -->
<section id="cv" class="cv-section">
    <div class="section-header">
        <h2 class="section-title">Mon <span class="highlight">CV</span></h2>
        <div class="section-line"></div>
    </div>
    <div class="cv-content">
        <div class="cv-timeline">
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <span class="timeline-date">2023 - 2025</span>
                    <h3>BTS SIO (SISR / SLAM)</h3>
                    <p>Formation en services informatiques, option réseau et développement.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <span class="timeline-date">2023</span>
                    <h3>Stage en entreprise</h3>
                    <p>Mise en pratique des compétences réseau et développement en milieu professionnel.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <span class="timeline-date">2021 - 2023</span>
                    <h3>Baccalauréat</h3>
                    <p>Obtention du baccalauréat avec spécialités scientifiques et numériques.</p>
                </div>
            </div>
        </div>
        <div class="cv-download">
            <a href="public/documents/cv_yazid_djani.pdf" target="_blank" class="btn-primary">
                <i class="fas fa-download"></i> Télécharger mon CV (PDF)
            </a>
        </div>
    </div>
</section>

<!-- ============================================
     FOOTER
     ============================================ -->
<?php require_once __DIR__ . '/layout/footer.php'; ?>

<!-- Scripts -->
<script src="public/scriptJS/navbar.js"></script>
<script src="public/scriptJS/viewer.js"></script>
<script src="public/scriptJS/trafic.js"></script>
<script src="public/scriptJS/ResDevPanel.js"></script>
<script src="public/scriptJS/openProjet.js"></script>

</body>
</html>
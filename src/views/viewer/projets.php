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
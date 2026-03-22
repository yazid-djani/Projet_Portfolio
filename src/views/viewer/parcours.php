<section id="parcours" class="projets-section">
    <div class="section-header text-center">
        <h2 class="section-title">Mon Parcours</h2>
        <p class="section-subtitle">Découvrez mon évolution professionnelle et académique</p>
    </div>

    <div class="projets-filter">
        <button class="filter-btn parcours-filter active" data-target="panel-formations">Formations</button>
        <button class="filter-btn parcours-filter" data-target="panel-experiences">Expériences</button>
    </div>

    <div class="parcours-viewport">
        <div class="parcours-slider" id="parcours-slider">

            <div class="parcours-panel" id="panel-formations">
                <div class="timeline">
                    <?php if (empty($formations)): ?>
                        <p class="no-projets">Aucune formation renseignée.</p>
                    <?php else: ?>
                        <?php foreach ($formations as $f): ?>
                            <div class="timeline-item glass-card animate-fade-up">
                                <div class="timeline-date"><?= htmlspecialchars($f['date_periode']) ?></div>
                                <div class="timeline-content">
                                    <h3 class="timeline-title"><?= htmlspecialchars($f['titre']) ?></h3>
                                    <h4 class="timeline-school"><?= htmlspecialchars($f['etablissement']) ?></h4>
                                    <p class="timeline-desc"><?= nl2br(htmlspecialchars($f['description'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="parcours-panel" id="panel-experiences">
                <div class="timeline">
                    <?php if (empty($experiences)): ?>
                        <p class="no-projets">Aucune expérience renseignée.</p>
                    <?php else: ?>
                        <?php foreach ($experiences as $e): ?>
                            <div class="timeline-item glass-card animate-fade-up">
                                <div class="timeline-date"><?= htmlspecialchars($e['date_periode']) ?></div>
                                <div class="timeline-content">
                                    <h3 class="timeline-title"><?= htmlspecialchars($e['titre']) ?></h3>
                                    <h4 class="timeline-school"><?= htmlspecialchars($e['etablissement']) ?></h4>
                                    <p class="timeline-desc"><?= nl2br(htmlspecialchars($e['description'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>
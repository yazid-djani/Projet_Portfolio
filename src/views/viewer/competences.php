<section id="competences" class="competences-section">
    <div class="section-header">
        <h2 class="section-title">Compétences</h2>
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
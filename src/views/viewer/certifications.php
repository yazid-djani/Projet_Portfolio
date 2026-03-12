<section id="certifications" class="projets-section">
    <div class="section-header">
        <h2 class="section-title">Certifications</h2>
        <p class="section-subtitle">Mes diplômes et attestations</p>
    </div>
    <div class="certif-grid-viewer">
        <?php if (empty($certifications)): ?>
            <p>Aucune certification pour le moment.</p>
        <?php else: ?>
            <?php foreach ($certifications as $certif): ?>
                <div class="certif-card-viewer animate-fade-up">
                    <img src="/public/images/<?= htmlspecialchars($certif['image_url']) ?>" alt="Certification">
                    <h3 class="card-title"><?= htmlspecialchars($certif['nom']) ?></h3>
                    <p class="card-description"><?= htmlspecialchars($certif['description']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
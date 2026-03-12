<?php if(!empty($certifications)): ?>
    <section id="certifications" class="projets-section">
        <div class="section-header">
            <h2 class="section-title">Certifications</h2>
            <p class="section-subtitle">Mes diplômes et attestations</p>
        </div>
        <div class="projet-grid">
            <?php foreach ($certifications as $certif): ?>
                <div class="projet-card animate-fade-up text-center">
                    <img src="/public/images/<?= htmlspecialchars($certif['image_url']) ?>" alt="Certification" class="w-100">
                    <h3 class="card-title"><br><?= htmlspecialchars($certif['nom']) ?></h3>
                    <p class="card-description"><?= htmlspecialchars($certif['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
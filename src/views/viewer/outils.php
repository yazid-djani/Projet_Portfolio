<?php if(!empty($outils)): ?>
    <section id="outils" class="outils-section">
        <div class="section-header text-center">
            <h2 class="section-title">Outils</h2>
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
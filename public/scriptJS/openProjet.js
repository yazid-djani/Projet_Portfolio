/* ============================================
   openProjet.js
   Ouvre une modale avec les détails du projet
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {
    // Éléments de la modale
    const modal       = document.getElementById('projectModal');
    const modalClose  = document.getElementById('modalClose');
    const modalImg    = document.getElementById('modalImg');
    const modalTitle  = document.getElementById('modalTitle');
    const modalDesc   = document.getElementById('modalDesc');
    const modalTags   = document.getElementById('modalTags');
    const modalLink   = document.getElementById('modalLink');

    // Toutes les cartes projet
    const cards = document.querySelectorAll('.projet-card');

    // 1. Ouvrir la modale au clic sur une carte
    cards.forEach(card => {
        card.addEventListener('click', () => {
            // Récupérer les données via les attributs data-
            const titre   = card.getAttribute('data-titre');
            const details = card.getAttribute('data-detail'); // Description longue
            const image   = card.getAttribute('data-image');
            const github  = card.getAttribute('data-github');
            const tags    = card.getAttribute('data-tags');

            // Remplir la modale
            modalTitle.textContent = titre;
            modalDesc.textContent  = details;

            // Gestion de l'image (si pas d'image, mettre une par défaut)
            if (image && image !== 'default.jpg') {
                // Adapter le chemin si tes images sont dans public/images/
                modalImg.src = 'public/images/' + image;
            } else {
                // Placeholder si pas d'image
                modalImg.src = 'https://via.placeholder.com/800x600/16161a/815CF0?text=' + encodeURIComponent(titre);
            }

            // Gestion du bouton GitHub
            if (github) {
                modalLink.href = github;
                modalLink.style.display = 'inline-flex';
            } else {
                modalLink.style.display = 'none';
            }

            // Gestion des tags
            modalTags.innerHTML = ''; // Reset
            if (tags) {
                const tagsArray = tags.split(',');
                tagsArray.forEach(tag => {
                    const span = document.createElement('span');
                    span.className = 'tag';
                    span.textContent = tag.trim();
                    modalTags.appendChild(span);
                });
            }

            // Afficher la modale
            modal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Bloquer le scroll du site
        });
    });

    // 2. Fermer la modale
    const closeModal = () => {
        modal.classList.remove('active');
        document.body.style.overflow = ''; // Réactiver le scroll
    };

    modalClose.addEventListener('click', closeModal);

    // Fermer si on clique en dehors du contenu (sur le fond gris)
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Fermer avec la touche Échap
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
});
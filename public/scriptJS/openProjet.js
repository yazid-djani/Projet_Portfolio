document.addEventListener('DOMContentLoaded', () => {
    const detailButtons = document.querySelectorAll('.btn-details');
    const modalOverlay = document.getElementById('projectModal');
    const modalClose = document.getElementById('modalClose');

    const modalTitle = document.getElementById('modalTitle');
    const modalDesc = document.getElementById('modalDesc');
    const modalTags = document.getElementById('modalTags');
    const modalLink = document.getElementById('modalLink');
    const mediaContainer = document.querySelector('.modal-media');

    detailButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const card = btn.closest('.projet-card');

            modalTitle.textContent = card.dataset.titre;
            modalDesc.textContent = card.dataset.detail;

            // Gestion de l'image ou de la vidéo
            const mediaSrc = card.dataset.image;
            if (mediaSrc.toLowerCase().endsWith('.mp4') || mediaSrc.toLowerCase().endsWith('.webm')) {
                mediaContainer.innerHTML = `<video src="public/images/${mediaSrc}" autoplay loop muted playsinline style="width: 100%; border-radius: 10px;"></video>`;
            } else {
                mediaContainer.innerHTML = `<img src="public/images/${mediaSrc}" alt="Aperçu du projet" style="width: 100%; border-radius: 10px; object-fit: cover;">`;
            }

            // Gestion des tags
            modalTags.innerHTML = '';
            const tags = card.dataset.tags.split(',').map(t => t.trim()).filter(t => t);
            tags.forEach(t => {
                const span = document.createElement('span');
                span.textContent = t;
                modalTags.appendChild(span);
            });

            // Lien GitHub
            if (card.dataset.github) {
                modalLink.href = card.dataset.github;
                modalLink.style.display = 'inline-flex';
            } else {
                modalLink.style.display = 'none';
            }

            modalOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Fermeture de la modale
    modalClose.addEventListener('click', () => {
        modalOverlay.classList.remove('active');
        document.body.style.overflow = '';
        mediaContainer.innerHTML = ''; // Arrête la vidéo quand on ferme
    });

    // Fermeture en cliquant en dehors
    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
            modalClose.click();
        }
    });
});
/* ============================================
   slider.js
   Gestion générique des sliders horizontaux (Projets & Parcours)
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {

    // Fonction générique pour configurer un slider
    const setupSlider = (sectionId, sliderId) => {
        // Sélectionne uniquement les boutons de filtre de la bonne section
        const btns = document.querySelectorAll(`#${sectionId} .filter-btn`);
        const slider = document.getElementById(sliderId);

        if (btns.length > 0 && slider) {
            btns.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    // Met à jour l'apparence des boutons (actif/inactif)
                    btns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    // Translation du slider (-50% pour le 2ème panneau)
                    const translateX = index * -50;
                    slider.style.transform = `translateX(${translateX}%)`;
                });
            });
        }
    };

    // 1. Initialiser le slider Projets
    setupSlider('projets', 'projectsSlider');

    // 2. Initialiser le slider Parcours
    setupSlider('parcours', 'parcours-slider');
});
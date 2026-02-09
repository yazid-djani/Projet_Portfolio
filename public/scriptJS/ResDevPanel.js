/* ============================================
   ResDevPanel.js
   Gestion du slider horizontal (Dev <-> Réseau)
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {
    const slider    = document.getElementById('projectsSlider');
    const btnDev    = document.getElementById('btn-dev');
    const btnReseau = document.getElementById('btn-reseau');

    // Vérification de sécurité
    if (!slider || !btnDev || !btnReseau) return;

    // Fonction pour passer en mode DEV (Translate 0%)
    btnDev.addEventListener('click', () => {
        slider.style.transform = 'translateX(0%)';

        // Gestion des classes actives boutons
        btnDev.classList.add('active');
        btnReseau.classList.remove('active');
    });

    // Fonction pour passer en mode RÉSEAU (Translate -50%)
    btnReseau.addEventListener('click', () => {
        // Le slider fait 200% de large. Pour voir la moitié droite, on décale de -50%
        slider.style.transform = 'translateX(-50%)';

        // Gestion des classes actives boutons
        btnReseau.classList.add('active');
        btnDev.classList.remove('active');
    });
});
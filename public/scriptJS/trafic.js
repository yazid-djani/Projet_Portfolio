document.addEventListener('DOMContentLoaded', () => {
    // 1. Enregistrer la visite de la page
    const trackAction = (name, type = 'vue') => {
        fetch('?action=track_visit', {
            method: 'POST',
            headers: { 'Content-Type: application/json'},
            body: JSON.stringify({
                page: name,
                type: type,
                userAgent: navigator.userAgent
            })
        });
    };

    // Enregistre l'arrivée sur le site
    trackAction('accueil', 'vue');

    // 2. Écouter les clics sur les éléments importants
    const linksToTrack = [
        { selector: 'a[href*="linkedin"]', name: 'clic_linkedin' },
        { selector: 'a[href*="github"]', name: 'clic_github' },
        { selector: 'a[href$=".pdf"]', name: 'clic_cv' }, // Détecte les liens vers des PDF (ton CV)
        { selector: '.btn-details', name: 'clic_projet_detail' }
    ];

    linksToTrack.forEach(item => {
        document.querySelectorAll(item.selector).forEach(el => {
            el.addEventListener('click', () => {
                trackAction(item.name, 'clic');
            });
        });
    });
});
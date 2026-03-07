document.addEventListener('DOMContentLoaded', () => {
    // 1. Enregistrer la visite ou l'action
    const trackAction = (name, type = 'vue') => {
        fetch('?action=track_visit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' // CORRECTION ICI : Les guillemets sont bien placés
            },
            body: JSON.stringify({
                page: name,
                type: type,
                userAgent: navigator.userAgent
            })
        }).catch(err => console.error("Erreur de tracking:", err));
    };

    // Enregistre l'arrivée sur le site
    trackAction('accueil', 'vue');

    // 2. Écouter les clics sur les éléments importants
    const linksToTrack = [
        { selector: 'a[href*="linkedin"]', name: 'clic_linkedin' },
        { selector: 'a[href*="github"]', name: 'clic_github' },
        { selector: 'a[href$=".pdf"]', name: 'clic_cv' },
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
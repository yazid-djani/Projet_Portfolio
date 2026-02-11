/* ============================================
   TRAFIC.JS — Enregistrement des visites
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {

    // Fonction pour envoyer les infos de visite au serveur
    const trackVisit = async () => {
        try {
            // On prépare les données minimales
            const visitData = {
                page: window.location.pathname, // La page actuelle (ex: /)
                referrer: document.referrer || 'Direct', // D'où vient le visiteur
                userAgent: navigator.userAgent // Le navigateur utilisé
            };

            // On envoie les données via une requête POST légère
            // On suppose que tu créeras une route '?action=track_visit' dans ton routeur PHP
            await fetch('index.php?action=track_visit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(visitData)
            });

            // (Optionnel) Log pour le débug
            // console.log('Visite enregistrée');

        } catch (error) {
            // En cas d'erreur (ex: adblocker), on ne fait rien pour ne pas gêner l'utilisateur
            console.warn('Tracking indisponible');
        }
    };

    // On lance le tracking une fois la page chargée
    trackVisit();
});
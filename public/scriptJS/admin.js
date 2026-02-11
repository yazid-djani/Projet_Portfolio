/* ============================================
   ADMIN.JS — Gestion de l'interface d'administration
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {

    // --- 1. Disparition auto des alertes (Succès/Erreur) ---
    const alerts = document.querySelectorAll('.alert');

    if (alerts.length > 0) {
        // On attend 4 secondes avant de commencer à faire disparaitre
        setTimeout(() => {
            alerts.forEach(alert => {
                // Animation de transition
                alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';

                // Suppression du DOM après l'animation
                setTimeout(() => alert.remove(), 500);
            });
        }, 4000);
    }

    // --- 2. Confirmation de suppression (Sécurité doublée) ---
    // C'est une sécurité supplémentaire en plus de ton 'onclick' dans le HTML
    const deleteBtns = document.querySelectorAll('.btn-delete');

    deleteBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (!confirm("⚠️ Êtes-vous certain de vouloir supprimer ce projet ?\nCette action est irréversible.")) {
                e.preventDefault();
            }
        });
    });
});
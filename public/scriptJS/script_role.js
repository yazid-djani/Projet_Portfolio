// Fonction pour afficher/masquer le champ Code Groupe
function toggleGroupCode() {
    const roleSelect = document.getElementById('role-select');
    const container = document.getElementById('group-code-container');

    // Sécurité : on vérifie que les éléments existent sur la page
    if (!roleSelect || !container) return;

    const role = roleSelect.value;

    // On affiche le champ si un rôle est sélectionné
    // (Modifiez cette condition si vous voulez restreindre l'affichage à 'ecole' ou 'entreprise' uniquement)
    if (role !== "") {
        container.style.display = 'block';
    } else {
        container.style.display = 'none';
    }
}

// Initialisation au chargement de la page
// (Utile si le formulaire est réaffiché avec des valeurs pré-remplies après une erreur)
document.addEventListener('DOMContentLoaded', () => {
    toggleGroupCode();
    
    // On attache l'écouteur d'événement ici aussi, c'est plus propre que le 'onchange' dans le HTML
    const roleSelect = document.getElementById('role-select');
    if (roleSelect) {
        roleSelect.addEventListener('change', toggleGroupCode);
    }
});
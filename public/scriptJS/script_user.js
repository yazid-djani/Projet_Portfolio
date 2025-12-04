// =========================================================
// GESTION DU SLIDING PANEL (Uniquement page Auth)
// =========================================================

document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector("#container");
    const registerBtn = document.querySelector("#register");
    const loginBtn = document.querySelector("#login");

    // On vérifie si les éléments existent avant d'ajouter les écouteurs
    // (Pour éviter des erreurs JS sur les pages qui n'ont pas ce formulaire)
    if (registerBtn && container) {
        registerBtn.addEventListener("click", () => {
            container.classList.add("active");
        });
    }

    if (loginBtn && container) {
        loginBtn.addEventListener("click", () => {
            container.classList.remove("active");
        });
    }
});
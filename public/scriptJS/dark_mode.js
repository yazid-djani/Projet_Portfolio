// =========================================================
// GESTION DU DARK MODE (Global - pour toutes les pages)
// =========================================================

document.addEventListener("DOMContentLoaded", () => {
    const themeToggleBtn = document.querySelector("#theme-toggle");
    const body = document.body;

    // 1. Appliquer le thème sauvegardé au chargement de la page
    const currentTheme = localStorage.getItem("theme");
    if (currentTheme === "dark") {
        body.classList.add("dark-mode");
        if (themeToggleBtn) themeToggleBtn.textContent = "☀️ Mode Clair";
    }

    // 2. Gestion du clic sur le bouton
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener("click", (e) => {
            e.preventDefault(); 

            body.classList.toggle("dark-mode");
            
            if (body.classList.contains("dark-mode")) {
                localStorage.setItem("theme", "dark");
                themeToggleBtn.textContent = "☀️ Mode Clair";
            } else {
                localStorage.setItem("theme", "light");
                themeToggleBtn.textContent = "🌙 Mode Sombre";
            }
        });
    }
});
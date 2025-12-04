// --- GESTION DU TOGGLE INSCRIPTION/CONNEXION (Page Accueil) ---
const container = document.querySelector("#container");
const registerBtn = document.querySelector("#register");
const loginBtn = document.querySelector("#login");

// On vérifie si les éléments existent avant d'ajouter les écouteurs
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

// ---- GESTION DU DARK MODE (Module en haut de la page) ----
const themeToggleBtn = document.querySelector("#theme-toggle");
const body = document.body;

// Appliquer le thème au chargement de la page
const currentTheme = localStorage.getItem("theme");
if (currentTheme === "dark") {
  body.classList.add("dark-mode");
  if (themeToggleBtn) themeToggleBtn.textContent = "☀️ Mode Clair";
}

// Gestion du clic
if (themeToggleBtn) {
  themeToggleBtn.addEventListener("click", (e) => {
    e.preventDefault(); // Empêche le comportement par défaut si c'était un lien (par exxemple dans template.php)

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

document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll(".navbar-links a[href^='#']");

    // Permet de mettre à jour le lien "actif" (souligné) au défilement
    window.addEventListener("scroll", () => {
        let current = "";

        // Parcourt toutes les sections pour voir laquelle est à l'écran
        document.querySelectorAll("section, .hero-wrapper").forEach((section) => {
            const sectionTop = section.offsetTop;
            // On déduit 150px pour anticiper la zone d'arrivée
            if (pageYOffset >= sectionTop - 100) {
                current = section.getAttribute("id");
            }
        });

        // Met à jour la classe "active" dans la barre de navigation
        navLinks.forEach((link) => {
            link.classList.remove("active");
            if (link.getAttribute("href") === `#${current}`) {
                link.classList.add("active");
            }
        });
    });
});
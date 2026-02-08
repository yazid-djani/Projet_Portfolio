/* ============================================
   NAVBAR.JS — Scroll spy + Burger menu
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {
    const navbar   = document.getElementById('navbar');
    const burger   = document.getElementById('burger');
    const navCenter = document.querySelector('.nav-center');
    const navLinks  = document.querySelectorAll('.nav-link[data-section]');

    // --- Effet "scrolled" sur la navbar ---
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // --- Scroll Spy : met en surbrillance le lien de la section visible ---
    const sections = document.querySelectorAll('section[id]');

    window.addEventListener('scroll', () => {
        let current = '';

        sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            if (window.scrollY >= sectionTop) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('data-section') === current) {
                link.classList.add('active');
            }
        });
    });

    // --- Burger menu (mobile) ---
    burger.addEventListener('click', () => {
        burger.classList.toggle('open');
        navCenter.classList.toggle('open');
    });

    // Ferme le menu quand on clique sur un lien (mobile)
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            burger.classList.remove('open');
            navCenter.classList.remove('open');
        });
    });
});
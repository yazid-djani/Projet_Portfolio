/* ============================================
   VIEWER.JS — Animations Scroll uniquement
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {

    // --- Animations au scroll (fade-up) ---
    const animElements = document.querySelectorAll('.animate-fade-up, .projet-card, .competence-category, .timeline-item, .contact-item, .about-card');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    animElements.forEach(el => {
        el.classList.add('animate-fade-up');
        observer.observe(el);
    });

    // --- Barres de compétences ---
    const skillBars = document.querySelectorAll('.skill-progress');
    const skillObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const width = entry.target.getAttribute('data-width');
                entry.target.style.width = width + '%';
                skillObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });

    skillBars.forEach(bar => skillObserver.observe(bar));

    // --- Compteur animé (Stats) ---
    const statNumbers = document.querySelectorAll('.stat-number');
    const countObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseInt(entry.target.getAttribute('data-target'));
                let count = 0;
                const duration = 1500;
                const step = Math.ceil(target / (duration / 30));

                const counter = setInterval(() => {
                    count += step;
                    if (count >= target) {
                        count = target;
                        clearInterval(counter);
                    }
                    entry.target.textContent = count;
                }, 30);

                countObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    statNumbers.forEach(num => countObserver.observe(num));
});
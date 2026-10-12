// Scroll-reveal ringan tanpa dependency tambahan: elemen dengan class
// "reveal" akan fade-in + naik dikit begitu masuk viewport.
document.addEventListener('DOMContentLoaded', () => {
    const revealEls = document.querySelectorAll('.reveal');

    if (!('IntersectionObserver' in window) || revealEls.length === 0) {
        revealEls.forEach((el) => el.classList.add('reveal-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('reveal-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15 }
    );

    revealEls.forEach((el) => observer.observe(el));
});

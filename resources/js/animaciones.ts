const motionPreference = window.matchMedia('(prefers-reduced-motion: reduce)');
const entranceSelector = [
    '.heroCopy > *', '.heroFoto', '.textoAbout > p', '.pageTitle',
    '.conocimientosSeccione', '.aboutNarrative > div',
    '.project-card__media', '.project-card__body > *', '.project-card > .galeria', '.seccionContact > *',
    '.seccionPracticas > h1', '.seccionPracticas > p',
    '.blog-header > *', '.blog-card .blog-gallery', '.blog-card-content > *', '.legalSection > *'
].join(', ');

const entranceObserver = 'IntersectionObserver' in window
    ? new IntersectionObserver((entries) => {
        for (const entry of entries) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-revealed');
                entranceObserver?.unobserve(entry.target);
            }
        }
    }, { threshold: 0.05 })
    : null;

function initEntrances() {
    entranceObserver?.disconnect();
    if (motionPreference.matches || !entranceObserver) return;

    document.querySelectorAll(entranceSelector).forEach((element) => {
        if (!element.classList.contains('is-revealed')) {
            entranceObserver.observe(element);
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initEntrances);
} else {
    initEntrances();
}

document.addEventListener('partial:navigation:loaded', initEntrances);
motionPreference.addEventListener('change', initEntrances);

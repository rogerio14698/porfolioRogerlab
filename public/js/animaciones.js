/**
 * animaciones.js
 * Efecto minimalista japonés equivalente a Framer Motion:
 *   - Texto dividido por palabras (stagger)
 *   - Fade-in suave + movimiento y: 10px → 0
 *   - Disparo por scroll con IntersectionObserver (= whileInView)
 *   - Easing personalizado cubic-bezier(0.2, 0.65, 0.3, 0.9)
 */
(function () {
  'use strict';

  const STAGGER_S   = 0.055;  // equivale a staggerChildren * ~2.5 (palabras vs letras)
  const DELAY_S     = 0.3;    // equivale a delayChildren: 0.3
  const DURATION_S  = 1.0;    // equivale a duration: 1
  const EASING      = 'cubic-bezier(0.2, 0.65, 0.3, 0.9)';
  const THRESHOLD   = 0.25;   // % visible para disparar (viewport)

  function buildWordSpans(paragraph) {
    const words = paragraph.innerText.trim().split(/\s+/);
    paragraph.innerHTML = '';

    words.forEach(function (word, i) {
      const span        = document.createElement('span');
      const delay       = (DELAY_S + i * STAGGER_S).toFixed(3);
      const transition  = [
        'opacity '   + DURATION_S + 's ' + EASING + ' ' + delay + 's',
        'transform ' + DURATION_S + 's ' + EASING + ' ' + delay + 's',
      ].join(', ');

      span.textContent  = word;
      span.style.cssText =
        'display:inline-block;' +
        'margin-right:0.28em;'  +
        'opacity:0;'            +
        'transform:translateY(10px);' +
        'will-change:opacity,transform;' +
        'transition:' + transition + ';';

      paragraph.appendChild(span);
    });
  }

  function revealWords(paragraph) {
    paragraph.querySelectorAll('span').forEach(function (span) {
      span.style.opacity   = '1';
      span.style.transform = 'translateY(0)';
    });
  }

  function init() {
    var section   = document.querySelector('.textoAbout');
    if (!section) return;
    var paragraph = section.querySelector('p');
    if (!paragraph) return;

    buildWordSpans(paragraph);

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          revealWords(paragraph);
          observer.unobserve(section);   // once: true
        }
      });
    }, { threshold: THRESHOLD });

    observer.observe(section);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
}());
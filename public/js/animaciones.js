/**
 * animaciones.js
 * Efecto typewriter minimo para el texto About.
 * Usa el texto del propio parrafo como string y mantiene su flujo normal.
 */
(function () {
  'use strict';

  const START_DELAY_MS = 300;
  const LETTER_DELAY_MS = 18;
  const DURATION_S = 0.9;
  const EASING = 'cubic-bezier(0.2, 0.65, 0.3, 0.9)';
  const THRESHOLD = 0.25;

  function prepareParagraph(paragraph) {
    paragraph.style.opacity = '0';
    paragraph.style.transform = 'translateY(10px)';
    paragraph.style.willChange = 'opacity, transform';
    paragraph.style.transition = [
      'opacity ' + DURATION_S + 's ' + EASING,
      'transform ' + DURATION_S + 's ' + EASING
    ].join(', ');
  }

  function getParagraphText(paragraph) {
    return paragraph.textContent.replace(/\s+/g, ' ').trim();
  }

  function typeParagraph(paragraph) {
    var fullText = getParagraphText(paragraph);
    var currentIndex = 0;

    paragraph.style.minHeight = paragraph.offsetHeight + 'px';
    paragraph.textContent = '';
    paragraph.style.opacity = '1';
    paragraph.style.transform = 'translateY(0)';

    function writeNextLetter() {
      currentIndex += 1;
      paragraph.textContent = fullText.slice(0, currentIndex);

      if (currentIndex < fullText.length) {
        window.setTimeout(writeNextLetter, LETTER_DELAY_MS);
        return;
      }

      paragraph.style.minHeight = '';
      paragraph.style.willChange = 'auto';
    }

    window.setTimeout(writeNextLetter, START_DELAY_MS);
  }

  function findSection(root) {
    if (!root) {
      return document.querySelector('.textoAbout');
    }

    if (root.matches && root.matches('.textoAbout')) {
      return root;
    }

    return root.querySelector('.textoAbout');
  }

  function init(root) {
    var section = findSection(root || document);
    if (!section) return;
    if (section.dataset.typewriterReady === 'true') return;

    section.dataset.typewriterReady = 'true';

    var paragraph = section.querySelector('p');
    if (!paragraph) return;

    prepareParagraph(paragraph);

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          typeParagraph(paragraph);
          observer.unobserve(section);
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

  document.addEventListener('partial:navigation:loaded', function (event) {
    var root = event.detail && event.detail.container ? event.detail.container : document;
    init(root);
  });
}());
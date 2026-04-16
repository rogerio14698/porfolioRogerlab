/**
 * theme.js
 * Gestión del modo oscuro / claro.
 * Cambia el atributo data-theme en <body> y mantiene
 * el estado activo del botón correspondiente.
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        const themeBtns = document.querySelectorAll('.themeBtn');

        themeBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                themeBtns.forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');

                document.body.dataset.theme = btn.getAttribute('data-theme');
            });
        });
    });
}());

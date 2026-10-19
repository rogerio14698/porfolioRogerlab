/**
 * theme.js
 * Gestión del modo oscuro / claro.
 * Cambia el atributo data-theme en <html> y <body>
 * y mantiene el botón activo correspondiente.
 */
(function () {
    'use strict';

    const STORAGE_KEY = 'rogerlab-theme';

    function setTheme(theme) {
        if (!theme) {
            return;
        }

        document.documentElement.dataset.theme = theme;
        document.body.dataset.theme = theme;

        document.querySelectorAll('.themeBtn').forEach(function (btn) {
            const isActive = btn.getAttribute('data-theme') === theme;
            btn.classList.toggle('active', isActive);
            btn.setAttribute('aria-pressed', String(isActive));
        });

        window.localStorage.setItem(STORAGE_KEY, theme);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const themeBtns = document.querySelectorAll('.themeBtn');
        const storedTheme = window.localStorage.getItem(STORAGE_KEY);
        const initialTheme = storedTheme || document.body.dataset.theme || document.documentElement.dataset.theme || 'dark';

        setTheme(initialTheme);

        themeBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                setTheme(btn.getAttribute('data-theme'));
            });
        });
    });
}());

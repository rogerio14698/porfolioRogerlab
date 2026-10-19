<aside class="asideLeft">
    <button type="button" class="themeBtn active" data-theme="dark" aria-pressed="true" aria-labelledby="darkThemeLabel">
        <svg class="preferenceIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <path d="M20.5 13.5A8.5 8.5 0 0 1 10.5 3a8.5 8.5 0 1 0 10 10.5Z"/>
        </svg>
        <span class="preferenceLabel" id="darkThemeLabel" data-i18n="theme.dark">Tema oscuro</span>
    </button>
    <button type="button" class="themeBtn" data-theme="light" aria-pressed="false" aria-labelledby="lightThemeLabel">
        <svg class="preferenceIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <circle cx="12" cy="12" r="4"/>
            <path d="M12 2v2m0 16v2M2 12h2m16 0h2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"/>
        </svg>
        <span class="preferenceLabel" id="lightThemeLabel" data-i18n="theme.light">Tema claro</span>
    </button>
    <button type="button" id="backgroundMotionToggle" aria-pressed="false" aria-labelledby="backgroundMotionPlayLabel" hidden>
        <svg class="preferenceIcon motionIcon--play" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <path d="m8 5 11 7-11 7Z"/>
        </svg>
        <svg class="preferenceIcon motionIcon--pause" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <path d="M8 5v14M16 5v14"/>
        </svg>
        <span class="preferenceLabel" id="backgroundMotionPlayLabel" data-motion-label="play" data-i18n="motion.play">Reproducir fondo</span>
        <span class="preferenceLabel" id="backgroundMotionPauseLabel" data-motion-label="pause" data-i18n="motion.pause" hidden>Pausar fondo</span>
        <span class="preferenceLabel" id="backgroundMotionReducedLabel" data-motion-label="reduced" data-i18n="motion.reduced" hidden>Movimiento reducido</span>
        <span class="preferenceLabel" id="backgroundMotionUnavailableLabel" data-motion-label="unavailable" data-i18n="motion.unavailable" hidden>Animación no disponible</span>
    </button>
</aside>
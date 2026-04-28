 <div class="cardJuegos">
        <div class="logoJuego">
            <img src="{{ asset('img/img-juegoAhorcado.png')}}" alt="Juego del ahorcado" data-i18n-alt="games.hangman.card.alt">
            <h2 data-i18n="games.hangman.card.title">Juego del ahorcado</h2>
        </div>
        <div class="descripcionJuego">
            <p data-i18n="games.hangman.card.body_1">
                Este juego del ahorcado pone a prueba tu vocabulario y rapidez mental: debes adivinar la palabra oculta letra por letra antes de completar el dibujo. Incluye una interfaz clara, feedback inmediato en cada intento y una experiencia pensada para jugar de forma fluida desde cualquier dispositivo.
            </p> <br>
            <p data-i18n="games.hangman.card.body_2">Lo desarrollé como parte de mi portafolio para demostrar lógica de programación, manejo del estado del juego y organización del código en componentes reutilizables. El objetivo fue combinar funcionalidad, rendimiento y una presentación visual consistente con el resto del sitio.</p>
            <a href="{{ route('juegos.ahorcado') }}" data-partial-nav data-i18n="games.hangman.card.cta">Jugar al ahorcado</a>
        </div>
</div>
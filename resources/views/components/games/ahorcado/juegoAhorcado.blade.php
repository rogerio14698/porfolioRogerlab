<section class="contenedorJuego">
    <a href="{{ route('juegos') }}" data-partial-nav data-i18n="games.back">Volver a juegos</a>
    <div id="tablero"></div>
    <p id="vidas"></p>
    <p id="letrasIncorrectas"></p>

    <input type="text" id="input-letra" maxlength="1" placeholder="Escribe una letra" data-i18n-placeholder="games.hangman.input_placeholder">
    <button id="btn-intentar" data-i18n="games.hangman.try">Intentar</button>

    <p id="mensaje"></p>

    <button id="btn-reiniciar" data-i18n="games.hangman.restart">Reiniciar juego</button>

    <script type="module" src="{{ asset('js/ahorcado.js') }}"></script>
</section>

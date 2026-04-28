(function () {
    'use strict';

    var SUPPORTED_LANGUAGES = ['es', 'en', 'pt'];

    var wordsByLanguage = {
        es: [
            'panadero', 'casa', 'perro', 'gato', 'libro', 'ventana', 'puerta', 'mesa', 'silla', 'coche',
            'avion', 'tren', 'camion', 'bicicleta', 'escuela', 'profesor', 'alumno', 'clase', 'pizarra', 'estrella',
            'cielo', 'nube', 'mar', 'rio', 'montana', 'bosque', 'flor', 'arbol', 'manzana', 'naranja',
            'telefono', 'ordenador', 'raton', 'teclado', 'pantalla', 'internet', 'programa', 'juego', 'musica', 'cancion',
            'pelicula', 'teatro', 'danza', 'pintura', 'poema', 'novela', 'historia', 'reloj', 'calendario', 'zapato'
        ],
        en: [
            'bakery', 'house', 'dog', 'cat', 'book', 'window', 'door', 'table', 'chair', 'car',
            'plane', 'train', 'truck', 'bicycle', 'school', 'teacher', 'student', 'classroom', 'board', 'star',
            'sky', 'cloud', 'sea', 'river', 'mountain', 'forest', 'flower', 'tree', 'apple', 'orange',
            'phone', 'computer', 'mouse', 'keyboard', 'screen', 'internet', 'program', 'game', 'music', 'song',
            'movie', 'theater', 'dance', 'painting', 'poem', 'novel', 'story', 'clock', 'calendar', 'market'
        ],
        pt: [
            'padaria', 'casa', 'cao', 'gato', 'livro', 'janela', 'porta', 'mesa', 'cadeira', 'carro',
            'aviao', 'comboio', 'camiao', 'bicicleta', 'escola', 'professor', 'aluno', 'turma', 'quadro', 'estrela',
            'ceu', 'nuvem', 'mar', 'rio', 'montanha', 'floresta', 'flor', 'arvore', 'maca', 'laranja',
            'telefone', 'computador', 'rato', 'teclado', 'ecra', 'internet', 'programa', 'jogo', 'musica', 'cancao',
            'filme', 'teatro', 'danca', 'pintura', 'poema', 'romance', 'historia', 'relogio', 'calendario', 'mercado'
        ]
    };

    var messages = {
        es: {
            lives: 'Vidas',
            wrongLetters: 'Letras incorrectas',
            lost: 'Perdiste. La palabra era: {word}',
            won: 'Ganaste!',
            invalidLetter: 'Introduce solo una letra valida.',
            alreadyFound: 'Ya encontraste esa letra.',
            alreadyTried: 'Ya intentaste esa letra.'
        },
        en: {
            lives: 'Lives',
            wrongLetters: 'Wrong letters',
            lost: 'You lost. The word was: {word}',
            won: 'You won!',
            invalidLetter: 'Enter only one valid letter.',
            alreadyFound: 'You already found that letter.',
            alreadyTried: 'You already tried that letter.'
        },
        pt: {
            lives: 'Vidas',
            wrongLetters: 'Letras incorretas',
            lost: 'Perdeste. A palavra era: {word}',
            won: 'Ganhaste!',
            invalidLetter: 'Introduce apenas uma letra valida.',
            alreadyFound: 'Ja encontraste essa letra.',
            alreadyTried: 'Ja tentaste essa letra.'
        }
    };

    var state = {
        language: 'es',
        palabra: '',
        letrasCorrectas: [],
        letrasIncorrectas: [],
        vidas: 10,
        letrasUnicas: 0
    };

    var languageListenerBound = false;

    function getLanguage() {
        var language = document.documentElement.lang || 'es';
        return SUPPORTED_LANGUAGES.indexOf(language) >= 0 ? language : 'es';
    }

    function t(key, params) {
        var dictionary = messages[state.language] || messages.es;
        var template = dictionary[key] || '';

        if (!params) {
            return template;
        }

        return template.replace(/\{(\w+)\}/g, function (_, token) {
            return params[token] || '';
        });
    }

    function handleLanguageChanged(event) {
        var nextLanguage = (event.detail && event.detail.language) || 'es';
        var ui = getUi();

        if (SUPPORTED_LANGUAGES.indexOf(nextLanguage) < 0) {
            return;
        }

        if (!isReady(ui) || ui.root.dataset.hangmanInit !== 'true') {
            return;
        }

        state.language = nextLanguage;

        // Keep game progress while refreshing labels/messages to the selected language.
        mostrarTablero(ui);
        verificarEstado(ui);
    }

    function getUi() {
        return {
            root: document.querySelector('.contenedorJuego'),
            tablero: document.getElementById('tablero'),
            vidas: document.getElementById('vidas'),
            incorrectas: document.getElementById('letrasIncorrectas'),
            input: document.getElementById('input-letra'),
            btnIntentar: document.getElementById('btn-intentar'),
            mensaje: document.getElementById('mensaje'),
            btnReiniciar: document.getElementById('btn-reiniciar')
        };
    }

    function isReady(ui) {
        return Boolean(
            ui.root && ui.tablero && ui.vidas && ui.incorrectas &&
            ui.input && ui.btnIntentar && ui.mensaje && ui.btnReiniciar
        );
    }

    function elegirPalabra() {
        var words = wordsByLanguage[state.language] || wordsByLanguage.es;
        state.palabra = words[Math.floor(Math.random() * words.length)];
        state.letrasUnicas = new Set(state.palabra).size;
    }

    function mostrarTablero(ui) {
        var oculto = state.palabra.split('').map(function (letra) {
            return state.letrasCorrectas.includes(letra) ? letra : '_';
        });

        ui.tablero.textContent = oculto.join(' ');
        ui.vidas.textContent = t('lives') + ': ' + state.vidas;
        ui.incorrectas.textContent = t('wrongLetters') + ': ' + state.letrasIncorrectas.join(' - ');
    }

    function verificarEstado(ui) {
        if (state.vidas <= 0) {
            ui.mensaje.textContent = t('lost', { word: state.palabra });
            ui.btnIntentar.disabled = true;
            ui.input.disabled = true;
            return;
        }

        if (state.letrasCorrectas.length === state.letrasUnicas) {
            ui.mensaje.textContent = t('won');
            ui.btnIntentar.disabled = true;
            ui.input.disabled = true;
        }
    }

    function reiniciar(ui) {
        state.language = getLanguage();
        state.palabra = '';
        state.letrasCorrectas = [];
        state.letrasIncorrectas = [];
        state.vidas = 10;
        state.letrasUnicas = 0;

        ui.mensaje.textContent = '';
        ui.btnIntentar.disabled = false;
        ui.input.disabled = false;
        ui.input.value = '';

        elegirPalabra();
        mostrarTablero(ui);
    }

    function intentarLetra(ui) {
        var letra = ui.input.value.toLowerCase();
        ui.input.value = '';

        if (!/^[a-z]$/.test(letra)) {
            alert(t('invalidLetter'));
            return;
        }

        if (state.palabra.includes(letra)) {
            if (!state.letrasCorrectas.includes(letra)) {
                state.letrasCorrectas.push(letra);
            } else {
                alert(t('alreadyFound'));
            }
        } else if (!state.letrasIncorrectas.includes(letra)) {
            state.letrasIncorrectas.push(letra);
            state.vidas -= 1;
        } else {
            alert(t('alreadyTried'));
        }

        mostrarTablero(ui);
        verificarEstado(ui);
    }

    function bind(ui) {
        ui.btnIntentar.addEventListener('click', function () {
            intentarLetra(ui);
        });

        ui.btnReiniciar.addEventListener('click', function () {
            reiniciar(ui);
        });

        ui.input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                intentarLetra(ui);
            }
        });
    }

    function initHangman() {
        var ui = getUi();

        if (!isReady(ui)) {
            return;
        }

        if (ui.root.dataset.hangmanInit === 'true') {
            return;
        }

        ui.root.dataset.hangmanInit = 'true';

        if (!languageListenerBound) {
            document.addEventListener('rogerlab:language-changed', handleLanguageChanged);
            languageListenerBound = true;
        }

        bind(ui);
        reiniciar(ui);
    }

    document.addEventListener('DOMContentLoaded', initHangman);
    document.addEventListener('partial:navigation:loaded', initHangman);
}());

(function () {
    'use strict';

    var palabras = [
        'panadero', 'hola', 'casa', 'perro', 'gato', 'libro', 'ventana', 'puerta', 'mesa', 'silla',
        'coche', 'avion', 'tren', 'camion', 'bicicleta', 'escuela', 'profesor', 'alumno', 'clase', 'pizarra',
        'luz', 'sombra', 'sol', 'luna', 'estrella', 'cielo', 'nube', 'mar', 'rio', 'montana',
        'bosque', 'flor', 'arbol', 'fruta', 'manzana', 'pera', 'uva', 'platano', 'naranja', 'sandia',
        'telefono', 'ordenador', 'raton', 'teclado', 'pantalla', 'internet', 'programa', 'juego', 'musica', 'cancion',
        'pelicula', 'teatro', 'danza', 'arte', 'pintura', 'escultura', 'fotografia', 'poema', 'novela', 'historia',
        'tiempo', 'reloj', 'calendario', 'dia', 'noche', 'manana', 'tarde', 'siglo', 'ropa', 'zapato',
        'camisa', 'pantalon', 'sombrero', 'abrigo', 'falda', 'vestido', 'bufanda', 'guante', 'ciudad', 'pueblo',
        'aldea', 'calle', 'plaza', 'parque', 'puente', 'carretera', 'edificio', 'iglesia', 'hospital', 'farmacia',
        'tienda', 'mercado', 'restaurante', 'hotel', 'bar', 'cafeteria', 'cine', 'museo', 'dinero', 'moneda',
        'billete', 'banco', 'tarjeta', 'precio', 'compra', 'venta', 'oferta', 'ahorro', 'trabajo', 'empleo',
        'jefe', 'companero', 'jardin', 'campo', 'playa', 'isla', 'desierto', 'oceano', 'volcan', 'cueva',
        'valle', 'pajaro', 'pez', 'insecto', 'abeja', 'hormiga', 'mariposa', 'caballo', 'vaca', 'oveja'
    ];

    var state = {
        palabra: '',
        letrasCorrectas: [],
        letrasIncorrectas: [],
        vidas: 10,
        letrasUnicas: 0
    };

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
        state.palabra = palabras[Math.floor(Math.random() * palabras.length)];
        state.letrasUnicas = new Set(state.palabra).size;
    }

    function mostrarTablero(ui) {
        var oculto = state.palabra.split('').map(function (letra) {
            return state.letrasCorrectas.includes(letra) ? letra : '_';
        });

        ui.tablero.textContent = oculto.join(' ');
        ui.vidas.textContent = 'Vidas: ' + state.vidas;
        ui.incorrectas.textContent = 'Letras incorrectas: ' + state.letrasIncorrectas.join(' - ');
    }

    function verificarEstado(ui) {
        if (state.vidas <= 0) {
            ui.mensaje.textContent = 'Perdiste. La palabra era: ' + state.palabra;
            ui.btnIntentar.disabled = true;
            ui.input.disabled = true;
            return;
        }

        if (state.letrasCorrectas.length === state.letrasUnicas) {
            ui.mensaje.textContent = 'Ganaste!';
            ui.btnIntentar.disabled = true;
            ui.input.disabled = true;
        }
    }

    function reiniciar(ui) {
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

        if (!/^[a-zñ]$/.test(letra)) {
            alert('Introduce solo una letra valida.');
            return;
        }

        if (state.palabra.includes(letra)) {
            if (!state.letrasCorrectas.includes(letra)) {
                state.letrasCorrectas.push(letra);
            } else {
                alert('Ya encontraste esa letra.');
            }
        } else if (!state.letrasIncorrectas.includes(letra)) {
            state.letrasIncorrectas.push(letra);
            state.vidas -= 1;
        } else {
            alert('Ya intentaste esa letra.');
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
        bind(ui);
        reiniciar(ui);
    }

    document.addEventListener('DOMContentLoaded', initHangman);
    document.addEventListener('partial:navigation:loaded', initHangman);
}());

// --- Lista de palabras ---
const palabras = [
    "panadero", "hola", "casa", "perro", "gato", "libro", "ventana", "puerta", "mesa", "silla",
    "coche", "avion", "tren", "camion", "bicicleta", "escuela", "profesor", "alumno", "clase", "pizarra",
    "luz", "sombra", "sol", "luna", "estrella", "cielo", "nube", "mar", "rio", "montana",
    "bosque", "flor", "arbol", "fruta", "manzana", "pera", "uva", "platano", "naranja", "sandia",
    "telefono", "ordenador", "raton", "teclado", "pantalla", "internet", "programa", "juego", "musica", "cancion",
    "pelicula", "teatro", "danza", "arte", "pintura", "escultura", "fotografia", "poema", "novela", "historia",
    "tiempo", "reloj", "calendario", "dia", "noche", "manana", "tarde", "siglo", "ropa", "zapato",
    "camisa", "pantalon", "sombrero", "abrigo", "falda", "vestido", "bufanda", "guante", "ciudad", "pueblo",
    "aldea", "calle", "plaza", "parque", "puente", "carretera", "edificio", "iglesia", "hospital", "farmacia",
    "tienda", "mercado", "restaurante", "hotel", "bar", "cafeteria", "cine", "museo", "dinero", "moneda",
    "billete", "banco", "tarjeta", "precio", "compra", "venta", "oferta", "ahorro", "trabajo", "empleo",
    "jefe", "companero", "jardin", "campo", "playa", "isla", "desierto", "oceano", "volcan", "cueva",
    "valle", "pajaro", "pez", "insecto", "abeja", "hormiga", "mariposa", "caballo", "vaca", "oveja"
];


// --- Variables globales ---
let palabra = "";
let letrasCorrectas = [];
let letrasIncorrectas = [];
let vidas = 10;
let letrasUnicas = 0;
let aciertos = 0;

// --- Elementos del DOM ---
const tablero = document.getElementById("tablero");
const vidasElem = document.getElementById("vidas");
const letrasIncorrectasElem = document.getElementById("letrasIncorrectas");
const inputLetra = document.getElementById("input-letra");
const btnIntentar = document.getElementById("btn-intentar");
const mensajeElem = document.getElementById("mensaje");
const btnReiniciar = document.getElementById("btn-reiniciar");

// --- Elegir palabra ---
function elegirPalabra() {
    palabra = palabras[Math.floor(Math.random() * palabras.length)];
    letrasUnicas = new Set(palabra).size;
}

// --- Mostrar tablero ---
function mostrarTablero() {
    let oculto = palabra.split("").map(letra =>
        letrasCorrectas.includes(letra) ? letra : "_"
    );
    tablero.textContent = oculto.join(" ");
    vidasElem.textContent = `Vidas: ${vidas}`;
    letrasIncorrectasElem.textContent = `Letras incorrectas: ${letrasIncorrectas.join(" - ")}`;
}

// --- Revisar letra ---
function intentarLetra() {
    const letra = inputLetra.value.toLowerCase();
    inputLetra.value = "";

    if (!/^[a-zñ]$/.test(letra)) {
        alert("Introduce solo una letra válida.");
        return;
    }

    if (palabra.includes(letra)) {
        if (!letrasCorrectas.includes(letra)) {
            letrasCorrectas.push(letra);
            aciertos++;
        } else {
            alert("Ya encontraste esa letra.");
        }
    } else {
        if (!letrasIncorrectas.includes(letra)) {
            letrasIncorrectas.push(letra);
            vidas--;
        } else {
            alert("Ya intentaste esa letra.");
        }
    }

    mostrarTablero();
    verificarEstado();
}

// --- Verificar si ganó o perdió ---
function verificarEstado() {
    if (vidas <= 0) {
        mensajeElem.textContent = `❌ Perdiste. La palabra era: ${palabra}`;
        btnIntentar.disabled = true;
        inputLetra.disabled = true;
    } else if (letrasCorrectas.length === letrasUnicas) {
        mensajeElem.textContent = "🎉 ¡Ganaste!";
        btnIntentar.disabled = true;
        inputLetra.disabled = true;
    }
}

// --- Reiniciar juego ---
function reiniciar() {
    palabra = "";
    letrasCorrectas = [];
    letrasIncorrectas = [];
    vidas = 10;
    aciertos = 0;
    mensajeElem.textContent = "";
    btnIntentar.disabled = false;
    inputLetra.disabled = false;

    elegirPalabra();
    mostrarTablero();
}

// --- Eventos ---
btnIntentar.addEventListener("click", intentarLetra);
btnReiniciar.addEventListener("click", reiniciar);

// --- Iniciar ---
reiniciar();

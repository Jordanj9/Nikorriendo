//======================================================================
// VARIABLES
//======================================================================
let firma_cliente = document.querySelector('#firma_cliente');
let lineas = [];
let correccionX = 0;
let correccionY = 0;
let pintarLinea = false;
let btn_limpiar = document.querySelector('#btn-limpiar');

let posicion = firma_cliente.getBoundingClientRect();
correccionX = posicion.x;
correccionY = posicion.y;

firma_cliente.width = 300;
firma_cliente.height = 200;

//======================================================================
// FUNCIONES
//==================title_firma====================================================

/**
 * Funcion que empieza a dibujar la linea
 */
function empezarDibujo() {
    pintarLinea = true;
    lineas.push([]);
};

/**
 * Funcion dibuja la linea
 */
function dibujarLinea(event) {
    event.preventDefault();
    if (pintarLinea) {
        let ctx = firma_cliente.getContext('2d');
        // Estilos de linea
        ctx.lineJoin = ctx.lineCap = 'round';
        ctx.lineWidth = 4;
        // Color de la linea
        ctx.strokeStyle = '#000';
        // Marca el nuevo punto
        let nuevaPosicionX = 0;
        let nuevaPosicionY = 0;
        if (event.changedTouches == undefined) {
            // Versión ratón
            nuevaPosicionX = event.layerX;
            nuevaPosicionY = event.layerY;

        } else {
            // Versión touch, pantalla tactil
            nuevaPosicionX = event.changedTouches[0].pageX - correccionX;
            nuevaPosicionY = event.changedTouches[0].pageY - correccionY;
        }


        // Guarda la linea
        lineas[lineas.length - 1].push({
            x: nuevaPosicionX,
            y: nuevaPosicionY
        });
        // Redibuja todas las lineas guardadas
        ctx.beginPath();
        lineas.forEach(function (segmento) {
            ctx.moveTo(segmento[0].x, segmento[0].y);
            segmento.forEach(function (punto, index) {
                ctx.lineTo(punto.x, punto.y);
            });
        });
        ctx.stroke();
    }
}

/**
 * Funcion que deja de dibujar la linea
 */
function pararDibujar() {
    pintarLinea = false;
}

//======================================================================
// EVENTOS
//======================================================================

// Eventos raton
firma_cliente.addEventListener('mousedown', empezarDibujo, false);
firma_cliente.addEventListener('mousemove', dibujarLinea, false);
firma_cliente.addEventListener('mouseup', pararDibujar, false);

// Eventos pantallas táctiles
firma_cliente.addEventListener('touchstart', empezarDibujo, false);
firma_cliente.addEventListener('touchmove', dibujarLinea, false);


//Evento para limpiar el canvas
btn_limpiar.addEventListener('click', function (event) {
    event.preventDefault();
    clear();
});

//funcion para limpiar el lienzo
function clear() {
    let ctx = firma_cliente.getContext('2d');
    ctx.clearRect(0, 0, firma_cliente.width, firma_cliente.height);
    lineas = [];
}

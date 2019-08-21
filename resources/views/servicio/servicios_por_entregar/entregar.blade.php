<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css')}}">

    <link rel="stylesheet" href="{{ asset('select2/dist/css/select2.min.css')}}">
    <title>Canvas</title>
    <style>
        canvas {
            width: 300px;
            height: 200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            border: 1px solid rgb(178, 178, 178);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Entregar Servicio</a>
        </div>
    </div>
</nav>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Servicio
            <small>Menú de Servicio</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a href="{{route('inicio')}}"><i class="fa fa-indent"></i> Servicios</a></li>
            <li class="active"><a><i class="fa fa-users"></i> Entrega </a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @include('flash::message')
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Seleccione las lavadoras que pretende entregar en el servicio</label>
                <select class="form-control show-tick select2" name="lavadoras[]" required="" multiple="">
                    <option value="" selected>--selecione una aqui--</option>
                    @foreach($lavadoras as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <h3 class="title_firma">Firma Cliente</h3>
            <canvas id="firma_cliente"></canvas>
            <div class="opciones">
                <form method='post' action='#' ENCTYPE='multipart/form-data'>
                    <button id="btn-limpiar" class="btn btn-info pull-right" value="Limpiar"><i
                            class="fa fa-sticky-note-o"></i></button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-12" style="margin-top: 20px !important">
                    <button class="btn btn-success icon-btn pull-right" type="submit" style="margin-left: 5px;"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                    <a class="btn btn-danger icon-btn pull-right" href="{{route('servicio.getServiciosPorEntregar')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Select2 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset('select2/dist/js/select2.full.min.js')}}"></script>
<script>
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

    function guardar_firma(event) {
        event.preventDefault();
        let imagen = firma_cliente.toDataURL('image/png');
        let inputImagen = document.getElementById('firma');
        inputImagen.value = imagen;
        console.log(imagen);
    }

    $(function () {
        $('.select2').select2();
    });

</script>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css')}}">

    <link rel="stylesheet" href="{{ asset('select2/dist/css/select2.min.css')}}">

    <link rel="shortcut icon" href="{{asset('images/nikorriendo-blanco.ico')}}">

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
        <div class="col-md-12" id="message" style="display: none">
            <div class="alert alert-danger" id="message-alert">
                <p class="h4" id="txt-message">
                </p>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Seleccione las lavadoras que pretende entregar en el servicio</label>
                <select class="form-control show-tick select2" name="lavadoras[]" id="lavadoras" required="" multiple="">
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
                    <button class="btn btn-success icon-btn pull-right" type="submit" onclick="guardar(event)" style="margin-left: 5px;"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                    <a class="btn btn-danger icon-btn pull-right" href="{{route('servicio.getServiciosPorEntregar')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Select2 -->
<script src="{{ asset('js/axios.min.js')}}"></script>
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset('select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('js/canvas/main.js')}}"></script>
<script>

    function guardar(event) {
        event.preventDefault();
        let imagen = firma_cliente.toDataURL('image/png');
        const lavadoras = $('#lavadoras').val();

        if(lavadoras.length == 0){
            writeMessage('Error: Debe seleccionar las lavadoras que se van a entregar, si no tiene disponible por favor libere el servicio');
            return;
        }
        if (lineas.length == 0) {
            writeMessage('Error: firma requerida');
            return;
        }
        axios.post('{{url('/servicio/guardarEntrega')}}', {
            base_64: imagen,
            lavadoras:lavadoras,
            servicio_id:'{{$servicio_id}}'
        }).then(function (response) {
            const data = response.data;
            if(data.status == 'error'){
                writeMessage(data.message);
            }else {
                writeMessage(data.message,'green');
                setTimeout(()=> {
                    window.history.back();
                    window.location.reload();
                },5000);
            }
        }).catch(function (error) {
            console.log(error);
        });
    }

    function writeMessage(message,color = 'red'){
        const div_message = document.getElementById('message');
        const div_message_alert = document.getElementById('message-alert');
        div_message.style.backgroundColor = color;
        const p = document.getElementById('txt-message');
        div_message.style.display = 'block';
        p.innerText = message;
        setTimeout(function () {
            div_message.style.display = 'none';
        },4500);

    }

    $(function () {
        $('.select2').select2();
    });

</script>
</body>
</html>

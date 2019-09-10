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

    <title>{{config('app.name','NIKORRIENDO')}}</title>
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
            <li class="active"><a><i class="fa fa-caret-square-o-down"></i> Recoger </a></li>
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
            <table class="table table-hover">
                <tbody>
                <tr class="read">
                    <td class="contact bg-green" colspan="2" ><center><b>Información del Cliente</b></center></td>
                </tr>
                <tr class="read">
                    <td class="contact"><b>Telefono</b></td>
                    <td class="subject">{{$servicio->cliente->telefono}}</td>
                </tr>
                <tr class="read">
                    <td class="contact"><b>Nombre</b></td>
                    <td class="subject">{{$servicio->cliente->nombre}}</td>
                </tr>
                <tr class="read">
                    <td class="contact"><b>Dirección</b></td>
                    <td class="subject">{{$servicio->cliente->direccion}}</td>
                </tr>
                <tr class="read">
                    <td class="contact"><b>Barrio</b></td>
                    <td class="subject">{{$servicio->cliente->barrio->nombre}}</td>
                </tr>
                <tr class="read">
                    <td class="contact bg-green" colspan="2" ><center><b>Información del Servicio</b></center></td>
                </tr>
                <tr class="read">
                    <td class="contact"><b>Numero de Lavadoras</b></td>
                    <td class="subject">{{$servicio->num_lavadoras}}</td>
                </tr>
                <tr class="read">
                    <td class="contact"><b>Numero de Dias</b></td>
                    <td class="subject">{{$servicio->dias}}</td>
                </tr>
                <tr class="read">
                    <td class="contact"><b>Dirrección</b></td>
                    <td class="subject">{{$servicio->direccion}}</td>
                </tr>
                <tr class="read">
                    <td class="contact"><b>Barrio</b></td>
                    <td class="subject">{{$servicio->barrio->nombre}}</td>
                </tr>
                @if($servicio->persona_id != null)
                    <tr class="read">
                        <td class="contact bg-green" colspan="2" ><center><b>Información del Mensajero Encargado del Servicio</b></center></td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Nombre</b></td>
                        <td class="subject">{{$servicio->persona->primer_nombre}} {{$servicio->persona->primer_apellido}}</td>
                    </tr>
                    <tr class="read">
                        <td class="contact"><b>Telefono</b></td>
                        <td class="subject">{{$servicio->persona->telefono}}</td>
                    </tr>
                @endif

                @if($servicio->estado == 'ENTREGADO' || $servicio->estado == 'RECOGER' || $servicio->estado == 'FINALIZADO' )

                    <tr class="read">
                        <td class="contact bg-green" colspan="2" ><center><b>Datos de Entrega del servicio</b></center></td>
                    </tr>

                    <tr class="read">
                        <td class="contact"><b>Fecha de Entrega</b></td>
                        <td class="subject">{{$servicio->fechaentrega}}</td>
                    </tr>

                    <tr class="read">
                        <td class="contact"><b>Fecha Final de Servicio</b></td>
                        <td class="subject">{{$servicio->fechafin}}</td>
                    </tr>


                    <tr class="read">
                        <td class="contact bg-green" colspan="2" ><center><b>Firma del Cliente</b></center></td>
                    </tr>

                    <tr class="read">
                        <td class="contact bg-white" colspan="2">
                            <img src="{{ url('/') . '/docs/firma_entregas/'.$servicio->firma_recibido_cliente}}" alt="firma del cliente" width="150" height="150">
                        </td>
                    </tr>

                @endif

                @if($servicio->lavadoras->count() > 0)

                    <tr class="read">
                        <td class="contact bg-green" colspan="2" ><center><b>Lavadora(s) Entregada(s) en el Servicio</b></center></td>
                    </tr>

                    @foreach($servicio->lavadoras as $lavadora)
                        <tr class="read">
                            <td  colspan="2" class="contact">{{$lavadora->serial.' - '.$lavadora->marca.' -BODEGA:'.$lavadora->bodega->nombre.' -SUCURSAL:'.$lavadora->bodega->sucursal->nombre}}</td>
                        </tr>
                    @endforeach

                @endif

                </tbody>
            </table>
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
<!-- Select2 -->
<script src="{{ asset('js/axios.min.js')}}"></script>
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset('select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('js/canvas/main.js')}}"></script>
<script>

    function guardar(event) {
        event.preventDefault();
        let imagen = firma_cliente.toDataURL('image/png');

        if (lineas.length == 0) {
            writeMessage('Error: firma requerida');
            return;
        }
        axios.post('{{url('/servicio/guardarRecogida')}}', {
            base_64: imagen,
            servicio_id:'{{$servicio->id}}'
        }).then(function (response) {
            const data = response.data;
            if(data.status == 'error'){
                writeMessage(data.message);
            }else {
                writeMessage(data.message,'green');
                setTimeout(()=> {
                    window.history.back();
                },3000);
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
        },2500);
    }

    $(function () {
        $('.select2').select2();
    });

</script>
</div>
</body>
</html>

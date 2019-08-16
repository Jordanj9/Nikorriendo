@extends('layouts.admin')
@section('breadcrumb')
<h1>
    Servicio
    <small>Solicitudes de Servicios</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.servicio')}}"><i class="fa fa-users"></i> Servicio</a></li>
    <li><a href="{{route('servicio.index')}}"><i class="fa fa-users"></i> Solicitudes</a></li>
    <li class="active"><a> Crear</a></li>
</ol>
@endsection
@if($mensaje != 'SI')
<div class="col-md-12">
    <div class="card">
        <div class="body">
            <div class="alert alert-warning">
                <strong>{{$mensaje}}</strong>
            </div>
        </div>
    </div>
</div>
@endif
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <p class="h4"><strong>Agregue nuevo servicio,</strong> gestiona la información de cada solicitud de servicios.
            </p>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Crear Servicio</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Minimizar">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Cerrar">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            @component('layouts.errors')
            @endcomponent
        </div>
        <div class="col-md-12">
            {!! Form::open(['route'=>'servicio.store','method'=>'POST','role'=>'form'])!!}
            <input type="hidden" name="latitud_cliente" id="latitud_cliente" />
            <input type="hidden" name="longitud_cliente" id="longitud_cliente" />
            <input type="hidden" name="latitud_servicio" id="latitud_servicio" />
            <input type="hidden" name="longitud_servicio" id="longitud_servicio" />
            <input type="hidden" name="id_cliente" id="id_cliente" />
            <div class="form-group">
                <div class="col-md-12"><h4 class="head" style="color: #2c3e50"><b>Datos del Cliente</b></h4></div>
                <div class="col-md-6">
                    <label>Telefono</label>
                    <input type="text" class="form-control" placeholder="Telefono del Cliente" name="telefono_cliente" id="telefono_cliente"/>
                </div>
                <div class="col-md-6">
                    <label>Si ha realizado pedidos antes pulse consultar</label>
                    <a class="btn btn-block bg-olive" onclick="ir()"><i>Consultar</i></a>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Nombre</label>
                    {!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombres','required','id'=>'nombre']) !!}
                </div>
                <div class="col-md-6">
                    <label class="control-label">Dirección</label>
                    {!! Form::text('direccion',null,['class'=>'form-control','placeholder'=>'Dirección de residencia','required','id'=>'direccion_cliente']) !!}
                </div>
            </div>
            <div class="col-md-12"><h4 class="head" style="color: #2c3e50"><b>Datos del Servicio</b></h4></div>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Dirección del Servicio</label>
                    {!! Form::text('direccion_servico',null,['class'=>'form-control','placeholder'=>'Dirección de residencia','required','id'=>'direccion_servicio']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="col-md-12">
                        <label class="control-label">Ubicación de Residencia (Arrastre el marcador <i style="color:red; font-size: 20px" class="fa fa-map-marker"></i> hasta su dirección de residencia)</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" readonly="" class="form-control" placeholder="Longitud" name="longitud" id="longitud" />
                    </div>
                    <div class="col-md-6">
                        <input type="text" readonly="" class="form-control" placeholder="Latitud" name="latitud" id="latitud" /><br/>
                    </div>
                    <div class="col-md-12" id="map" style="height: 400px;"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12" style="margin-top: 20px !important">
                    <button class="btn btn-success icon-btn pull-right" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Guardar</button>
                    <button class="btn btn-info icon-btn pull-right" type="reset"><i class="fa fa-fw fa-lg fa-trash-o"></i>Limpiar</button>
                    <a class="btn btn-danger icon-btn pull-right" href="{{route('bodega.index')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@section('script')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACMXJBl7W2A6fYConiB7bfeCkKuNusyyo&callback=initMap"></script>
<script type="text/javascript">
                        $(function () {
                            $('#example1').DataTable();
                        });
                        function limpiar() {
                            $("#nombre").html("");
                            $("#telefono_cliente").html("");
                            $("#direccion_servicio").html("");
                            $("#direccion_cliente").html("");
                            $("#latitud_cliente").html("");
                            $("#longitud_cliente").html("");
                            $("#latitud_servicio").html("");
                            $("#longitud_servicio").html("");
                        }
                        function inhabilitar() {
                            $("#nombre").attr('disabled', true);
                            $("#telefono_cliente").attr('disabled', true);
                            $("#direccion_cliente").attr('disabled', true);
                        }
                        function ir() {
                            var id = $("#telefono_cliente").val();
                            if (id.length <= 0) {
                                notify('Atención', 'Debe ingresar un telefono.', 'error');
                            } else {
                                limpiar();
                                $.ajax({
                                    type: 'GET',
                                    url: url + "servicio/servicio/" + id + "/getcliente",
                                    data: {},
                                }).done(function (msg) {
                                    if (msg !== "null") {
                                        var m = JSON.parse(msg);
                                        $("#id_cliente").val(m.id);
                                        $("#nombre").val(m.nom);
                                        $("#apellidos").val(m.ape);
                                        $("#telefono_cliente").val(m.tel);
                                        $("#direccion_cliente").val(m.dir);
                                        $("#direccion_servicio").val(m.dir);
                                        $("#latitud_cliente").val(m.lat);
                                        $("#longitud_cliente").val(m.lon);
                                        $("#latitud_servicio").val(m.lat);
                                        $("#longitud_servicio").val(m.lon);
                                        inhabilitar();
                                    } else {
                                        notify('Atención', 'No se encontro registro con ese telefono. Debe llenar el formulario.', 'error');
                                        $("#telefono_cliente").removeAttr('disabled');
                                    }
                                });
                            }
                        }

                        var marker;          //variable del marcador
                        var coords = {};    //coordenadas obtenidas con la geolocalización

//Funcion principal
                        initMap = function () {
                            //usamos la API para geolocalizar el usuario
                            navigator.geolocation.getCurrentPosition(
                                    function (position) {
                                        coords = {
                                            lng: position.coords.longitude,
                                            lat: position.coords.latitude
                                        };
                                        setMapa(coords, 'map');  //pasamos las coordenadas al metodo para crear el mapa
                                    }, function (error) {
                                console.log(error);
                            });
                        }

                        function setMapa(coords, mapa) {
                            //Se crea una nueva instancia del objeto mapa
                            var map = new google.maps.Map(document.getElementById(mapa),
                                    {
                                        zoom: 10,
                                        center: new google.maps.LatLng(coords.lat, coords.lng),
                                    });
                            //Creamos el marcador en el mapa con sus propiedades
                            //para nuestro obetivo tenemos que poner el atributo draggable en true
                            //position pondremos las mismas coordenas que obtuvimos en la geolocalización
                            marker = new google.maps.Marker({
                                map: map,
                                draggable: true,
                                animation: google.maps.Animation.DROP,
                                position: new google.maps.LatLng(coords.lat, coords.lng),

                            });
                            //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
                            //cuando el usuario a soltado el marcador
                            marker.addListener('click', toggleBounce);
                            marker.addListener('dragend', function (event)
                            {
                                //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
                                $("#latitud").val(this.getPosition().lat());
                                $("#longitud").val(this.getPosition().lng());
                            });
                        }

//callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
                        function toggleBounce() {
                            if (marker.getAnimation() !== null) {
                                marker.setAnimation(null);
                            } else {
                                marker.setAnimation(google.maps.Animation.BOUNCE);
                            }
                        }
</script>
@endsection

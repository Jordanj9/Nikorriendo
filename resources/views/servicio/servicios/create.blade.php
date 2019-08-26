@extends('layouts.admin')

@section('style')
<style>
    @import url('https://fonts.googleapis.com/css?family=Roboto&display=swap');
    #map {
        height: 400px;
        width: 100%;
        margin:0 auto;
        border-radius: 20px;
    }
    html, body {
        font-family: 'Roboto', sans-serif;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .row{
        position: relative;
    }

    .input{
        position: absolute;
        top: 5.2px;
        left: 220px;
    }

    .input input[type=text]{
        width: 350px;
        position: relative;
        border-radius: 20px;
        background-color: rgb(240, 242, 245);
        border: none;
        outline: none;
        padding: 14px;
    }

    .input input[type=text]:focus{
        border: 1px solid rgb(0, 170, 193);
        box-shadow: 0 0 8px dodgerblue;
    }

    .btn-search{
        position: absolute;
        top:0;
        left: 90%;
        font-size: 20px;
        color: rgb(178, 178, 178);
        line-height: 48px;
    }

    .btn-search:hover{
        color:rgb(69, 56, 234);
    }

    @media(max-width: 480px){
        .input{
            top: 55px;
            left: 20px;
        }
        .input input[type=text]{
            width: 250px;
        }
    }

</style>
@endsection

@section('breadcrumb')
<h1>
    Servicio
    <small>Servicios</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="{{route('admin.servicio')}}"><i class="fa fa-indent"></i> Servicios</a></li>
    <li><a href="{{route('servicio.index')}}"><i class="fa fa-pencil-square-o"></i> Solicitudes</a></li>
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
            <p class="h4"><strong>Agregue nuevo servicio,</strong> Gestiona la información de cada solicitud de servicios.
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
            <input type="hidden" name="telefono_cliente" id="tel">
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
                <div class="col-md-4">
                    <label class="control-label">Nombre</label>
                    {!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombres','required','id'=>'nombre']) !!}
                </div>
                <div class="col-md-4">
                    <label class="control-label">Dirección</label>
                    {!! Form::text('direccion',null,['class'=>'form-control','placeholder'=>'Dirección de residencia','required','id'=>'direccion_cliente']) !!}
                </div>
                <div class="col-md-4">
                    <label>Barrio</label>
                    {!! Form::select('barrio_id_cliente',$barrios,null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required','id'=>'barrio_cliente']) !!}
                </div>
            </div>
            <div class="col-md-12"><h4 class="head" style="color: #2c3e50"><b>Datos del Servicio</b></h4></div>

            <div class="col-md-4">
                <label>Dias de Alquiler</label>
                <input type="number" class="form-control" placeholder="Dias del Alquiler" name="dias" id="dias" value="1"/>
            </div>
            <div class="col-md-4">
                <label>Numero de lavadoras</label>
                <input type="number" value="1" class="form-control" placeholder="Numero de lavadora requeridas" name="num_lavadoras" id="num_lavadoras"/>
            </div>
            <div class="col-md-4">
                <label>Barrio</label>
                {!! Form::select('barrio_id_servicio',$barrios,null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required','id'=>'barrio_servicio']) !!}
            </div>
            <div class="col-md-12">
                <label class="control-label">Ubicación del servicio (Ingrese la dirección o arrastre el marcador <i style="color:red; font-size: 20px" class="fa fa-map-marker"></i> si la dirección no concuerda con el punto pintado en el mapa)</label>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="map">
                            </div>
                        </div>
                        <div class="input">
                            <input type="text" placeholder="Buscar en Google Maps" id="direccion_servicio" name="direccion_servicio">
                            <a href="#" class="btn-search" title="Buscar"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
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
<script src="{{asset('js/axios.min.js')}}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACMXJBl7W2A6fYConiB7bfeCkKuNusyyo&callback=initMap&libraries=places"></script>
<script type="text/javascript">

                        //  class para gecodifcar las direcciones en latitudes y en longitudes
                        class Geocoding {
                            constructor(key) {
                                this.key = key;
                            }
                            async getLatLng(location) {
                                const url = `https://maps.googleapis.com/maps/api/geocode/json`;
                                let result = await axios.get('https://maps.googleapis.com/maps/api/geocode/json', {
                                    params: {
                                        address: location,
                                        key: this.key
                                    }
                                });
                                return result.data;
                            }
                        }
                        var marker;          //variable del marcador
                        var coords = {};    //coordenadas obtenidas con la geolocalización
                        var map;
                        var geo = new Geocoding('AIzaSyACMXJBl7W2A6fYConiB7bfeCkKuNusyyo');
                        let btn_search = document.querySelector('.btn-search');
                        var marcadores = [];
                        $(function () {
                            $('#example1').DataTable();
                        });
                        function limpiar() {
                            $("#nombre").html("");
                            $("#telefono_cliente").html("");
                            $("#direccion_servicio").html("");
                            $("#barrio_cliente").val();
                            $("#barrio_servicio").val();
                            $("#direccion_cliente").html("");
                            $("#latitud_cliente").html("");
                            $("#longitud_cliente").html("");
                            $("#latitud_servicio").html("");
                            $("#longitud_servicio").html("");
                            $("#tel").html('');
                        }
                        function inhabilitar() {
                            $("#nombre").attr('disabled', true);
                            $("#telefono_cliente").attr('disabled', true);
                            $("#direccion_cliente").attr('disabled', true);
                            $("#barrio_cliente").attr('disabled', true);
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
                                        $("#barrio_servicio").val(m.bar);
                                        $("#barrio_cliente").val(m.bar);
                                        $("#direccion_cliente").val(m.dir);
                                        $("#direccion_servicio").val(m.dir);
                                        $("#latitud_cliente").val(m.lat);
                                        $("#longitud_cliente").val(m.lon);
                                        $("#latitud_servicio").val(m.lat);
                                        $("#longitud_servicio").val(m.lon);
                                        $("#tel").val(m.tel);
                                        //Creamos el marcador en el mapa con sus propiedades
                                        //para nuestro obetivo tenemos que poner el atributo draggable en true
                                        //position pondremos las mismas coordenas que obtuvimos en la geolocalización
                                        nuevo = new google.maps.Marker({
                                            map: map,
                                            draggable: true,
                                            animation: google.maps.Animation.DROP,
                                            position: new google.maps.LatLng(m.lat, m.lon),

                                        });
                                        nuevo.addListener('dragend', function (event)
                                        {
                                            //escribimos las coordenadas de la posicion actual del marcador dentro del input #coord'
                                            document.getElementById('latitud_servicio').value = this.getPosition().lat();
                                            document.getElementById('longitud_servicio').value = this.getPosition().lng();
                                        });
                                        if (marcadores.length > 1) {
                                            marcadores[1].setMap(null);
                                            marcadores.pop();
                                            marcadores.push(nuevo);
                                        } else {
                                            marcadores.push(nuevo);
                                        }
                                        bounds = new google.maps.LatLngBounds();
                                        bounds.extend(new google.maps.LatLng(m.lat, m.lon));
                                        bounds.extend(new google.maps.LatLng(10.4780176, -73.2561265));
                                        map.fitBounds(bounds);
                                        inhabilitar();
                                    } else {
                                        notify('Atención', 'No se encontro registro con ese telefono. Debe llenar el formulario.', 'error');
                                        $("#telefono_cliente").removeAttr('disabled');
                                    }
                                });
                            }
                        }

                        //Funcion principal
                        function initMap() {
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
                            map = new google.maps.Map(document.getElementById(mapa),
                                    {
                                        zoom: 15,
                                        center: new google.maps.LatLng(10.4780265, -73.2561265),
                                    });
                            //agregamos la funcionalidad de autocompletar las direcciones al input
                            const autocomplete = document.querySelector('.input input');
                            const search = new google.maps.places.Autocomplete(autocomplete);
                            search.bindTo("bounds", map);
                            //Creamos el marcador en el mapa con sus propiedades
                            //para nuestro obetivo tenemos que poner el atributo draggable en true
                            //position pondremos las mismas coordenas que obtuvimos en la geolocalización
                            marker = new google.maps.Marker({
                                map: map,
                                draggable: true,
                                animation: google.maps.Animation.DROP,
                                position: new google.maps.LatLng(10.4780176, -73.2555785),

                            });
                            marcadores.push(marker);
                            //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica
                            //cuando el usuario a soltado el marcador
                            marker.addListener('click', toggleBounce);
                            marker.addListener('dragend', function (event)
                            {
                                //escribimos las coordenadas de la posicion actual del marcador dentro del input #coord'
                                document.getElementById('latitud_servicio').value = this.getPosition().lat();
                                document.getElementById('longitud_servicio').value = this.getPosition().lng();
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
                        document.addEventListener('DOMContentLoaded', function () {
                            //se convierte la direccion en coordenadas para luego mostrarlas en el mapa con el api de geocoding de google
                            btn_search.addEventListener('click', event => {
                                event.preventDefault();
                                const input = document.querySelector('.input input');
                                geo.getLatLng(input.value)
                                        .then(response => {
                                            const location = response.results[0].geometry.location;
                                            $('#longitud_servicio').val(location.lng);
                                            $('#latitud_servicio').val(location.lat);
                                            $('#direccion_servicio').val(input.value);
                                            nuevo = new google.maps.Marker({
                                                map: map,
                                                draggable: true,
                                                animation: google.maps.Animation.DROP,
                                                position: new google.maps.LatLng(location.lat, location.lng)

                                            });
                                            if (marcadores.length > 1) {
                                                marcadores[1].setMap(null);
                                                marcadores.pop();
                                                marcadores.push(nuevo);
                                            } else {
                                                marcadores.push(nuevo);
                                            }
                                            bounds = new google.maps.LatLngBounds();
                                            bounds.extend(new google.maps.LatLng(location.lat, location.lng));
                                            bounds.extend(new google.maps.LatLng(10.4780176, -73.2555785));
                                            map.fitBounds(bounds);

                                        });
                            });



                        });

</script>
@endsection

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

    </style>
@endsection
@section('breadcrumb')
    <h1>
        Servicios
        <small>Solicitudes de Servicio</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{route('admin.servicio')}}"><i class="fa fa-indent"></i>Servicios</a></li>
        <li><a href="{{route('servicio.index')}}"><i class="fa fa-pencil-square-o"></i> Solicitudes</a></li>
        <li class="active"><a> Ver</a></li>
    </ol>
@endsection
@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <p class="h4"><strong>Datos del servicio, </strong> detalle de cada uno de los sevicios.
                </p>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Datos del servicio</h3>
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
            <div class="row clearfix">
                <div class="col-md-12">
                    <div id="map">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACMXJBl7W2A6fYConiB7bfeCkKuNusyyo&callback=initMap"></script>
    <script type="text/javascript">

        $(function () {

            axios.get('{{url('servicio/getServiciosPorRecogerJSON')}}').then(resonse => {
              const data  = resonse.data;
              data.forEach(item => {

                  //Creamos el marcador en el mapa con sus propiedades
                  //para nuestro obetivo tenemos que poner el atributo draggable en true
                  //position pondremos las mismas coordenas que obtuvimos en la geolocalización
                  marker = new google.maps.Marker({
                      map: map,
                      icon:  '{{url('/images/icon-maps/pin4.png')}}',
                      title:item.direccion,
                      draggable: true,
                      animation: google.maps.Animation.DROP,
                      position: new google.maps.LatLng(item.latitud, item.longitud),
                  });

                  marcadores.push(marker);

              });

              //pintamos el marker del servicio
              servicio = {
                 latitud : '{{$servicio->latitud}}',
                 longitud : '{{$servicio->longitud}}',
                 direccion : '{{$servicio->direccion}}'
              };

                marker = new google.maps.Marker({
                    map: map,
                    icon:  '{{url('/images/icon-maps/pin10.png')}}',
                    title:servicio.direccion,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: new google.maps.LatLng(servicio.latitud, servicio.longitud),
                });

                marcadores.push(marker);

                var bounds = new google.maps.LatLngBounds();

                marcadores.forEach(item => {
                    bounds.extend(new google.maps.LatLng(item.position.lat(), item.position.lng()));
                });

                map.fitBounds(bounds);

            });

        });

        var map;
        var marcadores = [];
        var marker;
        var coords;

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
                icon:  '{{url('/images/icon-maps/pin1.png')}}',
            });

            marcadores.push(marker);


            //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica
            //cuando el usuario a soltado el marcador
            marker.addListener('click', toggleBounce);
            marker.addListener('dragend', function (event) {
                //escribimos las coordenadas de la posicion actual del marcador dentro del input #coord'
                document.getElementById('latitud').value = this.getPosition().lat();
                document.getElementById('longitud').value = this.getPosition().lng();

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


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

    <link rel="shortcut icon" href="{{asset('images/nikorriendo-blanco.ico')}}">

    <title>Canvas</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto&display=swap');

        #map {
            height: 80vh;
            width: 100%;
            margin: 0 auto;
            border-radius: 20px;
        }

        html, body {
            font-family: 'Roboto', sans-serif;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .contenedor {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .message {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            width: 70%;
        }

        .message h1 {
            margin: 5px 0;
            font-size: 16px;
            color: orangered;
        }

        .message p {
            display: inline-block;
            margin: 5px 0;
        }

        .telefono {
            display: inline-block;
            width: 100%;
        }
    </style>
</head>
<body>
<nav class="navbar" style="background-color: red;">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#" style="color: white; font-size: 20px; font-weight: bold;">Ubicación de los
                Servicios</a>
        </div>
    </div>
</nav>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Servicios
            <small>ubicación</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a href="{{route('servicio.getServiciosPendientes')}}"><i class="fa fa-indent"></i>Servicios</a></li>
            <li class="active"><a><i class="fa fa-users"></i> Geolocalización </a></li>
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
    <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <div class="col-md-12">
                @component('layouts.errors')
                @endcomponent
            </div>
        </div>
    </div>
</div>
<div id="map">
</div>

<script src="{{ asset('js/axios.min.js')}}"></script>
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACMXJBl7W2A6fYConiB7bfeCkKuNusyyo&callback=initMap"></script>
<script type="text/javascript">
    var map;
    var marcadores = [];
    var marker;
    var coords;

    function initMap() {
        //usamos la API para geolocalizar el usuario
        /* navigator.geolocation.getCurrentPosition(
             function (position) {
                 coords = {
                     lng: position.coords.longitude,
                     lat: position.coords.latitude
                 };
                 setMapa(coords, 'map');  //pasamos las coordenadas al metodo para crear el mapa
             }, function (error) {
                 console.log(error);
             });*/
        coords = {
            lng: '-73.273496',
            lat: '10.4502618'
        };
        setMapa(coords, 'map');  //pasamos las coordenadas al metodo para crear el mapa

        axios.get('{{url('servicio/getServiciosPorRecogerJSON')}}').then(resonse => {
            const data = resonse.data;
            data.forEach(item => {

                const ruta = '{{url('servicio/recogerServicio')}}/' + item.id;

                var contentString = `<div class="contenedor">
                                        <div class="message">
                                                <h1>${item.cliente_nombre}</h1>
                                                <a href="tel:${item.cliente_telefono}" class="telefono">${item.cliente_telefono}</a>
                                                <p>${item.direccion}</p>
                                                <p style="width : 100%">${item.num_lavadoras} lavadora(s)</p>
                                                <p><strong>Tiempo Excedido:</strong> ${item.tiempo}</p>
                                                <div style="width : 100%; margin-bottom: 10px;">
                                                  <a href="${ruta}" class="btn btn-success pull-right">Recoger Servicio</a>
                                                 </div>
                                                  <h1>Servicio por Recoger</h1>
                                        </div>
                                   </div>`;

                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                //Creamos el marcador en el mapa con sus propiedades
                //para nuestro obetivo tenemos que poner el atributo draggable en true
                //position pondremos las mismas coordenas que obtuvimos en la geolocalización
                marker = new google.maps.Marker({
                    map: map,
                    icon: '{{url('/images/icon-maps/pin4.png')}}',
                    title: item.direccion,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: new google.maps.LatLng(item.latitud, item.longitud),
                });

                marker.addListener('click', function () {
                    infowindow.open(map, this);
                });

                marcadores.push(marker);

            });

            var bounds = new google.maps.LatLngBounds();

            marcadores.forEach(item => {
                bounds.extend(new google.maps.LatLng(item.position.lat(), item.position.lng()));
            });

            map.fitBounds(bounds);
        });
        axios.get('{{url('servicio/getServiciosPorEntregarJSON')}}').then(resonse => {
            const data = resonse.data;
            data.forEach(item => {

                const ruta = '{{url('servicio/entregarServicio')}}/' + item.id;

                var contentString = `<div class="contenedor">
                                        <div class="message">
                                                <h1>${item.cliente_nombre}</h1>
                                                <a href="tel:${item.cliente_telefono}" class="telefono">${item.cliente_telefono}</a>
                                                <p>${item.direccion}</p>
                                                <p style="width : 100%">${item.num_lavadoras} lavadora(s)</p>
                                                  <div style="width : 100%; margin-bottom: 10px;">
                                                   <a href="${ruta}" class="btn btn-success pull-right">Entregar Servicio</a>
                                                 </div>
                                                <h1>Servicio por Entregar</h1>
                                        </div>
                                   </div>`;

                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                //Creamos el marcador en el mapa con sus propiedades
                //para nuestro obetivo tenemos que poner el atributo draggable en true
                //position pondremos las mismas coordenas que obtuvimos en la geolocalización
                marker = new google.maps.Marker({
                    map: map,
                    icon: '{{url('/images/icon-maps/pin10.png')}}',
                    title: item.direccion,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: new google.maps.LatLng(item.latitud, item.longitud),
                });

                marker.addListener('click', function () {
                    infowindow.open(map, this);
                });

                marcadores.push(marker);

            });
            var bounds = new google.maps.LatLngBounds();

            marcadores.forEach(item => {
                bounds.extend(new google.maps.LatLng(item.position.lat(), item.position.lng()));
            });

            map.fitBounds(bounds);
        });
        axios.get('{{url('servicio/getServiciosEntregadosJSON')}}').then(resonse => {
            const data = resonse.data;
            data.forEach(item => {

                var contentString = `<div class="contenedor">
                                        <div class="message">
                                                <h1>${item.cliente_nombre}</h1>
                                                <a href="tel:${item.cliente_telefono}" class="telefono">${item.cliente_telefono}</a>
                                                <p>${item.direccion}</p>
                                                <p style="width : 100%">${item.num_lavadoras} lavadora(s)</p>
                                                <h1>En servicio...</h1>
                                        </div>
                                   </div>`;

                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                //Creamos el marcador en el mapa con sus propiedades
                //para nuestro obetivo tenemos que poner el atributo draggable en true
                //position pondremos las mismas coordenas que obtuvimos en la geolocalización
                marker = new google.maps.Marker({
                    map: map,
                    icon: '{{url('/images/icon-maps/pin8.png')}}',
                    title: item.direccion,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: new google.maps.LatLng(item.latitud, item.longitud),
                });

                marker.addListener('click', function () {
                    infowindow.open(map, this);
                });

                marcadores.push(marker);

            });
            var bounds = new google.maps.LatLngBounds();

            marcadores.forEach(item => {
                bounds.extend(new google.maps.LatLng(item.position.lat(), item.position.lng()));
            });

            map.fitBounds(bounds);
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
            icon: '{{url('/images/icon-maps/pin1.png')}}',
        });

        marcadores.push(marker);

        marker.setAnimation(google.maps.Animation.BOUNCE);

        //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica
        //cuando el usuario a soltado el marcador
        marker.addListener('click', function () {
            if (this.getAnimation() !== null) {
                this.setAnimation(null);
            } else {
                this.setAnimation(google.maps.Animation.BOUNCE);
            }
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
</body>
</html>


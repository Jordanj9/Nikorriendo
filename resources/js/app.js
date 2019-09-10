/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var base_url = 'http://localhost/Proyectos/Nikorriendo/public/';

//window.Vue = require('vue');

//
//import Echo from 'laravel-echo';
//import swal from 'sweetalert';
//import axios from 'axios';
//
//window.Pusher = require('pusher-js');
//
//window.Echo = new Echo({
//    broadcaster: 'pusher',
//    key: process.env.MIX_PUSHER_APP_KEY,
//    wsHost: window.location.hostname,
//    wsPort: 6001,
//    disableStats: true,
//});
//
//window.Echo.channel('new-service')
//    .listen('NewService', (data) => {
//        let audio = new Audio();
//        audio.src = base_url+'audio/audio1.mp3';
//        audio.play();
//        swal({
//            title: "Nuevo Servicio",
//            text: `${data.servicio.direccion} - #lavadoras:${data.servicio.num_lavadoras}`,
//            icon: "info",
//            buttons: {
//                aceptar: {
//                    text: "Aceptar",
//                    value: "aceptar",
//                },
//                cancel: "Ignorar"
//            }
//        }).then((result) => {
//            console.log(result);
//            if (result == 'aceptar') {
//                const url = base_url+'servicio/aceptar_servicioJSON/' + data.servicio.id;
//                axios.get(url).then(response => {
//                    let data = response.data;
//                    swal(data.message);
//                });
//            }
//        });
//    });






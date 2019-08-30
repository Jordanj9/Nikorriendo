/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');

import Echo from 'laravel-echo';
import swal from 'sweetalert';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort:6001,
    disableStats: true,
});

window.Echo.channel('new-service')
    .listen('NewService', (data) => {
        let audio = new Audio();
        audio.src = '../audio1.mp3';
        audio.play();
        swal('hola');
    });






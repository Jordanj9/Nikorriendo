/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');

import Push from 'push.js'

Push.Permission.request(onGranted, onDenied);

window.Echo.channel('new-service')
    .listen('NewService', (data) => {
       const notifications  =  document.querySelector('.notifications-menu .dropdown-menu .header');
       notifications.innerText =  data.servicio.direccion;

        Push.create("nuevo servicio!", {
            body: `Dirección: ${data.servicio.direccion} - #Lavadoras: ${data.servicio.num_lavadoras}`,
            timeout: 2000,
            onClick: function () {
                window.focus();
                this.close();
            }
        });

});

function onGranted() {
}
function onDenied() {
}

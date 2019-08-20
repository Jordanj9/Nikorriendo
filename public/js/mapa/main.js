 var map;
 //var geo = new Geocoding('AIzaSyACMXJBl7W2A6fYConiB7bfeCkKuNusyyo');
 let btn_search = document.querySelector('.btn-search');
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

    //agregamos la funcionalidad de autocompletar las direcciones al input
    const autocomplete =  document.querySelector('.input input');
    const search =  new google.maps.places.Autocomplete(autocomplete);
    search.bindTo("bounds",map);

  //Creamos el marcador en el mapa con sus propiedades
  //para nuestro obetivo tenemos que poner el atributo draggable en true
  //position pondremos las mismas coordenas que obtuvimos en la geolocalización
  marker = new google.maps.Marker({
      map: map,
      draggable: true,
      animation: google.maps.Animation.DROP,
      position: new google.maps.LatLng(coords.lat, coords.lng),

  });

  marcadores.push(marker);

          //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica
        //cuando el usuario a soltado el marcador
        marker.addListener('click', toggleBounce);
        marker.addListener('dragend', function (event)
        {
            //escribimos las coordenadas de la posicion actual del marcador dentro del input #coord'
            document.getElementById('latitud').value=this.getPosition().lat();
            document.getElementById('longitud').value=this.getPosition().lng();

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


document.addEventListener('DOMContentLoaded',function(){

    initMap();

    //se convierte la direccion en coordenadas para luego mostrarlas en el mapa con el api de geocoding de google
    btn_search.addEventListener('click',event => {
        event.preventDefault();
        const input =  document.querySelector('.input input');

        geo.getLatLng(input.value)
        .then(response => {

          const location = response.results[0].geometry.location;


          marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: new google.maps.LatLng(location.lat, location.lng)

        });

         //escribimos las coordenadas de la posicion actual del marcador dentro del input #coord'
         document.getElementById('latitud').value=location.lat;
         document.getElementById('longitud').value=location.lng;


        if(marcadores.length > 1){
            marcadores[1].setMap(null);
            marcadores.pop();
            marcadores.push(marker);
        }else{
            marcadores.push(marker);
        }

        var bounds = new google.maps.LatLngBounds();
        bounds.extend(new google.maps.LatLng(location.lat, location.lng));
        bounds.extend(new google.maps.LatLng(coords.lat, coords.lng));
        map.fitBounds(bounds);


        console.log(marker);

        });
    });



});




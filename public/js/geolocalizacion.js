/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

		function findMe(){
			//Obtenemos latitud y longitud
			function localizacion(posicion){
				var latitude = posicion.coords.latitude;
				var longitude = posicion.coords.longitude;
                                document.getElementById('lat').value = latitude;
                                document.getElementById('long').value = longitude;
                                fetch("https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat="+latitude+"&lon="+longitude+"")
                                    .then(function(response) {
                                        // Si todo sale bien en la promesa se devuelve el json de la respuesta
                                        return response.json();
                                    })
                                    .then(function(myJson) {
                                        console.log(myJson.address.postcode);
                                        document.getElementById('codigo').value = myJson.address.postcode;
                                    });
                                
        var vMarker
        var map
            map = new google.maps.Map(document.getElementById('mapa'), {
                zoom: 14,
                center: new google.maps.LatLng(latitude, longitude),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            vMarker = new google.maps.Marker({
                position: new google.maps.LatLng(latitude, longitude),
                draggable: true
            });
            google.maps.event.addListener(vMarker, 'dragend', function (evt) {
                $("#lat").val(evt.latLng.lat().toFixed(6));
                $("#long").val(evt.latLng.lng().toFixed(6));
                
                fetch("https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat="+evt.latLng.lat()+"&lon="+evt.latLng.lng()+"")
                .then(function(response) {
                    // Si todo sale bien en la promesa se devuelve el json de la respuesta
                    return response.json();
                })
                .then(function(myJson) {
                    console.log(myJson.address.postcode);
                    document.getElementById('codigo').value = myJson.address.postcode;
                })

                map.panTo(evt.latLng);
            });
            map.setCenter(vMarker.position);
            vMarker.setMap(map);
			}
                navigator.geolocation.getCurrentPosition(localizacion);
		}
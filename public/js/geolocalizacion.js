/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

		function findMe(){
			var mapa = document.getElementById('mapa');
                        
			// Verificar si soporta geolocalizacion
//			if (navigator.geolocation) {
//				output.innerHTML = "<p>Tu navegador soporta Geolocalizacion</p>";
//			}else{
//				output.innerHTML = "<p>Tu navegador no soporta Geolocalizacion</p>";
//			}
			//Obtenemos latitud y longitud
			function localizacion(posicion){
				var latitude = posicion.coords.latitude;
				var longitude = posicion.coords.longitude;
                                document.getElementById('lat').value = latitude;
                                document.getElementById('long').value = longitude;
				mapa.innerHTML = "<iframe src='https://maps.google.com/maps?q="+latitude+","+longitude+"&hl=es&z=14&amp;output=embed' width='300' height='200' style='border:0;' ></iframe>";
			}
//			function error(){
//				output.innerHTML = "<p>No se pudo obtener tu ubicación</p>";
//
//			}
			navigator.geolocation.getCurrentPosition(localizacion);
		}
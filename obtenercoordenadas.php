<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBViGAK8QcqvLcl0Pgilw-ENvMhmL88E6A&sensor=true" ></script>
<script type="text/javascript" language="javascript">
function inicializacion() {
     //Creo un nuevo mapa situado en Buenos Aires, Argentina, con 13 de Zoom y del tipo ROADMAP
     var mapa = new google.maps.Map(document.getElementById("mapa"),{center: new google.maps.LatLng(8.130524, -71.980326),zoom: 16,mapTypeId: google.maps.MapTypeId.HYBRID});

     //Creo un evento asociado a "mapa" cuando se hace "click" sobre el
     google.maps.event.addListener(mapa, "click", function(evento) {
     //Obtengo las coordenadas separadas
     var latitud = evento.latLng.lat();
     var longitud = evento.latLng.lng();

     //Puedo unirlas en una unica variable si asi lo prefiero
     var coordenadas = evento.latLng.lat() + ", " + evento.latLng.lng();

    //Las muestro con un popup
     alert(coordenadas);

     //Creo un marcador utilizando las coordenadas obtenidas y almacenadas por separado en "latitud" y "longitud"
     var coordenadas = new google.maps.LatLng(latitud, longitud); /* Debo crear un punto geografico utilizando google.maps.LatLng */
     var marcador = new google.maps.Marker({position: coordenadas,map: mapa, animation: google.maps.Animation.DROP, title:"Un marcador cualquiera"});
     }); //Fin del evento
} // Fin inicializacion()
</script>
</head>

<body onload="inicializacion()">
<div id="mapa" style="width:1100px; height:640px; background:#999;">

</div>
</body>
</html>
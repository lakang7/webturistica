<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Prueba</title>
		
    <link rel="stylesheet" href="../css/administracion/estructura.css" type="text/css"  />
	<link rel="stylesheet" type="text/css" href="../css/administracion/component.css" />
	<link rel="stylesheet" type="text/css" href="../css/administracion/default.css" />    
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css' />       
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	
	<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBViGAK8QcqvLcl0Pgilw-ENvMhmL88E6A&sensor=true"></script>
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js" ></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" ></script>    
    <script src="../js/administracion/modernizr.custom.js"></script>
    <script src="../js/administracion/jquery.dlmenu.js"></script>    
    <script type="text/javascript">  
		//Funcion para validar campo de texto, que NO permita ni campo vacío ni introducir solo espacios en blanco
		function validarCampo(formulario) {
        	//obteniendo el valor que se puso en el campo texto del formulario
        	miCampoTexto = formulario.nombre.value;
        	//la condición
        	if (miCampoTexto.length == 0) {
				alert("Debe indicar el nombre de la categoría que desea registrar");
            	return false;
        	}
			else if(/^\s+$/.test(miCampoTexto)){
				alert("El nombre de la categoría no puede quedar en blanco, ingrese un nombre válido");
            	return false;
			}
        	return true;
	    }
		/*FUNCION PARA INICIALIZAR UN MAPA, PONER UN SOLO MARCADOR Y QUE SEA DRAGGABLE*/
		function inicializacion() {
			//Creo un nuevo mapa situado en Buenos Aires, Argentina, con 13 de Zoom y del tipo ROADMAP
			var mapa = new google.maps.Map(document.getElementById("map_canvas"),{center: new google.maps.LatLng(8.1310,-71.9813),zoom: 17,mapTypeId: google.maps.MapTypeId.HYBRID});
	
			//Creo un marcador cualquiera situado en una coordenada cualquiera, con la propiedad "draggable" como "true".
			var marcador = new google.maps.Marker({position: new google.maps.LatLng(8.1310,-71.9813),map: mapa, animation: google.maps.Animation.DROP, draggable: true, title:"Arrastre el marcador hasta la ubicación del punto de la ruta y presione el botón \"Guardar punto\""});
		
			
			google.maps.event.addListener(marcador, "dragend", function(evento) {
				//Obtengo las coordenadas separadas
				var latitud = evento.latLng.lat();
				var longitud = evento.latLng.lng();
				//Puedo unirlas en una unica variable si asi lo prefiero
				var coordenadas = evento.latLng.lat() + ", " + evento.latLng.lng();
				//Las muestro con un popup
				//alert(coordenadas);
			}); //Fin del evento
			
		} // Fin inicializacion()
		
		
		/*-------------------------------------------------------------------------------------------------------------------
		*                                    OOOOOOOOOOOOOOOJJJJJJJJJJJJJJJJJOOOOOOOOOOOOOOOOOOOOOO
		-------------------------------------------------------------------------------------------------------------------*/
		function inicializacion2() {
     	     //Se crea un nuevo mapa situado en La Grita
	         var mapa = new google.maps.Map(document.getElementById("map_canvas"),{center: new google.maps.LatLng(8.1310,-71.9813),zoom: 17,mapTypeId: google.maps.MapTypeId.HYBRID});

     	 	//Se crea un evento asociado a "mapa" cuando se hace "click" sobre el
		    google.maps.event.addListener(mapa, "click", function(evento) {
    	 	 
			 	//Se obtienen las coordenadas por separado
			     var latitud = evento.latLng.lat();
    			 var longitud = evento.latLng.lng();
		
			     //Se pueden unir en una unica variable
    			 var coordenadas = evento.latLng.lat() + ", " + evento.latLng.lng();

			     //Se cargan las coordenadas en los campos de texto
				 document.getElementById("latitud").value = latitud;
				 document.getElementById("longitud").value = longitud;
    			 //alert(coordenadas);

	    		 /*Se crea un marcador usando las coordenadas obtenidas y almacenadas por separado en "latitud" y "longitud"
					/* (para ello se debe crear un punto geografico utilizando google.maps.LatLng) */
		    	 var coordenadas = new google.maps.LatLng(latitud, longitud); 
			     var marcador = new google.maps.Marker({position: coordenadas,map: mapa, animation: google.maps.Animation.DROP, title:""});
     		}); //Fin del evento click
		} // Fin inicializacion()	
	</script>
	
	
	
	
	
	
	
	<script type="text/javascript">
    function imagepopup(ruta){
        // Añade la imagen
		document.getElementById("divpopup").innerHTML="<img src='/imagenes/sitios/galeria/fotogaleria_37_peq_Posada Los Morochos.jpg' width='100'><br><a href="#" onclick="ocultardiv()">Cerrar</a>";	 		//Muestra el div
        document.getElementById("divpopup").style.display="block"; 
    }
    function ocultardiv(){
		//Oculta el div
         document.getElementById("divpopup").style.display="none"; 
    }
	</script>
</head>

<?php
	if(isset($_POST["Guardar"])){
		//if(validaEmail("correo@gmail.com")){ 			
			/*
			//Probando borrar DOS archivos de una ruta, que estan llamados igual pero con un inicio distinto GRANDE_ y PEQUE_
			$loBorro = borrarArchivo("../imagenes/sitios/galeria/Grande_1_Aldea Quintanera Grande.jpg");
			$ruta = str_replace("Grande_", "Peque_", "../imagenes/sitios/galeria/Grande_1_Aldea Quintanera Grande.jpg");
			$loBorro = borrarArchivo($ruta);*/				
		/*}
		else{
			?><script language="JavaScript" type="text/javascript">
				alert("EMAIL INVALIDO");
			</script><?php
		}*/
	}
?>
<body onload="cargo(),inicializacion()">
	<div class="banner">
	</div>
    <div class="menu"><?php menu_administrativo(); ?></div>
    <div class="panel">
    	<div class="titulo_panel">Crear Categoría</div>
        <div class="opcion_panel">
	        <div class="opcion"><a href="listadocategorias.php">Listar Categorías</a></div>
        	<div class="opcion" style="background:#F00; color:#FFF;"><a href="crearcategorias.php">Registrar Nueva Categoría</a></div>
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
				<div class="linea_formulario"></div>
				<div class="linea_formulario"></div>
				<div class="linea_formulario"></div>
            	<div id="map_canvas" style="width:70%; height:280px; margin-left:auto; margin-right:auto" align="center"></div>
				<div class="linea_formulario">
	              <input type="submit" value="Guardar" name="Guardar" style="font-size:12px;" />
                </div>
            </form>
        </div>
        
    </div>
    <div class="pie"></div>
</body>

<script>  			
	$(function() {
		$( '#dl-menu' ).dlmenu({
			animationClasses : { classin : 'dl-animate-in-2', classout : 'dl-animate-out-2' }
		});
	});
		 
	function cargo(){
		$("#dl-trigger").trigger("click");	
	}
</script>
</html>
<?php session_start();
	  require("../recursos/funciones.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Crear Rutas</title>
		
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
	
		/*********************************************************************************************
		*
			Funcion para validar campo de texto, que NO permita ni campo vacío ni introducir solo 
			espacios en blanco
		*
		**********************************************************************************************/
		function validarCampo(formulario) {
        	//obteniendo el valor que se puso en el campo texto del formulario
        	campoNombre = formulario.nombre.value;
			campoResena = formulario.resena.value;
			
        	//la condición
        	if (campoNombre.length == 0 || campoResena.length == 0) {
				alert("Es necesario completar todos los campos marcados como obligatorios (*)");
            	return false;
        	}
			else if(/^\s+$/.test(campoNombre) || /^\s+$/.test(campoResena)){
				alert("Ningún campo obligatorio (*) puede quedar en blanco, ingrese valores válidos");
            	return false;
			}			
			
        	return true;
	    }		
		/*********************************************************************************************
		*
			FUNCION PARA INICIALIZAR EL MAPA, se debe llamar en el onload() de la página
		*
		**********************************************************************************************/
      	function inicializacion() {
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
</head>

<?php
	if(isset($_POST["Guardar"])){
		
		$con = conectarse();
		
		/*Se consulta la existencia de otra RUTA con el mismo nombre*/
		$sql = "SELECT * FROM ruta ORDER BY idruta";
		$res = pg_exec($con, $sql);	
		$yaExiste = 0;
					
		if(pg_num_rows($res)>0){
			for($i=0; $i<pg_num_rows($res); $i++){				
				$ruta = pg_fetch_array($res,$i);	
				$nombreRuta = $ruta[1];
				
				/*Si efectivamente ya existe esa especialidad, no se le permite crearla*/
				if($nombreRuta==$_POST["nombre"]){
					$yaExiste = 1;
					?>
		        	<script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!! \n\n     Esa ruta ya existe, por favor ingrese otro nombre");
						location.href = "../administracion/crearutas.php";
					</script>
       				<?php
				}
			}
		}
				
		/*Si NO existe, se crea*/
		if($yaExiste==0){
			$sql_insert = "INSERT INTO ruta VALUES(nextval('ruta_idruta_seq'),'".$_POST['nombre']."','".$_POST['resena']."');";
			$result_insert = pg_exec($con,$sql_insert);
			
			if(!$result_insert){
				?>
        		<script type="text/javascript" language="javascript">
					alert("ERROR: No se pudo crear la ruta");
					location.href="../administracion/listadorutas.php";
				</script>
    	    	<?php	
			}else{	
				?>
	        	<script type="text/javascript" language="javascript">
					alert("¡¡¡ Ruta agregada satisfactoriamente !!!");
					location.href="../administracion/listadorutas.php";
				</script>
	        	<?php	
			}		
		}				
	}
?>

<body onload="cargo(),inicializacion()">
	<div class="banner">        
    </div>
    <div class="menu">    				
		<?php menu_administrativo();  ?>		                       
    </div>
    <div class="panel">
    	<div class="titulo_panel">Crear Rutas</div>
        <div class="opcion_panel">
	        <div class="opcion"> 
				<a href="listadorutas.php">Listar Rutas</a>
			</div>
        	<div class="opcion" style="background:#F00; color:#FFF;">
				<a href="crearutas.php">Registrar Nueva Ruta</a>
			</div>
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
            	<div class="linea_formulario">
                	<div class="linea_titulo_2">Información Básica de la Ruta</div>                    
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Nombre (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="nombre" name="nombre" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Reseña Histórica</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="resena" name="resena" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo_2">Puntos de la ruta</div>                    
                </div>
				<div class="linea_formulario"></div>
				<div id="map_canvas" style="width:70%; height:280px; margin-left:auto; margin-right:auto" align="center"></div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido_rojo">Busque el punto de la ruta en el mapa y haga</div>
                    <div class="linea_titulo_compartido_rojo">clic en él para cargar las coordenadas</div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Latitud (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="latitud" name="latitud" maxlength="200"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Longitud (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="longitud" name="longitud" maxlength="200"/>
                    </div>
                </div>
            	<div class="linea_formulario">
					<div class="linea_titulo_rojo">
						<input type="submit" value="Guardar ruta" name="Guardar" style="font-size:12px;" align="left"/>(*) Campos obligatorios
					</div>					
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
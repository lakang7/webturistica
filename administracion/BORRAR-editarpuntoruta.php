<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Editar Puntos de Ruta</title>
		
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
	
	<script src="../js/mootools.1.2.3.js"></script>
	<script src="../js/administracion/sombrear_fila_tabla.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/administracion/sombrear_fila_tabla.css" />
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js" ></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" ></script>    
    <script src="../js/administracion/modernizr.custom.js"></script>
    <script src="../js/administracion/jquery.dlmenu.js"></script>    
	<script src="../js/administracion/funcionesJS.js"></script>   
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
			campoLatitud = formulario.latitud.value;
			campoLongitud = formulario.longitud.value;
			campoResena = formulario.resena.value;
			
			if(campoResena.length>1200){
				alert("Campo reseña es más largo de lo permitido (1200 caracteres) por favor redúzcalo e inténtelo de nuevo");
            	return false;
			}
        	if (campoNombre.length == 0 || campoLatitud.length == 0 || campoLongitud.length == 0) {
				alert("Es necesario completar todos los campos marcados como obligatorios (*)");
            	return false;
        	}
			else if(/^\s+$/.test(campoNombre) || (/^\s+$/.test(campoLatitud)) || (/^\s+$/.test(campoLongitud))){
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
			//Se crea mapa ubicado en La Grita - Táchira - Venezuela, con 17 de Zoom y del tipo HYBRID
			var mapa = new google.maps.Map(document.getElementById("map_canvas"),{center: new google.maps.LatLng(8.131437081366755,-71.97978583068846),zoom: 17,mapTypeId: google.maps.MapTypeId.HYBRID});
	
			//Se crea un marcador allí mismo, con la propiedad "draggable" como "true" para que se pueda arrastrar
			var marcador = new google.maps.Marker({position: new google.maps.LatLng(8.131437081366755,-71.97978583068846),map: mapa, animation: google.maps.Animation.DROP, draggable: true, title:"Arrastre el marcador hasta la ubicación del punto de la ruta y presione el botón \"Guardar punto\""});				
			google.maps.event.addListener(marcador, "dragend", function(evento) {
				//Se obtienen las coordenadas finales del moovimiento
				var latitud = evento.latLng.lat();
				var longitud = evento.latLng.lng();
				//Puedo unirlas en una unica variable si asi lo prefiero
				//var coordenadas = evento.latLng.lat() + ", " + evento.latLng.lng();
				document.getElementById("latitud").value = latitud;
				document.getElementById("longitud").value = longitud;
			}); //Fin del evento
			
		} // Fin inicializacion()
		/*********************************************************************************************
		*
			Funcion para validar SOLO NUMEROS en un campo determinado
		*
		**********************************************************************************************/
		$(function(){

			//Para escribir solo numeros	
    		$('#latitud').funcionesJS('0123456789.');
			$('#longitud').funcionesJS('0123456789.');
    	});
	</script>
</head>

<?php
	if(isset($_POST["GuardarPuntoRuta"])){
		$con = conectarse();
		$sql_insert = "INSERT INTO punto_ruta VALUES(nextval('punto_ruta_idpunto_ruta_seq'),'".$_GET["idRuta"]."','".$_POST["latitud"]."','".$_POST["longitud"]."',null,'','".$_POST["resena"]."');";
		$result_insert = pg_exec($con,$sql_insert);	
				
		//Si NO se pudo insertar en la tabla el nuevo registro
		if(!$result_insert){
			?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ERROR !!! No se pudo guardar el punto de la ruta");
				location.href="../administracion/crearpuntoruta.php?idRuta="+<?php echo $_GET["idRuta"];?>;
			</script><?php	
		}else{
			/*Se guarda en la variable oculta HidRuta el id de la ruta recien creada*/
			$sql_select = "SELECT last_value FROM punto_ruta_idpunto_ruta_seq;";
			$result_select = pg_exec($con, $sql_select);
			$arreglo = pg_fetch_array($result_select,0);
				
			$sql_select_pr = "SELECT * FROM punto_ruta WHERE idpunto_ruta='".$arreglo[0]."';";
			$result_select_pr = pg_exec($con, $sql_select_pr);
			$pr = pg_fetch_array($result_select_pr,0);
				
			$sql_select_ruta = "SELECT * FROM ruta WHERE idruta='".$_GET["idRuta"]."';";
			$result_select_ruta = pg_exec($con, $sql_select_ruta);
			$ruta = pg_fetch_array($result_select_ruta,0);
				
			if($_FILES['foto']['name']!=""){					
				/*Si SI se pudo, se sube la foto a la carpeta respectiva*/
				$subir = new imgUpldr;	
				$subir->configurar($ruta["idruta"]."_".$ruta["nombre"]."_Punto_".$arreglo[0],"../imagenes/rutas/puntos/",591,591);
				$subir->init($_FILES['foto']);
				$destino = "imagenes/rutas/puntos/".$subir->_name;

				/*Se actualiza el registro para incluir la ruta del icono que se acaba de subir*/
				$sql_update = "UPDATE punto_ruta SET foto_portada='".$destino."' WHERE idpunto_ruta='".$arreglo[0]."'";
				$result_update = pg_exec($con, $sql_update);	
			
				if(!$result_update){
					?><script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!!\n\n     No se pudo guardar la foto del punto");
						location.href="../administracion/listadorutas.php";
					</script><?php	
		    	}
			}
			?><script type="text/javascript" language="javascript">
				alert("¡¡¡ Punto de Ruta agregado satisfactoriamente !!!")
				location.href="../administracion/crearpuntoruta.php?idRuta="+<?php echo $_GET["idRuta"]; ?>;
			</script><?php
		}
	}
	
	if(isset($_POST["Finalizar"])){
		$con = conectarse();
		/**/
		$sql_select = "SELECT * FROM punto_ruta WHERE idruta=".$_GET["idRuta"].";";
		$result_select = pg_exec($con, $sql_select);
		
		if(pg_num_rows($result_select)>0){
			/*Se recorren todos los puntos de esa ruta para ir guardando cada secuencia (campo NRO_SECUENCIA de la bd)*/
			for($i=0;$i<pg_num_rows($result_select);$i++){
				$punto_ruta = pg_fetch_array($result_select,$i);	
				/*Se revisa cada campo de texto, fila por fila para traer ese valor y guardarlo, si es != de vacio y numerico...*/
				$var = "pr".$punto_ruta["idpunto_ruta"];
				/*Es OBLIGATORIO el nro de secuencia para poder finalizar la creacion del pto ruta*/
				if($_POST[$var]!="" && is_numeric($_POST[$var])){
					/*Se procede a hacer el respectivo UPDATE*/
					$sql_update = "UPDATE punto_ruta SET nro_secuencia=".$_POST[$var]." WHERE idpunto_ruta=".$punto_ruta["idpunto_ruta"];
					$result_update = pg_exec($con, $sql_update);	
			
					if(!$result_update){
						?><script type="text/javascript" language="javascript">
							alert("¡¡¡ ERROR !!!\n\n     No se pudo guardar el número de secuencia del punto");
							location.href="../administracion/crearpuntoruta.php?idRuta="+<?php echo $_GET["idRuta"]; ?>;
						</script><?php	
			    	}
				}
			}
			?><script type="text/javascript" language="javascript">
				alert("¡¡¡ Punto culminado satisfactoriamente !!!");
				location.href = "../administracion/listadorutas.php";
			</script><?php
		}
	}
?>

<body onload="cargo(),inicializacion()">
	<div class="banner"></div>
    <div class="menu">
		<?php menu_administrativo(); 
		$con = conectarse();
		/*Se consultan los datos de la ruta para cargar los campos respectivos*/
		$sql_ruta = "SELECT * FROM ruta WHERE idruta=".$_GET["idRuta"];
		$res_ruta = pg_exec($con, $sql_ruta);	
		if(pg_num_rows($res_ruta)>0){
			$ruta = pg_fetch_array($res_ruta,0);
		}				
		/*Se consultan los datos del PUNTOruta para cargar los campos respectivos*/
		$sql = "SELECT * FROM punto_ruta WHERE idruta=".$_GET["idRuta"]." AND idpunto_ruta=".$_GET["idpunto_ruta"];
		$res = pg_exec($con, $sql);	
		if(pg_num_rows($res)>0){
			$puntoruta = pg_fetch_array($res,0);
		}
		?>
	</div>
    <div class="panel">
    	<div class="titulo_panel">Editar Punto de "<?php echo $ruta["nombre"]; ?>"</div>
        <div class="opcion_panel">
	        <div class="opcion"><a href="listadorutas.php">Listar Rutas</a></div>
        	<div class="opcion" style="background:#F00; color:#FFF;"><a href="crearuta.php" style="text-decoration:none; color:#FFF;">Registrar Nueva Ruta</a></div>
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
            	<div class="linea_formulario">
        	       	<div class="linea_titulo_rojo">Para editar los puntos de la ruta realice los siguientes pasos:</div>
				</div>
				<div class="linea_formulario">
					<div class="linea_titulo">- PASO 1: Para modificar latitud y longitud, arrastre el marcador en el mapa hasta la nueva ubicación e ingrese los campos que desee modificar (nombre, reseña)</div>
				</div>
				<div class="linea_formulario">
					<div class="linea_titulo">- PASO 2: Si ya terminó de hacer las modificaciones, haga clic en "Guardar punto"</div>
				</div>	
				<div class="linea_formulario"></div>
				<div id="map_canvas" style="width:70%; height:250px; margin-left:auto; margin-right:auto" align="center"></div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Nombre (*)</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="nombre" name="nombre" maxlength="100" value="<?php echo $puntoruta["nombre"]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Latitud (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="latitud" name="latitud" maxlength="20" value="<?php echo $puntoruta["latitud"]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Longitud (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="longitud" name="longitud" maxlength="20" value="<?php echo $puntoruta["longitud"]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio_rojo"></div>
                    <div class="linea_titulo_promedio_rojo">(*) Campos obligatorios</div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Reseña</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="resena" name="resena" maxlength="1200" value="<?php echo $puntoruta["resena"]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario"></div>
				<div class="linea_formulario">
                	<div class="linea_titulo_2">Vista Previa de Foto de Portada</div>                    
                </div>
				<div class="capa_tabla_fotos">
		        	<table class="estilo_tabla">
        		    	<thead></thead>
		                <tbody>
			                <?php
							/*Si el punto tiene cargada una imagen, se muestra, sino se muestra mensaje de NO HAY*/
							if($puntoruta["foto_portada"]==""){?>
								<tr align="center">
									<td>No hay fotografía para este punto</td>
								</tr>
								<?php 
							}
							else{?>
								<tr align="center">
									<td><img src="../<?php echo $puntoruta["foto_portada"]; ?>"></td>
								</tr><?php						
							}
							?>					               
        	        	</tbody>
            		</table>
	       		</div> 
				<div class="linea_formulario_tres_cuartos">
					<div class="linea_titulo_tres_cuartos">Cambiar Foto de portada</div>
                	<div class="linea_titulo_tres_cuartos"><input name="foto" type="file" id="icono"/></div>	
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio"></div>
                    <div class="linea_campo_promedio">
                    	<input type="submit" value="Guardar punto" name="GuardarPuntoRuta" style="font-size:12px;" align="left"/>
                    </div>
                </div>
				<div class="linea_formulario"></div>			
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
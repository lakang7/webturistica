<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Puntos de Ruta</title>
		
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
			Funcion para preguntar si esta seguro de eliminar un registro ANTES de proceder a eliminarlo realmente
		*
		**********************************************************************************************/
	    function confirmar(url){ 
			if (!confirm("¿Está seguro de que desea eliminar el registro? Presione ACEPTAR para eliminarlo o CANCELAR para volver al listado")){ 
				return false; 
		    }else{ 
				document.location=url; 
				return true; 
			} 
		} 	
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
			<?php 
			$con = conectarse();
			$sql = "SELECT * FROM punto_ruta WHERE idruta=".$_GET["idRuta"];		
			$res = pg_exec($con, $sql);
			
			if(pg_num_rows($res)>0){
				//$ruta = pg_fetch_array($res,$i);	
								
				for($i=0;$i<pg_num_rows($res);$i++){
					$punto_ruta = pg_fetch_array($res,$i);
					
					?>
					$('#sec-<?php echo $i; ?>').funcionesJS('0123456789');
					<?php
				}
			}				
			?>
    	});
		/*********************************************************************************************
		*
			Funcion para mostrar imagen en un POPUP
		*
		**********************************************************************************************/
		function openPopup(imageURL){
    		var popupTitle = "Icono";
    		var newImg = new Image();
    		newImg.src = "../"+imageURL;
 
 			pos_x = (screen.width-newImg.width)/2;
	 	    pos_y = (screen.height-newImg.height)/2;
			
    		popup = window.open(newImg.src,'image','height='+newImg.height+',width='+newImg.width+',left='+pos_x+',top='+pos_y+',toolbar=no, directories=no,status=no,menubar=no,scrollbars=no,resizable=no');

		    with (popup.document){
    	    	writeln('<html><head><title>'+popupTitle+'<\/title><style>body{margin:0px;}<\/style>');
	    	    writeln('<\/head><body onClick="window.close()">');
		        writeln('<img src='+newImg.src+' style="display:block"><\/body><\/html>');
        		close();
		    }
		    popup.focus();
		}
	</script>
</head>

<?php
	if(isset($_POST["GuardarPuntoRuta"])){
		$con = conectarse();
		
		//Primero se verifica que no exista ya este punto_ruta para esta ruta, para no repetir puntos
		$sql_pr = "SELECT * FROM punto_ruta WHERE idruta=".$_GET["idRuta"]." AND nombre='".$_POST["nombre"]."';";
		$res_pr = pg_exec($con, $sql_pr);	
						
		//Si existe no se le permite crearlo
		if(pg_num_rows($res_pr)>0){
			?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ERROR !!! \n\n     Ese punto ya existe para esta ruta, por favor ingrese otro nombre");
				location.href = "../administracion/crearpuntoruta.php?idRuta=<?php echo $_GET["idRuta"];?>"; 
			</script><?php
		}
		//Si no existe, se crea
		else{
			$sql_insert = "INSERT INTO punto_ruta VALUES(nextval('punto_ruta_idpunto_ruta_seq'),'".$_GET["idRuta"]."','".$_POST["nombre"]."','".$_POST["latitud"]."','".$_POST["longitud"]."','','".$_POST["resena"]."',0);";
			$result_insert = pg_exec($con,$sql_insert);	
			
			//Si NO se pudo insertar en la tabla el nuevo registro
			if(!$result_insert){
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ ERROR !!!\n\n     No se pudo guardar el punto de la ruta, inténtelo de nuevo.");
					location.href = "../administracion/crearpuntoruta.php?idRuta=<?php echo $_GET["idRuta"];?>";
				</script><?php	
			}
			//Si se pudo crear el punto_ruta, se agrega la foto			
			else{
				$sql_select = "SELECT last_value FROM punto_ruta_idpunto_ruta_seq;";
				$result_select = pg_exec($con, $sql_select);
				$idpuntoruta = pg_fetch_array($result_select,0);
					
				$sql_select_ruta = "SELECT * FROM ruta WHERE idruta='".$_GET["idRuta"]."';";
				$result_select_ruta = pg_exec($con, $sql_select_ruta);
				$ruta = pg_fetch_array($result_select_ruta,0);
				
				//Si seleccionó foto para el punto de ruta
				if($_FILES['foto']['name']!=""){					
					//Se sube a la carpeta respectiva
					$subir = new imgUpldr;	
					$subir->configurar("Ruta".$ruta["idruta"]."_Punto".$idpuntoruta[0],"../imagenes/rutas/puntos/",500,500);
					$subir->init($_FILES['foto']);
					$destino = "imagenes/rutas/puntos/".$subir->_name;

					//Se actualiza el registro para incluir la ruta del icono que se acaba de subir
					$sql_update = "UPDATE punto_ruta SET foto_portada='".$destino."' WHERE idpunto_ruta='".$idpuntoruta[0]."'";
					$result_update = pg_exec($con, $sql_update);		
					if(!$result_update){
						?><script type="text/javascript" language="javascript">
							alert("¡¡¡ ERROR !!!\n\n     No se pudo guardar la foto del punto");
							location.href = "../administracion/crearpuntoruta.php?idRuta=<?php echo $_GET["idRuta"];?>";
						</script><?php	
		    		}
				}//fin de carga de la foto
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ Punto de Ruta agregado satisfactoriamente !!!")
					location.href = "../administracion/crearpuntoruta.php?idRuta=<?php echo $_GET["idRuta"];?>";
				</script><?php
			}//end del else de que SI pudo crear el punto_ruta
		}
	}//end boton guardar
	
	/*--------------------------------------------------------------------------------------------------------------
	*
	*								FINALIZANDO LA CARGA DE TODOS LOS PUNTOS DE LA RUTA
	*
	--------------------------------------------------------------------------------------------------------------*/
	if(isset($_POST["Finalizar"])){
		$con = conectarse();		
		
		/*Para guardar los nro_secuencia de los puntos de ruta*/
		$sql_pr = "SELECT * FROM punto_ruta WHERE idruta=".$_GET["idRuta"]." ORDER BY idpunto_ruta;";		
		$res_pr = pg_exec($con, $sql_pr);
		
		if(pg_num_rows($res_pr)>0){
			//Se valida que los nros NO se repitan------------------------------------------------------
			$alguno_repite=0;
			for($i=0;$i<pg_num_rows($res_pr);$i++){
				$punto_ruta_i = pg_fetch_array($res_pr,$i);
				for($j=0;$j<pg_num_rows($res_pr);$j++){
					//El nro se repite
					$punto_ruta_j = pg_fetch_array($res_pr,$j);
					if($_POST["sec-".$punto_ruta_i["idpunto_ruta"]]!="" && $_POST["sec-".$punto_ruta_j["idpunto_ruta"]]!=""){
						if($i!=$j && $_POST["sec-".$punto_ruta_i["idpunto_ruta"]]==$_POST["sec-".$punto_ruta_j["idpunto_ruta"]]){
							$alguno_repite=1;
							$i=pg_num_rows($res_pr);
							$j=pg_num_rows($res_pr);
						}						
					}
					else if($_POST["sec-".$punto_ruta_i["idpunto_ruta"]]=="" || $_POST["sec-".$punto_ruta_j["idpunto_ruta"]]==""){
						?><script type="text/javascript" language="javascript">
							alert("¡¡¡ ALERTA !!! \n\n     Ninguno de los campos de número de secuencia pueden estar vacíos");
							location.href = "../administracion/crearpuntoruta.php?idRuta=<?php echo $_GET["idRuta"];?>";
						</script><?php
					}
				}
			}
			if($alguno_repite==1){
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ Alguno(s) de los números secuenciales de puntos de ruta está(n) repetido(s) !!!");
					location.href = "../administracion/crearpuntoruta.php?idRuta=<?php echo $_GET["idRuta"];?>";
				</script><?php
			}
			else{                 
				//Finalmente se valida si los nros siguen una SECUENCIA
				$es_secuencia = 0;			
				
				//Se busca la secuencia de numeros desde 1 hasta pg_num_rows para garantizar la secuencia
				for($j=0; $j<pg_num_rows($res_pr); $j++){
				
					for($i=0; $i<pg_num_rows($res_pr); $i++){
						$punto_ruta = pg_fetch_array($res_pr,$i);
						
						if($_POST["sec-".$punto_ruta["idpunto_ruta"]] == $j+1){
							$es_secuencia++;
							$i=pg_num_rows($res_pr);
						}
						if($i==pg_num_rows($res_pr)-1){
							//Si ya está en la última iteración y nunca encontro el nro, ya NO es secuencia con UN nro que no encuentre
							?><script type="text/javascript" language="javascript">
								alert("¡¡¡ ERROR !!!\n\n     Los números no son secuenciales, debe establecer una secuencia válida");
								location.href = "../administracion/crearpuntoruta.php?idRuta=<?php echo $_GET["idRuta"];?>";
							</script><?php
						}
					}//end if i
				}//end if j
				
				//Si es secuencia, finalmente LE ASIGNA nro_secuencia a cada punto_ruta
				if($es_secuencia==pg_num_rows($res_pr)){
					for($i=0;$i<pg_num_rows($res_pr);$i++){
						$punto_ruta = pg_fetch_array($res_pr,$i);
						$sql_update = "UPDATE punto_ruta SET nro_secuencia='".$_POST["sec-".$punto_ruta["idpunto_ruta"]]."' WHERE idpunto_ruta='".$punto_ruta["idpunto_ruta"]."';";
						$result_update = pg_exec($con,$sql_update);
			
						if(!$result_update){
							?><script type="text/javascript" language="javascript">
								alert("¡¡¡ ERROR !!!\n\n     No se pudieron modificar los puntos de ruta. Inténtelo de nuevo.");
								location.href = "../administracion/crearpuntoruta.php?idRuta=<?php echo $_GET["idRuta"];?>";
							</script><?php
						}
					}//end for
				}
				else{
					//No es secuencia
					?><script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!!\n\n     Los números no son secuenciales, debe establecer una secuencia válida");
						location.href = "../administracion/crearpuntoruta.php?idRuta=<?php echo $_GET["idRuta"];?>";
					</script><?php
				}		
			}//end else	$alguno_repite		
		}//end del if(pg_num_rows($res_pr)>0)
		
		$sql = "SELECT * FROM ruta WHERE idruta=".$_GET["idRuta"];		
		$res = pg_exec($con, $sql);
		if(pg_num_rows($res)>0){
			$ruta = pg_fetch_array($res,0);					
		}
		?><script type="text/javascript" language="javascript">
			var txt = "¡¡¡ Puntos culminados satisfactoriamente para <?php echo $ruta["nombre"]; ?> !!!";
			alert(txt);
			location.href = "../administracion/listadorutas.php";
		</script><?php		
	}
?>

<body onload="cargo(),inicializacion()">
	<div class="banner"></div>
    <div class="menu">
		<?php menu_administrativo(); 
		$con = conectarse();		
		/*Se consultan los datos de la ruta para cargar los campos respectivos*/
		$sql = "SELECT * FROM ruta WHERE idruta=".$_GET["idRuta"];
		$res = pg_exec($con, $sql);	
		if(pg_num_rows($res)>0){
			$ruta = pg_fetch_array($res,0);					
		}
		?>
	</div>
    <div class="panel">
    	<div class="titulo_panel">Puntos para "<?php echo $ruta["nombre"]; ?>"</div>
        <div class="opcion_panel">
	        <div class="opcion"><a href="listadorutas.php">Listar Rutas</a></div>
        	<div class="opcion"><a href="crearuta.php">Registrar Nueva Ruta</a></div>
			<div class="opcion" style="background:#F00; color:#FFF;"><a href="crearpuntoruta.php?idRuta=<?php echo $_GET["idRuta"];?>"  style="text-decoration:none; color:#FFF;">Crear nuevo punto de ruta</a></div>
			
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
            	<div class="linea_formulario">
        	       	<div class="linea_titulo_rojo">Para crear los puntos de la ruta realice los siguientes pasos:</div>
				</div>
				<div class="linea_formulario">
					<div class="linea_titulo">- PASO 1: Arrastre el marcador que se muestra en el mapa hasta la ubicación del punto de la ruta, ingrese nombre, reseña y foto de portada (opcionales), presione "Guardar punto"</div>
				</div>
				<div class="linea_formulario">
					<div class="linea_titulo">- PASO 2: Si ya cargó todos los puntos de la ruta, haga clic en "Finalizar Ruta"</div>
				</div>	
				<div class="linea_formulario"></div>
				<div id="map_canvas" style="width:70%; height:250px; margin-left:auto; margin-right:auto" align="center"></div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Nombre (*)</div>
                    <div class="linea_campo_compartido">
						<input type="text" class="campo_compartido" id="nombre" name="nombre" maxlength="100"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Latitud (*)</div>
                    <div class="linea_campo_promedio">
						<input type="text" class="campo_promedio" id="latitud" name="latitud" maxlength="20" value="8.131437081366"/>
					</div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Longitud (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="longitud" name="longitud" maxlength="20" value="-71.9797858306"/>                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio_rojo">(*) Campos obligatorios</div>
                    <div class="linea_campo_promedio"></div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Reseña</div>
                    <div class="linea_campo">
						<input type="text" class="campo" id="resena" name="resena" maxlength="1200"/>						
                    </div>
                </div>
				<div class="linea_formulario_promedio">
					<div class="linea_titulo_tres_cuartos">Foto de portada</div>
                	<div class="linea_titulo_tres_cuartos"><input name="foto" type="file" id="icono"/></div>	
                </div>
				<div class="linea_formulario_promedio">
					<div class="linea_titulo_tres_cuartos"></div>
                	<div class="linea_titulo_tres_cuartos"></div>	
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio"></div>
                    <div class="linea_campo_promedio"></div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio"></div>
                    <div class="linea_titulo_promedio">
						<input type="submit" class="campo_promedio" value="Guardar punto" name="GuardarPuntoRuta" style="font-size:12px;" align="left"/>
					</div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio"></div>
                    <div class="linea_campo_promedio"></div>
                </div>
				<div class="linea_formulario"></div>		
				<div class="linea_formulario"><div class="linea_titulo_2">Puntos de la ruta</div></div>	
				<div class="linea_formulario">
					<div class="linea_titulo">Antes de hacer clic en "Finalizar ruta" indique en los campos de texto el orden secuencial de los puntos de la ruta</div>
				</div>			
				<div class="capa_tabla_fotos">
        			<table border="0" class="estilo_tabla" id="highlight-table" align="center">
		            	<thead style="background:#F00; color:#FFF;" align="center">
							<tr>
                		    	<td width="40">Nro.</td><td>Nombre</td><td width="100">Latitud</td><td width="100">Longitud</td><td width="300">Reseña del punto</td><td width="40">Ver</td><td width="40">Editar</td><td width="40">Eliminar</td>
		                    </tr>
        		        </thead>
                		<tbody>
							<input type="hidden" name="HidRuta" value="-1" />
			                <?php
							$con = conectarse();
						 	$sql_select = "SELECT * FROM punto_ruta WHERE idruta=".$_GET["idRuta"]." ORDER BY idpunto_ruta";
							$result_select = pg_exec($con,$sql_select);
							$cant_puntos = pg_num_rows($result_select);
				
							if(pg_num_rows($result_select)==0){
								?><tr><td colspan=8 align="center" style="cursor:pointer;">No existen puntos para esta ruta hasta el momento</td></tr><?php
							}
				
							for($i=0;$i<pg_num_rows($result_select);$i++){
							    $punto_ruta = pg_fetch_array($result_select,$i);	
							    ?><tr class="row-<?php echo $i+1; ?>" align="center" style="cursor:pointer;">
									<td width="40">
										<input name="sec-<?php echo $punto_ruta["idpunto_ruta"]; ?>" type="text" size="2" maxlength="2" style="font-size:11px" title="sec-<?php echo $punto_ruta["idpunto_ruta"]; ?>" value=""/>
									</td>
									<td><?php echo $punto_ruta["nombre"]; ?></td>
									<td><?php echo $punto_ruta["latitud"]; ?></td>
									<td><?php echo $punto_ruta["longitud"]; ?></td>
									<td width="50" height="5"><?php echo $punto_ruta["resena"]; ?></td>
									<td title="Ver foto del punto <?php echo $punto_ruta["nombre"]; ?>" align="center" width="25">
										<?php 
										//Si tiene foto el punto, se muestra en un popup
										if($punto_ruta["foto_portada"]!=""){?>
											<a href="#" onclick="openPopup('<? echo $punto_ruta["foto_portada"]; ?>');return false;"><img src="../imagenes/ver.png" width="16" height="16" /></a><?php 
										}else{?>
											<img src="../imagenes/ver.png" width="16" height="16" title="No existe imagen para este punto de ruta"/><?php
										}?>
									</td>
									<td title="Editar <?php echo $punto_ruta["nombre"]; ?>" width="25">
										<a href="editarpuntoruta.php?idpunto_ruta=<?php echo $punto_ruta["idpunto_ruta"]; ?>&idruta=<?php echo $_GET["idRuta"]; ?>"><img src="../imagenes/edit.png" width="16" height="16" /></a></td>
									<td title="Eliminar <?php echo $punto_ruta["nombre"]; ?>" width="25">
										<a href="javascript:;" onClick="confirmar('eliminar.php?clave=11&id=<?php echo $punto_ruta["idpunto_ruta"];?>'); return false;"><img src="../imagenes/delete.png" width="16" height="16" /></a></td>
								</tr><?php
	    		            }?>					               
        	        	</tbody>
	            	</table>	
				</div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio"></div>
                    <div class="linea_campo_promedio">
                    	<input type="submit" value="Finalizar ruta" name="Finalizar" style="font-size:12px;" align="left"/>
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
<?php session_start();
	  require("../recursos/funciones.php");
	  
	  //Variables recibidas en esta pág: $_GET["idSitio"]
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Crear Hospedaje</title>
		
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
	<script src="../js/administracion/funcionesJS.js"></script>   
	
    <script type="text/javascript">  	
		/*********************************************************************************************
		*
			Funcion para validar campo de texto, que NO permita ni campo vacío ni introducir solo espacios en blanco
		*
		**********************************************************************************************/
		function validarCampo(formulario) {
        	//obteniendo el valor que se puso en el campo texto del formulario
        	campoPromServicio = formulario.promedio_servicio.value;
			campoPromUbicacion = formulario.promedio_ubicacion.value;
			campoPromLimpieza = formulario.promedio_limpieza.value;
			campoPromPersonal = formulario.promedio_personal.value;
			campoPromPrecio = formulario.promedio_precio.value;
			
        	if (campoPromServicio.length == 0 || campoPromUbicacion.length == 0 || campoPromLimpieza.length == 0 || campoPromPersonal.length == 0 || campoPromPrecio.length == 0) {
				alert("Es necesario completar todos los campos marcados como obligatorios (*)");
				return false;
        	}
			else if(/^\s+$/.test(campoPromServicio) || (/^\s+$/.test(campoPromUbicacion)) || (/^\s+$/.test(campoPromLimpieza)) || (/^\s+$/.test(campoPromPersonal)) || (/^\s+$/.test(campoPromPrecio))){
				alert("Ningún campo obligatorio puede quedar en blanco, ingrese valores válidos");
            	return false;
			}		
        	return true;
	    }		
		/*********************************************************************************************
		*
			Funcion para validar SOLO NUMEROS o SOLO LETRAS en un campo determinado
		*
		**********************************************************************************************/
		$(function(){

			//Para escribir solo numeros	
    		$('#promedio_servicio').funcionesJS('0123456789.,');
			$('#promedio_ubicacion').funcionesJS('0123456789.,');
			$('#promedio_limpieza').funcionesJS('0123456789.,');
			$('#promedio_personal').funcionesJS('0123456789.,');
			$('#promedio_precio').funcionesJS('0123456789.,');
    	});
		/*********************************************************************************************
		*
			Funcion para guardar en variables ocultas, los checked que están seleccionados
		*
		**********************************************************************************************/
		function guardarChecked(elementoCheck,bandera) {
			
			/*Si bandera es 1, se está llamando para pintar las comodidades*/
			if(bandera==1){
				var variableOculta = "Hid"+elementoCheck;
			}
			/*Si bandera es 2, se está llamando para pintar los check de los tipos de habitación*/
			else if(bandera==2){
				var variableOculta = "Tipo"+elementoCheck;
			}
			
			if(document.all(variableOculta).value == -1){				
				document.all(variableOculta).value = elementoCheck;	
			}
			else{
				document.all(variableOculta).value = -1;
			}			
			//alert(document.all(variableOculta).value);        			
	    }
    </script>
</head>

<?php
	if(isset($_POST["Guardar"])){
	
		$con = conectarse();
		
		//Se calcula el promedio GENERAL entre todos los promedios
		$suma_promedios = $_POST["promedio_servicio"]+$_POST["promedio_ubicacion"]+$_POST["promedio_limpieza"]+$_POST["promedio_personal"]+$_POST["promedio_precio"];
		$promedio_general = $suma_promedios/5;
		
		//Si ya existen registros en HOSPEDAJE correspondientes a ESTE sitio, se deben ACTUALIZAR para evitar registros repetidos de un 
		//mismo sitio
		$sql_sel_hospedaje = "SELECT * FROM hospedaje WHERE idsitio=".$_GET["idSitio"];
		$result_sql_hospedaje = pg_exec($con,$sql_sel_hospedaje);
		
		if(pg_num_rows($result_sql_hospedaje)>0){
			$hospedaje = pg_fetch_array($result_sql_hospedaje,0);
			$idHospedaje = $hospedaje[0];
			$sql_update = "UPDATE hospedaje SET promedio_servicio='".$_POST["promedio_servicio"]."', promedio_ubicacion='".$_POST["promedio_ubicacion"]."', promedio_limpieza='".$_POST["promedio_limpieza"]."', promedio_personal='".$_POST["promedio_personal"]."', promedio_precio='".$_POST["promedio_precio"]."', promedio='".$promedio_general."' WHERE idsitio='".$_GET["idSitio"]."';";
			
			$result_sql_update_hospedaje = pg_exec($con,$sql_update);
			if(!$result_sql_update_hospedaje){
				?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ERROR !!! \n     No se podrá crear el hospedaje, por favor inténtelo de nuevo");
				location.href="crearhospedaje.php?idSitio="+<?php echo $_GET["idSitio"]; ?>;
			</script><?php	
			}		
		}
		
		//Si no existian reg en hospedaje asociados a este sitio, se crean desde CERO
		else{
			/*Se inserta el nuevo registro*/			
			$sql_insert = "INSERT INTO hospedaje VALUES(nextval('hospedaje_idhospedaje_seq'),'".$_GET["idSitio"]."','".$_POST["promedio_servicio"]."','".$_POST["promedio_ubicacion"]."','".$_POST["promedio_limpieza"]."','".$_POST["promedio_personal"]."','".$_POST["promedio_precio"]."','".$promedio_general."');";
			$result_insert = pg_exec($con,$sql_insert);
		
			//Si NO se pudo insertar en la tabla el nuevo registro
			if(!$result_insert){
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ ERROR !!! \n     No se pudieron guardar los promedios");
					location.href="listadositios.php";
				</script><?php	
			}
			
			//Guardo el id del hospedaje recien creado
			$sql_select = "SELECT last_value FROM hospedaje_idhospedaje_seq;";
			$result_select = pg_exec($con, $sql_select);
			$arreglo = pg_fetch_array($result_select,0);
			$idHospedaje = $arreglo[0];
		}
		
		/*---------------------------------------------------------------------------------------------------------------
		*					 
		*										PARA CREAR LAS COMODIDADES DEL SITIO
		*
		---------------------------------------------------------------------------------------------------------------*/
		/*Se consultan las comodidades*/
		$sql_select_comodidad = "SELECT * FROM comodidad";
		$result_select_comodidad = pg_exec($con, $sql_select_comodidad);
				
		/*Si existen, se construye una lista con todas para revisar los checkbox que están seleccionados*/						
		if(pg_num_rows($result_select_comodidad)>0){
			for($i=0; $i<pg_num_rows($result_select_comodidad); $i++){
				$comodidad = pg_fetch_array($result_select_comodidad,$i);
				$idComodidad = $comodidad[0];
				$variableOculta = "Hid".$idComodidad;
					
				//Si la variable oculta es != -1 es porque está seleccionada, entonces...
				if($_POST[$variableOculta] != -1){
						
					/*Se inserta el nuevo registro*/			
					$sql_insert = "INSERT INTO hospedaje_comodidad VALUES(nextval('hospedaje_comodidad_idhospedaje_comodidad_seq'),'".$idHospedaje."','".$idComodidad."');";
					$result_insert = pg_exec($con,$sql_insert);
						
					//Si NO se pudo insertar en la tabla el nuevo registro
					if(!$result_insert){
						?><script type="text/javascript" language="javascript">
							alert("¡¡¡ ERROR !!! \n     No se pudo guardar la comodidad para este sitio de hospedaje");
							location.href="listadositios.php";
						</script><?php
					}
				}//end variable oculta != -1
			}//end for
		}//end if num rows
			
		/*---------------------------------------------------------------------------------------------------------------
		*					
		*										PARA CREAR LOS TIPOS DE HABITACION DEL SITIO
		*
		---------------------------------------------------------------------------------------------------------------*/
		/*Se consultan los tipos de habitacion*/
		$sql_select_tipo = "SELECT * FROM tipo_habitacion";
		$result_select_tipo = pg_exec($con, $sql_select_tipo);
				
		/*Si existen, se construye una lista con todos para revisar los checkbox que están seleccionados*/						
		if(pg_num_rows($result_select_tipo)>0){
			$algunoNoEsNumerico = 0;
			for($i=0; $i<pg_num_rows($result_select_tipo); $i++){
				$tipo = pg_fetch_array($result_select_tipo,$i);
				$idTipo = $tipo[0];
				$variableOculta = "Tipo".$idTipo; //checkbox
				$campoTexto = "txt".$idTipo; //input
					
				//Si la variable oculta es != -1 es porque está seleccionada, entonces...
				if($_POST[$variableOculta] != -1){
						
					/*Si los campos de nro de habitaciones tienen datos y son NUMERICOS, se inserta el nuevo registro*/								
					if($_POST[$campoTexto]!="" && is_numeric($_POST[$campoTexto])){
						$sql_insert = "INSERT INTO hospedaje_tipo_habitacion VALUES(nextval('hospedaje_tipo_habitacion_idhospedaje_tipo_habitacion_seq'),'".$idTipo."','".$idHospedaje."','".$_POST[$campoTexto]."');";
						$result_insert = pg_exec($con,$sql_insert);
						
						//Si NO se pudo insertar en la tabla el nuevo registro
						if(!$result_insert){
							?><script type="text/javascript" language="javascript">
								alert("¡¡¡ ERROR !!! \n     No se pudo guardar el tipo de habitación para este sitio de hospedaje");
								location.href="listadositios.php";
							</script><?php
						}
					}//end if is_numeric		
					
					/*Si está seleccionado el check pero NO se indicó el nro. de habitaciones, igual se permite guardar*/
					else if($_POST[$campoTexto]==""){
						$sql_insert = "INSERT INTO hospedaje_tipo_habitacion VALUES(nextval('hospedaje_tipo_habitacion_idhospedaje_tipo_habitacion_seq'),'".$idTipo."','".$idHospedaje."',null);";
						$result_insert = pg_exec($con,$sql_insert);
						
						//Si NO se pudo insertar en la tabla el nuevo registro
						if(!$result_insert){
							?><script type="text/javascript" language="javascript">
								alert("¡¡¡ ERROR !!! \n     No se pudo guardar el tipo de habitación para este sitio de hospedaje");
								location.href="listadositios.php";
							</script><?php
						}
					}
					/*Si algun campo esta vacio o no es numerico*/
					else{
						$algunoNoEsNumerico = 1;
					}					
				}//end variable oculta != -1
			}//end for
				
			if($algunoNoEsNumerico==1){
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ ALERTA !!! \n     Los campos de Nro. de Habitaciones deben ser NUMERICOS");
					location.href="crearhospedaje.php?idSitio="+<?php echo $_GET["idSitio"]; ?>;
				</script><?php
			}
		}//end if num rows
		?><script type="text/javascript" language="javascript">
			alert("¡¡¡ Hospedaje agregado satisfactoriamente !!!");
			location.href = "../administracion/creargaleriafotos.php?idSitio="+<?php echo $_GET["idSitio"];?>;
		</script><?php	
	}
?>

<body onload="cargo()">
	<div class="banner"></div>
    <div class="menu">    				
		<?php menu_administrativo();  ?>		                       
    </div>
    <div class="panel">
    	<div class="titulo_panel">Crear Sitios - Hospedaje</div>
        <div class="opcion_panel">
	        <div class="opcion"> 
				<a href="listadositios.php">Listar Sitios</a>
			</div>
        	<div class="opcion" style="background:#F00; color:#FFF;">
				<a href="crearsitio.php">Registrar Nuevo Sitio</a>
			</div>
        </div>
		<?php 
			/*Se busca el nombre del sitio (hospedaje) con el id recibido por GET*/
			$con = conectarse();		
			$sql_select_sitio = "SELECT * FROM sitio WHERE idsitio='".$_GET["idSitio"]."';";
			$result_select_sitio = pg_exec($con, $sql_select_sitio);
			$sitio = pg_fetch_array($result_select_sitio,0);
			$nombreSitio = $sitio[3];					
		?>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
  			   	<div class="linea_formulario">
                	<div class="linea_titulo_2">Evaluación de <?php echo $nombreSitio; ?></div>                    
                </div>
				<div class="linea_formulario">
        	       	<div class="linea_titulo_rojo">Indique los promedios de "<?php echo $nombreSitio; ?>" en cuanto a servicio, ubicación, limpieza, personal y precio. Valores entre 0 y 100: (Ejemplo: Promedio de Servicio = 95)</div>
				</div>	
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Servicio (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_servicio" name="promedio_servicio"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Ubicación (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_ubicacion" name="promedio_ubicacion"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Limpieza (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_limpieza" name="promedio_limpieza"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Personal (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_personal" name="promedio_personal"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Precio (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_precio" name="promedio_precio"/>
                    </div>
                </div>
				<div class="linea_formulario"></div>						
				<div class="linea_formulario">
                	<div class="linea_titulo_2">Comodidades</div>                    
                </div>	
				<div class="linea_formulario">
        	       	<div class="linea_titulo_rojo">Seleccione las comodidades que ofrece <?php echo $nombreSitio; ?>:</div>
				</div>	
						
				<?php 
				/*Se buscan todas las comodidades para que el usuario seleccione las deseadas*/
				$con = conectarse();		
				$sql_select_comodidad = "SELECT * FROM comodidad ORDER BY nombre";
				$result_select_comodidad = pg_exec($con, $sql_select_comodidad);	
									
				/*Si existen, se construye una lista con todas*/						
				if(pg_num_rows($result_select_comodidad)>0){
				?>
				<tr>
					<td>						
						<?php
						for($i=0; $i<pg_num_rows($result_select_comodidad); $i++){
							$comodidad = pg_fetch_array($result_select_comodidad,$i);
							$idComodidad = $comodidad[0];
							$nombre = $comodidad[1];
							
							/*Se crean los checkbox de c/comodidad y en el onclick se llama a la funcion que guarda el valor en la 
							  variable oculta Hid*/
							echo '<div class="linea_formulario_promedio">';
								echo '<div class="linea_titulo_promedio">';
									echo '<div class="linea_campo_promedio">';
										echo '<input type="hidden" name="Hid'.$idComodidad.'" value="-1" />';
										echo '<input type="checkbox" name="'.$idComodidad.'" value="'.$idComodidad.'" onclick="guardarChecked('.$idComodidad.',1)"/>'.$nombre;										
									echo '</div>';	
								echo '</div>';
							echo '</div>';			
						}
						?>
						</select>							
					</td>
				</tr>
				<?php
				}
				?>							
            	<div class="linea_formulario"></div>
				<div class="linea_formulario">
                	<div class="linea_titulo_2">Tipos de Habitación</div>                    
                </div>
				
				<div class="linea_formulario">
        	       	<div class="linea_titulo_rojo">Seleccione los tipos de habitaciones que ofrece "<?php echo $nombreSitio; ?>", así como también indique en el campo de texto junto a cada tipo, el número de habitaciones que tiene por cada uno:</div>
				</div>
				<div class="linea_formulario"></div>
				<?php 
					/*Se buscan todas las comodidades para que el usuario seleccione las deseadas*/
					$con = conectarse();
					$sql_select_tipo = "SELECT * FROM tipo_habitacion ORDER BY nombre";
					$result_select_tipo = pg_exec($con, $sql_select_tipo);
									
					/*Si existen, se construye una lista con todas*/						
					if(pg_num_rows($result_select_tipo)>0){
				?>
				<tr>
					<td>						
						<?php
						for($i=0; $i<pg_num_rows($result_select_tipo); $i++){
							$tipo = pg_fetch_array($result_select_tipo,$i);
							$idTipo = $tipo[0];
							$nombre = $tipo[1].": ";
							
							/*Se crean los checkbox de c/comodidad y en el onclick se llama a la funcion que guarda el valor en la 
							  variable oculta Hid*/
							echo '<div class="linea_formulario_promedio">';
								echo '<div class="linea_titulo_promedio">';
									echo '<div class="linea_campo_promedio">';
										echo '<input type="hidden" name="Tipo'.$idTipo.'" value="-1" />';										
										echo '<input type="checkbox" name="'.$idTipo.'" value="'.$idTipo.'" onclick="guardarChecked('.$idTipo.',2)"/>'.$nombre;						
										echo '<input name="txt'.$idTipo.'" value="" type="text" size="1" maxlength="2" height="3" width="10px" style="font-size:small"/>';	
										?>
										<script language="JavaScript" type="text/javascript">
											var campo = "#txt"+<?php echo $idTipo; ?>;
											$(campo).funcionesJS('0123456789');
										</script>
										<?php
									echo '</div>';	
								echo '</div>';
							echo '</div>';			
						}
						?>
						</select>							
					</td>
				</tr>
				<?php
				}
				?>
				<div class="linea_formulario"></div>
				<div class="linea_formulario"></div>
				<div class="linea_formulario">
					<div class="linea_titulo_rojo">
						<input type="submit" value="Guardar datos hospedaje" name="Guardar" style="font-size:12px;" align="left"/>(*) Campos obligatorios
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
<?php session_start();
	  require("../recursos/funciones.php");
	  
	  //Variables recibidas en esta pág: $_GET["idSitio"]
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Crear Gastronomía</title>
		
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
        	campoPromComida = formulario.promedio_comida.value;
			campoPromServicio = formulario.promedio_servicio.value;
			campoPromAmbiente = formulario.promedio_ambiente.value;
			campoPromHigiene = formulario.promedio_higiene.value;
			campoPromPrecio = formulario.promedio_precio.value;
			
        	if (campoPromComida.length == 0 || campoPromServicio.length == 0 || campoPromAmbiente.length == 0 || campoPromHigiene.length == 0 || campoPromPrecio.length == 0) {
				alert("Es necesario completar todos los campos marcados como obligatorios (*)");
				return false;
        	}
			else if(/^\s+$/.test(campoPromComida) || (/^\s+$/.test(campoPromServicio)) || (/^\s+$/.test(campoPromAmbiente)) || (/^\s+$/.test(campoPromHigiene)) || (/^\s+$/.test(campoPromPrecio))){
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
    		//Para escribir solo letras
    		//$('#miCampo1').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');

    		//Para escribir solo numeros	
    		$('#promedio_comida').funcionesJS('0123456789.,');
			$('#promedio_servicio').funcionesJS('0123456789.,');
			$('#promedio_ambiente').funcionesJS('0123456789.,');
			$('#promedio_higiene').funcionesJS('0123456789.,');
			$('#promedio_precio').funcionesJS('0123456789.,');
    	});
		/*********************************************************************************************
		*
			Funcion para guardar en variables ocultas, los checked que están seleccionados
		*
		**********************************************************************************************/
		function guardarChecked(elementoCheck,bandera) {
			
			/*Si bandera es 1, se está llamando para pintar las especialidades*/
			if(bandera==1){
				var variableOculta = "Hid"+elementoCheck;
			}
			/*Si bandera es 2, se está llamando para pintar los check de los servicios*/
			else if(bandera==2){
				var variableOculta = "Ser"+elementoCheck;
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
		$suma_promedios = $_POST["promedio_comida"]+$_POST["promedio_servicio"]+$_POST["promedio_ambiente"]+$_POST["promedio_higiene"]+$_POST["promedio_precio"];
		$promedio_general = $suma_promedios/5;
		
		$sql_sel_gastronomia = "SELECT * FROM gastronomia WHERE idsitio=".$_GET["idSitio"];
		$result_sql_gastronomia = pg_exec($con,$sql_sel_gastronomia);
		
		if(pg_num_rows($result_sql_gastronomia)>0){
			$gastronomia = pg_fetch_array($result_sql_gastronomia,0);
			$idGastronomia = $gastronomia[0];
			$sql_update = "UPDATE gastronomia SET promedio_comida='".$_POST["promedio_comida"]."', promedio_servicio='".$_POST["promedio_servicio"]."', promedio_ambiente='".$_POST["promedio_ambiente"]."', promedio_higiene='".$_POST["promedio_higiene"]."', promedio_precio='".$_POST["promedio_precio"]."', promedio='".$promedio_general."' WHERE idsitio='".$_GET["idSitio"]."';";
			
			$result_sql_update_gastronomia = pg_exec($con,$sql_update);
			if(!$result_sql_update_gastronomia){
				?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ERROR !!! \n     No se podrá crear la gastronomía, por favor inténtelo de nuevo");
				location.href="creargastronomia.php?idSitio="+<?php echo $_GET["idSitio"]; ?>;
				</script><?php	
			}		
		}
		
		/*Sino se crean desde CERO*/
		else{
			/*Se inserta el nuevo registro*/			
			$sql_insert = "INSERT INTO gastronomia VALUES(nextval('gastronomia_idgastronomia_seq'),'".$_GET["idSitio"]."','".$_POST["promedio_comida"]."','".$_POST["promedio_servicio"]."','".$_POST["promedio_ambiente"]."','".$_POST["promedio_higiene"]."','".$_POST["promedio_precio"]."','".$promedio_general."');";
			$result_insert = pg_exec($con,$sql_insert);
			
			//Si NO se pudo insertar en la tabla el nuevo registro
			if(!$result_insert){
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ ERROR !!! \n     No se pudieron guardar los promedios");
					location.href="listadositios.php";
				</script><?php	
			}
			
			/*Se selecciona el id de gastronomia recien creado*/
			$sql_select = "SELECT last_value FROM gastronomia_idgastronomia_seq;";
			$result_select = pg_exec($con, $sql_select);
			$arreglo = pg_fetch_array($result_select,0);
			$idGastronomia = $arreglo[0];
		
		}	
		
		//Si se pudieron insertar en la tabla 'hospedaje' los promedios, se procede a guardar las comodidades de ese hospedaje
		//else{
			/*---------------------------------------------------------------------------------------------------------------
			*					 
			*										PARA CREAR LAS ESPECIALIDADES DEL SITIO
			*
			---------------------------------------------------------------------------------------------------------------*/
			/*Se consultan las especialidades*/
			$sql_select_especialidad = "SELECT * FROM especialidad";
			$result_select_especialidad = pg_exec($con, $sql_select_especialidad);
				
			/*Si existen, se construye una lista con todas para revisar los checkbox que están seleccionados*/						
			if(pg_num_rows($result_select_especialidad)>0){
				for($i=0; $i<pg_num_rows($result_select_especialidad); $i++){
					$especialidad = pg_fetch_array($result_select_especialidad,$i);
					$idEspecialidad = $especialidad[0];
					$variableOculta = "Hid".$idEspecialidad;
					
					//Si la variable oculta es != -1 es porque está seleccionada, entonces...
					if($_POST[$variableOculta] != -1){
						
						/*Se inserta el nuevo registro*/			
						$sql_insert = "INSERT INTO gastronomia_especialidad VALUES(nextval('gastronomia_especialidad_idgastronomia_especialidad_seq'),'".$idGastronomia."','".$idEspecialidad."');";
						$result_insert = pg_exec($con,$sql_insert);
						
						//Si NO se pudo insertar en la tabla el nuevo registro
						if(!$result_insert){
							?><script type="text/javascript" language="javascript">
								alert("¡¡¡ ERROR !!! \n     No se pudo guardar la especialidad para este sitio de gastronomía");
								location.href="listadositios.php";
							</script><?php
						}
					}//end variable oculta != -1
				}//end for
			}//end if num rows
			/*---------------------------------------------------------------------------------------------------------------
			*					
			*										PARA CREAR LOS SERVICIOS DEL SITIO
			*
			---------------------------------------------------------------------------------------------------------------*/
			/*Se consultan las especialidades*/
			$sql_select_servicio = "SELECT * FROM servicio";
			$result_select_servicio = pg_exec($con, $sql_select_servicio);
				
			/*Si existen, se construye una lista con todas para revisar los checkbox que están seleccionados*/						
			if(pg_num_rows($result_select_servicio)>0){
				for($i=0; $i<pg_num_rows($result_select_servicio); $i++){
					$servicio = pg_fetch_array($result_select_servicio,$i);
					$idServicio = $servicio[0];
					$variableOculta = "Ser".$idServicio;
					
					//Si la variable oculta es != -1 es porque está seleccionada, entonces...
					if($_POST[$variableOculta] != -1){
						
						/*Se inserta el nuevo registro*/			
						$sql_insert = "INSERT INTO gastronomia_servicio VALUES(nextval('gastronomia_servicio_idgastronomia_servicio_seq'),'".$idGastronomia."','".$idServicio."');";
						$result_insert = pg_exec($con,$sql_insert);
						
						//Si NO se pudo insertar en la tabla el nuevo registro
						if(!$result_insert){
							?>
    		    			<script type="text/javascript" language="javascript">
								alert("¡¡¡ ERROR !!! \n     No se pudo guardar el servicio");
								location.href="listadositios.php";
							</script>
					       	<?php
						}
					}//end variable oculta != -1
				}//end for
			}//end if num rows
			?>			
			<script type="text/javascript" language="javascript">
				alert("¡¡¡ Sitio de gastronomía agregado satisfactoriamente !!!");
				location.href = "../administracion/creargaleriafotos.php?idSitio="+<?php echo $_GET["idSitio"];?>;
			</script>
			<?php
		//}//end else		
	}
?>

<body onload="cargo()">
	<div class="banner"></div>
    <div class="menu">    				
		<?php menu_administrativo();  ?>		                       
    </div>
    <div class="panel">
    	<div class="titulo_panel">Crear Sitio de Gastronomía</div>
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
                	<div class="linea_titulo_2">Evaluación de "<?php echo $nombreSitio; ?>"</div>                    
                </div>
				<div class="linea_formulario">
        	       	<div class="linea_titulo_rojo">Indique los promedios de "<?php echo $nombreSitio; ?>" en cuanto a comida, servicio, ambiente, higiene y precio. Valores entre 1 y 100: (Ejemplo: Promedio de Servicio = 95)</div>
				</div>	
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Comida (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_comida" name="promedio_comida" />
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Servicio (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_servicio" name="promedio_servicio" />
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Ambiente (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_ambiente" name="promedio_ambiente" />
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Higiene (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_higiene" name="promedio_higiene" />
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Precio (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_precio" name="promedio_precio" />
                    </div>
                </div>
				<div class="linea_formulario"></div>							
				<div class="linea_formulario">
                	<div class="linea_titulo_2">Especialidades Gastronómicas</div>                    
                </div>	
				<div class="linea_formulario">
        	       	<div class="linea_titulo_rojo">Seleccione las especialidades gastronómicas que ofrece "<?php echo $nombreSitio; ?>"</div>
				</div>
				<?php 
				/*Se buscan todas las comodidades para que el usuario seleccione las deseadas*/
				$con = conectarse();		
				$sql_select_especialidad = "SELECT * FROM especialidad ORDER BY nombre";
				$result_select_especialidad = pg_exec($con, $sql_select_especialidad);	

				/*Si existen, se construye una lista con todas*/						
				if(pg_num_rows($result_select_especialidad)>0){
				?>
				<tr>
					<td>						
						<?php
						for($i=0; $i<pg_num_rows($result_select_especialidad); $i++){
							$especialidad = pg_fetch_array($result_select_especialidad,$i);
							$idEspecialidad = $especialidad[0];
							$nombre = $especialidad[1];
							
							/*Se crean los checkbox de c/especialidad y en el onclick se llama a la funcion que guarda el valor en la 
							  variable oculta Hid*/
							echo '<div class="linea_formulario_promedio">';
								echo '<div class="linea_titulo_promedio">';
									echo '<div class="linea_campo_promedio">';
										echo '<input type="hidden" name="Hid'.$idEspecialidad.'" value="-1" />';
										echo '<input type="checkbox" name="'.$idEspecialidad.'" value="'.$idEspecialidad.'" onclick="guardarChecked('.$idEspecialidad.',1)"/>'.$nombre;										
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
                	<div class="linea_titulo_2">Servicios</div>                    
                </div>	
				<div class="linea_formulario">
        	       	<div class="linea_titulo_rojo">Seleccione los servicios que ofrece "<?php echo $nombreSitio; ?>"</div>
				</div>	
				<?php 
				/*Se buscan todas las comodidades para que el usuario seleccione las deseadas*/
				$con = conectarse();		
				$sql_select_servicios = "SELECT * FROM servicio ORDER BY nombre";
				$result_select_servicios = pg_exec($con, $sql_select_servicios);	

				/*Si existen, se construye una lista con todas*/						
				if(pg_num_rows($result_select_servicios)>0){
				?>
				<tr>
					<td>						
						<?php
						for($i=0; $i<pg_num_rows($result_select_servicios); $i++){
							$servicio = pg_fetch_array($result_select_servicios,$i);
							$idServicio = $servicio[0];
							$nombre = $servicio[1];
							
							/*Se crean los checkbox de c/especialidad y en el onclick se llama a la funcion que guarda el valor en la 
							  variable oculta Hid*/
							echo '<div class="linea_formulario_promedio">';
								echo '<div class="linea_titulo_promedio">';
									echo '<div class="linea_campo_promedio">';
										echo '<input type="hidden" name="Ser'.$idServicio.'" value="-1" />';
										echo '<input type="checkbox" name="'.$idServicio.'" value="'.$idServicio.'" onclick="guardarChecked('.$idServicio.',2)"/>'.$nombre;										
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
					<div class="linea_titulo_rojo">
						<input type="submit" value="Guardar datos" name="Guardar" style="font-size:12px;" align="left"/>(*) Campos obligatorios
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
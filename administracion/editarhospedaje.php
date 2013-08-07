<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Editar hospedaje</title>
	
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
			Funcion para guardar en una variable oculta la seleccion del combo 
		*
		**********************************************************************************************/
		function guardarValorCombo(valor,bandera)
		{
			//Bandera 1 es para guardar el valor de la SUBCATEGORIA
			if(bandera==1 && valor != -1){
				document.all('HidSubCategoria').value = valor;
			}
			else if(bandera==1 && valor == -1){
				document.all('HidSubCategoria').value = -1;
			}
			//Bandera 2 es para guardar el valor de la RUTA
			else if(bandera==2 && valor != -1){
				document.all('HidRuta').value = valor;
			}
			else if(bandera==2 && valor == -1){
				document.all('HidRuta').value = -1;
			}
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
		function guardarChecked(elementoCheck) {
			
			var variableOculta = "Hid"+elementoCheck;
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
		/*Se actualiza el registro*/
		$con = conectarse();
			
		//Se calcula el promedio GENERAL entre todos los promedios
		$suma_promedios = $_POST["promedio_servicio"]+$_POST["promedio_ubicacion"]+$_POST["promedio_limpieza"]+$_POST["promedio_personal"]+$_POST["promedio_precio"];
		$promedio_general = $suma_promedios/5;
		
		/*--------------------------------------------------------------------------------------------------------------------
			Se verifica el valor que trae la variable $_GET["idHospe"] recibida desde editarsitios.php, si viene con 
			valor != -1 hay que actualizar el registro de la tabla HOSPEDAJE
			Sino, hay que crear el registro desde cero
		--------------------------------------------------------------------------------------------------------------------*/
		if($_GET["idHospe"]!=-1){
			//Se prepara el query de update
			$sql_update = "UPDATE hospedaje SET promedio_servicio='".$_POST["promedio_servicio"]."', promedio_ubicacion='".$_POST["promedio_ubicacion"]."', promedio_limpieza='".$_POST["promedio_limpieza"]."', promedio_personal='".$_POST["promedio_personal"]."', promedio_precio='".$_POST["promedio_precio"]."', promedio='".$promedio_general."' WHERE idhospedaje='".$_GET["idHospe"]."' AND idsitio='".$_GET["idSitio"]."';";
		
			//Se ejecuta el update
			$result_update = pg_exec($con,$sql_update);
			
			//Si devuelve FALSE, ocurrió un error que no permitió que se ejecutara el update
			if(!$result_update){
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ ERROR !!! \n     No se pudieron modificar los promedios del hospedaje");
					location.href="../administracion/listadositios.php";
				</script><?php
			}
			
			//Si devuelve TRUE, se pudo ejecutar el UPDATE
			else{	
			
				/*-------------------------------------------------------------------------------------------------------------------
					Se consulta la tabla hospedaje_comodidad para PRIMERO ELIMINAR cualquier registro que haya relacionado con
					especialidades asociadas a ESTE sitio, pues al editar un sitio, puede o AGREGAR o QUITAR comodidades 
					entonces es mejor eliminarlas todas primero y luego si agregarlas de nuevo
				-------------------------------------------------------------------------------------------------------------------*/
				
				//Si ya existen registros en hospedaje_comodidad asociados a ESE sitio, se eliminan
				if($_GET["idHospe"]!=-1){
					$con = conectarse();
					$sql_delete = "DELETE FROM hospedaje_comodidad WHERE idhospedaje=".$_GET["idHospe"];
					$result_delete = pg_exec($con,$sql_delete);
				}
					
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
							$sql_insert = "INSERT INTO hospedaje_comodidad VALUES( nextval('hospedaje_comodidad_idhospedaje_comodidad_seq'), '".$_GET["idHospe"]."','".$idComodidad."');";
							$result_insert = pg_exec($con,$sql_insert);
						
	 						//Si NO se pudo insertar en la tabla el nuevo registro
 							if(!$result_insert){
								?>
    			    			<script type="text/javascript" language="javascript">
									alert("¡¡¡ ERROR !!! \n     No se pudo guardar la comodidad para este hospedaje");
									location.href="../administracion/listadositios.php";
								</script>
					       		<?php
							}							
						}//end variable oculta != -1
					}//end for
					?>
					<script type="text/javascript" language="javascript">
					alert("¡¡¡ Hospedaje agregado satisfactoriamente !!!");
					location.href = "../administracion/listadositios.php";
					</script>
					<?php	
				}//end if num rows
			}//end else if(!$result_update)
		}//end del if($_GET["idHospe"]!=-1)
		
		/*Si no habia ningun registro de este sitio en la tabla hospedaje, se crea desde cero*/
		else if($_GET["idHospe"]==-1){
			$con = conectarse();
			
			//Se calcula el promedio GENERAL entre todos los promedios
			$suma_promedios = $_POST["promedio_servicio"]+$_POST["promedio_ubicacion"]+$_POST["promedio_limpieza"]+$_POST["promedio_personal"]+$_POST["promedio_precio"];
			$promedio_general = $suma_promedios/5;
			
			/*Se inserta el nuevo registro*/			
			$sql_insert = "INSERT INTO hospedaje VALUES(nextval('hospedaje_idhospedaje_seq'),'".$_GET["idSitio"]."','".$_POST["promedio_servicio"]."','".$_POST["promedio_ubicacion"]."','".$_POST["promedio_limpieza"]."','".$_POST["promedio_personal"]."','".$_POST["promedio_precio"]."','".$promedio_general."');";
			$result_insert = pg_exec($con,$sql_insert);
				
			//Si NO se pudo insertar en la tabla el nuevo registro
			if(!$result_insert){
				?>
    	    	<script type="text/javascript" language="javascript">
					alert("¡¡¡ ERROR !!! \n     No se pudieron guardar los promedios");
					location.href="../administracion/listadositios.php";
				</script>
				<?php	
			}
			else{
				?>
				<script type="text/javascript" language="javascript">
					alert("¡¡¡ Hospedaje agregado satisfactoriamente !!!");
					location.href = "../administracion/listadositios.php";					
				</script>
				<?php	
			}
		}		
	}//end del if(isset($_POST["Guardar"]))
?>

<body onload="cargo()">
	<div class="banner"></div>
    <div class="menu">    				
		<?php menu_administrativo(); 
		
			/*Se seleccionan los datos del id que se recibe por GET*/
			$con = conectarse();
			$sql_select = "SELECT * FROM sitio WHERE idsitio='".$_GET["idSitio"]."';";
			$result_select = pg_exec($con, $sql_select);
			$arreglo = pg_fetch_array($result_select,0);
		?>	 
    </div>
    <div class="panel">
    	<div class="titulo_panel">Editar <?php echo $arreglo[3];?></div>
        <div class="opcion_panel">
	        <div class="opcion"><a href="listadositios.php">Listar Sitios</a></div>
        	<div class="opcion" style="background:#F00; color:#FFF;"><a href="crearsitio.php">Registrar Nuevo Sitio</a></div>
	    </div>
		<?php 
			/*Se busca el nombre del sitio con el id recibido por GET*/
			$nombreSitio = $arreglo[3];
			
			/* Se busca el ID del hospedaje asociado a ESTE sitio */
			$con = conectarse();
			
			/*Si trae valor != -1 es porque ese sitio ya tenía un registro en la tabla hospedaje*/
			if($_GET["idHospe"]!=-1){
				$sql_sel_hospedaje = "SELECT * FROM hospedaje WHERE idhospedaje=".$_GET["idHospe"]." AND idsitio=".$_GET["idSitio"].";";
				$result_select_hospedaje = pg_exec($con, $sql_sel_hospedaje);	
				$hospedaje = pg_fetch_array($result_select_hospedaje,0);		
			}
			else{
				$hospedaje[2] = "";
				$hospedaje[3] = "";
				$hospedaje[4] = "";
				$hospedaje[5] = "";
				$hospedaje[6] = "";
			}
					
		?>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
	  			<div class="linea_formulario">
                	<div class="linea_titulo_2">-  Evaluación -</div>                    
                </div>
				<div class="linea_formulario">
        	       	<div class="linea_titulo_rojo">Indique los promedios de <?php echo $nombreSitio; ?> en cuanto a servicio, ubicación, limpieza, personal y precio:</div>
				</div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Servicio (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_servicio" name="promedio_servicio" value="<? echo $hospedaje[2]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Ubicación (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_ubicacion" name="promedio_ubicacion" value="<? echo $hospedaje[3]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Limpieza (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_limpieza" name="promedio_limpieza" value="<? echo $hospedaje[4]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Personal (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_personal" name="promedio_personal" value="<? echo $hospedaje[5]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Promedio de Precio (*)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="promedio_precio" name="promedio_precio" value="<? echo $hospedaje[6]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo"></div>
                    <div class="linea_campo"></div>
                </div>							
				<div class="linea_formulario">
                	<div class="linea_titulo_2">-  Comodidades  -</div>                    
                </div>	
				<div class="linea_formulario">
        	       	<div class="linea_titulo_rojo">Seleccione las comodidades con las cuales cuenta <?php echo $nombreSitio; ?>:</div>
				</div>	
				<?php 		
				
				/*Si trae valor != -1 es porque ese sitio ya tenía un registro en la tabla hospedaje*/
				if($_GET["idHospe"]!=-1){
					/*Se buscan todas las comodidades con las que cuenta ese sitio*/					
					$sql_sel_hospe_como = "SELECT * FROM hospedaje_comodidad WHERE idhospedaje=".$_GET["idHospe"].";";
					$result_sel_hospe_como = pg_exec($con, $sql_sel_hospe_como);					
				}
				
				/*Se consultan todas las comodidades para cargar los checkbox y MARCAR aquellos que están asociados al sitio*/
				$sql_sel_comodidad = "SELECT * FROM comodidad ORDER BY nombre";
				$result_select_comodidad = pg_exec($con, $sql_sel_comodidad);
				
				/*Se construye lista con todas*/						
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
										
										/*Antes de crear el checkbox, se verifica si ese sitio posee esa comodidad para marcarlo*/
										$valorOculto = -1;
										
										/*Si idHospe trae valor != -1 es porque ese sitio ya tenía un registro en la tabla hospedaje*/
										if($_GET["idHospe"]!=-1){
											if(pg_num_rows($result_sel_hospe_como)>0){
												for($j=0; $j<pg_num_rows($result_sel_hospe_como); $j++){
													$hospe_como = pg_fetch_array($result_sel_hospe_como,$j);
												
													//Si posee la comodidad
													if($hospe_como[1]==$_GET["idHospe"] && $hospe_como[2]==$idComodidad){
														$valorOculto = $idComodidad;
														$j = pg_num_rows($result_sel_hospe_como);
													}
												}
											}
										}
										
										//Si la comodidad no está para ese sitio, lo dibuja SIN MARCA
										if($valorOculto==-1){
											echo '<input type="checkbox" name="'.$idComodidad.'" value="'.$idComodidad.'" onclick="guardarChecked('.$idComodidad.')"/>'.$nombre;
										}
										//Sino, se dibuja MARCADO
										else{
											echo '<input type="checkbox" name="'.$idComodidad.'" value="'.$idComodidad.'" onclick="guardarChecked('.$idComodidad.')" checked="checked"/>'.$nombre;
										}
										
										echo '<input type="hidden" name="Hid'.$idComodidad.'" value="'.$valorOculto.'" />';																				
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
            	<div class="linea_formulario">
                	<div class="linea_titulo"></div>
                    <div class="linea_campo"></div>
                </div>	
            	<div class="linea_formulario">
					<div class="linea_titulo_rojo">
						<input type="submit" value="Guardar cambios" name="Guardar" style="font-size:12px;" />(*) Campos obligatorios
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
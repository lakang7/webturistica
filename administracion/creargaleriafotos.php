<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Crear galería de fotos</title>
		
    <link rel="stylesheet" href="../css/administracion/estructura.css" type="text/css"  />
	<link rel="stylesheet" type="text/css" href="../css/administracion/component.css" />
	<link rel="stylesheet" type="text/css" href="../css/administracion/default.css" />    
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css' />       
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	
	<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	
	<script src="../js/mootools.1.2.3.js"></script>
	<script src="../js/administracion/sombrear_fila_tabla.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/administracion/sombrear_fila_tabla.css" />

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBViGAK8QcqvLcl0Pgilw-ENvMhmL88E6A&sensor=true"></script>
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js" ></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" ></script>    
    <script src="../js/administracion/modernizr.custom.js"></script>
    <script src="../js/administracion/jquery.dlmenu.js"></script>    
	<script src="../js/administracion/funcionesJS.js"></script> 
	
	<script type="text/javascript" language="javascript">
		//Funcion para preguntar si esta seguro de eliminar un registro ANTES de proceder a eliminarlo realmente
		function confirmar(url){ 
			if (!confirm("¿Está seguro de que desea eliminar la fotografía de la galería? Presione ACEPTAR para eliminarlo o CANCELAR para volver al listado")) { 
				return false; 
		    } 
			else { 
				document.location = url; 
				return true; 
			} 
		} 
	</script>  
</head>

<?php
	if(isset($_POST["Agregar"])){
		
		/*Si se seleccionó alguna imagen, se guarda en la galería de ESE sitio*/
		if($_FILES['foto']['name']!=""){
			
			$con = conectarse();
			
			/*---------------------------------------------------------------------------------------------------------------------
			*								Solo se pueden subir máximo 20 fotografías por sitio
			*								por lo tanto ANTES de insertar la foto, se consulta
			*								la cant de fotos que hay cargadas hasta el momento
			---------------------------------------------------------------------------------------------------------------------*/
			$sql_select = "SELECT * FROM foto_sitio WHERE idsitio=".$_GET["idSitio"].";";
			$result_select = pg_exec($con,$sql_select);
			
			if(pg_num_rows($result_select)<20){
				$hoy = date("Y-m-d");
				
				/*-------------------------------------------------------------------------------------------------------------------
				*										PARA INSERTAR LA FOTO EN TAMAÑO GRANDE
				-------------------------------------------------------------------------------------------------------------------*/
				$sql_insert = "INSERT INTO foto_sitio VALUES(nextval('foto_sitio_idfoto_sitio_seq'),'".$_GET["idSitio"]."','".$hoy."','');";
				$result_insert = pg_exec($con,$sql_insert);	
				
				//Si NO se pudo insertar en la tabla el nuevo registro
				if(!$result_insert){
					?><script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!! No se pudo guardar la  foto en la galería");
						location.href="../administracion/creargaleriafotos.php?idSitio="+<?php echo $_GET["idSitio"];?>;
					</script><?php	
				}
				//Si se insertó el nuevo sitio satisfactoriamente
				else{				
					/*Se consulta el NOMBRE del sitio*/
					$sql_select_sitio = "SELECT * FROM sitio WHERE idsitio=".$_GET["idSitio"].";";
					$result_select_sitio = pg_exec($con, $sql_select_sitio);
					$sitio = pg_fetch_array($result_select_sitio,0);
					$nombreSitio = $sitio[3];		
			
					/*Se selecciona el ultimo id asignado a foto_sitio*/
					$sql_select = "SELECT last_value FROM foto_sitio_idfoto_sitio_seq";
					$result_select = pg_exec($con, $sql_select);
					$arreglo = pg_fetch_array($result_select,0);
					
					/*Se prepara la fotografía en tamaño GRANDE*/
					$subir = new imgUpldr;
					$nombreImagenGrande = "Grande_".$arreglo[0]."_".$nombreSitio;
					$subir->configurar($nombreImagenGrande, "../imagenes/sitios/galeria/",1024,768);
					$subir->init($_FILES['foto']);			
					$destino = "imagenes/sitios/galeria/".$subir->_name;
				
					/*------------------------------------------------------------------------------------------------------------
					*  					   	        SE GUARDA EN LA CARPETA LA FOTO EN TAMAÑO PEQUEÑO
					------------------------------------------------------------------------------------------------------------*/
					$subirP = new imgUpldr;
					$nombreImagenPeque = "Peque_".$arreglo[0]."_".$nombreSitio;
					$subirP->configurar($nombreImagenPeque, "../imagenes/sitios/galeria/",200,150);
					$subirP->init($_FILES['foto']);	
					
					/*Se actualiza el registro para incluir la ruta del icono que se acaba de subir*/
					$sql_update = "UPDATE foto_sitio SET foto='".$destino."' WHERE idfoto_sitio='".$arreglo[0]."'";
					$result_update = pg_exec($con, $sql_update);
					
					if(!$result_update){
						?>
   					    <script type="text/javascript" language="javascript">
							alert("¡¡¡ ERROR !!!\n\n     No se pudo insertar la imagen");
							location.href = "../administracion/creargaleriafotos.php?idSitio="+<?php echo $_GET["idSitio"];?>;
						</script>
				       	<?php	
					}	
					
					?><script type="text/javascript" language="javascript">
						alert("¡¡¡ Fotografía almacenada exitosamente !!!");
						location.href = "../administracion/creargaleriafotos.php?idSitio="+<?php echo $_GET["idSitio"];?>;
					</script><?php
				}							
			}//end pg_num_rows($result_select)<20
			else{
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ ALERTA !!!\n\nEstimado usuario, solo puede guardar veinte (20) fotografías en la galería de cada sitio. Le invitamos a eliminar fotografías para liberar el espacio de la galería y así poder agregar otras.");
				</script><?php
			}
		}//end if($_FILES['foto']['name']!="")
		
		if($_FILES['foto']['name']==""){
			?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ALERTA !!! Debe seleccionar una foto");
			</script><?php
		}
	}//end isset($_POST["Agregar"] (Botón AGREGAR A GALERÍA)
	
	if(isset($_POST["Guardar"])){
	
		if($_FILES['foto']['name']!=""){
			?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ALERTA !!! Tiene una fotografía pendiente por agregar a la galería, haga primero clic en AGREGAR A GALERÍA");
			</script><?php	
		}
		else{
			?><script type="text/javascript" language="javascript">
				alert("¡¡¡ Se ha culminado satisfactoriamente el registro del sitio !!!");
				location.href = "../administracion/listadositios.php";
			</script><?php
		}		
	}//end isset($_POST["Guardar"] (Botón GUARDAR GALERÍA)
?>

<body onload="cargo()">
	<div class="banner"></div>
    <div class="menu">    				
		<?php menu_administrativo();  
			/*Se busca el nombre del sitio (hospedaje) con el id recibido por GET*/
			$con = conectarse();		
			$sql_select_sitio = "SELECT * FROM sitio WHERE idsitio='".$_GET["idSitio"]."';";
			$result_select_sitio = pg_exec($con, $sql_select_sitio);
			$sitio = pg_fetch_array($result_select_sitio,0);
			$nombreSitio = $sitio[3];
		?>		                       
    </div>
    <div class="panel">
    	<div class="titulo_panel">Galería de fotos de <?php echo $nombreSitio; ?></div>
        <div class="opcion_panel">
	        <div class="opcion"> <a href="listadositios.php">Listar Sitios</a></div>
        	<div class="opcion" style="background:#F00; color:#FFF;"><a href="crearsitio.php">Registrar Nuevo Sitio</a></div>
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
        	       	<div class="linea_titulo_rojo">Realice los siguientes pasos:</div>
				</div>
				<div class="linea_formulario">
					<div class="linea_titulo">- PASO 1: Seleccione la fotografía deseada haciendo clic en "Seleccionar archivo"</div>
				</div>
				<div class="linea_formulario">
					<div class="linea_titulo">- PASO 2: Una vez cargada la foto, haga clic en "Agregar foto a galería"</div>
				</div>
				<div class="linea_formulario">
					<div class="linea_titulo">- PASO 3: Repita pasos 1 y 2 tantas veces como fotos desee agregar</div>
				</div>
				<div class="linea_formulario">
					<div class="linea_titulo">- PASO 4: Para finalizar, haga clic en "Finalizar galería"</div>
				</div>
				<div class="linea_formulario">
					<div class="linea_titulo"></div>
				</div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido"><input name="foto" type="file" id="foto"/></div>
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido"></div>
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido"><input type="submit" value="Agregar foto a galería" name="Agregar" style="font-size:12px;" align="left"/></div>
                </div>							
				<div class="linea_formulario">
                    <div class="linea_campo"></div>
                </div>	
				<div class="linea_formulario">
                	<div class="linea_titulo_2">Fotografías que conforman la galería</div>                    
                </div>
				<div class="capa_tabla_fotos">
		        	<table border="1" class="estilo_tabla" id="highlight-table">
        		    	<thead></thead>
		                <tbody>
	        		        <?php
							$con = conectarse();
						 	$sql_select = "SELECT * FROM foto_sitio WHERE idsitio=".$_GET["idSitio"]." ORDER BY idfoto_sitio;";
							$result_select = pg_exec($con,$sql_select);
				
							if(pg_num_rows($result_select)==0){
								?>
								<tr>
            			        	<td align="center" width="50%" bordercolor="">No hay fotografías cargadas hasta el momento</td>
			                    </tr>
								<?php
							}
				
							else{?>
								<tr style="background:#F00; color:#FFF;" align="center">
	                    			<td width="20">No.</td><td width="100">Fecha</td><td>Fotografía</td><td width="20"></td><td width="20"></td>
    	                		</tr>
								<?php
								for($i=0;$i<pg_num_rows($result_select);$i++){
								    $foto_sitio = pg_fetch_array($result_select,$i);
									$idFotoSitio = $foto_sitio[0];
									?>
									<tr class="row-<?php echo $i+1; ?>" align="center">
										<td><?php echo $i+1; ?></td>
										<td><?php echo $foto_sitio[2]; ?></td>
										<td><?php echo $foto_sitio[3]; ?></td>
										<td title="Ver foto <?php echo $i+1; ?>" style="cursor:pointer;" width="20">
											<a href="" ><img src="../imagenes/ver.png" width="16" height="16" /></a></td>
										<td title="Eliminar foto <?php echo $i+1; ?>" style="cursor:pointer;" width="20">
											<a href="javascript:;" onClick="confirmar('eliminar.php?clave=7&id=<?php echo $idFotoSitio;?>'); return false;"><img src="../imagenes/delete.png" width="16" height="16" /></a></td>
									</tr>					    
									<?php
		        	        	}		
							}			
							?>					               
		                </tbody>
            		</table>
        		</div> 
				<div class="linea_formulario">
					<div class="linea_titulo_rojo">
						<input type="submit" value="Finalizar galería" name="Guardar" style="font-size:12px;" align="right"/>
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
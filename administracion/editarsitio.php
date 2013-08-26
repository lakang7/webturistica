<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Editar Sitios</title>
	
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
        	campoDir = formulario.direccion.value;
			campoNombre = formulario.nombre.value;
			campoTel1 = formulario.tel1.value;
			campoLat = formulario.latitud.value;
			campoLong = formulario.longitud.value;
			
        	if (campoNombre.length == 0 || campoDir.length == 0 || campoTel1.length == 0 || campoLat.length == 0 || campoLong.length == 0) {
				alert("Es necesario completar todos los campos marcados como obligatorios (*)");
				return false;
        	}
			else if(/^\s+$/.test(campoNombre) || (/^\s+$/.test(campoDir)) || (/^\s+$/.test(campoTel1)) || (/^\s+$/.test(campoLat)) || (/^\s+$/.test(campoLong))){
				alert("Ningún campo obligatorio (*) puede quedar en blanco, ingrese valores válidos");
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
			//var txt = "HidSubcategoria="+document.all('HidSubCategoria').value+" yyyyy HidRuta="+document.all('HidRuta').value;
			//alert(txt);
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
    		$('#tel1').funcionesJS('0123456789-');
			$('#tel2').funcionesJS('0123456789-');
			$('#latitud').funcionesJS('0123456789-.');
			$('#longitud').funcionesJS('0123456789-.');
    	});	
		/*********************************************************************************************
		*
			FUNCION PARA INICIALIZAR EL MAPA, se debe llamar en el onload() de la página
		*
		**********************************************************************************************/
      	function inicializacion() {
     	     //Se crea un nuevo mapa situado en La Grita
	         var mapa = new google.maps.Map(document.getElementById("map_canvas"),{center: new google.maps.LatLng(8.132308,-71.9797),zoom: 15,mapTypeId: google.maps.MapTypeId.HYBRID});

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
		    	 //var coordenadas = new google.maps.LatLng(latitud, longitud); 
			     //var marcador = new google.maps.Marker({position: coordenadas,map: mapa, animation: google.maps.Animation.DROP, title:"Un marcador cualquiera"});
     		}); //Fin del evento click
		} // Fin inicializacion()
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
		$con = conectarse();
		
		/*Se actualiza el registro*/		
		$sql_update = "UPDATE sitio SET idsubcategoria='".$_POST["HidSubCategoria"]."', idruta='".$_POST["HidRuta"]."', nombre='".$_POST["nombre"]."', direccion='".$_POST["direccion"]."', telefono1='".$_POST["tel1"]."', telefono2='".$_POST["tel2"]."', correo='".$_POST["correo"]."', resena='".$_POST["resena"]."', pagfacebook='".$_POST["facebook"]."', pagtwitter='".$_POST["twitter"]."', latitud='".$_POST["latitud"]."', longitud='".$_POST["longitud"]."' WHERE idsitio='".$_GET["id"]."'";
		$result_update = pg_exec($con,$sql_update);
		
		//Si devuelve FALSE, ocurrió un error que no permitió que se ejecutara el update
		if(!$result_update){
			?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ERROR !!! \n     No se pudo modificar el sitio");
				location.href="../administracion/listadositios.php";
			</script><?php
		}
		
		//Si devuelve TRUE, se pudo ejecutar el update del sitio
		else{
			/*Si se modificó la imagen de perfil*/
			if($_FILES['perfil']['name']!=""){
				//Antes de actualizar, se busca la foto anterior para luego eliminarla
				$sql = "SELECT * FROM sitio WHERE idsitio=".$_GET["id"];
				$result_select = pg_exec($con,$sql);
				$sitio = pg_fetch_array($result_select,0);	
				
				//Si ya tenía icono cargado, se borra la imagen de la carpeta respectiva
				if($sitio["imagen_perfil"]!=""){
					$borrar = borrarArchivo("../".$sitio["imagen_perfil"]);
				}
				/*Se sube la imagen*/
				$subir_perfil = new imgUpldr;	
				//Se prepara el nombre con que se guardará la imagen
				$nombreImagen = $_GET["id"]."-".$_POST["nombre"];	
				$subir_perfil->configurar($nombreImagen,"../imagenes/sitios/perfil/",450,300);
				$subir_perfil->init($_FILES['perfil']);
				$destino_perfil = "imagenes/sitios/perfil/".$subir_perfil->_name;
		
				/*Se actualiza el registro para incluir la ruta de la imagen que se acaba de subir*/
				$sql_update = "UPDATE sitio SET imagen_perfil='".$destino_perfil."' WHERE idsitio='".$_GET["id"]."'";
				$result_update = pg_exec($con, $sql_update);	
				
				//Si el query devuelve FALSE, ocurrió un error
				if(!$result_update){
					?><script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!!\n\n     No se pudo modificar la imagen de perfil");
						location.href="../administracion/listadositios.php";
					</script><?php
				}
			}//end files perfil name != ""
			/*--------------------------------------------------------------------------------------------------------------
			*
				Para crear la relacion sitio_medio_pago
			*
			--------------------------------------------------------------------------------------------------------------*/
			$con = conectarse();		
			
			/*Si ya existian registros para este sitio dentro de sitio_medio_pago, se deben eliminar PRIMERO*/
			$sql_delete = "DELETE FROM sitio_medio_pago WHERE idsitio='".$_GET["id"]."';";
			$result_delete = pg_exec($con,$sql_delete);
			if(!$result_delete){
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ ERROR !!! \n     No se pudieron actualizar los medios de pago");
					location.href = "../administracion/editarsitios.php?id="+<?php echo $_GET["id"];?>+"&sub="+<?php echo $_GET["sub"];?>+"&ruta="+<?php echo $_GET["ruta"]; ?>;		
 		 		</script><?php
	 		}
			
			$sql_select_mp = "SELECT * FROM medio_pago";
			$result_select_mp = pg_exec($con, $sql_select_mp);
				
			/*Si existen, se construye una lista con todas para revisar los checkbox que están seleccionados*/						
			if(pg_num_rows($result_select_mp)>0){
				for($i=0; $i<pg_num_rows($result_select_mp); $i++){
					$medioPago = pg_fetch_array($result_select_mp,$i);
					$idMedio = $medioPago[0];
					$variableOculta = "Hid".$idMedio;
					
					//Si la variable oculta es != -1 es porque está seleccionado el check, entonces...
					if($_POST[$variableOculta] != -1){
						/*Se inserta el nuevo registro*/			
						$sql_insert = "INSERT INTO sitio_medio_pago VALUES(nextval('sitio_medio_pago_idsitio_medio_pago_seq'),'".$_GET["id"]."','".$idMedio."');";
						$result_insert = pg_exec($con,$sql_insert);
					
						//Si NO se pudo insertar en la tabla el nuevo registro
						if(!$result_insert){
							?><script type="text/javascript" language="javascript">
								alert("¡¡¡ ERROR !!! \n     No se pudieron actualizar los medios de pago permitidos por este sitio");
								location.href = "../administracion/editarsitios.php?id="+<?php echo $_GET["id"];?>+"&sub="+<?php echo $_GET["sub"];?>+"&ruta="+<?php echo $_GET["ruta"]; ?>;		
							</script><?php
						}
					}
				}//end for de medios de pago
			}//end de pg_num_rows($result_select_mp)>0
								
			/*--------------------------------------------------------------------------------------------------------------
			*
				Para saber si el sitio creado es de la categoría padre HOSPEDAJE, GASTRONOMÍA o ninguna de ellas
				para redireccionar a diversas páginas según sea el caso    $_GET["id"]
			*
			--------------------------------------------------------------------------------------------------------------*/
			$con = conectarse();				
			$sql_categoria = "SELECT * FROM categoria c JOIN subcategoria sc ON c.idcategoria=sc.idcategoria AND sc.idsubcategoria=".$_GET["sub"].";";					
			$res_sql_categoria = pg_exec($con, $sql_categoria);
					
			if(pg_num_rows($res_sql_categoria)!=0){
				
				$categoria = pg_fetch_array($res_sql_categoria,0);
				$nombreCategoria = $categoria[1];				
				?>
        		<script type="text/javascript" language="javascript">
					alert("¡¡¡ Sitio editado satisfactoriamente !!!\n\n    A continuación complete la información del mismo");
				</script>
			    <?php
					
				if($nombreCategoria=='Hospedaje'){
					/*---------------------------------------------------------------------------------------------------------
								Se prepara la variable idHospe a enviar, para que envíe -1 en caso de que no haya
					 			en HOSPEDAJE registros asociados a este sitio, o si SI los hay envie el idhospedaje
					 ---------------------------------------------------------------------------------------------------------*/
					$sql_select = "SELECT * FROM hospedaje WHERE idsitio='".$_GET["id"]."';";
					$result_select = pg_exec($con, $sql_select);
					
					$idHospedaje = -1;
					if(pg_num_rows($result_select)>0){
						$hospedaje = pg_fetch_array($result_select,0);
						$idHospedaje = $hospedaje[0];
					}
					
					$idSitio = $_GET["id"];
					?><script type="text/javascript" language="javascript">
						location.href = "../administracion/editarhospedaje.php?idSitio="+<?php echo $idSitio;?>+"&idHospe="+<?php echo $idHospedaje;?>;</script><?php
				}//end categoria HOSPEDAJE
				else if($nombreCategoria=='Gastronomía'){
					$sql_select = "SELECT * FROM gastronomia WHERE idsitio='".$_GET["id"]."';";
					$result_select = pg_exec($con, $sql_select);
					
					$idGastronomia = -1;
					if(pg_num_rows($result_select)>0){
						$gastronomia = pg_fetch_array($result_select,0);
						$idGastronomia = $gastronomia[0];
					}
					
					$idSitio = $_GET["id"];
					?>
        			<script type="text/javascript" language="javascript">
						location.href = "../administracion/editargastronomia.php?idSitio="+<?php echo $idSitio;?>+"&idGastro="+<?php echo $idGastronomia;?>;
					</script>
			       	<?php
				}//end categoria GASTRONOMIA
				else{
					?>
        			<script type="text/javascript" language="javascript">
						location.href = "../administracion/creargaleriafotos.php?idSitio="+<?php echo $_GET["id"];?>;
					</script>
			       	<?php
				}
			}//end if					
		}//end else result update - end de consulta exitosa
	}
?>

<body onload="cargo(),inicializacion()">
	<div class="banner"></div>
    <div class="menu">    				
		<?php menu_administrativo();  

		/*Se seleccionan los datos del id que se recibe por GET*/
		$con = conectarse();
		$sql_select = "SELECT * FROM sitio WHERE idsitio='".$_GET["id"]."';";
		$result_select = pg_exec($con, $sql_select);
		$arreglo = pg_fetch_array($result_select,0);
		?>		                       
    </div>
    <div class="panel">
    	<div class="titulo_panel">Editar Sitio de Interés </div>
        <div class="opcion_panel">
	        <div class="opcion"><a href="listadositios.php">Listar Sitios</a></div>
        	<div class="opcion" style="background:#F00; color:#FFF;"><a href="crearsitio.php">Registrar Nuevo Sitio</a></div>
	    </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
	  			<div class="linea_formulario">
                	<div class="linea_titulo_2">Información Básica</div>                    
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Tipo de Sitio (*)</div>
                    <div class="linea_campo_promedio">	
						<?php 
						/*Se buscan todas las subcategorias de la categoria seleccionada*/
						/*$con2 = conectarse();		
						$sql_select = "SELECT * FROM subcategoria ORDER BY nombre;";
						$result_select = pg_exec($con2, $sql_select);*/
						
						//Se consulta el id y nombre de la subcategoria asociada a este sitio
						$sql_select_subcategoria = "SELECT * FROM subcategoria WHERE idsubcategoria ='".$_GET["sub"]."';";
						$result_select_subcategoria = pg_exec($con, $sql_select_subcategoria);
						$subcategoria_sel = pg_fetch_array($result_select_subcategoria,0);
						$nombreSeleccionado = $subcategoria_sel[2];
					    
						?>
						<input type="hidden" name="HidSubCategoria" value="<?php echo $_GET["sub"]; ?>" />
						<?php
						
						/*Si existen, se construye una lista con todas*/						
						//if(pg_num_rows($result_select)!=0){
						?>
						<tr>
							<td>
								<select name="subcategoria" id="subcategoria" disabled="disabled">
								<option value="<?php echo $_GET["sub"]; ?>"><?php echo $nombreSeleccionado; ?></option>
								<?php
								/*for($i=0; $i<pg_num_rows($result_select); $i++){
						   			$subcategoria = pg_fetch_array($result_select,$i);
									
									//Se agregan a la lista todas las demas subcategorias
									if($subcategoria[0]!=$_GET["sub"]){
										echo '<option value="'.$subcategoria[0].'">'.$subcategoria[2].'</option>';
									}	*/							
								//}
								?>
								</select>							
							</td>
						</tr>
						<?php
						//}
						?>	
	               	</div>
    	        </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Ruta (*)</div>
                    <div class="linea_campo_promedio">
						
                    	<?php
						/*Se buscan todas las rutas*/
						$con3 = conectarse();		
						$sql_select = "SELECT * FROM ruta ORDER BY nombre;";
						$result_select = pg_exec($con3, $sql_select);
						
						//Se consulta el id y nombre de la ruta asociada a este sitio
						$sql_select_ruta = "SELECT * FROM ruta WHERE idruta ='".$_GET["ruta"]."';";
						$result_select_ruta = pg_exec($con, $sql_select_ruta);
						$rutaSeleccionada = pg_fetch_array($result_select_ruta,0);
						$nombreRutaSel = $rutaSeleccionada[1];
					    
						?>
						<input type="hidden" name="HidRuta" value="<?php echo $_GET["ruta"]; ?>" />
						<?php
						
						/*Si existen, se construye una lista con todas*/						
						if(pg_num_rows($result_select)!=0){
							?>
							<tr>
								<td>
									<select name="ruta" id="ruta" onChange="javascript:guardarValorCombo(this.value,2)" disabled="disabled">
									<option value="<?php echo $_GET["ruta"]; ?>"><?php echo $nombreRutaSel; ?></option>
									<?php
									for($i=0; $i<pg_num_rows($result_select); $i++){
						    			$ruta = pg_fetch_array($result_select,$i);
										
										//Se agregan a la lista todas las demas subcategorias
										if($ruta[0]!=$_GET["ruta"]){
											echo '<option value="'.$ruta[0].'">'.$ruta[1].'</option>';
										}										
									}
									?>
									</select>
							  </td>
							</tr>									    
							<?php            		   		
						}
						?>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
					<div class="linea_titulo_promedio">Imagen de Perfil (*): </div>
					<div class="linea_campo_promedio"><input name="perfil" type="file" id="perfil"/></div>
				</div>
				<div class="linea_formulario_doble">
                	<div class="linea_titulo_doble"></div>
                </div>
				<div class="linea_formulario_tres_cuartos">
                	<div class="linea_titulo_tres_cuartos">Nombre del Sitio (*)</div>
                    <div class="linea_campo_tres_cuartos">
                    	<input type="text" class="campo_tres_cuartos" id="nombre" name="nombre" maxlength="100" value="<?php echo $arreglo[3]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Teléfono 1 (*) [Ej:0277-5123456]</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="tel1" name="tel1" maxlength="12" value="<?php echo $arreglo[5]; ?>"/>
                    </div>					
                </div>
				<div class="linea_formulario_tres_cuartos">
                	<div class="linea_titulo_tres_cuartos">Dirección (*)</div>
                    <div class="linea_campo_tres_cuartos">
                    	<input type="text" class="campo_tres_cuartos" id="direccion" name="direccion" maxlength="400" value="<?php echo $arreglo[4]; ?>"/>
                    </div>
                </div>			
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Teléfono 2 [Ej:0277-5123456]</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="tel2" name="tel2" maxlength="12" value="<?php echo $arreglo[6]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Reseña histórica</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="resena" name="resena" maxlength="2000" value="<?php echo $arreglo[8]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Correo electrónico</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="correo" name="correo" maxlength="60" value="<?php echo $arreglo[7]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Página de Facebook</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="facebook" name="facebook" maxlength="200" value="<?php echo $arreglo[9]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Página de Twitter</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="twitter" name="twitter" maxlength="200" value="<?php echo $arreglo[10]; ?>"/>
                    </div>
                </div>				
				<div class="linea_formulario"></div>
				<div class="linea_formulario">
                	<div class="linea_titulo_2">Ubicación Geográfica</div>                    
                </div>
				<div class="linea_formulario"></div>
				<div class="linea_formulario"></div>
				<div id="map_canvas" style="width:70%; height:280px; margin-left:auto; margin-right:auto" align="center"></div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido_rojo">Busque el sitio en el mapa y haga clic en él</div>
                    <div class="linea_titulo_compartido_rojo">para cargar las coordenadas</div>
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Latitud (*)</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="latitud" name="latitud" maxlength="200" value="<?php echo $arreglo[11]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Longitud (*)</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="longitud" name="longitud" maxlength="200" value="<?php echo $arreglo[12]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario"></div>
				<div class="linea_formulario">
                	<div class="linea_titulo_2">Medios de Pago Permitidos</div>                    
                </div>
				<?php 		
				/*Primero se consulta si existen reg en sitio_medio_pago asociados a este sitio*/					
				$sql_sel_sitio_medio = "SELECT * FROM sitio_medio_pago WHERE idsitio=".$_GET["id"].";";
				$result_sel_sitio_medio = pg_exec($con, $sql_sel_sitio_medio);	
				
				/*Se consultan los medios de pago para cargar los checkbox y MARCAR aquellos que están asociados al sitio*/
				$sql_sel_medio = "SELECT * FROM medio_pago ORDER BY nombre";
				$result_select_medio = pg_exec($con, $sql_sel_medio);
				
				/*Se construye lista con todas*/						
				if(pg_num_rows($result_select_medio)>0){
				?>
				<tr>
					<td>						
						<?php
						for($i=0; $i<pg_num_rows($result_select_medio); $i++){
							$medio = pg_fetch_array($result_select_medio,$i);
							$idMedio = $medio[0];
							$nombre = $medio[1];
							
							/*Se crean los checkbox de c/comodidad y en el onclick se llama a la funcion que guarda el valor en la 
							  variable oculta Hid*/
							echo '<div class="linea_formulario_promedio">';
								echo '<div class="linea_titulo_promedio">';
									echo '<div class="linea_campo_promedio">';
										
										/*Antes de crear el checkbox, se verifica si ese sitio posee esa comodidad para marcarlo*/
										$valorOculto = -1;
										
										if(pg_num_rows($result_sel_sitio_medio)>0){
											for($j=0; $j<pg_num_rows($result_sel_sitio_medio); $j++){
												$sitio_medio = pg_fetch_array($result_sel_sitio_medio,$j);
											
												//Si el sitio permite ese medio de pago
												if($sitio_medio[1]==$_GET["id"] && $sitio_medio[2]==$idMedio){
													$valorOculto = $idMedio;
													$j = pg_num_rows($result_sel_sitio_medio);
												}
											}
										}
										
										//Si el medio de pago no está para ese sitio, lo dibuja SIN MARCA
										if($valorOculto==-1){
											echo '<input type="checkbox" name="'.$idMedio.'" value="'.$idMedio.'" onclick="guardarChecked('.$idMedio.')"/>'.$nombre;
										}
										//Sino, se dibuja MARCADO
										else{
											echo '<input type="checkbox" name="'.$idMedio.'" value="'.$idMedio.'" onclick="guardarChecked('.$idMedio.')" checked="checked"/>'.$nombre;
										}
										
										echo '<input type="hidden" name="Hid'.$idMedio.'" value="'.$valorOculto.'" />';																				
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
<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Crear Sitio</title>
		
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
			
        	//la condición
        	if (campoNombre.length==0 || campoDir.length==0 || campoTel1.length==0 || campoLat.length==0 || campoLong.length==0) {
				alert("Es necesario completar todos los campos marcados como obligatorios (*)");
				return false;
        	}
			else if(/^\s+$/.test(campoNombre) || (/^\s+$/.test(campoDir)) || (/^\s+$/.test(campoTel1)) || (/^\s+$/.test(campoLat)) || (/^\s+$/.test(campoLong))){
				alert("Ningún campo obligatorio puede quedar en blanco, ingrese valores válidos");
            	return false;
			}
        	return true;
	    }		
		/*********************************************************************************************
		*
			Funcion para guardar los valores seleccionados en los combos
		*
		**********************************************************************************************/
		function guardarValorCombo(valor,bandera)
		{
			//Bandera 1 es para guardar el valor de la subcategoria
			if(bandera==1 && valor != -1){
				document.all('HidSubCategoria').value = valor;
				//var texto = "Entro a guardarValorCombo 1 ::"+document.all('HidSubCategoria').value;
				//alert(texto);
			}
			else if(bandera==1 && valor == -1){
				document.all('HidSubCategoria').value = -1;
			}
			//Bandera 2 es para guardar el valor de la RUTA
			else if(bandera==2 && valor != -1){
				document.all('HidRuta').value = valor;
				//var texto = "Entro a guardarValorCombo 2 ::"+document.all('HidRuta').value;
				//alert(texto);
			}
			else if(bandera==2 && valor == -1){
				document.all('HidRuta').value = -1;
			}
			//alert(document.all('HidCategoria').value);			
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
		
		/*Se verifica que haya seleccionado una subcategoria y una ruta y que haya seleccionado logotipo e imagen de perfil*/
		if($_POST["HidSubCategoria"]!=-1 && $_POST["HidRuta"]!=-1 && $_FILES['perfil']['name']!="" /* && $_FILES['logo']['name']!=""*/){
			
			$con = conectarse();
			
			/*Se consulta la existencia de otro sitio en esa subcategoria con el mismo nombre*/
			$sql = "SELECT * FROM sitio WHERE idsubcategoria=".$_POST["HidSubCategoria"].";";
			$res = pg_exec($con, $sql);	
			$yaExiste = 0;
					
			if(pg_num_rows($res)>0){
				for($i=0; $i<pg_num_rows($res); $i++){				
					$sitio = pg_fetch_array($res,$i);	
					$nombreSitio = $sitio["nombre"];
					
					/*Si efectivamente ya existe ese sitio, no se le permite crearlo*/
					if($nombreSitio==$_POST["nombre"]){
						$yaExiste = 1;
						?>
			        	<script type="text/javascript" language="javascript">
							alert("¡¡¡ ERROR !!! \n\n     Ese sitio ya existe, por favor ingrese otro nombre");
							location.href="../administracion/crearsitio.php";
						</script>
        				<?php
					}
				}
			}
						
			/*Si por el contrario, no existe, se crea*/
			if($yaExiste==0){
				
				/*----------------------------------------------------------------------------------------------
				* 								SE VALIDA LA DIRECCION DE CORREO
				* Se permite la creación del sitio si: Opcion 1=Escribió en el campo correo y es correo VALIDO
				*									   Opcion 2=NO escribió en el campo correo (porque es un campo NO obligatorio)
				----------------------------------------------------------------------------------------------*/
				if( ($_POST["correo"]!="" && validaEmail($_POST["correo"])) || $_POST["correo"]==""){ 
					/*Se inserta el nuevo registro*/			
					$sql_insert = "INSERT INTO sitio VALUES(nextval('sitio_idsitio_seq'),".$_POST["HidSubCategoria"].",".$_POST["HidRuta"].",'".$_POST["nombre"]."','".$_POST["direccion"]."','".$_POST["tel1"]."','".$_POST["tel2"]."','".$_POST["correo"]."','".$_POST["resena"]."','".$_POST["facebook"]."','".$_POST["twitter"]."','".$_POST["latitud"]."','".$_POST["longitud"]."','');";
					$result_insert = pg_exec($con,$sql_insert);
					
					//Si NO se pudo insertar en la tabla el nuevo registro
					if(!$result_insert){
						?><script type="text/javascript" language="javascript">
							alert("¡¡¡ ERROR !!!\n\n     No se pudo crear el sitio");
							location.href="../administracion/listadositios.php";
						</script><?php	
					}
					//Si se insertó el nuevo sitio satisfactoriamente
					else{						
						/*Se selecciona el ultimo id asignado a sitio*/
						$sql_select = "SELECT last_value FROM sitio_idsitio_seq;";
						$result_select = pg_exec($con, $sql_select);
						$arreglo = pg_fetch_array($result_select,0);
						
						/*Se guarda la imagen de perfil de la empresa en la carpeta respectiva*/
						
						$nombreSitio = quitarAcentos($_POST["nombre"]);
						
						$subirPerfil = new imgUpldr;
						$subirPerfil->configurar($arreglo[0]."_".$nombreSitio,"../imagenes/sitios/perfil/",450,300);
						$subirPerfil->init($_FILES['perfil']);
						$destinoPerfil = "imagenes/sitios/perfil/".$subirPerfil->_name;
			
						/*Se actualiza el registro para incluir la ruta de la imagen que se acaba de subir*/
						$sql_update = "UPDATE sitio SET imagen_perfil='".$destinoPerfil."' WHERE idsitio='".$arreglo[0]."'";
						$result_update_perfil = pg_exec($con, $sql_update);	
						
						if(!$result_update_perfil){
							?><script type="text/javascript" language="javascript">
								alert("¡¡¡ ERROR !!!\n\n     No se pudo modificar la imagen de perfil");
								location.href="../administracion/listadositios.php";
							</script><?php	
					    }					
						/*--------------------------------------------------------------------------------------------------------------
						*
							Para crear la relacion sitio_mediopago
						*
						--------------------------------------------------------------------------------------------------------------*/
						$con = conectarse();
						/*Se selecciona el id del sitio recien creado*/
						$sql_select = "SELECT last_value FROM sitio_idsitio_seq;";
						$result_select = pg_exec($con, $sql_select);
						$sitio = pg_fetch_array($result_select,0);
						$idSitio = $sitio[0];
			
						/*Se consultan los medios de pago*/
						$sql_select_mp = "SELECT * FROM medio_pago";
						$result_select_mp = pg_exec($con, $sql_select_mp);
				
						/*Si existen, se construye una lista con todas para revisar los checkbox que están seleccionados*/						
						if(pg_num_rows($result_select_mp)>0){
							for($i=0; $i<pg_num_rows($result_select_mp); $i++){
								$medioPago = pg_fetch_array($result_select_mp,$i);
								$idMedioPago = $medioPago[0];
								$variableOculta = "Hid".$idMedioPago;
					
								//Si la variable oculta es != -1 es porque está seleccionada, entonces...
								if($_POST[$variableOculta] != -1){
						
									/*Se inserta el nuevo registro*/			
									$sql_insert = "INSERT INTO sitio_medio_pago VALUES(nextval('sitio_medio_pago_idsitio_medio_pago_seq'),'".$idSitio."','".$idMedioPago."');";
									$result_insert = pg_exec($con,$sql_insert);
						
									//Si NO se pudo insertar en la tabla el nuevo registro
									if(!$result_insert){
										?><script type="text/javascript" language="javascript">
											alert("¡¡¡ ERROR !!! \n     No se pudo guardar el medio de pago para este sitio");
											location.href="../administracion/listadositios.php";
										</script><?php
									}
								}//end variable oculta != -1
							}//end for
						}//end if num rows			
						
						/*--------------------------------------------------------------------------------------------------------------
							Para saber si el sitio creado es de la categoría padre HOSPEDAJE, GASTRONOMÍA o ninguna de ellas
							para redireccionar a diversas páginas según sea el caso
						--------------------------------------------------------------------------------------------------------------*/
						/*Se busca la categoria padre*/
						$sql_categoria = "SELECT * FROM categoria c JOIN subcategoria sc ON c.idcategoria=sc.idcategoria AND sc.idsubcategoria=".$_POST["HidSubCategoria"].";";					
						$res_sql_categoria = pg_exec($con, $sql_categoria);
					
						if(pg_num_rows($res_sql_categoria)!=0){
						
							$categoria = pg_fetch_array($res_sql_categoria,0);
							$nombreCategoria = quitarAcentos($categoria["nombre"]);
						
							?><script type="text/javascript" language="javascript">
								alert("¡¡¡ Sitio agregado satisfactoriamente !!!\n\n    A continuación complete más información relacionada con el sitio que acaba de crear");</script><?php
						
							if($nombreCategoria=='Hospedaje'){
								?><script type="text/javascript" language="javascript">
									location.href = "../administracion/crearhospedaje.php?idSitio="+<?php echo $sitio[0];?>;
								</script><?php
							}
							else if($nombreCategoria=='Gastronomia'){
								?><script type="text/javascript" language="javascript">
									location.href = "../administracion/creargastronomia.php?idSitio="+<?php echo $sitio[0];?>;
								</script><?php
							}
							else{
								?><script type="text/javascript" language="javascript">
									location.href = "../administracion/creargaleriafotos.php?idSitio="+<?php echo $sitio[0];?>;
								</script><?php
							}
						}//end if																
					}//end else	del if(!$result_insert)	
				}//end validacion de correo electronico
				else{
					?><script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!!\n\n    Correo inválido");
						location.href = "../administracion/crearsitio.php";
					</script><?php
				}
			}//end if($yaExiste==0)
		}//end if($_POST["HidSubCategoria"]!=-1 && $_POST["HidRuta"]!=-1)
		
		//Si las variables de SUBCATEGORIA, RUTA E IMAGEN DE PERFIL están en -1 es porque NO se ha seleccionado el combo
		else{
			?><script language="JavaScript" type="text/javascript">
				var cont = 1;
				var txt = "¡¡¡ ALERTA !!!! Debe seleccionar...\n";
			</script><?php
			/*Falta seleccionar la SUBCATEGORIA*/
			if($_POST["HidSubCategoria"]==-1){
				?><script type="text/javascript" language="javascript">
					txt += "\n"+cont+") Tipo de Sitio";
					cont++;
				</script><?php
			}			
			/*Falta seleccionar la RUTA*/
			if($_POST["HidRuta"]==-1){
				?><script type="text/javascript" language="javascript">
					txt += "\n"+cont+") Ruta a la que pertenece el sitio";
					cont++;
				</script><?php
			}			
			/*Falta seleccionar la IMAGEN DE PERFIL*/
			if($_FILES['perfil']['name']==""){
				?><script type="text/javascript" language="javascript">
					txt += "\n"+cont+") Imagen de perfil";
					cont++;
				</script><?php
			}
			/*Muestra el mensaje alertando los campos que falta por completar*/
			?><script type="text/javascript" language="javascript">alert(txt);</script><?php
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
    	<div class="titulo_panel">Crear Sitios de Interés</div>
        <div class="opcion_panel">
	        <div class="opcion"><a href="listadositios.php">Listar Sitios</a></div>
        	<div class="opcion" style="background:#F00; color:#FFF;"><a href="crearsitio.php" style="text-decoration:none; color:#FFF;">Registrar Nuevo Sitio</a></div>
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
  			   	<div class="linea_formulario">
                	<div class="linea_titulo_2">Información Básica</div>                    
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Tipo de Sitio (*)</div>
                    <div class="linea_campo_promedio">
						<input type="hidden" name="HidSubCategoria" value="-1" />                    	
						<?php 
						/*Se buscan todas las subcategorias de la categoria seleccionada*/
						$con = conectarse();		
						$sql_select = "SELECT * FROM subcategoria ORDER BY nombre;";
						$result_select = pg_exec($con, $sql_select);
						
						/*Si existen, se construye una lista con todas*/						
						if(pg_num_rows($result_select)!=0){
						?><tr>
							<td>
								<select name="subcategoria" id="subcategoria" onChange="javascript:guardarValorCombo(this.value,1)" style="font-size:12px">
								<option value="-1">Seleccione</option>
								<?php
								for($i=0; $i<pg_num_rows($result_select); $i++){
						   			$subcategoria = pg_fetch_array($result_select,$i);
									echo '<option value="'.$subcategoria["idsubcategoria"].'">'.$subcategoria["nombre"].'</option>';
								}?>
								</select>							
							</td>
						</tr>
						<?php
						}else{
							?><tr>
								<td>
									<select name="subcategoria" id="subcategoria"><option value="-1">No hay registros cargados</option></select>
							  </td>
							</tr><?php    
						}
						?>	
                	</div>
                </div> 
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Ruta (*)</div>
                    <div class="linea_campo_promedio">
						<input type="hidden" name="HidRuta" value="-1" />
                    	<?php
						/*Se buscan todas las rutas*/
						$con = conectarse();		
						$sql_select = "SELECT * FROM ruta ORDER BY nombre;";
						$result_select = pg_exec($con, $sql_select);
						
						/*Si existen, se construye una lista con todas*/						
						if(pg_num_rows($result_select)!=0){
							?><tr>
								<td>
									<select name="ruta" id="ruta" onChange="javascript:guardarValorCombo(this.value,2)" style="font-size:12px">
									<option value="-1">Seleccione</option>
									<?php
									for($i=0; $i<pg_num_rows($result_select); $i++){
						    			$ruta = pg_fetch_array($result_select,$i);
										echo '<option value="'.$ruta["idruta"].'">'.$ruta["nombre"].'</option>';
									}?>
									</select>
							  </td>
							</tr><?php            		   		
						}else{
							?><tr>
								<td>
									<select name="ruta" id="ruta"><option value="-1">No hay rutas cargadas</option></select>
							  </td>
							</tr><?php    
						}
						?>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
					<div class="linea_titulo_promedio">Imagen de Perfil (*): </div>
					<div class="linea_campo_promedio"><input name="perfil" type="file" id="perfil"/></div>
				</div>
				<div class="linea_formulario_tres_cuartos">
                	<div class="linea_titulo_tres_cuartos">Nombre del Sitio (*)</div>
                    <div class="linea_campo_tres_cuartos">
                    	<input type="text" class="campo_tres_cuartos" id="nombre" name="nombre" maxlength="100"/>
                    </div>
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Teléfono 1 (*) [Ej:0277-5123456]</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="tel1" name="tel1" maxlength="12"/>
                    </div>					
                </div>
				<div class="linea_formulario_tres_cuartos">
                	<div class="linea_titulo_tres_cuartos">Dirección (*)</div>
                    <div class="linea_campo_tres_cuartos">
                    	<input type="text" class="campo_tres_cuartos" id="direccion" name="direccion" maxlength="400"/>
                    </div>
                </div>			
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Teléfono 2 [Ej:0277-5123456]</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="tel2" name="tel2" maxlength="12"/>
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Reseña histórica</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="resena" name="resena" maxlength="2000"/>
                    </div>
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Correo electrónico</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="correo" name="correo" maxlength="60"/>
                    </div>
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Página de Facebook</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="facebook" name="facebook" maxlength="200"/>
                    </div>
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Página de Twitter</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="twitter" name="twitter" maxlength="200"/>
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
                    	<input type="text" class="campo_compartido" id="latitud" name="latitud" maxlength="200"/>
                    </div>
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Longitud (*)</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="longitud" name="longitud" maxlength="200"/>
                    </div>
                </div>
				<div class="linea_formulario"></div>
				<div class="linea_formulario">
                	<div class="linea_titulo_2">Medios de Pago Permitidos</div>                    
                </div>
				<?php 
				/*Se buscan todos los medios de pago para que el usuario seleccione los deseados*/
				$con = conectarse();		
				$sql_select_mp = "SELECT * FROM medio_pago ORDER BY nombre";
				$result_select_mp = pg_exec($con, $sql_select_mp);	
									
				/*Si existen, se construye una lista con todas*/						
				if(pg_num_rows($result_select_mp)>0){
				?>
				<tr>
					<td>						
						<?php
						for($i=0; $i<pg_num_rows($result_select_mp); $i++){
							$mediopago = pg_fetch_array($result_select_mp,$i);
							$idMedioPago = $mediopago["idmedio_pago"];
							$nombre = $mediopago["nombre"];
							
							/*Se crean los checkbox de c/comodidad y en el onclick se llama a la funcion que guarda el valor en la 
							  variable oculta Hid*/
							echo '<div class="linea_formulario_promedio">';
								echo '<div class="linea_titulo_promedio">';
									echo '<div class="linea_campo_promedio">';
										echo '<input type="hidden" name="Hid'.$idMedioPago.'" value="-1" />';
										echo '<input type="checkbox" name="'.$idMedioPago.'" value="'.$idMedioPago.'" onclick="guardarChecked('.$idMedioPago.')"/>'.$nombre;										
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
				else{?>
					<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">No hay medios de pago cargados</div>                  
	                </div>
					<?php
				}
				?>
				<div class="linea_formulario"></div>
				<div class="linea_formulario"></div>
            	<div class="linea_formulario">
					<div class="linea_titulo_rojo">
						<input type="submit" value="Guardar sitio" name="Guardar" style="font-size:12px;" align="left"/>(*) Campos obligatorios
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
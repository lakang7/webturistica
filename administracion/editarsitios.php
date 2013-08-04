<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>EditarSitios</title>
	
    <link rel="stylesheet" href="../css/administracion/estructura.css" type="text/css"  />
	<link rel="stylesheet" type="text/css" href="../css/administracion/component.css" />
	<link rel="stylesheet" type="text/css" href="../css/administracion/default.css" />
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css' />       
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js" ></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" ></script>    
    <script src="../js/administracion/modernizr.custom.js"></script>
    <script src="../js/administracion/jquery.dlmenu.js"></script>    
	<script type="text/javascript">  
    	//Funcion para validar campo de texto, que NO permita ni campo vacío ni introducir solo espacios en blanco
		function validarCampo(formulario) {
        	//obteniendo el valor que se puso en el campo texto del formulario
        	campoDir = formulario.direccion.value;
			campoNombre = formulario.nombre.value;
			campoTel1 = formulario.tel1.value;
			campoLat = formulario.latitud.value;
			campoLong = formulario.longitud.value;
			
        	//la condición
        	if (campoNombre.length == 0 || campoDir.length == 0 || campoTel1.length == 0 || latitud.length == 0 || longitud.length == 0) {
				alert("Es necesario completar todos los campos marcados como obligatorios (*)");
				return false;
        	}
			else if(/^\s+$/.test(campoNombre) || (/^\s+$/.test(campoDir)) || (/^\s+$/.test(campoTel1)) || (/^\s+$/.test(campoLat)) || (/^\s+$/.test(campoLong))){
				alert("Ningún campo obligatorio puede quedar en blanco, ingrese valores válidos");
            	return false;
			}		
			//Para validar el correo	
        	return true;
	    }
		
		//Funcion para guardar en una variable oculta la CATEGORIA a la cual pertenecerá esta subcategoria
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
	</script>

</head>

<?php
	if(isset($_POST["Guardar"])){
		/*Se actualiza el registro*/
		$con = conectarse();
		$sql_update = "UPDATE sitio SET nombre='".$_POST["nombre"]."', direccion='".$_POST["direccion"]."', telefono1='".$_POST["tel1"]."', telefono2='".$_POST["tel2"]."', correo='".$_POST["correo"]."', resena='".$_POST["resena"]."', pagfacebook='".$_POST["facebook"]."', pagtwitter='".$_POST["twitter"]."', latitud='".$_POST["latitud"]."', longitud='".$_POST["longitud"]."' WHERE idsitio='".$_GET["id"]."'";
		
		$result_update=pg_exec($con,$sql_update);
		
		if($_FILES['icono']['name']!=""){
	
			/*Se sube el icono de la categoria*/
			$subir = new imgUpldr;		
			$subir->configurar($_POST["nombre"],"../imagenes/sitios/",591,591);
			$subir->init($_FILES['icono']);
			$destino = $subir->_dest.$subir->_name;
		
			/*Se actualiza el registro para incluir la ruta del icono que se acaba de subir*/
			$sql_update = "UPDATE subcategoria SET icono='".$destino."' WHERE idsubcategoria='".$_GET["id"]."'";
			$result_update = pg_exec($con, $sql_update);				
		}
		
		?>
        	<script type="text/javascript" language="javascript">
				alert("¡¡¡ Subcategoria editada satisfactoriamente !!!");
				location.href="../administracion/listadosubcategorias.php";
			</script>
        <?php	
	}
?>

<body onload="cargo()">
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
    	<div class="titulo_panel">Editar Sitio de Interés</div>
        <div class="opcion_panel">
	        <div class="opcion"><a href="listadositios.php">Listar Sitios</a></div>
        	<div class="opcion" style="background:#F00; color:#FFF;"><a href="crearsitio.php">Registrar Nuevo Sitio</a></div>
	    </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
	  			<div class="linea_formulario">
        	       	<div class="linea_titulo">Tipo de Sitio (*)</div>
					<div class="linea_campo">						                    	
						<?php 
						/*Se buscan todas las subcategorias de la categoria seleccionada*/
						$con2 = conectarse();		
						$sql_select = "SELECT * FROM subcategoria ORDER BY nombre;";
						$result_select = pg_exec($con2, $sql_select);
						
						//Se consulta el id y nombre de la subcategoria asociada a este sitio
						$sql_select_subcategoria = "SELECT * FROM subcategoria WHERE idsubcategoria ='".$_GET["sub"]."';";
						$result_select_subcategoria = pg_exec($con, $sql_select_subcategoria);
						$subcategoria_sel = pg_fetch_array($result_select_subcategoria,0);
						$nombreSeleccionado = $subcategoria_sel[2];
					    
						?>
						<input type="hidden" name="HidSubCategoria" value="<?php echo $_GET["sub"]; ?>" />
						<?php
						
						/*Si existen, se construye una lista con todas*/						
						if(pg_num_rows($result_select)!=0){
						?>
						<tr>
							<td>
								<select name="subcategoria" id="subcategoria" onChange="javascript:guardarValorCombo(this.value,1)">
								<option value="<?php echo $_GET["sub"]; ?>"><?php echo $nombreSeleccionado; ?></option>
								<?php
								for($i=0; $i<pg_num_rows($result_select); $i++){
						   			$subcategoria = pg_fetch_array($result_select,$i);
									
									//Se agregan a la lista todas las demas subcategorias
									if($subcategoria[0]!=$_GET["sub"]){
										echo '<option value="'.$subcategoria[0].'">'.$subcategoria[2].'</option>';
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
				<div class="linea_formulario">
                	<div class="linea_titulo">Ruta a la que pertenece el sitio (*)</div>
                    <div class="linea_campo">
						
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
									<select name="ruta" id="ruta" onChange="javascript:guardarValorCombo(this.value,2)">
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
				<div class="linea_formulario">
                	<div class="linea_titulo">Nombre del Sitio (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="nombre" name="nombre" value="<? echo $arreglo[3]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Dirección (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="direccion" name="direccion" value="<? echo $arreglo[4]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Teléfono 1 (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="tel1" name="tel1" value="<? echo $arreglo[5]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Teléfono 2</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="tel2" name="tel2" value="<? echo $arreglo[6]; ?>" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Correo</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="correo" name="correo" value="<? echo $arreglo[7]; ?>" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Reseña histórica</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="resena" name="resena" value="<? echo $arreglo[8]; ?>" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Página de Facebook</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="facebook" name="facebook" value="<? echo $arreglo[9]; ?>" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Página de Twitter</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="twitter" name="twitter" value="<? echo $arreglo[10]; ?>" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Logotipo del sitio</div>
                    <div class="linea_campo">
                    	<input name="logo" type="file" id="logo" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Imagen de Perfil</div>
                    <div class="linea_campo">
                    	<input name="perfil" type="file" id="perfil" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Latitud (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="latitud" name="latitud" value="<? echo $arreglo[12]; ?>" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Longitud (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="longitud" name="longitud" value="<? echo $arreglo[13]; ?>" />
                    </div>
                </div>
            	<div class="linea_formulario">
					<input type="submit" value="Guardar" name="Guardar" style="font-size:12px;" />(*) Campos obligatorios
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
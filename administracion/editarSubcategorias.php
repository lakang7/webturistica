<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Editar SubCategoría</title>
	
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
        	campoNombre = formulario.nombre.value;
        	//la condición
        	if (campoNombre.length == 0) {
				alert("Es necesario completar todos los campos marcados como obligatorios (*)");
            	return false;
        	}
			else if(/^\s+$/.test(campoNombre)){
				alert("Ningún campo obligatorio (*) puede quedar en blanco, ingrese valores válidos");
            	return false;
			}
        	return true;
	    }
		
		//Funcion para guardar en una variable oculta la CATEGORIA a la cual pertenecerá esta subcategoria
		function guardarCategoria(valor)
		{
			if(valor != -1){
				document.all('HidCategoria').value = valor;
			}
			else{
				document.all('HidCategoria').value = -1;
			}	
			//alert(document.all('HidCategoria').value);		
		}
	</script>

</head>

<?php
	if(isset($_POST["Guardar"])){
		
		/*Se actualiza el registro*/
		$con = conectarse();
		$sql_update = "UPDATE subcategoria SET idcategoria='".$_POST["HidCategoria"]."', nombre='".$_POST["nombre"]."' WHERE idsubcategoria='".$_GET["id"]."'";
		$result_update = pg_exec($con,$sql_update);
		
		//Si la consulta devuelve FALSE, es porque ocurrió un error
		if(!$result_update){
			?>
        	<script type="text/javascript" language="javascript">
				alert("¡¡¡ ERROR !!!\n\n     No se pudo modificar la subcategoria");
				location.href="../administracion/listadosubcategorias.php";
			</script>
	        <?php
		}
		
		//Sino es porque pudo hacer la actualización de subcategoria satisfactoriamente
		//entonces se procede a actualizar el icono
		else{
			
			/*Si se cargó un nuevo icono*/
			if($_FILES['icono']['name']!=""){
	
				/*Se sube la imagen a la ruta predefinida*/
				$subir = new imgUpldr;		
				$nombreImagen = $_GET["id"]."-".$_POST["nombre"];	
				$subir->configurar($nombreImagen,"../imagenes/subcategorias/",591,591);
				$subir->init($_FILES['icono']);
				$destino = $subir->_dest.$subir->_name;
				
				/*Se actualiza el registro para incluir la nueva ruta*/
				$sql_update = "UPDATE subcategoria SET icono='".$destino."' WHERE idsubcategoria='".$_GET["id"]."'";
				$result_update = pg_exec($con, $sql_update);
			
				/*Si la consulta devuelve FALSE, es porque ocurrió un error y no se pudo hacer el UPDATE*/
				if(!$result_update){
					?>
		        	<script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!!\n\n     No se pudo modificar la imagen del icono de la subcategoria");
						location.href="../administracion/listadosubcategorias.php";
					</script>
	    		    <?php
				}
			}
			
			/*Se actualiza el Nro. de Hijos del padre ANTERIOR ----------------------------------------------------------*/
			$con = conectarse();
						
			//Primero se consulta la cantidad de hijos del padre ANTERIOR
			$sql_select_hijos_padre_anterior = "SELECT * FROM categoria WHERE idcategoria=".$_GET['cat'].";";
			$result_select_hijos_padre_anterior = pg_exec($con, $sql_select_hijos_padre_anterior);
			$hijos_padre_anterior = pg_fetch_array($result_select_hijos_padre_anterior,0);
			
			//Luego se actualiza el padre ANTERIOR disminuyendole un hijo
			$menosHijos = $hijos_padre_anterior[2] - 1;
			$sql_update_padre_anterior = "UPDATE categoria SET hijos=".$menosHijos." WHERE idcategoria=".$_GET['cat'].";";
			$result_update_padre_anterior = pg_exec($con, $sql_update_padre_anterior);	
						
			if(!$result_update_padre_anterior){
				?>
				<script type="text/javascript" language="javascript">
					var txt = "ERROR: No se pudo actualizar el número de hijos de la categoria "+<?php echo $hijos_padre_anterior[1]; ?>;
					alert(txt);
					location.href="../administracion/listadosubcategorias.php";
				</script>
		       	<?php	
			}//end if
					
			/*Se actualiza el Nro. de Hijos del padre NUEVO ----------------------------------------------------------*/
			$con = conectarse();
						
			//Primero se consulta la cantidad de hijos del padre NUEVO
			$sql_select_hijos_padre_nuevo = "SELECT * FROM categoria WHERE idcategoria=".$_POST['HidCategoria'].";";
			$result_select_hijos_padre_nuevo = pg_exec($con, $sql_select_hijos_padre_nuevo);
			$hijos_padre_nuevo = pg_fetch_array($result_select_hijos_padre_nuevo,0);
				
			//Luego se actualiza el padre NUEVO disminuyendole un hijo
			$masHijos = $hijos_padre_nuevo[2] + 1;
			$sql_update_padre_nuevo = "UPDATE categoria SET hijos=".$masHijos." WHERE idcategoria=".$_POST['HidCategoria'].";";
			$result_update_padre_nuevo = pg_exec($con, $sql_update_padre_nuevo);	
						
			if(!$result_update_padre_nuevo){
				?>
    			<script type="text/javascript" language="javascript">
					var txt = "ERROR: No se pudo actualizar el número de hijos de la categoria "+<?php echo $hijos_padre_nuevo[1]; ?>;
					alert(txt);
					location.href="../administracion/listadosubcategorias.php";
				</script>
		       	<?php	
		    }
			
			/*Finaliza el UPDATE satisfactoriamente*/
			?>
    		<script type="text/javascript" language="javascript">
				alert("¡¡¡ Subcategoria editada satisfactoriamente !!!");
				location.href="../administracion/listadosubcategorias.php";
			</script>
    	    <?php	
		}//end else
	}
?>

<body onload="cargo()">
	<div class="banner"></div>
    <div class="menu">    				
		<?php menu_administrativo();  

		/*Se seleccionan los datos del id que se recibe por GET*/
		$con = conectarse();
		$sql_select = "SELECT * FROM subcategoria where idsubcategoria='".$_GET["id"]."';";
		$result_select = pg_exec($con, $sql_select);
		$arreglo = pg_fetch_array($result_select,0);
		?>		                       
    </div>
    <div class="panel">
    	<div class="titulo_panel">Editar Sub Categoría</div>
        <div class="opcion_panel">
	        <div class="opcion"> 
				<a href="listadosubcategorias.php">Listar Sub Categorías</a>
			</div>
        	<div class="opcion" style="background:#F00; color:#FFF;">
				<a href="crearsubcategorias.php">Registrar Nueva SubCategoría</a></div>
	        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
  			<input type="hidden" name="MAX_FILE_SIZE" value="200000000" />            
            	<div class="linea_formulario_compartido">
        	       	<div class="linea_titulo_compartido">Categoría padre (*)</div>
					<div class="linea_campo_compartido">						                    	
						<?php 
						/* Se busca el ID y NOMBRE de la categoria padre para cargarlo en la lista */
						$con2 = conectarse();		
						$sql_select = "SELECT * FROM categoria WHERE idcategoria=".$_GET["cat"].";";
						$result_select = pg_exec($con2, $sql_select);
						
						$categoria_padre_sel = pg_fetch_array($result_select,0);
						$nombreCatPadre = $categoria_padre_sel[1];
						
						/* Se consultan TODAS las categorias */
						$sql_select_categorias = "SELECT * FROM categoria;";
						$result_select_categorias = pg_exec($con2, $sql_select_categorias);
						
						?>
						<input type="hidden" name="HidCategoria" value="<?php echo $_GET["cat"]; ?>" />
						<?php
						
						/*Si existen, se construye una lista con todas*/						
						if(pg_num_rows($result_select_categorias)!=0){
						?>
						<tr>
							<td>
								<select name="categoria" id="categoria" onChange="javascript:guardarCategoria(this.value)">
								<option value="<?php echo $_GET["cat"]; ?>"><?php echo $nombreCatPadre; ?></option>
								<?php
								for($i=0; $i<pg_num_rows($result_select_categorias); $i++){
						   			$categoria = pg_fetch_array($result_select_categorias,$i);
									
									//Se agregan a la lista todas las demas categorias
									if($categoria[0] != $_GET["cat"]){
										echo '<option value="'.$categoria[0].'">'.$categoria[1].'</option>';
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
                	<div class="linea_titulo">Nombre Sub Categoría (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="nombre" name="nombre" maxlength="45" value="<? echo $arreglo[2]; ?>" />
                    </div>
                </div>
            	<div class="linea_formulario">
                	<div class="linea_titulo">Icono Identificador</div>
                    <div class="linea_campo">
                    	<input name="icono" type="file" id="icono"/>
                    </div>
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
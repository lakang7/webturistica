<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Crear Subcategoria</title>
		
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
		function validarCampoTexto(formulario) {
        	//obteniendo el valor que se puso en el campo texto del formulario
        	miCampoTexto = formulario.nombre.value;
        	//la condición
        	if (miCampoTexto.length == 0) {
				alert("Debe indicar el nombre de la subcategoria que desea registrar");
            	return false;
        	}
			else if(/^\s+$/.test(miCampoTexto)){
				alert("El nombre de la subcategoria no puede quedar en blanco, ingrese un nombre válido");
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
	
		//Si hay seleccionada alguna categoria
		if($_POST["HidCategoria"]!=-1){
			
			/*Se inserta el nuevo registro*/
			$con = conectarse();
			$sql_insert = "INSERT INTO subcategoria VALUES(nextval('subcategoria_idsubcategoria_seq'),".$_POST["HidCategoria"].",'".$_POST["nombre"]."',null);";
			$result_insert = pg_exec($con,$sql_insert);
		
			/*Se sube el icono de la subcategoria a la carpeta respectiva*/
			$subir = new imgUpldr;		
			$subir->configurar($_POST["nombre"],"../imagenes/subcategorias/",591,591);
			$subir->init($_FILES['icono']);
			$destino = $subir->_dest.$subir->_name;
		
			/*Se selecciona el id que le fue asignado a la subcategoria que se acaba de registrar en la base datos*/
			$sql_select = "SELECT last_value FROM subcategoria_idsubcategoria_seq;";
			$result_select = pg_exec($con, $sql_select);
			$arreglo = pg_fetch_array($result_select,0);
		
			/*Se actualiza el registro para incluir la ruta del icono que se acaba de subir*/
			$sql_update = "UPDATE subcategoria SET icono='".$destino."' WHERE idsubcategoria='".$arreglo[0]."'";
			$result_update = pg_exec($con, $sql_update);		
			
			/*Se actualiza el Nro. de Hijos de la CATEGORIA padre*/

			//Primero se consulta la cantidad de hijos del padre
			$sql_select_hijos = "SELECT hijos FROM categoria WHERE idcategoria=".$_POST['HidCategoria'].";";
			$result_select_hijos = pg_exec($con, $sql_select_hijos);
			$hijos = pg_fetch_array($result_select_hijos,0);
			
			//Luego Se actualiza el padre agregandole un hijo más
			$masHijos = $hijos[0] + 1;
			$sql_update_padre = "UPDATE categoria SET hijos=".$masHijos." WHERE idcategoria=".$_POST['HidCategoria'].";";
			$result_update = pg_exec($con, $sql_update_padre);		
		
			?>
        	<script type="text/javascript" language="javascript">
				alert("¡¡¡ Subcategoria agregada satisfactoriamente !!!");
				location.href = "../administracion/listadoSubcategorias.php";
			</script>
        	<?php			
		}
		else{
		?>
			<script type="text/javascript" language="javascript">
				alert("Debe seleccionar una categoria");
			</script>
		<?php
		}
	
			
	}
?>

<body onload="cargo()">
	<div class="banner"></div>
    <div class="menu"><?php menu_administrativo();?></div>
    <div class="panel">
    	<div class="titulo_panel">Crear SubCategoría</div>
        <div class="opcion_panel">
	        <div class="opcion"> <a href="listadoSubcategorias.php">Listar Subcategorias</a></div>
        	<div class="opcion" style="background:#F00; color:#FFF;"><a href="crearSubcategorias.php">Registrar Nueva Subcategoria</a></div>
        </div>
        <div class="capa_formulario">
		
        	<form onsubmit="return validarCampoTexto(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
  				<input type="hidden" name="MAX_FILE_SIZE" value="200000000" /> 				
				<div class="linea_formulario">
                	<div class="linea_titulo">Categoria</div>
                    <div class="linea_campo">
						<input type="hidden" name="HidCategoria" value="-1" />
                    	<?php
						/*Se buscan todas las categorias*/
						$con = conectarse();		
						$sql_select = "SELECT * FROM categoria ORDER BY idcategoria;";
						$result_select = pg_exec($con, $sql_select);
						
						/*Si existen, se construye una lista con todas*/						
						if(pg_num_rows($result_select)!=0){
							?>
							<tr>
								<td>
									<select name="categoria" id="categoria" onChange="javascript:guardarCategoria(this.value)">
									<option value="-1">Seleccione</option>
									<?php
									for($i=0; $i<pg_num_rows($result_select); $i++){
						    			$categoria = pg_fetch_array($result_select,$i);
										echo '<option value="'.$categoria[0].'">'.$categoria[1].'</option>';
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
                	<div class="linea_titulo">Nombre Subcategoria</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="nombre" name="nombre" />
                    </div>
                </div>
            	<div class="linea_formulario">
                	<div class="linea_titulo">Icono Identificador</div>
                    <div class="linea_campo">
                    	<input name="icono" type="file" id="icono" />
                    </div>
                </div>
                <div class="linea_formulario">
	              <input type="submit" value="Guardar" name="Guardar" style="font-size:12px;" />
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
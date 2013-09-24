<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Crear Subcategoría</title>
		
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
				alert("Es necesario completar todos los campos marcados como obligatorios (*)");
            	return false;
        	}
			else if(/^\s+$/.test(miCampoTexto)){
				alert("Ningún campo obligatorio puede quedar en blanco, ingrese valores válidos");
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
		
			$con = conectarse();
			
			/*Se consulta la existencia de otra subcategoria con el mismo nombre dentro de la misma categoria*/
			$sql = "SELECT * FROM subcategoria WHERE idcategoria=".$_POST["HidCategoria"];
			$res = pg_exec($con, $sql);	
			$yaExiste = 0;	
					
			for($j=0; $j<pg_num_rows($res); $j++){				
				$subCategoria = pg_fetch_array($res,$j);	
					
				/*Si efectivamente ya existe esa subcategoria, no se le permite crearla*/
				if($subCategoria["nombre"]==$_POST["nombre"]){
					$yaExiste = 1;
					?><script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!! \n\n     Ese nombre de subcategoría ya existe para la categoría seleccionada, por favor ingrese otro nombre");
						location.href = "../administracion/crearsubcategoria.php";
					</script><?php
				}
			}//end de recorrido de subcategorias
			
			/*Si al terminar de recorrer las subcat, la subcategoria NO existe para esa categoria, se crea*/
			if($yaExiste==0){
				/*Se inserta el nuevo registro*/			
				$sql_insert = "INSERT INTO subcategoria VALUES(nextval('subcategoria_idsubcategoria_seq'),".$_POST["HidCategoria"].",'".$_POST["nombre"]."');";
				$result_insert = pg_exec($con,$sql_insert);

				//Si NO se pudo insertar en la tabla el nuevo registro
				if(!$result_insert){
					?><script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!!\n\n     No se pudo crear la subcategoria");
						location.href="../administracion/listadosubcategorias.php";
					</script><?php	
				}else{									
					//Si hay cargada alguna imagen de icono
					if($_FILES['icono']['name']!=""){
						/*Se consulta el id de la ultima subcategoria recien creada*/
						$sql_select = "SELECT last_value FROM subcategoria_idsubcategoria_seq;";
						$result_select = pg_exec($con, $sql_select);
						$arreglo = pg_fetch_array($result_select,0);
						$idSubcategoria = $arreglo[0];
		
						//Se procesa el nombre para quitarle las tildes
						$nombreSub = quitarAcentos($_POST["nombre"]);
						/*Si SI se pudo, se sube el icono de la subcategoria a la carpeta respectiva*/
						$subir = new imgUpldr;	
						$subir->configurar($idSubcategoria."_".$nombreSub,"../imagenes/subcategorias/",591,591);
						$subir->init($_FILES['icono']);
						$destino = "imagenes/subcategorias/".$subir->_name;

						/*Se actualiza el registro para incluir la ruta del icono que se acaba de subir*/
						$sql_update = "UPDATE subcategoria SET icono='".$destino."' WHERE idsubcategoria='".$arreglo[0]."'";		
						$result_update = pg_exec($con, $sql_update);	
					
						if(!$result_update){
							?><script type="text/javascript" language="javascript">
								alert("¡¡¡ ERROR !!!\n\n     No se pudo guardar el icono asociado a esta subcategoría");
								location.href="../administracion/listadosubcategorias.php";
							</script><?php	
		    			}
					}
					?><script type="text/javascript" language="javascript">
						alert("¡¡¡ Subcategoria agregada satisfactoriamente !!!");
						location.href = "../administracion/listadosubcategorias.php";
					</script><?php
				}//end de se pudo insertar el registro
			}//end yaExiste==0
		}//end de seleccionada una categoria
		else{
			?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ALERTA !!!\n\n     Debe seleccionar una categoria");
			</script><?php
		}			
	}
?>

<body onload="cargo()">
	<div class="banner"></div>
    <div class="menu"><?php menu_administrativo();?></div>
    <div class="panel">
    	<div class="titulo_panel">Crear SubCategoría</div>
        <div class="opcion_panel">
	        <div class="opcion"> <a href="listadosubcategorias.php">Listar SubCategorías</a></div>
        	<div class="opcion" style="background:#F00; color:#FFF;"><a href="crearsubcategoria.php" style="text-decoration:none; color:#FFF;">Registrar Nueva SubCategoría</a></div>
        </div>
        <div class="capa_formulario">
		
        	<form onsubmit="return validarCampoTexto(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
  				<input type="hidden" name="MAX_FILE_SIZE" value="200000000" /> 				
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Categoría (*)</div>
                    <div class="linea_campo_compartido">
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
            	<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Nombre Subcategoría (*)</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="nombre" name="nombre" maxlength="45"/>
                    </div>
                </div>
            	<div class="linea_formulario">
                	<div class="linea_titulo">Icono Identificador</div>
                    <div class="linea_campo">
                    	<input name="icono" type="file" id="icono" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo"></div>
                    <div class="linea_campo"></div>
                </div>
                <div class="linea_formulario">
					<div class="linea_titulo_rojo">
						<input type="submit" value="Guardar Subcategoría" name="Guardar" style="font-size:12px;" align="left"/>(*) Campos obligatorios
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
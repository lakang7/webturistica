<?php session_start();
	  require("../recursos/funciones.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Editar Comodidades</title>
	
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
			campoDesc = formulario.descripcion.value;
			
        	//la condición
        	if (campoNombre.length == 0 || campoDesc.length == 0) {
				alert("Es necesario completar todos los campos marcados como obligatorios (*)");
            	return false;
        	}
			else if(/^\s+$/.test(campoNombre) || /^\s+$/.test(campoDesc)){
				alert("Ningún campo obligatorio (*) puede quedar en blanco, ingrese valores válidos");
            	return false;
			}			
			
        	return true;
	    }    
	</script>

</head>

<?php
	if(isset($_POST["Guardar"])){
		
		/*Se actualiza el registro*/
		$con = conectarse();
		$sql_update = "UPDATE especialidad SET nombre='".$_POST["nombre"]."', descripcion='".$_POST["descripcion"]."' WHERE idespecialidad='".$_GET["id"]."'";
		$result_update = pg_exec($con,$sql_update);
				
		?>
        	<script type="text/javascript" language="javascript">
				alert("¡¡¡ Especialidad gastronómica modificada satisfactoriamente !!!");
				location.href="../administracion/listadoespecialidades.php";
			</script>
        <?php	
	}
?>

<body onload="cargo()">
	<div class="banner"></div>
    <div class="menu">    				
		<?php menu_administrativo();  
		
		/*Se consultan los datos del id que llega por GET*/
		$con = conectarse();
		$sql_select = "SELECT * FROM especialidad WHERE idespecialidad='".$_GET["id"]."';";
		$result_select = pg_exec($con, $sql_select);
		$arreglo = pg_fetch_array($result_select,0);	
		?>		                       
    </div>
    <div class="panel">
    	<div class="titulo_panel">Editar Especialidad Gastronómica</div>
        <div class="opcion_panel">
	        <div class="opcion"> <a href="listadoespecialidades.php">Listar Especialidades</a></div>
        	<div class="opcion" style="background:#F00; color:#FFF;"><a href="crearespecialidad.php" style="text-decoration:none; color:#FFF;">Registrar Nueva Especialidad</a></div>
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
            	<div class="linea_formulario_compartido">
                	<div class="linea_titulo">Nombre (*)</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="nombre" name="nombre" maxlength="45" value="<? echo $arreglo[1]; ?>" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Descripción (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="descripcion" name="descripcion" maxlength="600" value="<? echo $arreglo[2]; ?>" />
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
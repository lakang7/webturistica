<?php session_start();
	  require("../recursos/funciones.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Crear Especialidades</title>
		
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
        	miCampoTexto = formulario.nombre.value;
			campoDesc = formulario.descripcion.value;
			
        	//la condición
        	if (miCampoTexto.length == 0 || campoDesc.length == 0) {
				alert("Es necesario completar todos los campos");
            	return false;
        	}
			else if(/^\s+$/.test(miCampoTexto) || /^\s+$/.test(campoDesc)){
				alert("Ningún campo puede quedar en blanco, ingrese valores válidos");
            	return false;
			}			
			
        	return true;
	    }
	</script>
</head>

<?php
	if(isset($_POST["Guardar"])){
		
		/*Se inserta el nuevo registro*/
		$con = conectarse();
		$sql_insert = "INSERT INTO especialidad VALUES(nextval('especialidad_idespecialidad_seq'),'".$_POST['nombre']."','".$_POST['descripcion']."');";
		$result_insert = pg_exec($con,$sql_insert);
		
		?>
        	<script type="text/javascript" language="javascript">
				alert("¡¡¡ Especialidad Gastronómica agregada satisfactoriamente !!!");
				location.href="../administracion/listadocomodidades.php";
			</script>
        <?php			
	}
?>

<body onload="cargo()">
	<div class="banner">        
    </div>
    <div class="menu">    				
		<?php menu_administrativo();  ?>		                       
    </div>
    <div class="panel">
    	<div class="titulo_panel">Crear Especialidades Gastronómicas</div>
        <div class="opcion_panel">
	        <div class="opcion"> 
				<a href="listadoespecialidades.php">Listar Especialidades</a>
			</div>
        	<div class="opcion" style="background:#F00; color:#FFF;">
				<a href="crearespecialidades.php">Registrar Nueva Especialidad</a>
			</div>
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
  			<input type="hidden" name="MAX_FILE_SIZE" value="200000000" />            
            	<div class="linea_formulario">
                	<div class="linea_titulo">Nombre (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="nombre" name="nombre" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Descripción (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="descripcion" name="descripcion" />
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
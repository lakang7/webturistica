<?php session_start();
	  require("../recursos/funciones.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Crear Gastronomía</title>
		
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
	<script src="../js/administracion/funcionesJS.js"></script>   
	
    <script type="text/javascript">  
	
		//Funcion para validar campo de texto, que NO permita ni campo vacío ni introducir solo espacios en blanco
		function validarCampo(formulario) {
        	//obteniendo el valor que se puso en el campo texto del formulario
        	miCampoTexto = formulario.nombre.value;
			campoPosX = formulario.posX.value;
			campoPosY = formulario.posY.value;
			
        	//la condición
        	if (miCampoTexto.length == 0 || campoPosX.length == 0 || campoPosY.length == 0) {
				alert("Es necesario completar todos los campos");
            	return false;
        	}
			else if(/^\s+$/.test(miCampoTexto) || /^\s+$/.test(campoPosX) || /^\s+$/.test(campoPosY)){
				alert("Ningún campo puede quedar en blanco, ingrese valores válidos");
            	return false;
			}			
			
        	return true;
	    }
		
		//Funcion para validar solo nros o solo letras en un campo de texto
		$(function(){
    		//Para escribir solo letras
    		//$('#miCampo1').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiou');

    		//Para escribir solo numeros	
    		$('#posX').funcionesJS('0123456789');
			$('#posY').funcionesJS('0123456789');	
    	});
	</script>
</head>

<?php
	if(isset($_POST["Guardar"])){
		
		/*Se inserta el nuevo registro*/
		$con = conectarse();
		$sql_insert = "INSERT INTO gastronomia VALUES(nextval('gastronomia_idgastronomia_seq'),'".$_POST["nombre"]."',".$_POST["posX"].",".$_POST["posY"].");";
		$result_insert = pg_exec($con,$sql_insert);
		
		?>
        	<script type="text/javascript" language="javascript">
				alert("¡¡¡ Comodidad agregada satisfactoriamente !!!");
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
    	<div class="titulo_panel">Crear Comodidad</div>
        <div class="opcion_panel">
	        <div class="opcion"> 
				<a href="listadocomodidades.php">Listar Comodidades</a>
			</div>
        	<div class="opcion" style="background:#F00; color:#FFF;">
				<a href="crearCategorias.php">Registrar Nueva Comodidad</a>
			</div>
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
  			<input type="hidden" name="MAX_FILE_SIZE" value="200000000" />            
            	<div class="linea_formulario">
                	<div class="linea_titulo">Nombre Comodidad (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="nombre" name="nombre" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Posición X imagen (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="posX" name="posX" />
                    </div>
                </div>
				<div class="linea_formulario">
                	<div class="linea_titulo">Posición Y imagen (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="posY" name="posY" />
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
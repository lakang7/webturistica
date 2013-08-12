<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Prueba</title>
		
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
        	//la condición
        	if (miCampoTexto.length == 0) {
				alert("Debe indicar el nombre de la categoría que desea registrar");
            	return false;
        	}
			else if(/^\s+$/.test(miCampoTexto)){
				alert("El nombre de la categoría no puede quedar en blanco, ingrese un nombre válido");
            	return false;
			}
        	return true;
	    }
	</script>
</head>

<?php
	if(isset($_POST["Guardar"])){
		//if(validaEmail("correo@gmail.com")){ 
			
			/*$con = conectarse();
			$sql_sel = "SELECT * FROM sitio WHERE idsitio=4;";
			$res_sql = pg_exec($con, $sql_sel);
			if(pg_num_rows($res_sql)>0){
				for($i=0; $i<pg_num_rows($res_sql); $i++){
				$arreglo = pg_fetch_array($res_sql,$i);
				$campo = $arreglo["imagen_perfil"];
				echo "../".$campo;
				$loBorro = borrarArchivo("../".$campo);	
				echo $loBorro;
				}
			}*/
			$loBorro = borrarArchivo("../imagenes/sitios/galeria/Grande_1_Aldea Quintanera Grande.jpg");
			$ruta = str_replace("Grande_", "Peque_", "../imagenes/sitios/galeria/Grande_1_Aldea Quintanera Grande.jpg");
			$loBorro = borrarArchivo($ruta);	
				
			/*if(file_exists($rutaImagen){
				?><script language="JavaScript" type="text/javascript">
				alert("La imagen existe");
				</script><?php
			    //unlink("./" . $_GET['archivo']);
			}*/
		/*}
		else{
			?><script language="JavaScript" type="text/javascript">
				alert("NO VALIDO");
			</script><?php
		}*/
	}
?>

<body onload="cargo()">
	<div class="banner">        
    </div>
    <div class="menu">    				
		<?php menu_administrativo();  ?>		                       
    </div>
    <div class="panel">
    	<div class="titulo_panel">Crear Categoría</div>
        <div class="opcion_panel">
	        <div class="opcion"> 
				<a href="listadocategorias.php">Listar Categorías</a>
			</div>
        	<div class="opcion" style="background:#F00; color:#FFF;">
				<a href="crearcategorias.php">Registrar Nueva Categoría</a>
			</div>
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
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
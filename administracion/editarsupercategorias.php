<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Editar Super Categoría</title>

	
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
    function validar_ingreso(formulario){
	    
		if(formulario.nombre.value==""){
		   alert("Debe indicar el nombre de la super categoria que desea registrar.");
		   return false;	
		}
															
		return true;
	}	    
	</script>

</head>

<?php
	if(isset($_POST["Guardar"])){
		
		/*Actualizo el registro*/
		$con = conectarse();
		$sql_update="update supercategoria set nombre='".$_POST["nombre"]."' where idsupercategoria='".$_GET["id"]."'";
		$result_update=pg_exec($con,$sql_update);
		
		
		
		if($_FILES['icono']['name']!=""){
	
			/*Subo el icono de la categoria*/
			$subir = new imgUpldr;		
			$subir->configurar($_POST["nombre"],"../imagenes/supercategorias/",640,420);
			$subir->init($_FILES['icono']);
			$destino = $subir->_dest.$subir->_name;
		
			
			/*Actualizo el registro para incluir la ruta del icono que se acaba de subir*/
			$sql_update="update supercategoria set icono='".$destino."' where idsupercategoria='".$_GET["id"]."'";
			$result_update= pg_exec($con, $sql_update);				
		}
		
		
		
		?>
        	<script type="text/javascript" language="javascript">
				alert("Supercategoria editada satisfactoriamente.");
				location.href="../administracion/listadosupercategorias.php";
			</script>
        <?php	
		
	}
?>


<body onload="cargo()">
	<div class="banner">
        
    </div>
    <div class="menu">    				
		<?php menu_administrativo();  

		/*Selecciono los datos del id que me llega por get*/
		$con = conectarse();
		$sql_select="select * from supercategoria where idsupercategoria='".$_GET["id"]."';";
		$result_select= pg_exec($con, $sql_select);
		$arreglo=pg_fetch_array($result_select,0);		
		
		?>		                       
    </div>
    <div class="panel">
    	<div class="titulo_panel">Editar Super Categoría</div>
        <div class="opcion_panel">
	        <div class="opcion"> <a href="listadoSupercategorias.php">Listar Categorias</a></div>
        	<div class="opcion" style="background:#F00; color:#FFF;"><a href="crearSupercategorias.php">Registrar Nueva Categoría</a></div>
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validar_ingreso(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
  			<input type="hidden" name="MAX_FILE_SIZE" value="200000000" />            
            	<div class="linea_formulario">
                	<div class="linea_titulo">Nombre Super Categoría</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="nombre" name="nombre" value="<? echo $arreglo[1]; ?>" />
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
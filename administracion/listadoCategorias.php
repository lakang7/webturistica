<?php session_start();
	  require("../recursos/funciones.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado Categorias</title>
	
    <link rel="stylesheet" href="../css/administracion/estructura.css" type="text/css"  />
	<link rel="stylesheet" type="text/css" href="../css/administracion/component.css" />
	<link rel="stylesheet" type="text/css" href="../css/administracion/default.css" />    
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css' />    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="../js/administracion/modernizr.custom.js"></script>
    <script src="../js/administracion/jquery.dlmenu.js"></script>	
	<script type="text/javascript" language="javascript">
		//Funcion para preguntar si esta seguro de eliminar un registro ANTES de proceder a eliminarlo realmente
		function confirmar(url){ 
			if (!confirm("¿Está seguro de que desea eliminar el registro? Presione ACEPTAR para borrar o CANCELAR para volver al listado")) { 
				return false; 
		    } 
			else { 
				document.location=url; 
				return true; 
			} 
		} 
	</script>
</head>

<body onload="cargo()">
	<div class="banner"></div>
    <div class="menu"><?php menu_administrativo();?></div>
    <div class="panel">
    	<div class="titulo_panel">Listado de Categorías</div>
        <div class="opcion_panel">
	        <div class="opcion" style="background:#F00; color:#FFF;"><a href="listadoCategorias.php" style="text-decoration:none; color:#FFF;">Listar Categorias</a></div>
        	<div class="opcion"><a href="crearCategorias.php">Registrar Nueva Categoría</a></div>
        </div>
  		<div class="capa_tabla">
        	<table border="1" class="estilo_tabla">
            	<thead style="background:#F00; color:#FFF;">
					<tr>
                    	<td>Supercategoria</td><td>Código Categoría</td><td>Descripción Categoría</td><td width="20"></td><td width="20"></td>
                    </tr>
                </thead>
                <tbody>
                <?php
				//Consultando las categorias
				$con = conectarse();
			 	$sql_select = "SELECT * FROM categoria ORDER BY idcategoria";
				$result_select = pg_exec($con,$sql_select);
				for($i=0;$i<pg_num_rows($result_select);$i++){
				    $categoria = pg_fetch_array($result_select,$i);	
					$idCategoria = $categoria[0];
					
					//Para consultar la supercategoria asociada a esta categoria
					$sql_select_supercategoria = "SELECT nombre FROM supercategoria WHERE idsupercategoria=".$categoria[1];
					$result_supercategoria = pg_exec($con,$sql_select_supercategoria);
					$supercategoria = pg_fetch_array($result_supercategoria,0);
					
				    ?>
					<tr>
						<td>
						<?php echo $supercategoria[0]; ?>
						</td>
						<td>
						<?php echo Codigo("CAT",$categoria[0]); ?>
						</td>
						<td><?php echo $categoria[2]; ?>
						</td>
						<td title="Editar <?php echo $categoria[2]; ?>" style="cursor:pointer;"><a href="" ><img src="../imagenes/edit.png" width="16" height="16" /></a></td>
						<td title="Eliminar <?php echo $categoria[2]; ?>" style="cursor:pointer;"><a href=""><img src="../imagenes/delete.png" width="16" height="16" /></a>
						</td>
					</tr>					    
					<?php
                }				
				?>					               
                </tbody>
            </table>
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
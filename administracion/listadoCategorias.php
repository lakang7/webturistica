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
	
	<script src="../js/mootools.1.2.3.js"></script>
	<script src="../js/administracion/sombrear_fila_tabla.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/administracion/sombrear_fila_tabla.css" />
	
	<script type="text/javascript" language="javascript">
		/*********************************************************************************************
		*
			Funcion para preguntar si esta seguro de eliminar un registro ANTES de proceder a eliminarlo realmente
		*
		**********************************************************************************************/
		function confirmar(url){ 
			if (!confirm("¿Está seguro de que desea eliminar el registro? Presione ACEPTAR para eliminarlo o CANCELAR para volver al listado")) { 
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
    	<div class="titulo_panel">Listado Categorías</div>
        <div class="opcion_panel">
	        <div class="opcion" style="background:#F00; color:#FFF;"><a href="listadocategorias.php" style="text-decoration:none; color:#FFF;">Listar Categorías</a></div>
        	<div class="opcion"><a href="crearcategoria.php">Registrar Nueva Categoría</a></div>
        </div>
  		<div class="capa_tabla">
        	<table border="0" class="estilo_tabla" id="highlight-table">
            	<thead style="background:#F00; color:#FFF;" align="center">
					<tr>
                    	<td width="100">Código</td><td>Categoría</td><td width="40" align="center">Editar</td><td width="40" align="center">Eliminar</td>
                    </tr>
                </thead>
                <tbody>
                <?php
				$con = conectarse();
			 	$sql_select = "SELECT * FROM categoria ORDER BY nombre";
				$result_select = pg_exec($con,$sql_select);
				
				if(pg_num_rows($result_select)==0){
				?>
					<tr>
                    	<td colspan=6 align="center">No existen categorías hasta el momento</td>
                    </tr>
				<?php
				}
				
				for($i=0;$i<pg_num_rows($result_select);$i++){
				    $categoria = pg_fetch_array($result_select,$i);	
					$idCategoria = $categoria[0];
				    ?>
					<tr class="row-<?php echo $i+1; ?>" style="cursor:pointer;" align="center">
						<td>
							<?php echo Codigo("CAT",$categoria[0]); ?>
						</td>
						<td>
							<?php echo $categoria[1]; ?>
						</td>
						<td title="Editar <?php echo $categoria[1]; ?>" style="cursor:pointer;" align="center">
							<a href="editarcategoria.php?id=<?php echo $categoria[0]; ?>" ><img src="../imagenes/edit.png" width="16" height="16" /></a></td>
						<td title="Eliminar <?php echo $categoria[1]; ?>" style="cursor:pointer;" align="center">
							<a href="javascript:;" onClick="confirmar('eliminar.php?clave=1&id=<?php echo $idCategoria;?>'); return false;"><img src="../imagenes/delete.png" width="16" height="16" /></a>
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
<?php session_start();
	  require("../recursos/funciones.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado Sitios de Interés</title>
	
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
		/*********************************************************************************************
		*
			Funcion para mostrar imagen en un POPUP
		*
		**********************************************************************************************/
		function openPopup(imageURL){
    		var popupTitle = "Imagen de perfil";
    		var newImg = new Image();
    		newImg.src = "../"+imageURL;
			var ancho = newImg.width;
			var alto = newImg.height;
 
 			pos_x = (screen.width-ancho)/2;
	 	    pos_y = (screen.height-alto)/2;
			
    		popup = window.open(newImg.src,'image','height='+alto+',width='+ancho+',left='+pos_x+',top='+pos_y+',toolbar=no, directories=no,status=no,menubar=no,scrollbars=no,resizable=no');

		    with (popup.document){
    	    	writeln('<html><head><title>'+popupTitle+'<\/title><style>body{margin:0px;}<\/style>');
	    	    writeln('<\/head><body onClick="window.close()">');
		        writeln('<img src='+newImg.src+' style="display:block"><\/body><\/html>');
        		close();
		    }
		    popup.focus();
		}
	</script>
</head>

<body onload="cargo()">
	<div class="banner"></div>
    <div class="menu"><?php menu_administrativo();?></div>
    <div class="panel">
    	<div class="titulo_panel">Listado de Sitios de Interés</div>
        <div class="opcion_panel">
	        <div class="opcion" style="background:#F00; color:#FFF;"><a href="listadositios.php" style="text-decoration:none; color:#FFF;">Listar Sitios</a></div>
        	<div class="opcion"><a href="crearsitio.php">Registrar Nuevo Sitio</a></div>
        </div>
  		<div class="capa_tabla">
        	<table border="0" class="estilo_tabla" id="highlight-table">
            	<thead style="background:#F00; color:#FFF;" align="center">
					<tr>
                    	<td>Categoría</td><td>Subcategoría</td><td>Ruta</td><td>Nombre del Sitio</td><td>Dirección</td><td width="40">Ver</td><td width="40">Editar</td><td width="40">Eliminar</td>
                    </tr>
                </thead>
                <tbody>
                <?php
				//Consultando los sitios
				$con = conectarse();
			 	$sql_select = "SELECT * FROM sitio ORDER BY idsubcategoria, nombre;";
				$result_select = pg_exec($con,$sql_select);
				
				if(pg_num_rows($result_select)==0){
					?><tr><td colspan=8 align="center">No existen sitios cargados hasta el momento</td></tr><?php
				}
				
				else{
					for($i=0;$i<pg_num_rows($result_select);$i++){
				    	$sitio = pg_fetch_array($result_select,$i);	
						$idSitio = $sitio["idsitio"];
					
						//Para consultar la subcategoría de cada sitio
						$sql_select_subCategoria = "SELECT * FROM subcategoria WHERE idsubcategoria=".$sitio["idsubcategoria"];
						$result_subCategoria = pg_exec($con,$sql_select_subCategoria);
						$subCategoria = pg_fetch_array($result_subCategoria,0);
						$idSubcategoria = $subCategoria["idsubcategoria"];
					
						//Para consultar la categoria de esa subcategoria
						$sql_select_categoria = "SELECT nombre FROM categoria WHERE idcategoria=".$subCategoria["idcategoria"];
						$result_categoria = pg_exec($con,$sql_select_categoria);
						$categoria = pg_fetch_array($result_categoria,0);
					
						//Para consultar la ruta
						$sql_select_ruta = "SELECT nombre FROM ruta WHERE idruta=".$sitio["idruta"];
						$result_ruta = pg_exec($con,$sql_select_ruta);
						$ruta = pg_fetch_array($result_ruta,0);
						
					    ?>
						<tr class="row-<?php echo $i+1; ?>" style="cursor:pointer;">
							<td align="center"><?php echo $categoria[0];?></td>
							<td align="center"><?php echo $subCategoria["nombre"];?></td>
							<td align="center"><?php echo $ruta[0];?></td>
							<td align="center"><?php echo $sitio["nombre"];?></td>
							<td align="center"><?php echo $sitio["direccion"];?></td>
							<td title="Ver imagen de perfil de <?php echo $sitio["nombre"]; ?>" style="cursor:pointer;" align="center">
								<a href="#" onclick="openPopup('<? echo $sitio["imagen_perfil"]; ?>');return false;"><img src="../imagenes/ver.png" width="16" height="16" /></a>
							</td>
							<td align="center" title="Editar <?php echo $sitio["nombre"]; ?>" style="cursor:pointer;">
								<a href="editarsitio.php?id=<?php echo $idSitio;?>&amp;sub=<?php echo $idSubcategoria;?>&amp;ruta=<?php echo $idRuta;?>" ><img src="../imagenes/edit.png" width="16" height="16" /></a>
							</td>
							<td title="Eliminar <?php echo $sitio["nombre"]; ?>" style="cursor:pointer;" align="center">
								<a href="javascript:;" onClick="confirmar('eliminar.php?clave=6&id=<?php echo $idSitio;?>'); return false;"><img src="../imagenes/delete.png" width="16" height="16" /></a>
							</td>
						</tr>					    
						<?php
	                }
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
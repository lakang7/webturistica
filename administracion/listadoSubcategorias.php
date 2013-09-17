<?php session_start();
	  require("../recursos/funciones.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado Subcategorías</title>
	
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
    		var popupTitle = "Icono";
    		var newImg = new Image();
    		newImg.src = "../"+imageURL;
			var ancho = 200; /*newImg.width;*/
			var alto = 200; /*newImg.height;*/
 
 			pos_x = (screen.width-ancho)/2;
	 	    pos_y = (screen.height-alto)/2;
			
    		popup = window.open(newImg.src,'image','height='+alto+',width='+ancho+',left='+pos_x+',top='+pos_y+',toolbar=no, directories=no,status=no,menubar=no,scrollbars=no,resizable=no');

		    with (popup.document){
    	    	writeln('<html><head><title>'+popupTitle+'<\/title><style>body{margin:0px;}<\/style>');
	    	    writeln('<\/head><body onClick="window.close()">');
		        writeln('<img src='+newImg.src+' width="200" height="200" style="display:block"><\/body><\/html>');
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
    	<div class="titulo_panel">Listado de SubCategorías</div>
        <div class="opcion_panel">
	        <div class="opcion" style="background:#F00; color:#FFF;"><a href="listadosubcategorias.php" style="text-decoration:none; color:#FFF;">Listar SubCategorías</a></div>
        	<div class="opcion"><a href="crearsubcategoria.php">Registrar Nueva SubCategoría</a></div>
        </div>
  		<div class="capa_tabla">
        	<table border="0" class="estilo_tabla" id="highlight-table" align="center">
            	<thead style="background:#F00; color:#FFF;" align="center">
					<tr>
                    	<td width="150" align="left">Categoría</td><td width="100">Código SubCategoría</td><td>Descripción SubCategoría</td><td width="40">Ver</td><td width="40">Editar</td><td width="40">Eliminar</td>
                    </tr>
                </thead>
                <tbody>
                <?php
				//Consultando las subcategorias
				$con = conectarse();
			 	$sql_select = "SELECT * FROM subcategoria ORDER BY nombre";
				$result_select = pg_exec($con,$sql_select);
				
				if(pg_num_rows($result_select)==0){
					?><tr><td colspan=6 align="center">No existen subcategorías hasta el momento</td></tr><?php
				}
				
				for($i=0;$i<pg_num_rows($result_select);$i++){
				    $subCategoria = pg_fetch_array($result_select,$i);	
					$idSubcategoria = $subCategoria["idsubcategoria"];
					
					//Para consultar la categoria asociada a esta subcategoria
					$sql_select_categoria = "SELECT * FROM categoria WHERE idcategoria=".$subCategoria["idcategoria"];
					$result_categoria = pg_exec($con,$sql_select_categoria);
					$categoria = pg_fetch_array($result_categoria,0);					
				    ?>
					<tr class="row-<?php echo $i+1; ?>" style="cursor:pointer;">
						<td width="150"><?php echo $categoria["nombre"]; ?></td>
						<td width="100" align="center"><?php echo Codigo("SUB",$subCategoria["idsubcategoria"]); ?></td>
						<td align="center"><?php echo $subCategoria["nombre"]; ?></td>
						<td title="Ver ícono de <?php echo $subCategoria["nombre"]; ?>" style="cursor:pointer;" align="center">
						<?php 
						//Si tiene ícono asociado, lo muestra en un popup
						if($subCategoria["icono"]!=""){?>
							<a href="#" onclick="openPopup('<? echo $subCategoria["icono"]; ?>');return false;"><img src="../imagenes/ver.png" width="16" height="16" /></a>
							<?php 
						}else{
							?><a href="#"><img src="../imagenes/ver.png" width="16" height="16" /></a><?php
						}?>
						</td>
						<td title="Editar <?php echo $subCategoria["nombre"]; ?>" style="cursor:pointer;" align="center">
							<a href="editarsubcategoria.php?id=<?php echo $idSubcategoria;?>&cat=<?php echo $subCategoria["idcategoria"];?>" ><img src="../imagenes/edit.png" width="16" height="16" /></a>
						</td>
						<td title="Eliminar <?php echo $subCategoria["nombre"]; ?>" style="cursor:pointer;" align="center"><a href="javascript:;" onClick="confirmar('eliminar.php?clave=2&idSub=<?php echo $idSubcategoria;?>'); return false;"><img src="../imagenes/delete.png" width="16" height="16" /></a>
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
<?php session_start();
require("../recursos/funciones.php");

//PRIMERO LA CONEXION A LA BASE DE DATOS:

$con = conectarse();

/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 1	-> ELIMINAR CATEGORIA
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==1){ 
	 
	 /*PRIMERO Se verifica que no existan SUBCATEGORIAS que dependan de la categoria que se desea eliminar*/
	 $sql_select = "SELECT count(*) FROM subcategoria WHERE idcategoria='".$_GET["id"]."'";
	 $result_select = pg_exec($con,$sql_select);
	 $tieneHijos = pg_fetch_array($result_select,0);
	
     if($tieneHijos[0]==0){
	 	 $sql_delete = "DELETE FROM categoria WHERE idcategoria='".$_GET["id"]."'";
		 $result_delete = pg_exec($con,$sql_delete);
		 
	 	 if(!$result_delete){
			 ?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ERROR !!! \n     La subcategoria no pudo ser eliminada");					
	 		 </script><?php
		 }else{
			 ?><script type="text/javascript" language="javascript">
				alert("¡¡¡ Categoria eliminada satisfactoriamente !!!");					
	 		 </script><?php
		 }
		 ?><script type="text/javascript" language="javascript">					
			location.href="../administracion/listadocategorias.php";
 		 </script><?php
	}else{
		 ?><script type="text/javascript" language="javascript">
			alert("ERROR: La categoría no puede ser eliminada ya que existen subcategorias asociadas a la misma.\n\n(Si realmente desea eliminar esta categoria, primero elimine todas las subcategorias que dependan de ella)");
			location.href="../administracion/listadocategorias.php";
		 </script><?php		 			 
	}
}//end $_GET["clave"]==1
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 2	-> ELIMINAR SUBCATEGORIA
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==2){
	
	 $idSub = $_GET["idSub"];
		 
	 /*Se verifica que no existan registros en tablas hijas que dependan del registro que se desea eliminar*/
	 $sql_select = "SELECT count(*) FROM sitio WHERE idsubcategoria='".$idSub."'";
	 $result_select_sitio = pg_exec($con,$sql_select);
	 $tieneHijos = pg_fetch_array($result_select_sitio,0);
	
     //Si no tiene hijos se procede a eliminar
	 if($tieneHijos[0]==0){
	 	 //Primero se consulta la cantidad de hijos del padre
	 	 $sql = "SELECT c.idcategoria, c.hijos FROM categoria c JOIN subcategoria sc ON c.idcategoria=sc.idcategoria AND sc.idsubcategoria='".$idSub."'";
	 	 $result_select_hijos = pg_exec($con, $sql);
		 $categoria = pg_fetch_array($result_select_hijos);
			
	 	 //Luego se actualiza la categoria padre restandole un hijo
		 $menosHijos = $categoria[1]-1;
	 	 $sql_update_padre = "UPDATE categoria SET hijos=".$menosHijos." WHERE idcategoria=".$categoria[0].";";
		 $result_update = pg_exec($con, $sql_update_padre);
		 	 
		 if(!$result_update){
		 	?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ERROR !!! \n     No se pudo actualizar el campo 'hijos' de la tabla categoria");
			 </script><?php
		 }else{
		 	 /*Finalmente, se elimina la subcategoria*/
		 	 $sql_delete = "DELETE FROM subcategoria WHERE idsubcategoria='".$idSub."'";
			 $result_delete = pg_exec($con,$sql_delete);
			 
			 //Si la variable devuelve FALSE es porque no se pudo ejecutar el Query de eliminación
			 if(!$result_delete){
			 
			 	 //Entonces se le vuelven a colocar los hijos al padre
				 $masHijos = $categoria[1]+1;
			 	 $sql_update_padre = "UPDATE categoria SET hijos=".$masHijos." WHERE idcategoria=".$categoria[0].";";
				 $result_update = pg_exec($con, $sql_update_padre);
		 		 //Y se informa al usuario
				 ?><script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!! \n     La subcategoria no pudo ser eliminada");
				 </script><?php
			 }else{
		 		 ?><script type="text/javascript" language="javascript">
					alert("¡¡¡ Subcategoria eliminada satisfactoriamente !!!");
				 </script><?php
			 }?>
   		     <script type="text/javascript" language="javascript">
				location.href = "../administracion/listadosubcategorias.php";
			 </script><?php
		 }//else del if(!$result_delete)
	 }//end if($tieneHijos[0]==0)
	 else{
	 	?><script type="text/javascript" language="javascript">
			alert("ERROR: La subcategoria NO PUEDE SER ELIMINADA ya que existen registros en otras tablas de la base de datos que dependen de ella.\n\n(Si realmente desea eliminarla, primero elimine todos los sitios que estén asociados a ella)");
			location.href="../administracion/listadosubcategorias.php";
		</script><?php
	 }	 		 			 
}//end $_GET["clave"]==2
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 3	-> ELIMINAR COMODIDAD
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==3){
	
	 /*PRIMERO Se verifica que no existan registros en tablas hijas que dependan del registro que se desea eliminar*/
	 $sql_select = "SELECT count(*) FROM hospedaje_comodidad WHERE idcomodidad='".$_GET["id"]."'";
	 $result_select = pg_exec($con,$sql_select);
	 $tieneHijos = pg_fetch_array($result_select,0);
	
     if($tieneHijos[0]==0){
	 	 $sql_delete = "DELETE FROM comodidad WHERE idcomodidad='".$_GET["id"]."'";
		 $result_delete = pg_exec($con,$sql_delete);
	 
	 	 if(!$result_delete){
		 	?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ERROR !!! \n     La comodidad no pudo ser eliminada");
			</script><?php
		 }else{
		 	?><script type="text/javascript" language="javascript">
				alert("¡¡¡ Comodidad eliminada satisfactoriamente !!!");					
			</script><?php
		 }	
		 ?><script type="text/javascript" language="javascript">
			location.href="../administracion/listadocomodidades.php";
		 </script><?php 
	 }else{
		 ?><script type="text/javascript" language="javascript">
			alert("ERROR: La comodidad NO PUEDE SER ELIMINADA ya que existen registros en la tabla hospedaje_comodidad asociados a la misma.\n\n(Si realmente desea eliminar esta comodidad, primero elimine todos los registros en la tabla hospedaje_comodidad que dependan de ella)");
			location.href="../administracion/listadocomodidades.php";
		 </script><?php		 			 
	 }
}//end $_GET["clave"]==3
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 4	-> ELIMINAR ESPECIALIDAD
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==4){ 
	
	 /*PRIMERO Se verifica que no existan registros en tablas hijas que dependan del registro que se desea eliminar*/
	 $sql_select = "SELECT count(*) FROM gastronomia_especialidad WHERE idespecialidad='".$_GET["id"]."'";
	 $result_select = pg_exec($con,$sql_select);
	 $tieneHijos = pg_fetch_array($result_select,0);
	
     if($tieneHijos[0]==0){
	 	 $sql_delete = "DELETE FROM especialidad WHERE idespecialidad='".$_GET["id"]."'";
		 $result_delete = pg_exec($con,$sql_delete);
	 	 
		 if(!$result_delete){
		 	?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ERROR !!! \n     La especialidad gastronómica no pudo ser eliminada");					
			</script><?php
		 }else{
		 	?><script type="text/javascript" language="javascript">
				alert("¡¡¡ Especialidad gastronómica eliminada satisfactoriamente !!!");
				location.href="../administracion/listadoespecialidades.php";
			</script><?php
		 }?>
		 <script type="text/javascript" language="javascript">
		 	location.href="../administracion/listadoespecialidades.php";				
		 </script><?php				 
	 }else{
		 ?><script type="text/javascript" language="javascript">
			alert("ERROR: La especialidad gastronómica NO PUEDE SER ELIMINADA ya que existen registros en la tabla gastronomia_especialidad asociados a la misma.\n\n(Si realmente desea eliminar esta comodidad, primero elimine todas los registros en la tabla gastronomia_especialidad que dependan de ella)");
			location.href="../administracion/listadoespecialidades.php";
		 </script><?php		 			 
	 }
}// end $_GET["clave"]==4
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 5	-> ELIMINAR RUTA
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==5){ 
	
	 /*Se verifica que no existan registros en tablas hijas que dependan del registro que se desea eliminar*/
	 $sql_select_sitio = "SELECT count(*) FROM sitio WHERE idruta='".$_GET["id"]."'";
	 $result_select_sitio = pg_exec($con,$sql_select_sitio);
	 $tieneHijos = pg_fetch_array($result_select_sitio,0);
		 
	 $sql_select_punto = "SELECT count(*) FROM punto_ruta WHERE idruta='".$_GET["id"]."'";
	 $result_select_punto = pg_exec($con,$sql_select_punto);
	 $tieneHijos2 = pg_fetch_array($result_select_punto,0);
	
     if($tieneHijos[0]==0 && $tieneHijos2[0]==0){
	 	 $sql_delete = "DELETE FROM ruta WHERE idruta='".$_GET["id"]."'";
		 $result_delete = pg_exec($con,$sql_delete);
		 
		 if(!$result_delete){
		 	?><script type="text/javascript" language="javascript">
		 		alert("¡¡¡ ERROR !!! \n     La ruta no pudo ser eliminada");					
			</script><?php	
		 }else{
		 	?><script type="text/javascript" language="javascript">
		 		alert("¡¡¡ Ruta eliminada satisfactoriamente !!! ");					
			</script><?php	
		 }?>
		 <script type="text/javascript" language="javascript">
		 	location.href="../administracion/listadorutas.php";					
		 </script><?php			 	 
	 }else{
		 ?><script type="text/javascript" language="javascript">
			alert("ERROR: La ruta NO PUEDE SER ELIMINADA ya que existen registros en otras tablas que están asociados a la misma.\n\n(Si realmente desea eliminar esta ruta, primero elimine todas los registros que dependan de ella)");
			location.href="../administracion/listadositios.php";
		 </script><?php		 			 
	 }
}
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 6	-> ELIMINAR SITIO
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==6){
	
	 $sql_sel_sitio = "SELECT * FROM sitio WHERE idsitio='".$_GET["id"]."'";
	 $result_sel_sitio = pg_exec($con,$sql_sel_sitio);
	 $sitio = pg_fetch_array($result_sel_sitio,0); 
	 $idSubcategoria = $sitio[1];
	 
	 $sql_sel_categoria = "SELECT * FROM categoria c JOIN subcategoria sc ON c.idcategoria=sc.idcategoria AND sc.idsubcategoria=".$idSubcategoria;
	 $result_sel_categoria = pg_exec($con,$sql_sel_categoria);
	 $categoria = pg_fetch_array($result_sel_categoria,0);
	 $nombreCategoria = $categoria[1];
	 
	 /*------------------------Si el sitio a eliminar es HOSPEDAJE------------------------*/
	 if($nombreCategoria=='Hospedaje'){
	 	/*Se consultan todos los hospedajes asociados a ese sitio*/
	 	$sql_sel_hospe = "SELECT * FROM hospedaje WHERE idsitio='".$_GET["id"]."'";
		$result_sel_hospe = pg_exec($con,$sql_sel_hospe);
		
		if(pg_num_rows($result_sel_hospe)>0){		
			/*Para cada uno se eliminan los posibles hijos*/
			for($i=0; $i<pg_num_rows($result_sel_hospe); $i++){
				$hospedaje = pg_fetch_array($result_sel_hospe,$i);
				
				$sql_del_hospe_como = "DELETE FROM hospedaje_comodidad WHERE idhospedaje='".$hospedaje[0]."'";
				$result_del_hospe_como = pg_exec($con, $sql_del_hospe_como);
			
				$sql_del_hospe_tipo = "DELETE FROM hospedaje_tipo_habitacion WHERE idhospedaje='".$hospedaje[0]."'";
				$result_del_hospe_tipo = pg_exec($con, $sql_del_hospe_tipo);
			}
			/*Finalmente se elimina el hospedaje*/
			$sql_del_hospe = "DELETE FROM hospedaje WHERE idsitio='".$_GET["id"]."'";
			$result_del_hospe = pg_exec($con, $sql_del_hospe);	
			if($result_del_hospe_tipo){$listoParaEliminar++;}		
		}	 	
	 }//end eliminar hospedaje
	 
	 /*------------------------Si el sitio a eliminar es GASTRONOMIA------------------------*/
	 else if($nombreCategoria=='Gastronomía'){
	    /*Se consultan todas las gastronomias asociadas a ese sitio*/
	 	$sql_sel_gastro = "SELECT * FROM gastronomia WHERE idsitio='".$_GET["id"]."'";
		$result_sel_gastro = pg_exec($con,$sql_sel_gastro);
		if(pg_num_rows($result_sel_gastro)>0){		
			/*Para cada uno se eliminan los posibles hijos*/
			for($i=0; $i<pg_num_rows($result_sel_gastro); $i++){
				$gastronomia = pg_fetch_array($result_sel_gastro,$i);
				
				$sql_del_gastro_ser = "DELETE FROM gastronomia_servicio WHERE idgastronomia='".$gastronomia[0]."'";
				$result_del_gastro_ser = pg_exec($con, $sql_del_gastro_ser);
			
				$sql_del_gastro_espe = "DELETE FROM gastronomia_especialidad WHERE idgastronomia='".$gastronomia[0]."'";
				$result_del_gastro_espe = pg_exec($con, $sql_del_gastro_espe);								
			}
			/*Finalmente se elimina la gastronomia*/
			$sql_del_gastro = "DELETE FROM gastronomia WHERE idsitio='".$_GET["id"]."'";
			$result_del_gastro = pg_exec($con, $sql_del_gastro);
		}		
	 }//end eliminar gastronomía
	 
	/*------------------------Luego se elimina lo común a todos los sitios------------------------*/
	$sql_del_sitio_mp = "DELETE FROM sitio_medio_pago WHERE idsitio='".$_GET["id"]."'";
	$result_del_sitio_mp = pg_exec($con, $sql_del_sitio_mp);
	
	//Elimino las fotos de galeria de ese sitio, de la carpeta
	$sql_sel_imagenes = "SELECT * FROM foto_sitio WHERE idsitio='".$_GET["id"]."'";
	$res_sel_imagenes = pg_exec($con, $sql_sel_imagenes);
	if(pg_num_rows($res_sel_imagenes)>0){
		for($i=0; $i<pg_num_rows($res_sel_imagenes); $i++){
			$galeria = pg_fetch_array($res_sel_imagenes,$i);
			$imagenGrande = $galeria["foto"];
			$borrarFoto = borrarArchivo("../".$imagenGrande);	
			
			// Reemplazo del nombre de la imagen, el "Grande_" por "Peque_"
			$imagenPeque = str_replace("Grande_", "Peque_", $imagenGrande);
			$borrarFoto = borrarArchivo("../".$imagenPeque);	
		}
	}
	
	$sql_del_foto_sitio = "DELETE FROM foto_sitio WHERE idsitio='".$_GET["id"]."'";
	$result_del_foto_sitio = pg_exec($con, $sql_del_foto_sitio);
	
	$sql_del_horario = "DELETE FROM horario WHERE idsitio='".$_GET["id"]."'";
	$result_del_horario = pg_exec($con, $sql_del_horario);

	/*------------------------ANTES de eliminar el sitio, elimino la imagen de perfil de la carpeta------------------------*/
	$sql_sel_imagen = "SELECT * FROM sitio WHERE idsitio='".$_GET["id"]."'";
	$res_sel_imagen = pg_exec($con, $sql_sel_imagen);
	if(pg_num_rows($res_sel_imagen)>0){
		for($i=0; $i<pg_num_rows($res_sel_imagen); $i++){
			$sitio = pg_fetch_array($res_sel_imagen,$i);
			$imagen = $sitio["imagen_perfil"];
			$borrarImagen = borrarArchivo("../".$imagen);
		}
	}

	/*------------------------Finalmente se elimina EL SITIO------------------------*/
	 $sql_delete = "DELETE FROM sitio WHERE idsitio='".$_GET["id"]."'";
	 $result_delete = pg_exec($con,$sql_delete);
	 if(!$result_delete){
	 	?><script type="text/javascript" language="javascript">
			alert("¡¡¡ Error !!!\n\n     No se pudo eliminar el sitio");
		    location.href="../administracion/listadositios.php";				
  	    </script><?php		 
	 }else{
	 	?><script type="text/javascript" language="javascript">
			alert("¡¡¡ Sitio eliminado satisfactoriamente !!!");
		    location.href="../administracion/listadositios.php";				
  	    </script><?php	
	 }	 
}//end CLAVE=6 ELIMINAR SITIO
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 7	-> ELIMINAR FOTO DE GALERIA
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==7){
	
	$sql_select = "SELECT * FROM foto_sitio WHERE idfoto_sitio='".$_GET["id"]."'";
	$result_select = pg_exec($con,$sql_select);
	$foto_sitio = pg_fetch_array($result_select,0);
	$idSitio = $foto_sitio[1];

	//Primero se elimina la imagen de la ruta especificada por parametro
	$imagenGrande = $foto_sitio["foto"];
	$borrarFoto = borrarArchivo("../".$imagenGrande);	
		
	// Reemplazo del nombre de la imagen, el "Grande_" por "Peque_" para borrar la imagen pequeña
	$imagenPeque = str_replace("Grande_", "Peque_", $imagenGrande);
	$borrarFoto = borrarArchivo("../".$imagenPeque);

	//Luego si se elimina el registro en foto_sitio de la BD
	$sql_delete = "DELETE FROM foto_sitio WHERE idfoto_sitio='".$_GET["id"]."'";	
	$result_delete = pg_exec($con,$sql_delete);
			 
	if(!$result_delete){
		?><script type="text/javascript" language="javascript">
	 		alert("¡¡¡ ERROR !!! \n     No se pudo eliminar la fotografía");
		</script><?php
	}else{
	 	?><script type="text/javascript" language="javascript">
	 		alert("¡¡¡ Fotografía eliminada satisfactoriamente !!! ");	
			location.href = "../administracion/creargaleriafotos.php?idSitio="+<?php echo $idSitio;?>;
		</script><?php
	}
}//END CLAVE 7
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 8	-> ELIMINAR TIPO DE HABITACION
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==8){ 
	 
	 $sql_select = "SELECT * FROM hospedaje_tipo_habitacion WHERE idtipo_habitacion='".$_GET["id"]."'";
	 $result_select = pg_exec($con,$sql_select);
	
	 //Si hay registros en hospedaje_tipo_habitacion asociados a este tipo de habitación, NO se puede eliminar
	 if(pg_num_rows($result_select)>0){
	 	?><script type="text/javascript" language="javascript">
			alert("¡¡¡ ERROR !!!\n\n     No se puede eliminar este tipo de habitación ya que existen hospedajes asociados al mismo.\n\n(Si realmente desea eliminarlo, primero elimine todos los sitios asociados a este tipo de habitación))");
			location.href="../administracion/listadotipohabitacion.php";
		 </script><?php	
	 }
	 else{	 	
	 	$sql_delete = "DELETE FROM tipo_habitacion WHERE idtipo_habitacion='".$_GET["id"]."'";	
		$result_delete = pg_exec($con,$sql_delete);
		
		if(!$result_delete){
			?><script type="text/javascript" language="javascript">
		 		alert("¡¡¡ ERROR !!! \n     No se pudo eliminar el tipo de habitación");
			</script><?php
		}else{
		 	?><script type="text/javascript" language="javascript">
	 			alert("¡¡¡ Tipo de habitación eliminado satisfactoriamente !!! ");	
				location.href = "../administracion/listadotipohabitacion.php";
			</script><?php
		}
	 }     
}//end $_GET["clave"]==8
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 9	-> ELIMINAR MEDIO DE PAGO
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==9){ 
	 
	 $sql_select = "SELECT * FROM sitio_medio_pago WHERE idmedio_pago='".$_GET["id"]."'";
	 $result_select = pg_exec($con,$sql_select);
	
	 //Si hay registros en sitio_medio_pago asociados a este tipo de habitación, NO se puede eliminar
	 if(pg_num_rows($result_select)>0){
	 	?><script type="text/javascript" language="javascript">
			alert("¡¡¡ ERROR !!!\n\n     No se puede eliminar este medio de pago ya que está referenciado por algunos sitios.\n\n(Si realmente desea eliminarlo, primero debe eliminar todos los sitios asociados a este medio de pago))");
			location.href="../administracion/listadomediopago.php";
		 </script><?php	
	 }
	 else{	 	
	 	$sql_delete = "DELETE FROM medio_pago WHERE idmedio_pago='".$_GET["id"]."'";	
		$result_delete = pg_exec($con,$sql_delete);
		
		if(!$result_delete){
			?><script type="text/javascript" language="javascript">
		 		alert("¡¡¡ ERROR !!! \n     No se pudo eliminar el medio de pago");
			</script><?php
		}else{
		 	?><script type="text/javascript" language="javascript">
	 			alert("¡¡¡ Medio de pago eliminado satisfactoriamente !!! ");	
				location.href = "../administracion/listadomediopago.php";
			</script><?php
		}
	 }     
}//end $_GET["clave"]==9
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 10	-> ELIMINAR SERVICIO
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==10){ 
	 
	 $sql_select = "SELECT * FROM gastronomia_servicio WHERE idservicio='".$_GET["id"]."'";
	 $result_select = pg_exec($con,$sql_select);
	
	 //Si hay registros en sitio_medio_pago asociados a este tipo de habitación, NO se puede eliminar
	 if(pg_num_rows($result_select)>0){
	 	?><script type="text/javascript" language="javascript">
			alert("¡¡¡ ERROR !!!\n\n     No se puede eliminar este servicio ya que está referenciado por algunos sitios.\n\n(Si realmente desea eliminarlo, primero debe eliminar todos los sitios asociados a este medio de pago))");
			location.href="../administracion/listadoservicios.php";
		 </script><?php	
	 }
	 else{	 	
	 	$sql_delete = "DELETE FROM servicio WHERE idservicio='".$_GET["id"]."'";	
		$result_delete = pg_exec($con,$sql_delete);
		
		if(!$result_delete){
			?><script type="text/javascript" language="javascript">
		 		alert("¡¡¡ ERROR !!! \n     No se pudo eliminar el servicio");
			</script><?php
		}else{
		 	?><script type="text/javascript" language="javascript">
	 			alert("¡¡¡ Servicio eliminado satisfactoriamente !!! ");	
				location.href = "../administracion/listadoservicios.php";
			</script><?php
		}
	 }     
}//end $_GET["clave"]==10

?>
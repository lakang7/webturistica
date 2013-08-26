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
			alert("¡¡¡ ERROR !!!\n\n     La categoría no puede ser eliminada ya que existen subcategorias asociadas a la misma.\n\n(Si realmente desea eliminar esta categoria, primero elimine todas las subcategorias que dependan de ella)");
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
		 
	 /*Se verifica que no existan registros en tablas hijas que dependan del registro que se desea eliminar*/
	 $sql_select = "SELECT * FROM sitio WHERE idsubcategoria='".$_GET["idSub"]."'";
	 $result_select_sitio = pg_exec($con,$sql_select);
	 
	 if(pg_num_rows($result_select_sitio)>0){
	 	?><script type="text/javascript" language="javascript">
			alert("¡¡¡ ERROR !!!\n\n     La subcategoria NO PUEDE SER ELIMINADA ya que existen sitios asociados a ella");
			location.href="../administracion/listadosubcategorias.php";
		</script><?php
	 }
	 else{
	 	 /*Primero se consulta la cantidad de hijos del padre*/
	 	 $sql = "SELECT c.idcategoria, c.hijos FROM categoria c JOIN subcategoria sc ON c.idcategoria=sc.idcategoria AND sc.idsubcategoria='".$_GET["idSub"]."'";
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
		 	 /*Antes de eliminar la subcategoria, se elimina su ICONO de la carpeta respectiva*/
			 $sql_sel_subcategoria = "SELECT * FROM subcategoria WHERE idsubcategoria=".$_GET["idSub"];
			 $res_sel_subcategoria = pg_exec($con,$sql_sel_subcategoria);
			 $subcategoria = pg_fetch_array($res_sel_subcategoria,0);
			 $borrarFoto = borrarArchivo("../".$subcategoria["icono"]);
			 
		 	 /*Finalmente, se elimina la subcategoria*/
		 	 $sql_delete = "DELETE FROM subcategoria WHERE idsubcategoria='".$_GET["idSub"]."'";
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
						location.href = "../administracion/listadosubcategorias.php";
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
	 }	 			 
}//end $_GET["clave"]==2
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 3	-> ELIMINAR COMODIDAD
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==3){
	
	 /*PRIMERO Se verifica que no existan registros en tablas hijas que dependan del registro que se desea eliminar*/
	 $sql_select = "SELECT * FROM hospedaje_comodidad WHERE idcomodidad='".$_GET["id"]."'";
	 $result_select = pg_exec($con,$sql_select);
	 
	 if(pg_num_rows($result_select)>0){
	 	?><script type="text/javascript" language="javascript">
			alert("¡¡¡ ERROR !!!\n\n     La comodidad NO PUEDE SER ELIMINADA ya que existen registros de otras tablas asociados a ella");
			location.href="../administracion/listadocomodidades.php";
		</script><?php
	 }else{
	 	 $sql_delete = "DELETE FROM comodidad WHERE idcomodidad='".$_GET["id"]."'";
		 $result_delete = pg_exec($con,$sql_delete);
	 
	 	 if(!$result_delete){
		 	?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ERROR !!! \n     La comodidad no pudo ser eliminada");
				location.href="../administracion/listadocomodidades.php";
			</script><?php
		 }else{
		 	?><script type="text/javascript" language="javascript">
				alert("¡¡¡ Comodidad eliminada satisfactoriamente !!!");
				location.href="../administracion/listadocomodidades.php";					
			</script><?php
		 }
	 }
}//end $_GET["clave"]==3
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 4	-> ELIMINAR ESPECIALIDAD
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==4){ 
	
	 /*PRIMERO Se verifica que no existan registros en tablas hijas que dependan del registro que se desea eliminar*/
	 $sql_select = "SELECT * FROM gastronomia_especialidad WHERE idespecialidad='".$_GET["id"]."'";
	 $result_select = pg_exec($con,$sql_select);
	 
	 if(pg_num_rows($result_select)>0){
	 	?><script type="text/javascript" language="javascript">
			alert("¡¡¡ ERROR !!!\n\n   La especialidad NO PUEDE SER ELIMINADA ya que existen registros de otras tablas asociados a ella");
			location.href="../administracion/listadoespecialidades.php";
		</script><?php
	 }else{
	 	$sql_delete = "DELETE FROM especialidad WHERE idespecialidad='".$_GET["id"]."'";
		$result_delete = pg_exec($con,$sql_delete);
	 	 
		if(!$result_delete){
			?><script type="text/javascript" language="javascript">
				alert("¡¡¡ ERROR !!! \n     La especialidad gastronómica no pudo ser eliminada");
				location.href="../administracion/listadoespecialidades.php";					
			</script><?php
		}else{
		 	?><script type="text/javascript" language="javascript">
				alert("¡¡¡ Especialidad gastronómica eliminada satisfactoriamente !!!");
				location.href="../administracion/listadoespecialidades.php";
			</script><?php
		}
	 } 
}// end $_GET["clave"]==4
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 5	-> ELIMINAR RUTA
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==5){ 
	
	 /*Se verifica que no existan registros en tablas hijas que dependan del registro que se desea eliminar*/
	 $sql_select_sitio = "SELECT * FROM sitio WHERE idruta='".$_GET["id"]."'";
	 $result_select_sitio = pg_exec($con,$sql_select_sitio);		 
	 $sql_select_punto = "SELECT * FROM punto_ruta WHERE idruta='".$_GET["id"]."'";
	 $result_select_punto = pg_exec($con,$sql_select_punto);
	 
	 if(pg_num_rows($result_select_sitio)>0 || pg_num_rows($result_select_punto)>0){
	 	?><script type="text/javascript" language="javascript">
			alert("¡¡¡ ERROR !!!\n\n   La ruta NO PUEDE SER ELIMINADA ya que existen registros de otras tablas asociados a ella");
			location.href="../administracion/listadorutas.php";
		</script><?php
	 }else{ 
	 	 //Antes de eliminar la ruta, se elimina su FOTO_PORTADA de la carpeta respectiva
	 	 $sql_sel_ruta = "SELECT * FROM ruta WHERE idruta='".$_GET["id"]."'";
		 $res_sel_ruta = pg_exec($con,$sql_sel_ruta);
		 $ruta = pg_fetch_array($res_sel_ruta,0);
		 $borrarFoto = borrarArchivo("../".$ruta["foto_portada"]);
		 
		 //Finalmente, se elimina LA RUTA
	 	 $sql_delete = "DELETE FROM ruta WHERE idruta='".$_GET["id"]."'";
		 $result_delete = pg_exec($con,$sql_delete);
		 
		 if(!$result_delete){
		 	?><script type="text/javascript" language="javascript">
		 		alert("¡¡¡ ERROR !!! \n     La ruta no pudo ser eliminada");
				location.href="../administracion/listadorutas.php";					
			</script><?php	
		 }else{
		 	?><script type="text/javascript" language="javascript">
		 		alert("¡¡¡ Ruta eliminada satisfactoriamente !!! ");
				location.href="../administracion/listadorutas.php";					
			</script><?php	
		 }
	 }
}
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 6	-> ELIMINAR SITIO
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==6){
		
	 /*Se buscan todos los datos del sitio*/
	 $sql_sel_sitio = "SELECT * FROM sitio WHERE idsitio='".$_GET["id"]."'";
	 $result_sel_sitio = pg_exec($con,$sql_sel_sitio);
	 $sitio = pg_fetch_array($result_sel_sitio,0);
	 
	 /*Se busca la categoria en base a la subcategoria del sitio*/
	 $sql_sel_subcategoria = "SELECT * FROM subcategoria WHERE idsubcategoria=".$sitio["idsubcategoria"];
	 $result_sel_subcategoria = pg_exec($con,$sql_sel_subcategoria);
	 $subcategoria = pg_fetch_array($result_sel_subcategoria,0);
					
	 $sql_sel_categoria = "SELECT * FROM categoria WHERE idcategoria=".$subcategoria["idcategoria"];
	 $result_sel_categoria = pg_exec($con,$sql_sel_categoria);
	 $categoria = pg_fetch_array($result_sel_categoria,0);
	 
	 /*------------------------Si el sitio a eliminar es HOSPEDAJE------------------------*/
	 if($categoria[1]=='Hospedaje'){
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
			if(!$result_del_hospe){
				?><script type="text/javascript" language="javascript">
				alert("¡¡¡ Error !!!\n\n     No se pudo eliminar el hospedaje");
			    location.href="../administracion/listadositios.php";				
	  	    	</script><?php
			}	
		}	 	
	 }//end eliminar hospedaje
	 
	 /*------------------------Si el sitio a eliminar es GASTRONOMIA------------------------*/
	 //Se pudiese cambiar por if($categoria["idcategoria"]==2) si se garantiza que SIEMPRE Hospedaje será la CAT 1 y Gastronomia la 2
	 if($categoria[1]=='Gastronomia'){
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
			if(!$result_del_gastro){
				?><script type="text/javascript" language="javascript">
				alert("¡¡¡ Error !!!\n\n     No se pudo eliminar la gastronomía");
			    location.href="../administracion/listadositios.php";				
	  	    	</script><?php
			}
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
			$imagenPeque = $galeria["foto"];
			$borrarFoto = borrarArchivo("../".$imagenPeque);	
			
			// Reemplazo del nombre de la imagen, el "_peq_" por "_gra_" PARA ELIMINAR LA FOTO GRANDE DE LA RUTA TAMBIEN
			$imagenGrande = str_replace("_peq_", "_gra_", $imagenPeque);
			$borrarFoto = borrarArchivo("../".$imagenGrande);
		}
	}
	
	$sql_del_foto_sitio = "DELETE FROM foto_sitio WHERE idsitio='".$_GET["id"]."'";
	$result_del_foto_sitio = pg_exec($con, $sql_del_foto_sitio);
	
	$sql_del_horario = "DELETE FROM horario WHERE idsitio='".$_GET["id"]."'";
	$result_del_horario = pg_exec($con, $sql_del_horario);

	/*------------------------ANTES de eliminar el sitio, elimino la imagen de perfil de la carpeta---------*/
	$imagen = $sitio["imagen_perfil"];
	$borrarImagen = borrarArchivo("../".$imagen);	

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
	$idSitio = $foto_sitio["idsitio"];

	//Primero se elimina la imagen de la ruta especificada por parametro
	$imagenPeque = $foto_sitio["foto"];
	$borrarFoto = borrarArchivo("../".$imagenPeque);	
		
	// Reemplazo del nombre de la imagen, el "Grande_" por "Peque_" para borrar la imagen pequeña
	$imagenGrande = str_replace("_peq_", "_gra_", $imagenPeque);
	$borrarFoto = borrarArchivo("../".$imagenGrande);

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
	    //Antes de eliminar el medio_pago se elimina el ICONO de la ruta respectiva
		$sql_sel_mp = "SELECT * FROM medio_pago WHERE idmedio_pago='".$_GET["id"]."'";
		$res_sel_mp = pg_exec($con,$sql_sel_mp);
 	    $mp = pg_fetch_array($res_sel_mp,0);
		if($mp["icono"]!=""){
			$borrarFoto = borrarArchivo("../".$mp["icono"]);
		}
		
		//Finalmente, se elimina EL MEDIO DE PAGO
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
				location.href = "../administracion/listadoservicios.php";
			</script><?php
		}else{
		 	?><script type="text/javascript" language="javascript">
	 			alert("¡¡¡ Servicio eliminado satisfactoriamente !!! ");	
				location.href = "../administracion/listadoservicios.php";
			</script><?php
		}
	 }     
}//end $_GET["clave"]==10
/*------------------------------------------------------------------------------------------------------------------------------
*
*											Clave = 11	-> ELIMINAR PUNTO_RUTA
*
------------------------------------------------------------------------------------------------------------------------------*/
if($_GET["clave"]==11){
	
	$sql_select = "SELECT * FROM punto_ruta WHERE idpunto_ruta='".$_GET["id"]."'";
	$result_select = pg_exec($con,$sql_select);
	$punto_ruta = pg_fetch_array($result_select,0);

	//Primero se elimina la FOTO_PORTADA del punto_ruta especificado por parametro
	if($punto_ruta["foto_portada"]!=""){
		$borrarFoto = borrarArchivo("../".$punto_ruta["foto_portada"]);	
	}
		
	//Luego si se elimina el registro en punto_ruta de la BD
	$sql_delete = "DELETE FROM punto_ruta WHERE idpunto_ruta='".$_GET["id"]."'";
	$result_delete = pg_exec($con,$sql_delete);
			 
	if(!$result_delete){
		?><script type="text/javascript" language="javascript">
	 		alert("¡¡¡ ERROR !!! \n     No se pudo eliminar el punto de la ruta");
		</script><?php
	}else{
	 	?><script type="text/javascript" language="javascript">
	 		alert("¡¡¡ Punto de ruta eliminado satisfactoriamente !!! ");	
			location.href = "../administracion/crearpuntoruta.php?idRuta="+<?php echo $punto_ruta["idruta"]; ?>;
		</script><?php
	}
}//END CLAVE 11
?>
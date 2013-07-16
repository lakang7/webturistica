<?php session_start();
	  require("../recursos/funciones.php");
	  
	  
	if($_GET["clave"]==1){ //Clave 1 indica que elimina CATEGORIA
	
		 $con = conectarse();
		 
		 /*Se verifica que no existan SUBCATEGORIAS que dependan de la categoria que se desea eliminar*/
		 $sql_select = "SELECT count(*) FROM subcategoria WHERE idcategoria='".$_GET["id"]."'";
		 $result_select = pg_exec($con,$sql_select);
		 $tieneHijos = pg_fetch_array($result_select,0);
	
	     if($tieneHijos[0]==0){
		 	 $sql_delete = "DELETE FROM categoria WHERE idcategoria='".$_GET["id"]."'";
			 $result_delete = pg_exec($con,$sql_delete);
		 
			 ?><script type="text/javascript" language="javascript">
					alert("¡¡¡ Categoria eliminada satisfactoriamente !!!");
					location.href="../administracion/listadoCategorias.php";
				</script>
    	     <?php		 
		 
		 }else{
		 ?>
        	<script type="text/javascript" language="javascript">
				alert("ERROR: La categoría no puede ser eliminada ya que existen subcategorias asociadas a la misma.\n\n(Si realmente desea eliminar esta categoria, primero elimine todas las subcategorias que dependan de ella)");
				location.href="../administracion/listadoCategorias.php";
			</script>
         <?php		 			 
		 }
	}
	
	if($_GET["clave"]==2){ //Clave 2 indica que elimina SUBCATEGORIA
	
		 /*Primero se elimina la subcategoria*/
		 $con = conectarse();
		 $sql_delete = "DELETE FROM subcategoria WHERE idsubcategoria='".$_GET["id"]."'";
		 $result_delete = pg_exec($con,$sql_delete);
		 
		 /*Se actualiza el Nro. de Hijos de la CATEGORIA padre*/
		 
		 //Primero se consulta la cantidad de hijos del padre
 		 $sql_select_hijos = "SELECT hijos FROM categoria WHERE idcategoria=".$_GET["id"].";";
 		 $result_select_hijos = pg_exec($con, $sql_select_hijos);
		 $hijos = pg_fetch_array($result_select_hijos,0);
			
		 //Luego Se actualiza el padre restandole un hijo
		 $menosHijos = $hijos[0] - 1;
		 $sql_update_padre = "UPDATE categoria SET hijos=".$menosHijos." WHERE idcategoria=".$_GET["id"].";";
		 $result_update = pg_exec($con, $sql_update_padre);		 
		 
		 ?>
        	<script type="text/javascript" language="javascript">
				alert("¡¡¡ Subcategoria eliminada satisfactoriamente !!!");
				location.href = "../administracion/listadoSubcategorias.php";
			</script>
         <?php			 
	}

?>
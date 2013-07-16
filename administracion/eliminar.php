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
	
		 $con = conectarse();
		 $idSub = $_GET["idSub"];
		 
		 //Primero se consulta la cantidad de hijos del padre
 		 $sql = "SELECT c.idcategoria, c.hijos FROM categoria c JOIN subcategoria sc ON c.idcategoria=sc.idcategoria AND sc.idsubcategoria='".$idSub."'";
		 $result_select_hijos = pg_exec($con, $sql);
		 $categoria = pg_fetch_array($result_select_hijos);
			
		 //Luego se actualiza la categoria padre restandole un hijo
		 $menosHijos = $categoria[1]-1;
 	 	 $sql_update_padre = "UPDATE categoria SET hijos=".$menosHijos." WHERE idcategoria=".$categoria[0].";";
		 $result_update = pg_exec($con, $sql_update_padre);
		 		 
		 /*Finalmente, se elimina la subcategoria*/
		 $sql_delete = "DELETE FROM subcategoria WHERE idsubcategoria='".$idSub."'";
		 $result_delete = pg_exec($con,$sql_delete);
		 ?>
        	<script type="text/javascript" language="javascript">
				alert("¡¡¡ Subcategoria eliminada satisfactoriamente !!!");
				location.href = "../administracion/listadoSubcategorias.php";
			</script>
         <?php			 
	}

?>
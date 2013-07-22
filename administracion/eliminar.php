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
					location.href="../administracion/listadocategorias.php";
				</script>
    	     <?php		 
		 
		 }else{
		 ?>
        	<script type="text/javascript" language="javascript">
				alert("ERROR: La categoría no puede ser eliminada ya que existen subcategorias asociadas a la misma.\n\n(Si realmente desea eliminar esta categoria, primero elimine todas las subcategorias que dependan de ella)");
				location.href="../administracion/listadocategorias.php";
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
				location.href = "../administracion/listadosubcategorias.php";
			</script>
         <?php			 
	}
	
	if($_GET["clave"]==3){ //Clave 3 indica que elimina COMODIDAD
	
		 $con = conectarse();
		 
		 /*Se verifica que no existan registros en tablas hijas que dependan del registro que se desea eliminar*/
		 $sql_select = "SELECT count(*) FROM hospedaje_comodidad WHERE idcomodidad='".$_GET["id"]."'";
		 $result_select = pg_exec($con,$sql_select);
		 $tieneHijos = pg_fetch_array($result_select,0);
	
	     if($tieneHijos[0]==0){
		 	 $sql_delete = "DELETE FROM comodidad WHERE idcomodidad='".$_GET["id"]."'";
			 $result_delete = pg_exec($con,$sql_delete);
		 
			 ?><script type="text/javascript" language="javascript">
					alert("¡¡¡ Comodidad eliminada satisfactoriamente !!!");
					location.href="../administracion/listadocomodidades.php";
				</script>
    	     <?php		 
		 
		 }else{
		 ?>
        	<script type="text/javascript" language="javascript">
				alert("ERROR: La comodidad NO PUEDE SER ELIMINADA ya que existen registros en la tabla hospedaje_comodidad asociados a la misma.\n\n(Si realmente desea eliminar esta comodidad, primero elimine todas los registros en la tabla hospedaje_comodidad que dependan de ella)");
				location.href="../administracion/listadocomodidades.php";
			</script>
         <?php		 			 
		 }
	}
	
	if($_GET["clave"]==4){ //Clave 4 indica que elimina ESPECIALIDAD
	
		 $con = conectarse();
		 
		 /*Se verifica que no existan registros en tablas hijas que dependan del registro que se desea eliminar*/
		 $sql_select = "SELECT count(*) FROM gastronomia_especialidad WHERE idespecialidad='".$_GET["id"]."'";
		 $result_select = pg_exec($con,$sql_select);
		 $tieneHijos = pg_fetch_array($result_select,0);
	
	     if($tieneHijos[0]==0){
		 	 $sql_delete = "DELETE FROM especialidad WHERE idespecialidad='".$_GET["id"]."'";
			 $result_delete = pg_exec($con,$sql_delete);
		 
			 ?><script type="text/javascript" language="javascript">
					alert("¡¡¡ Especialidad gastronómica eliminada satisfactoriamente !!!");
					location.href="../administracion/listadoespecialidades.php";
				</script>
    	     <?php		 
		 
		 }else{
		 ?>
        	<script type="text/javascript" language="javascript">
				alert("ERROR: La especialidad gastronómica NO PUEDE SER ELIMINADA ya que existen registros en la tabla gastronomia_especialidad asociados a la misma.\n\n(Si realmente desea eliminar esta comodidad, primero elimine todas los registros en la tabla gastronomia_especialidad que dependan de ella)");
				location.href="../administracion/listadoespecialidades.php";
			</script>
         <?php		 			 
		 }
	}

?>
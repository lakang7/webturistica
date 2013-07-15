<?php session_start();
	  require("../recursos/funciones.php");
	  
	  
	if($_GET["clave"]==1){ //Clave 1 indica que elimina supercategoria
	
		 $con = conectarse();
		 $sql_select="select count(*) from categoria where idsupercategoria='".$_GET["id"]."'";
		 $result_select=pg_exec($con,$sql_select);
		 $cuenta = pg_fetch_array($result_select,0);	
	
	     if($cuenta[0]==0){
		 $sql_delete = "delete from supercategoria where idsupercategoria='".$_GET["id"]."'";
		 $result_delete = pg_exec($con,$sql_delete);
		 
		 ?>
        	<script type="text/javascript" language="javascript">
				alert("Supercategoria eliminada satisfactoriamente.");
				location.href="../administracion/listadosupercategorias.php";
			</script>
         <?php		 
		 
		 }else{
		 ?>
        	<script type="text/javascript" language="javascript">
				alert("la supercategoria no puede ser eliminada ya que existen categorias asociada a la misma.");
				location.href="../administracion/listadosupercategorias.php";
			</script>
         <?php		 			 
		 }
	}

?>
<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Crear Tipo de Habitación</title>
		
    <link rel="stylesheet" href="../css/administracion/estructura.css" type="text/css"  />
	<link rel="stylesheet" type="text/css" href="../css/administracion/component.css" />
	<link rel="stylesheet" type="text/css" href="../css/administracion/default.css" />    
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css' />       
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js" ></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" ></script>    
    <script src="../js/administracion/modernizr.custom.js"></script>
    <script src="../js/administracion/jquery.dlmenu.js"></script>    
	<script src="../js/administracion/funcionesJS.js"></script>   
	
    <script type="text/javascript">  	
		/*********************************************************************************************
		*
			Funcion para validar campo de texto, que NO permita ni campo vacío ni introducir solo espacios en blanco
		*
		**********************************************************************************************/
		function validarCampo(formulario) {
        	//obteniendo el valor que se puso en el campo texto del formulario
        	campoNombre = formulario.nombre.value;			
			
        	//la condición
        	if (campoNombre.length == 0) {
				alert("Es necesario completar todos los campos marcados como obligatorios (*)");
            	return false;
        	}
			else if(/^\s+$/.test(campoNombre)){
				alert("Ningún campo obligatorio (*) puede quedar en blanco, ingrese valores válidos");
            	return false;
			}			
        	return true;
	    }
	</script>
</head>

<?php
	if(isset($_POST["Guardar"])){
		
		$con = conectarse();
		
		/*Se consulta la existencia de otro registro con ese mismo nombre para evitar crear registros repetidos*/
		$sql = "SELECT * FROM medio_pago ORDER BY idmedio_pago";
		$res = pg_exec($con, $sql);	
		$yaExiste = 0;
					
		if(pg_num_rows($res)>0){
			for($i=0; $i<pg_num_rows($res); $i++){				
				$medioPago = pg_fetch_array($res,$i);	
				$nombre = $medioPago[1];
				
				/*Si efectivamente ya existe, no se le permite crear*/
				if($nombre==$_POST["nombre"]){
					$yaExiste = 1;
					?><script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!! \n\n     Ese medio de pago ya existe, por favor ingrese otro nombre");
						location.href = "../administracion/crearmediopago.php";
					</script><?php
				}
			}
		}
		
		/*Si NO existe, se crea*/
		if($yaExiste==0){
			$sql_insert = "INSERT INTO medio_pago VALUES(nextval('medio_pago_idmedio_pago_seq'),'".$_POST["nombre"]."',null);";
			$result_insert = pg_exec($con,$sql_insert);
		
			if(!$result_insert){
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ ERROR !!!\n\n     No se pudo crear el medio de pago");
					location.href="../administracion/listadomediopago.php";
				</script><?php	
			}else{						
				/*Se consulta el id del registro recien creado*/
				$sql_select = "SELECT last_value FROM medio_pago_idmedio_pago_seq;";
				$result_select = pg_exec($con, $sql_select);
				$arreglo = pg_fetch_array($result_select,0);
				$idMedioPago = $arreglo[0];
					
				if($_FILES['icono']['name']!=""){
					/*Si SI se pudo, se sube el icono de la subcategoria a la carpeta respectiva*/
					$subir = new imgUpldr;	
					$nombreImagen = $idMedioPago."_".$_POST["nombre"];	
					$subir->configurar($nombreImagen,"../imagenes/mediosdepago/",591,591);
					$subir->init($_FILES['icono']);
					$destino = "imagenes/mediosdepago/".$subir->_name;
		
					/*Se actualiza el registro para incluir la ruta del icono que se acaba de subir*/
					$sql_update = "UPDATE medio_pago SET icono='".$destino."' WHERE idmedio_pago='".$idMedioPago."'";
					$result_update = pg_exec($con, $sql_update);	
							
					if(!$result_update){
						?><script type="text/javascript" language="javascript">
							alert("¡¡¡ ERROR !!!\n\n     No se pudo guardar el icono asociado a este medio de pago");
							location.href="../administracion/listadomediopago.php";
						</script><?php	
				    }
				}	
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ Medio de pago creado satisfactoriamente !!!");
					location.href="../administracion/listadomediopago.php";
				</script><?php
			}//end else de result_insert
		}//end yaExiste==0		
	}//end boton Guardar
?>

<body onload="cargo()">
	<div class="banner">        
    </div>
    <div class="menu">    				
		<?php menu_administrativo();  ?>		                       
    </div>
    <div class="panel">
    	<div class="titulo_panel">Crear Medio de Pago</div>
        <div class="opcion_panel">
	        <div class="opcion"> 
				<a href="listadomediopago.php">Listar Medios de Pago</a>
			</div>
        	<div class="opcion" style="background:#F00; color:#FFF;">
				<a href="crearmediopago.php">Registrar Nuevo Medio de Pago</a>
			</div>
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >    
            	<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Medio de Pago(*)</div>
                    <div class="linea_campo_compartido">
                    	<input type="text" class="campo_compartido" id="nombre" name="nombre" maxlength="45" value="<?php echo $tipo[1]; ?>"/>
                    </div>
                </div>
				<div class="linea_formulario_doble">
                	<div class="linea_titulo_doble">Icono Identificador</div>
                    <div class="linea_campo_doble">
                    	<input name="icono" class="campo_doble" type="file" id="icono" />
                    </div>
                </div>					
				<div class="linea_formulario">
					<div class="linea_titulo_rojo">
						<input type="submit" value="Guardar" name="Guardar" style="font-size:12px;" />(*) Campos obligatorios
					</div>					
				</div>
            </form>
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
<?php session_start();
	  require("../recursos/funciones.php");
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
		/*********************************************************************************************
		*
			Funcion para validar SOLO NUMEROS o SOLO LETRAS en un campo determinado
		*
		**********************************************************************************************/
		$(function(){
    		$('#capacidad').funcionesJS('0123456789-');
    	});	
	</script>
</head>

<?php
	if(isset($_POST["Guardar"])){
		
		$con = conectarse();
		
		/*Se consulta la existencia de otro TIPO DE HABITACION con el mismo nombre*/
		$sql = "SELECT * FROM tipo_habitacion ORDER BY idtipo_habitacion";
		$res = pg_exec($con, $sql);	
		$yaExiste = 0;
					
		if(pg_num_rows($res)>0){
			for($i=0; $i<pg_num_rows($res); $i++){				
				$tipo = pg_fetch_array($res,$i);	
				$nombre = $tipo[1];
				
				/*Si efectivamente ya existe esa comodidad, no se le permite crearla*/
				if($nombre==$_POST["nombre"]){
					$yaExiste = 1;
					?>
		        	<script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!! \n\n     Ese tipo de habitación ya existe, por favor ingrese otro nombre");
						location.href = "../administracion/creartipohabitacion.php";
					</script>
       				<?php
				}
			}
		}
		
		/*Si el TIPO DE HABITACION NO existe, se crea*/
		if($yaExiste==0){
			$sql_insert = "INSERT INTO tipo_habitacion VALUES(nextval('tipo_habitacion_idtipo_habitacion_seq'),'".$_POST["nombre"]."',".$_POST["capacidad"].");";
			$result_insert = pg_exec($con,$sql_insert);
		
			if(!$result_insert){
				?>
        		<script type="text/javascript" language="javascript">
					alert("¡¡¡ ERROR !!!\n\n     No se pudo crear el tipo de habitación");
					location.href="../administracion/listadotipohabitacion.php";
				</script>
    	    	<?php	
			}else{		
				?>
	        	<script type="text/javascript" language="javascript">
					alert("¡¡¡ Tipo de habitación agregado satisfactoriamente !!!");
					location.href="../administracion/listadotipohabitacion.php";
				</script>
	    	    <?php		
			}
		}		
	}
?>

<body onload="cargo()">
	<div class="banner">        
    </div>
    <div class="menu">    				
		<?php menu_administrativo();  ?>		                       
    </div>
    <div class="panel">
    	<div class="titulo_panel">Crear Tipo de Habitación</div>
        <div class="opcion_panel">
	        <div class="opcion"> 
				<a href="listadotipohabitacion.php">Listar Tipos</a>
			</div>
        	<div class="opcion" style="background:#F00; color:#FFF;">
				<a href="creartipohabitacion.php">Registrar Nuevo Tipo de Habitación</a>
			</div>
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >    
            	<div class="linea_formulario">
                	<div class="linea_titulo">Nombre del Tipo de Habitación (*)</div>
                    <div class="linea_campo">
                    	<input type="text" class="campo" id="nombre" name="nombre" maxlength="45"/>
                    </div>
                </div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio">Capacidad (Nro. Personas)</div>
                    <div class="linea_campo_promedio">
                    	<input type="text" class="campo_promedio" id="capacidad" name="capacidad" />
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
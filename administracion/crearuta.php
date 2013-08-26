<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Crear Rutas</title>
		
    <link rel="stylesheet" href="../css/administracion/estructura.css" type="text/css"  />
	<link rel="stylesheet" type="text/css" href="../css/administracion/component.css" />
	<link rel="stylesheet" type="text/css" href="../css/administracion/default.css" />    
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css' />       
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	
	<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBViGAK8QcqvLcl0Pgilw-ENvMhmL88E6A&sensor=true"></script>
	
	<script src="../js/mootools.1.2.3.js"></script>
	<script src="../js/administracion/sombrear_fila_tabla.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/administracion/sombrear_fila_tabla.css" />
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js" ></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" ></script>    
    <script src="../js/administracion/modernizr.custom.js"></script>
    <script src="../js/administracion/jquery.dlmenu.js"></script>    
	
    <script type="text/javascript">  
	
		/*********************************************************************************************
		*
			Funcion para validar campo de texto, que NO permita ni campo vacío ni introducir solo 
			espacios en blanco
		*
		**********************************************************************************************/
		function validarCampo(formulario) {
        	//obteniendo el valor que se puso en el campo texto del formulario
        	campoNombre = formulario.nombre.value;
			campoResena = formulario.resena.value;
			
			if(campoResena.length>1200){
				alert("Campo reseña es más largo de lo permitido (1200 caracteres) por favor redúzcalo e inténtelo de nuevo");
            	return false;
			}
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
			FUNCION PARA VALIDAR CANTIDAD MAXIMA DE CARACTERES EN RESEÑA (1200)
		*
		**********************************************************************************************/
		function limita(maximoCaracteres) {
			var elemento = document.getElementById("resena");
			if(elemento.value.length >= maximoCaracteres ) {
				//document.getElementById("hid_max_resena").value = -1;
				return false;				
			}else {
				//document.getElementById("hid_max_resena").value = 0;
				return true;
			}
		} 
	</script>
</head>

<?php
	if(isset($_POST["GuardarRuta"])){		
		$con = conectarse();		
		/*Se consulta la existencia de otra RUTA con el mismo nombre*/
		$sql = "SELECT * FROM ruta ORDER BY idruta";
		$res = pg_exec($con, $sql);	
		$yaExiste = 0;					
		if(pg_num_rows($res)>0){
			for($i=0; $i<pg_num_rows($res); $i++){				
				$ruta = pg_fetch_array($res,$i);	
				$nombreRuta = $ruta[1];
				
				/*Si efectivamente ya existe esa ruta, no se le permite crearla*/
				if($nombreRuta==$_POST["nombre"]){
					$yaExiste = 1;
					?><script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!! \n\n     Esa ruta ya existe, no se pudo crear la ruta");
						location.href = "../administracion/listadorutas.php";
					</script><?php
				}
			}
		}
				
		/*Si NO existe, se crea*/
		if($yaExiste==0){
			$sql_insert = "INSERT INTO ruta VALUES(nextval('ruta_idruta_seq'),'".$_POST['nombre']."','".$_POST['resena']."',null);";
			$result_insert = pg_exec($con,$sql_insert);
			
			if(!$result_insert){
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ ERROR !!! No se pudo crear la ruta");
					location.href="../administracion/listadorutas.php";
				</script><?php	
			}else{
				/*Se guarda en la variable oculta HidRuta el id de la ruta recien creada     $_POST["HidRuta"]*/ 
				$sql_select = "SELECT last_value FROM ruta_idruta_seq;";
				$result_select = pg_exec($con, $sql_select);
				$arreglo = pg_fetch_array($result_select,0);
				
				/*Se buscan datos de la ruta*/
				$sql_select_ruta = "SELECT * FROM ruta WHERE idruta='".$arreglo[0]."';";
				$result_select_ruta = pg_exec($con, $sql_select_ruta);
				$ruta = pg_fetch_array($result_select_ruta,0);
					
				if($_FILES['foto']['name']!=""){					
					/*Si SI se pudo, se sube la foto a la carpeta respectiva*/
					$subir = new imgUpldr;	
					$subir->configurar($arreglo[0]."_".$ruta["nombre"],"../imagenes/rutas/portadas/",591,591);
					$subir->init($_FILES['foto']);
					$destino = "imagenes/rutas/portadas/".$subir->_name;

					/*Se actualiza el registro para incluir la ruta del icono que se acaba de subir*/
					$sql_update = "UPDATE ruta SET foto_portada='".$destino."' WHERE idruta='".$arreglo[0]."'";
					$result_update = pg_exec($con, $sql_update);	
				
					if(!$result_update){
						?><script type="text/javascript" language="javascript">
							alert("¡¡¡ ERROR !!!\n\n     No se pudo guardar la foto de la ruta");
							location.href="../administracion/listadorutas.php";
						</script><?php	
			    	}
				}
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ Ruta agregada satisfactoriamente !!!")
					location.href="../administracion/crearpuntoruta.php?idRuta="+<?php echo $arreglo[0]; ?>;
				</script><?php
			}//end else de if(!$result_insert)
			
		}//end del if($yaExiste==0)		
	}
?>

<body onload="cargo(),inicializacion()">
	<div class="banner"></div>
    <div class="menu"><?php menu_administrativo(); ?></div>
    <div class="panel">
    	<div class="titulo_panel">Crear Rutas</div>
        <div class="opcion_panel">
	        <div class="opcion"><a href="listadorutas.php">Listar Rutas</a></div>
        	<div class="opcion" style="background:#F00;  color:#FFF;"><a href="crearuta.php" style="text-decoration:none; color:#FFF;">Registrar Nueva Ruta</a></div>
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
            	<div class="linea_formulario">
                	<div class="linea_titulo_2">Información Básica de la Ruta</div>                    
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Nombre de la Ruta (*)</div>
                    <div class="linea_campo_compartido"><input type="text" class="campo_compartido" id="nombre" name="nombre" maxlength="100"/></div>
                </div>
				<div class="linea_formulario_promedio">
					<div class="linea_titulo_tres_cuartos">Foto de portada</div>
                	<div class="linea_titulo_tres_cuartos"><input name="foto" type="file" id="icono"/></div>	
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido"></div><div class="linea_campo_compartido"></div>					
                </div>				
				<div class="linea_formulario_parrafo">
                	<div class="linea_titulo_tres_cuartos">Reseña Histórica</div>
					<input type="hidden" name="hid_max_resena" value="0" /> 	
                    <div class="linea_campo_tres_cuartos"><textarea name="resena" id="resena" rows="17" cols="110" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; max-width:550px; max-height:250px;" onkeypress="return limita(1200);"></textarea></div>
                </div>
				<div class="linea_formulario_promedio">
					<div class="linea_titulo_tres_cuartos"></div>
                	<div class="linea_titulo_tres_cuartos">
						<input type="submit" value="Guardar ruta" name="GuardarRuta" style="font-size:12px;" align="left"/>(*) Campos obligatorios
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
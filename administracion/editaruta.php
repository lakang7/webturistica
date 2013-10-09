<?php session_start();
	  require("../recursos/funciones.php");
	  include_once("../recursos/class_imgUpldr.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Editar Rutas</title>
	
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
			FUNCION PARA VALIDAR CANTIDAD MAXIMA DE CARACTERES EN RESEÑA (1200)
		*
		**********************************************************************************************/
		function limita(maximoCaracteres) {
			var elemento = document.getElementById("resena");
			if(elemento.value.length >= maximoCaracteres ) {
				return false;				
			}else {
				return true;
			}
		} 	
		/*********************************************************************************************
		*
			Funcion para guardar los valores de radio button TIPO DE RUTA
		*
		**********************************************************************************************/
		function guardarValorRadio(valor)
		{
			if(valor != -1){
				document.all('HidTipoRuta').value = valor;
			}
			else if(valor == -1){
				document.all('HidTipoRuta').value = -1;
			}
			//alert(document.all('HidTipoRuta').value);			
		}	
		/*********************************************************************************************
		*
			Funcion para mostrar imagen en un POPUP
		*
		**********************************************************************************************/
		function openPopup(imageURL,nombre){
    		var popupTitle = "Portada de "+nombre;
    		var newImg = new Image();
    		newImg.src = "../"+imageURL;
 			var ancho = 591; /*newImg.width;*/
			var alto = 591; /*newImg.height;*/
			
 			pos_x = (screen.width-newImg.width)/2;
	 	    pos_y = (screen.height-newImg.height)/2;
			
			popup = window.open(newImg.src,'image','height='+newImg.height+',width='+newImg.width+',left='+pos_x+',top='+pos_y+',toolbar=no, directories=no,status=no,menubar=no,scrollbars=no,resizable=no');

		    with (popup.document){
    	    	writeln('<html><head><title>'+popupTitle+'<\/title><style>body{margin:0px;}<\/style>');
	    	    writeln('<\/head><body onClick="window.close()">');
				writeln('<img src='+newImg.src+' style="display:block"><\/body><\/html>');
        		close();
		    }
		    popup.focus();
		}
	</script>

</head>

<?php
	if(isset($_POST["GuardarRuta"])){
		$con = conectarse();
		
		/*Se consulta la existencia de otra RUTA con el mismo nombre para no crear rutas repetidas*/
		$sql = "SELECT * FROM ruta ORDER BY idruta";
		$res = pg_exec($con, $sql);	
		$yaExiste = 0;		
							
		if(pg_num_rows($res)>0){
			for($i=0; $i<pg_num_rows($res); $i++){				
				$ruta = pg_fetch_array($res,$i);	
				
				/*Si efectivamente ya existe esa ruta, no se le permite crearla*/
				if($ruta["nombre"]==$_POST["nombre"] && $ruta["idruta"]!=$_GET["id"]){
					$yaExiste = 1;
					?><script type="text/javascript" language="javascript">
						alert("¡¡¡ ERROR !!! \n\n     Esa ruta ya existe, no se pudo crear la ruta");
						location.href = "../administracion/listadorutas.php";
					</script><?php
				}
			}
		}
				
		/*Si NO existe ese nombre de ruta, se actualiza el registro*/
		if($yaExiste==0){
			$sql_update = "UPDATE ruta SET nombre='".$_POST["nombre"]."', resena='".$_POST["resena"]."', tipo_ruta='".$_POST["HidTipoRuta"]."' WHERE idruta='".$_GET["id"]."'";
			$result_update = pg_exec($con,$sql_update);
		
			//Si NO se pudo actualizar el registro
			if(!$result_update){
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ ERROR !!! \n     No se pudo modificar la ruta");
					location.href="../administracion/listadorutas.php";
				</script><?php	
			}
			//Si SI se pudo actualizar 
			else{
				/*Se buscan los datos de la ruta*/
				$sql_select_ruta = "SELECT * FROM ruta WHERE idruta='".$_GET["id"]."';";
				$result_select_ruta = pg_exec($con, $sql_select_ruta);
				$ruta = pg_fetch_array($result_select_ruta,0);
			
				//Si se cargó una nueva fotografía
				if($_FILES['foto']['name']!=""){	
					//Si ya tenía icono cargado, se borra la imagen de la carpeta respectiva
					if($ruta["foto_portada"]!=""){ $borrar = borrarArchivo("../".$ruta["foto_portada"]); }
								
					//Se sube la foto nueva a la carpeta respectiva
					$subir = new imgUpldr;	
					$subir->configurar($ruta["idruta"]."_".quitarAcentos($ruta["nombre"]),"../imagenes/rutas/portadas/",450,300);
					$subir->init($_FILES['foto']);
					$destino = "imagenes/rutas/portadas/".$subir->_name;

					/*Se actualiza el registro para incluir la ruta del icono que se acaba de subir*/
					$sql_update = "UPDATE ruta SET foto_portada='".$destino."' WHERE idruta='".$ruta["idruta"]."'";
					$result_update = pg_exec($con, $sql_update);	
					
					if(!$result_update){
						?><script type="text/javascript" language="javascript">
							alert("¡¡¡ ERROR !!!\n\n     No se pudo guardar la foto de la ruta");
							location.href="../administracion/listadorutas.php";
						</script><?php	
		    		}
				}
			
				?><script type="text/javascript" language="javascript">
					alert("¡¡¡ Ruta modificada satisfactoriamente !!\n\n     A continuación complete la información de los puntos del sitio");	
					location.href = "../administracion/listadopuntosruta.php?idRuta=<?php echo $_GET["id"];?>";
			</script><?php
			}//end de que si se pudo actualizar	
		}
	}
?>

<body onload="cargo()">
	<div class="banner"></div>
    <div class="menu">    				
		<?php menu_administrativo();  
		
		/*Se consultan los datos del id que llega por GET*/
		$con = conectarse();
		$sql_select = "SELECT * FROM ruta WHERE idruta='".$_GET["id"]."';";
		$result_select = pg_exec($con, $sql_select);
		$arreglo = pg_fetch_array($result_select,0);	
		?>		                       
    </div>
    <div class="panel">
    	<div class="titulo_panel">Editar Rutas</div>
        <div class="opcion_panel">
	        <div class="opcion"> <a href="listadorutas.php">Listar Rutas</a></div>
        	<div class="opcion" style="background:#F00; color:#FFF;"><a href="crearuta.php">Registrar Nueva Ruta</a></div>
        </div>
        <div class="capa_formulario">
        	<form onsubmit="return validarCampo(this)" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
  				<div class="linea_formulario">
                	<div class="linea_titulo_2">Información Básica de la Ruta</div>                    
                </div>
				<div class="linea_formulario_compartido">
                	<div class="linea_titulo_compartido">Nombre de la Ruta (*)</div>
                    <div class="linea_campo_compartido"><input type="text" class="campo_compartido" id="nombre" name="nombre" maxlength="100" value="<?php echo $arreglo["nombre"]; ?>"/></div>
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
                    <div class="linea_campo_tres_cuartos"><textarea name="resena" id="resena" rows="17" cols="110" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; max-width:550px; max-height:250px;" onkeypress="return limita(1200);"><?php echo $arreglo["resena"]; ?></textarea></div>
                </div>
				<div class="linea_formulario_promedio"></div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio_rojo">Vista Previa Portada Actual</div> 	
					<div class="linea_titulo_tres_cuartos"></div> 	
                    <div class="linea_titulo_tres_cuartos">
						<?php 
							//Si tiene ícono asociado, lo muestra en un popup
							if($arreglo["foto_portada"]!=""){?>
								<a href="#" onclick="openPopup('<? echo $arreglo["foto_portada"]; ?>','<? echo $arreglo["nombre"]; ?>');return false;"><img src="../imagenes/ver.png" width="16" height="16" title="Vista Previa Foto actual" align="middle"/></a>
								<?php 
							}else{
								?><img src="../imagenes/ver.png" width="16" height="16" title="No existe imagen para esta ruta"/><?php
							}?>
					</div>
                </div>
				<div class="linea_formulario_promedio"></div><div class="linea_formulario_promedio"></div>
				<div class="linea_formulario_promedio"></div><div class="linea_formulario_promedio"></div>
				<div class="linea_formulario_promedio">
                	<div class="linea_titulo_promedio_rojo">Tipo de Ruta</div> 	
					<div class="linea_titulo_tres_cuartos"></div> 	
                    <div class="linea_titulo_tres_cuartos">
						<input type="hidden" name="HidTipoRuta" value="1" />
						<?php 
						/*----------------------------------------------------------------------
									              Si es RUTA TURISTICA 
						----------------------------------------------------------------------*/
						if($arreglo["tipo_ruta"]==1){?>
							<input name="tipo_ruta" type="radio" value="1" checked="checked" onchange="javascript:guardarValorRadio(this.value)"/> Turística
							<input name="tipo_ruta" type="radio" value="2" onchange="javascript:guardarValorRadio(this.value)"/> Ecomuseos
						<?php
						}
						/*----------------------------------------------------------------------
									              Si es RUTA ECOMUSEOS 
						----------------------------------------------------------------------*/
						if($arreglo["tipo_ruta"]==2){?>
							<input name="tipo_ruta" type="radio" value="1" onchange="javascript:guardarValorRadio(this.value)"/> Turística
							<input name="tipo_ruta" type="radio" value="2" checked="checked" onchange="javascript:guardarValorRadio(this.value)"/> Ecomuseos
						<?php
						}?>
					</div>
                </div>
				<div class="linea_formulario_promedio"></div><div class="linea_formulario_promedio"></div>
				<div class="linea_formulario_promedio"></div><div class="linea_formulario_promedio"></div>
				<div class="linea_formulario_promedio"></div><div class="linea_formulario_promedio"></div>
				<div class="linea_formulario_promedio"></div>
				<div class="linea_formulario_promedio">
					<div class="linea_titulo_tres_cuartos"></div>
                	<div class="linea_titulo_tres_cuartos">
						<input type="submit" value="Guardar ruta" name="GuardarRuta" style="font-size:12px;" align="left" title="Haga clic para guardar los cambios de la ruta"/>(*) Campos obligatorios
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
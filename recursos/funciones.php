<?php

	function conectarse(){
	  if (!($conexion = pg_connect("dbname=turismoenlagrita port=5432 user=postgres password=jcglobal")))
	   {
	       echo "No pudo conectarse al servidor";
	       exit();
	   }
	    return $conexion;		
	}


	function Codigo($prefijo,$numero){
		$codigo=$prefijo;																
		if($numero>9999){
			$codigo=$codigo.$numero;	
		}else
		if($numero>999){
			$codigo=$codigo."0".$numero;	
		}else
		if($numero>99){
			$codigo=$codigo."00".$numero;	
		}else
		if($numero>9){
			$codigo=$codigo."000".$numero;	
		}else															
		if($numero>0){
			$codigo=$codigo."0000".$numero;	
		}
		return $codigo;			
	}
	
	function InversaCodigo($codigo){
		$aux="";
		for($i=0;$i<strlen($codigo);$i++){
		    if($i>2){
			   $aux=$aux.$codigo[$i];	
			}
		}
		return $aux;
	}


	function menu_administrativo(){
				echo "<div class='container demo-0'>";
					echo "<div id='dl-menu' class='dl-menuwrapper'>";
						echo "<button class='dl-trigger' id='dl-trigger'>Open Menu</button>";
						echo "<ul class='dl-menu'>";
							echo "<li>";
								echo "<a href='#'>Sitios de Interes</a>";
								echo "<ul class='dl-submenu'>";
									echo "<li>";
										echo "<a href='#'>Clasificación</a>";
										echo "<ul class='dl-submenu'>";
											echo "<li><a href='crearcategorias.php'>Categoría</a></li>";
											echo "<li><a href='#'>Sub Categoría</a></li>";
										echo "</ul>";
									echo "</li>";
									echo "<li>";
										echo "<a href='#'>Hospedaje</a>";
										echo "<ul class='dl-submenu'>";
											echo "<li><a href='#'>Comodidades</a></li>";
											echo "<li><a href='#'>Hoteles</a></li>";
											echo "<li><a href='#'>Posadas</a></li>";
										echo "</ul>";
									echo "</li>";
									echo "<li>";
										echo "<a href='#'>Gastronomia</a>";
										echo "<ul class='dl-submenu'>";
											echo "<li><a href='#'>Especialidades</a></li>";
											echo "<li><a href='#'>Servicios</a></li>";
                                            echo "<li><a href='#'>Recomendado</a></li>";
											echo "<li><a href='#'>Restaurantes</a></li>";
                                            echo "<li><a href='#'>Panaderias</a></li>";                                        
										echo "</ul>";
									echo "</li>";
								echo "</ul>";
							echo "</li>";
							echo "<li>";
								echo "<a href='#'>Electronics</a>";
								echo "<ul class='dl-submenu'>";
									echo "<li><a href='#'>Camera &amp; Photo</a></li>";
									echo "<li><a href='#'>TV &amp; Home Cinema</a></li>";
									echo "<li><a href='#'>Phones</a></li>";
									echo "<li><a href='#'>PC &amp; Video Games</a></li>";
								echo "</ul>";
							echo "</li>";
							echo "<li>";
								echo "<a href='#'>Furniture</a>";
								echo "<ul class='dl-submenu'>";
									echo "<li>";
										echo "<a href='#'>Living Room</a>";
										echo "<ul class='dl-submenu'>";
											echo "<li><a href='#'>Sofas &amp; Loveseats</a></li>";
											echo "<li><a href='#'>Coffee &amp; Accent Tables</a></li>";
											echo "<li><a href='#'>Chairs &amp; Recliners</a></li>";
											echo "<li><a href='#'>Bookshelves</a></li>";
										echo "</ul>";
									echo "</li>";
									echo "<li>";
										echo "<a href='#'>Bedroom</a>";
										echo "<ul class='dl-submenu'>";
											echo "<li>";
												echo "<a href='#'>Beds</a>";
												echo "<ul class='dl-submenu'>";
													echo "<li><a href='#'>Upholstered Beds</a></li>";
													echo "<li><a href='#'>Divans</a></li>";
													echo "<li><a href='#'>Metal Beds</a></li>";
													echo "<li><a href='#'>Storage Beds</a></li>";
													echo "<li><a href='#'>Wooden Beds</a></li>";
													echo "<li><a href='#'>Children's Beds</a></li>";
												echo "</ul>";
											echo "</li>";
											echo "<li><a href='#'>Bedroom Sets</a></li>";
											echo "<li><a href='#'>Chests &amp; Dressers</a></li>";
										echo "</ul>";
									echo "</li>";
									echo "<li><a href='#'>Home Office</a></li>";
									echo "<li><a href='#'>Dining &amp; Bar</a></li>";
									echo "<li><a href='#'>Patio</a></li>";
								echo "</ul>";
							echo "</li>";
							echo "<li>";
								echo "<a href='#'>Jewelry &amp; Watches</a>";
								echo "<ul class='dl-submenu'>";
									echo "<li><a href='#'>Fine Jewelry</a></li>";
									echo "<li><a href='#'>Fashion Jewelry</a></li>";
									echo "<li><a href='#'>Watches</a></li>";
									echo "<li>";
										echo "<a href='#'>Wedding Jewelry</a>";
										echo "<ul class='dl-submenu'>";
											echo "<li><a href='#'>Engagement Rings</a></li>";
											echo "<li><a href='#'>Bridal Sets</a></li>";
											echo "<li><a href='#'>Women's Wedding Bands</a></li>";
											echo "<li><a href='#'>Men's Wedding Bands</a></li>";
										echo "</ul>";
									echo "</li>";
								echo "</ul>";
							echo "</li>";
						echo "</ul>";
					echo "</div>";
				echo "</div>";	
	}

?>
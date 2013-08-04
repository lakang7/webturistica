<?php
	function conectarse(){
	  if (!($conexion = pg_connect("dbname=turismoenlagrita port=5432 user=postgres password=jcglobal")))
	   {
	       echo "No pudo conectarse al servidor";
	       exit();
	   }
	    return $conexion;		
	}	
			
	function menu_principal(){		
    	echo "<div class='navbar navbar-static-top'>";
        	echo "<div class='navbar-inner'>";
        		echo "<div class='container'>";
      				echo "<a class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>";
				    	echo "<span class='icon-bar'></span><span class='icon-bar'></span><span class='icon-bar'></span>";
	    			echo "</a>";   
        			echo "<a class='brand' href='index.php'>www.turismoenlagrita.com</a>";
	    			echo "<div class='nav-collapse collapse'>";
	    				echo "<ul class='nav'>";                    
	    					echo "<li class='dropdown'>";
	        					echo "<a class='dropdown-toggle' data-toggle='dropdown' href=''>Sitios de Inter&eacutes<b class='caret'></b></a>";
	    	    				echo "<ul class='dropdown-menu'>";		
 		    						$con = conectarse();
							 	    $sql_select_cat = "SELECT * FROM categoria ORDER BY idcategoria";
							 	    $result_sel_cat = pg_exec($con,$sql_select_cat);	
								    for($i=0;$i<pg_num_rows($result_sel_cat);$i++){
									    $categoria = pg_fetch_array($result_sel_cat);
									    echo "<li><a href='sitiosinteres.php'>".$categoria[1]."</a></li>";
								    }		         
						        echo "</ul>";
					        echo "</li>";
                        
						    echo "<li class='dropdown'>";
						        echo "<a class='dropdown-toggle' data-toggle='dropdown' href=''>Rutas<b class='caret'></b></a>";
						        echo "<ul class='dropdown-menu'>";
							        echo "<li><a href=''>Rutas Tur&iacutesticas</a></li>";
							        echo "<li><a href=''>Ruta de Los Eco-Museos</a></li>";
						        echo "</ul>";
				    	    echo "</li>";
                                                

						    echo "<li class='dropdown'>";
						        echo "<a class='dropdown-toggle' data-toggle='dropdown' href=''>Nosotros<b class='caret'></b></a>";
						        echo "<ul class='dropdown-menu'>";
							        echo "<li><a href='festividades.php'>Festividades</a></li>";
					    		    echo "<li><a href='platostipicos.php'>Platos T&iacutepicos</a></li>";
					        		echo "<li><a href='personajes.php'>Personajes</a></li>";
						        echo "</ul>";
					        echo "</li>";
						    echo "<li><a href=''>Sube tu Foto</a></li>";
						    echo "<li><a href='blog.php'>Nuestro Blog</a></li>";
						    echo "<li><a href=''>Cont&aacutectanos</a></li>";
		    			echo "</ul>";
                    
				        echo "<button class='btn' style='float:rigth'>Reg&iacutestrate</button>";
				    echo "</div>";
				echo "</div>";
        	echo "</div>";
        echo "</div>";		


			
		

	}			
	
	function menu_sitiosinteres(){
	    $con = conectarse();
 	    $sql_select_cat="SELECT * FROM categoria ORDER BY idcategoria";
	    $result_sel_cat=pg_exec($con,$sql_select_cat);
	   
        echo "<div class='well'>";
	    echo "<ul class='nav nav-list' style='font-family: 'PT Sans Narrow', sans-serif;' >";
	   
	    for($i=0;$i<pg_num_rows($result_sel_cat);$i++){
		    $categoria=pg_fetch_array($result_sel_cat);
		    if($categoria[2]>0){
			    echo "<li class='nav-header'>".$categoria[1]."</li>";
		    	$sql_select_sub="SELECT * FROM subcategoria WHERE idcategoria='".$categoria[0]."' ORDER BY idsubcategoria";
				$result_sel_sub=pg_exec($con,$sql_select_sub);
				for($j=0;$j<pg_num_rows($result_sel_sub);$j++){
					$subcategoria=pg_fetch_array($result_sel_sub,$j); 
					echo "<li ><a href='#'>".$subcategoria[2]."</a></li>";						
				}
				echo "<li class='divider'></li>";
		    }
	    }
	   
	    echo "</ul>";
        echo "</div>";
	}	
?>
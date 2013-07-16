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
            
        echo "<a class='brand' href='#'  >www.turismoenlagrita.com</a>";
	    echo "<div class='nav-collapse collapse'>";
	    echo "<ul class='nav'>";
                    
	    echo "<li class='dropdown'>";
        echo "<a class='dropdown-toggle' data-toggle='dropdown' href=''>Sitios de Interes<b class='caret'></b></a>";
        echo "<ul class='dropdown-menu'>";
		
	   $con = conectarse();
	   $sql_select_cat="select * from categoria order by idcategoria";
	   $result_sel_cat=pg_exec($con,$sql_select_cat);	
	   for($i=0;$i<pg_num_rows($result_sel_cat);$i++){
		   $categoria=pg_fetch_array($result_sel_cat);
		   echo "<li><a href=''>".$categoria[1]."</a></li>";
	   }
		        
        echo "</ul>";
        echo "</li>";
                        
	    echo "<li class='dropdown'>";
        echo "<a class='dropdown-toggle' data-toggle='dropdown' href=''>Rutas<b class='caret'></b></a>";
        echo "<ul class='dropdown-menu'>";
        echo "<li><a href=''>Rutas Turisticas</a></li>";
        echo "<li><a href=''>Ruta de Los Eco-Museos</a></li>";
        echo "</ul>";
        echo "</li>";
                                                
	    echo "<li class='dropdown'>";
        echo "<a class='dropdown-toggle' data-toggle='dropdown' href=''>Nosotros<b class='caret'></b></a>";
        echo "<ul class='dropdown-menu'>";
        echo "<li><a href=''>Festividades</a></li>";
        echo "<li><a href=''>Platos Tipicos</a></li>";
        echo "<li><a href=''>Personajes</a></li>";
        echo "</ul>";
        echo "</li>";
	    echo "<li><a href=''>Sube tu Foto</a></li>";
	    echo "<li><a href=''>Nuestro Blog</a></li>";
	    echo "<li><a href=''>Contactanos</a></li>";
	    echo "</ul>";
                    
        echo "<button class='btn' style='float:rigth'>Registrate</button>";
	    echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
			
		
	}			
	
	function menu_sitiosinteres(){
	   $con = conectarse();
	   $sql_select_cat="select * from categoria order by idcategoria";
	   $result_sel_cat=pg_exec($con,$sql_select_cat);
	   
       echo "<div class='well'>";
	   echo "<ul class='nav nav-list' style='font-family: 'PT Sans Narrow', sans-serif;' >";
	   
	   for($i=0;$i<pg_num_rows($result_sel_cat);$i++){
		   $categoria=pg_fetch_array($result_sel_cat);
		   if($categoria[2]>0){
			    echo "<li class='nav-header'>".$categoria[1]."</li>";
		    	$sql_select_sub="select * from subcategoria where idcategoria='".$categoria[0]."' order by idsubcategoria";
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
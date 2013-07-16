<?php session_start();
	  require("recursos/funcionesinterfaz.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>turismoenlagrita</title>

<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/css/bootstrap-combined.min.css" rel="stylesheet">
<link href="css/modificabootstrap.css" rel="stylesheet" />

<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700' rel='stylesheet' type='text/css'>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>


</head>

<body style="background:#F9F9F9;">
      	   

	<?php menu_principal(); ?>

	
	<div id="myCarousel" class="carousel slide">
	  <ol class="carousel-indicators">
	    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	    <li data-target="#myCarousel" data-slide-to="1"></li>
	    <li data-target="#myCarousel" data-slide-to="2"></li>
	  </ol>

	  <div class="carousel-inner">
	    <div class="active item"><img src="imagenes/index/banner1.jpg" width="1500" height="350" />      	            	
	        <div class="carousel-caption">
        	  <div class="span7">   
			        <h1 style="color:#FFF; ">Another example headline.</h1>
			        <p class="lead" style="font-family: 'PT Sans Narrow', sans-serif; font-size:18px;">
						Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.                    
			        </p>
	                <a class="btn btn-large btn-primary" href="#">Link Prueba</a>
		        </div>       
	        </div>                                           
        </div>
	    <div class="item"><img src="imagenes/index/banner2.jpg" width="1500" height="350" />
	        <div class="carousel-caption">
        	  <div class="span7">   
			        <h1 style="color:#FFF; ">Another example headline.</h1>
			        <p class="lead" style="font-family: 'PT Sans Narrow', sans-serif; font-size:18px;">
						Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.                    
			        </p>
	                <a class="btn btn-large btn-primary" href="#">Link Prueba</a>
		        </div>       
	        </div>                 
        </div>
	    <div class="item"><img src="imagenes/index/banner3.jpg" width="1500" height="350" />
	        <div class="carousel-caption">
        	  <div class="span7">   
			        <h1 style="color:#FFF; ">Another example headline.</h1>
			        <p class="lead" style="font-family: 'PT Sans Narrow', sans-serif; font-size:18px;">
						Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.                    
			        </p>
	                <a class="btn btn-large btn-primary" href="#">Link Prueba</a>
		        </div>       
	        </div>         
        </div>
	  </div>
	
	  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
	  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
	</div>  
    


<div class="container-fluid">


<div class="row-fluid" >
	<div class="span1">
      <img src="imagenes/subcategorias/parques.png" width="591" height="591" />
      <h5>Parques</h5>
    </div>
    <div class="span1" >
      <img src="imagenes/subcategorias/museos.png" width="591" height="591" />
      <h5>Museos</h5>
    </div>
    <div class="span1">
    	<img src="imagenes/subcategorias/restaurantes.png" width="591" height="591" />
        <h5>Restaurantes</h5>
    </div>
    <div class="span1">
    	<img src="imagenes/subcategorias/gasolineras.png" width="591" height="591" />
      	<h5>Gasolineras</h5>
    </div>
  	<div class="span1">
   		<img src="imagenes/subcategorias/iglesias.png" width="591" height="591" />
        <h5>Iglesias</h5>    
  	</div>
    <div class="span1">
    	<img src="imagenes/subcategorias/hoteles.png" width="591" height="591" />
    	<h5>Hoteles</h5>     
  	</div>
    <div class="span1">
    	<img src="imagenes/subcategorias/cajeros.png" width="499" height="499" />
    	<h5>Cajeros</h5>    
    </div>
    <div class="span1">
    	<img src="imagenes/subcategorias/hospitales.png" width="591" height="591" />
    	<h5>Hospitales</h5> 
    </div>
    <div class="span1">
   	 	<img src="imagenes/subcategorias/discos.png" width="591" height="591" />
        <h5>Discos y Bares</h5>     
  	</div>
    <div class="span1">
    	<img src="imagenes/subcategorias/posadas.png" width="590" height="590" />
    	<h5>Posadas</h5> 
	</div>
    <div class="span1">
    	<img src="imagenes/subcategorias/aldeas.png" width="590" height="590" />
    	<h5>Aldeas</h5>    	
    </div>
  	<div class="span1">
    	<img src="imagenes/subcategorias/panaderias.png" width="590" height="590" />
    	<h5>Panaderias</h5>   
  	</div>    
</div>

<div class="row-fluid">
	  <div class="span4">
      <img src="imagenes/index/fiestasreligiosas.png" class="imagen" />
      <h2>Fiestas Religiosas</h2>
      <p style="text-align:justify;font-family: 'PT Sans Narrow', sans-serif; font-size:16px;">
		Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.      
      </p>
      <a class="btn" href="#" style="margin-bottom:20px;">Link Prueba »</a>
    </div>
    <div class="span4" >
    <img src="imagenes/index/platostipicos.png"  class="imagen"   />
    <h2>Platos Tipicos</h2>  
      <p style="text-align:justify;font-family: 'PT Sans Narrow', sans-serif; font-size:16px;">
		Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.      
      </p> 
      <a class="btn" href="#" style="margin-bottom:20px;">Link Prueba »</a>           
    </div>
  <div class="span4">
  <img src="imagenes/index/personajestipicos.png"  class="imagen"  />
  <h2>Personajes</h2> 
      <p style="text-align:justify;font-family: 'PT Sans Narrow', sans-serif; font-size:16px;">
		Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.      
      </p>
      <a class="btn" href="#" style="margin-bottom:20px;">Link Prueba »</a>             
    </div>
  </div>

	<div class="row-fluid" >


<div class="span8">
	
    <div class="accordion" id="accordion2">
    	<div class="accordion-group">
        	<div class="accordion-heading">
				<a class="accordion-toggle" style="font-family: 'PT Sans Narrow', sans-serif; font-size:18px; font-weight:bold; color:#333; text-decoration:none;" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">Ruta paso de los Andes</a>
		    </div>
    	<div id="collapseOne" class="accordion-body collapse in">
			<div class="accordion-inner">
		        <img src="imagenes/index/ruta1.jpg" width="1024" height="350" />
	        </div>
	    </div>
	</div>
  
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" style="font-family: 'PT Sans Narrow', sans-serif; font-size:18px; font-weight:bold; color:#333; text-decoration:none;" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">Ruta del Peregrino</a>
		</div>
		<div id="collapseTwo" class="accordion-body collapse">
			<div class="accordion-inner">
				<img src="imagenes/index/ruta2.jpg" width="1024" height="350" />
			</div>
		</div>
	</div>
  
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" style="font-family: 'PT Sans Narrow', sans-serif; font-size:18px; font-weight:bold; color:#333; text-decoration:none;" data-toggle="collapse" data-parent="#accordion2" href="#collapseTree">Ruta Bellezas de mi Pueblo</a>
		</div>
		<div id="collapseTree" class="accordion-body collapse">
			<div class="accordion-inner">
				<img src="imagenes/index/ruta3.jpg" width="1024" height="350" />
			</div>
		</div>
	</div>      
</div>      
</div>
		
    
    <div class="span4">
        
	<div class="accordion-group">
	  <div class="accordion-heading">
		<a class="accordion-toggle" style="font-family: 'PT Sans Narrow', sans-serif; font-size:18px; font-weight:bold; color:#333; text-decoration:none;" data-toggle="collapse" data-parent="#accordion2" >Ruta de los Eco-Museos</a>
	  </div>
	  	<img src="imagenes/index/ruta4.jpg" width="618" height="450" />		   
    </div>                
      <p style="text-align:justify;font-family: 'PT Sans Narrow', sans-serif;">
		Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.      
      </p> 	
    </div><!-- Fin de span4-->

</div>  
    
</body>


	<script>

      !function ($) {
        $(function(){
          // carousel demo
          $('#myCarousel').carousel()
        })
      }(window.jQuery)
    
	</script>

</html>
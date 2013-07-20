<?php session_start();
	  require("recursos/funcionesinterfaz.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/css/bootstrap-combined.min.css" rel="stylesheet">
<link href="css/modificabootstrap.css" rel="stylesheet" />

<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

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
		<div class="span4">
        
        
            <div class="well">
				<ul class="nav nav-list" style="font-family: 'PT Sans Narrow', sans-serif;	" >
				  <li class="nav-header" style="font-size:18px; margin-top:15px; margin-bottom:10px;">Nuestros Articulos Mas Leidos</li>
				  <li><a href="#" style="line-height:30px;"><h2 style="float:left; margin-right:5px;">01</h2>Cómo llegar del Aeropuerto de Bérgamo a Milán</a></li>
				  <li><a href="#" style="line-height:30px;"><h2 style="float:left; margin-right:5px;">02</h2>Compañeros de Ruta: canciones, consejos y destinos veraniegos</a></li>
                  <li><a href="#" style="line-height:30px;"><h2 style="float:left; margin-right:5px;">03</h2>Consejos a viajeros de la Asociación Catalana de Agencias de Viajes</a></li>	
				  <li><a href="#" style="line-height:30px;"><h2 style="float:left; margin-right:5px;">04</h2>Visita a la Mezquita del Cristo de la Luz en Toledo</a></li>
                  <li><a href="#" style="line-height:30px;"><h2 style="float:left; margin-right:5px;">05</h2>La Haya: los museos que no debes dejar de visitar</a></li>                  
                  <li class="divider"></li>                                                                                 		  
				</ul>        	
            </div>
            
            
            
        </div>
        
        
        <div class="span8">
        
	<div class="row-fluid" style="margin-bottom:10px;" >
   		<h4 style="border-bottom:1px solid #e3e3e3;">Cómo llegar del Aeropuerto de Bérgamo a Milán</h4>
        <label>Publicado por Lakhsmi Angarita el 17 de Julio de 2013</label> 
        <div class="row-fluid">
        	<div class="span6" >
            	<img src="imagenes/blog/cadaques.jpg" width="650" height="435" />
            </div>
       	    <div class="span6" >
            	<p style="font-family: 'PT Sans Narrow', sans-serif; font-size:16px; text-indent:30px; text-align:justify;">
				Cambio de quincena en pleno mes de julio, eso significa que mucha gente empezará mañana sus vacaciones y probablemente algún viaje apasionante. Los que todavía no tengan claro su destino quizá puedan ir tomando nota de las propuestas de nuestros compañeros de ruta.
				</p>
                <p style="font-family: 'PT Sans Narrow', sans-serif; font-size:16px; text-indent:30px; text-align:justify;">
                En Diario del Viajero nos encanta bucear en otros blogs de viajes para luego compartir sus experiencias con todos vosotros. Este domingo, empezamos un viaje fascinante que nos va a llevar por varios continentes. Despegamos en 3,2,1…                
                </p>
            </div>                       
        </div>
        <div class="row-fluid">
        	<div class="span12">
            <a class="btn" href="#" style="float:right;">Seguir Leyendo »</a>
            </div>
        </div>
        
    </div>        


	<div class="row-fluid" style="margin-bottom:10px;"  >
   		<h4 style="border-bottom:1px solid #e3e3e3;">Compañeros de Ruta: canciones, consejos y destinos veraniegos</h4>
        <label>Publicado por Lakhsmi Angarita el 17 de Julio de 2013</label> 
        <div class="row-fluid">
        	<div class="span6" >
            	<img src="imagenes/blog/Socotra.jpg" width="650" height="435" />
            </div>
       	    <div class="span6" >
            	<p style="font-family: 'PT Sans Narrow', sans-serif; font-size:16px; text-indent:30px; text-align:justify;">
				Cambio de quincena en pleno mes de julio, eso significa que mucha gente empezará mañana sus vacaciones y probablemente algún viaje apasionante. Los que todavía no tengan claro su destino quizá puedan ir tomando nota de las propuestas de nuestros compañeros de ruta.
				</p>
                <p style="font-family: 'PT Sans Narrow', sans-serif; font-size:16px; text-indent:30px; text-align:justify;">
                En Diario del Viajero nos encanta bucear en otros blogs de viajes para luego compartir sus experiencias con todos vosotros. Este domingo, empezamos un viaje fascinante que nos va a llevar por varios continentes. Despegamos en 3,2,1…                
                </p>
            </div>            
        </div>
        <div class="row-fluid">
        	<div class="span12">
            <a class="btn" href="#" style="float:right;">Seguir Leyendo »</a>
            </div>
        </div>        
    </div>  
         
        
        </div>
	</div>
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
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
		<div class="span3">
            <div class="well">
				<ul class="nav nav-list" style="font-family: 'PT Sans Narrow', sans-serif;	" >
				  <li class="nav-header">Nuestras Festividades</li>
				  <li><a href="#">Religiosas</a></li>
				  <li class="active"><a href="#">Patrioticas</a></li>	
                  <li class="divider"></li>                                                                                 		  
				</ul>        	
            </div>
        </div>
        
        
        <div class="span9">
        
	<div class="row-fluid">

	<ul class="breadcrumb" style="font-family: 'Oswald', sans-serif; font-weight:normal; border:1px solid #e3e3e3;">
	  
	  <img src="imagenes/fiestasreligiosas.png" width="25" height="25" /><li style="margin-left:5px;" ><a href="#">Festividades</a> <span class="divider">/</span></li>
	  <li class="active" >Religiosas [02]</li>
	</ul>    
    
    </div>        
    <div class="row-fluid">    
	<ul class="thumbnails">
	  <li class="span4">
	    <div class="thumbnail">
	      <img src="imagenes/festividades/religiosas/santocristodelagrita.png" width="450" height="300" />
	      <h3><img src="imagenes/fiestasreligiosas.png" width="20" height="20" /> Día del Santo Cristo</h3>
		  <h6><img src="imagenes/calendario.png" width="25" height="17" />Celebrado los 06 de agosto de cada año.</h6>
          <h6><img src="imagenes/posiciongeografica.png" width="25" height="17" />Se lleva a cabo por las calles principales de la ciudad.</h6>
	    </div>
	  </li>
	  <li class="span4">
	    <div class="thumbnail">
	      <img src="imagenes/festividades/religiosas/virgendelosangeles.png" width="450" height="300" />
	      <h3><img src="imagenes/fiestasreligiosas.png" width="20" height="20" /> Día de la Virgen de los Angeles</h3>
		  <h6><img src="imagenes/calendario.png" width="25" height="17" />Celebrado los 02 de agosto de cada año.</h6>
          <h6><img src="imagenes/posiciongeografica.png" width="25" height="17" />Se lleva a cabo por las calles principales de la ciudad.</h6>          
	    </div>
	  </li>
                
	</ul> 
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
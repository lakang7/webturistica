<?php session_start();
	  require("recursos/funcionesinterfaz.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Posada Laguna Grande</title>

<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/css/bootstrap-combined.min.css" rel="stylesheet">
<link href="css/modificabootstrap.css" rel="stylesheet" />

<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBViGAK8QcqvLcl0Pgilw-ENvMhmL88E6A&sensor=true"></script>
    <script type="text/javascript">
      function initialize() {
		  var myLatlng = new google.maps.LatLng(8.132308,-71.9797);
    	  var mapOptions = {
          center: new google.maps.LatLng(8.132308,-71.9797),
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.HYBRID
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
		

		
		var marker = new google.maps.Marker({
		    position: myLatlng,
		    map: map,
		    title:"Posada Campo Alegre"
		});
		

      }
    </script>

</head>

<body style="background:#F9F9F9;" onload="initialize()">

<?php menu_principal(); ?>
	


	
<div class="row-fluid">
	<div class="span12">
    <div class="carousel-inner" >
		<img src="imagenes/sitiosinteres/hospedaje/posadas/bannerposada2.jpg"   />
	        
            <div class="carousel-caption" >
        	  <div class="span8 offset2" style="background:url(imagenes/contentBg.png) repeat;">   
				 <div class="span1">
                 	<img src="imagenes/subcategorias/posadas.png" width="53" height="53" />
                 </div>
                 <div class="span11">
				   <div class="row-fluid" style="height:20px;"><h7 style="color:#FFF" >Posada Laguna Grande</h7><img src="imagenes/posicionwhite.png" style="margin-top:-5px; margin-left:10px;" width="20" height="20" /><h8>Carretera La Grita vía Hotel de Montaña. Caserío Judio.</h8></div>
                   <div class="row-fluid"><img src="imagenes/telefonowhite.png" width="20" height="20" style="margin-right:5px;" /><h8>0277-8811298 | 0416-9875421</h8>
                   <img src="imagenes/correowhite.png" width="25" height="25" /><h8>posadalagunagrande@hotmail.com</h8></div>
               	   
                 </div>
                                
		      </div>       
	        </div> 
            
            
         </div>        
	</div>    
</div>		

<div class="container-fluid" style="margin-top:10px;">
	<div id="map_canvas" style="width:100%; height:300px;"></div>
</div>

<div class="container-fluid" style="margin-top:10px; margin-bottom:10px;">
	<div class="row-fluid">
    	<div class="span6 pagination-centered" style="">
        <div class="row-fluid">
        	<img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto1-grande.jpg" />
        </div>
        <div class="row-fluid">
       
        <div class="span12" style="border:1px solid #CCC; padding:10px; -webkit-border-radius: 8px; -moz-border-radius: 8px; margin-top:10px;">
        	<div class="row-fluid">
        	<div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto1.png" width="200" height="150" /></div>
            <div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto2.png" width="200" height="150" /></div>
            <div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto3.png" width="200" height="150" /></div>
        	<div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto1.png" width="200" height="150" /></div>
            <div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto2.png" width="200" height="150" /></div>
            <div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto3.png" width="200" height="150" /></div>            
            </div>
        	<div class="row-fluid" style="margin-top:12px;">
        	<div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto1.png" width="200" height="150" /></div>
            <div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto2.png" width="200" height="150" /></div>
            <div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto3.png" width="200" height="150" /></div>
        	<div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto1.png" width="200" height="150" /></div>
            <div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto2.png" width="200" height="150" /></div>
            <div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto3.png" width="200" height="150" /></div>  
            </div> 
        	<div class="row-fluid" style="margin-top:12px;">
        	<div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto1.png" width="200" height="150" /></div>
            <div class="span2"><img src="imagenes/sitiosinteres/hospedaje/posadas/Posada Laguna Grande/foto2.png" width="200" height="150" /></div>
            </div>                                                                                      
        </div>                        
        </div>               
        </div>

      <div class="span6" style="">
            
	  <div class="row-fluid" style="margin-bottom:7px;"><h2>Servicios y Comodidades</h2></div>
            
            <div class="row-fluid" style="margin-bottom:7px;">
   		    	<div title="TV por cable" style= "background:url(imagenes/comodidades.png) no-repeat 0px -0px; width:20px; height:20px; float:left; margin-right:5px;"></div>
                <div style= "background:url(imagenes/comodidades.png) no-repeat 0px -20px; width:20px; height:20px;  float:left; margin-right:5px;"></div>
                <div style= "background:url(imagenes/comodidades.png) no-repeat 0px -40px; width:20px; height:20px;  float:left; margin-right:5px;"></div>
                <div title="Lavanderia"  style= "background:url(imagenes/comodidades.png) no-repeat 0px -60px; width:20px; height:20px;  float:left; margin-right:5px;"></div>
                <div style= "background:url(imagenes/comodidades.png) no-repeat 0px -80px; width:20px; height:20px;  float:left; margin-right:5px;"></div>
            </div>
            
			<?php		 		 		    	
				 $botonmegusta="<div id=\"fb-root\"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return; js = d.createElement(s); js.id = id;js.src = \"//connect.facebook.net/es_ES/all.js#xfbml=1\";fjs.parentNode.insertBefore(js, fjs);}(document, \"script\", \"facebook-jssdk\"));</script><div class=\"fb-like\" data-href=\"http://www.buscaloenlaweb.com.ve\" data-width=\"450\" data-show-faces=\"true\" data-send=\"true\"></div>";				
				 $botontwitter="<a href=\"https://twitter.com/share\" class=\"twitter-share-button\" data-url=\"http://www.fragocollections.com/articulo.php?id=".$_GET["id"]."\" data-via=\"FragoCollection\" data-lang=\"es\">Twittear</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=\"//platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);}}(document,\"script\",\"twitter-wjs\");</script>";			
			     $comentarios="<div id=\"fb-root\"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = \"//connect.facebook.net/es_ES/all.js#xfbml=1\"; fjs.parentNode.insertBefore(js, fjs); }(document, \"script\", \"facebook-jssdk\"));</script><div class=\"fb-comments\" data-href=\"http://www.buscaloenlaweb.com.ve\" data-width=\"475px\"></div>";
			?>        	
            
  <div class="row-fluid" style="margin-bottom:7px;">
            <?php echo $botontwitter; ?>
            </div>
        
        <div class="row-fluid" style="margin-bottom:7px;">
            <?php echo $botonmegusta; ?>						    
        </div> 
                        
            <div class="row-fluid">
			<?php echo $comentarios; ?>
            </div>
		       		
      </div>
    </div>

</div>


    
</body>
<script type="text/javascript" language="javascript1.1">
   function desplegar_galeria(){		 
		$("#galeria").load("recursos/galeria.php", {clave: 1});			   	   
   }  
</script>




</html>
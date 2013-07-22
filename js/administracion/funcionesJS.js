// JavaScript Document

//Funcion jQuery para validar solo números o solo letras, ver su forma de uso en "crearcomodidades.php"
(function(a){
		  a.fn.funcionesJS = function(b){
			  a(this).on({keypress:function(a){
						var c=a.which,d=a.keyCode,e=String.fromCharCode(c).toLowerCase(),f=b;
											(-1!=f.indexOf(e)||9==d||37!=c&&37==d||39==d&&39!=c||8==d||46==d&&46!=c)&&161!=c||a.preventDefault()}
											})
			  }
})(jQuery);

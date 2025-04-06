<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	$active_usuarios="";	
	$active_colonias="active";
	$active_delegaciones="";
	$active_giro="";
	$active_tramite="";
	$active_modalidad="";
	$active_serviciosAdicionales="";
	$active_reportes="";


	$title="Colonias | Bebal";
	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>


    <div class="container">
        <div class="panel panel-success">
        <div class="panel-heading">
        </div>
        </div>
        <div class="panel-body">

	<?php
	include("modal/registro_colonia.php");
	include("modal/editar_colonia.php");
        ?>
        <form class="form-horizontal" role="form" id="datos_cotizacion">

<div class="input-group mb-1">
  <input type="text" class="form-control" id="q" placeholder="Escribe el Colonia a Buscar" aria-label="Escribe el Colonia a Buscar" title="Enter Colonia" aria-describedby="basic-addon2"  onkeyup="load(1);">
  <div class="input-group-append">
    <button class="btn btn-outline-primary btn-sm" type="button" onclick="load(1);"><i class="bi bi-search"></i></button>

<button type='button' class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#nuevaColonia"><span class="bi bi-plus-circle me-1" style="background-color:#661C32;color:white"></span> Nueva Colonia</button>



        <span id="loader"></span>
        </div>

				
	</form>
	<div id="resultados"></div><!-- Carga los datos ajax -->
	<div class='outer_div'></div><!-- Carga los datos ajax -->
			
			
	</div>
	</div>
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
<script type="text/javascript" src="js/colonias.js"></script>
  </body>
</html>


<script>
$( "#guardar_colonia" ).submit(function( event ) {
  $('#Button_guardar_colonia').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
		type: "POST",
		url: "ajax/nueva_colonia.php",
		data: parametros,
		beforeSend: function(objeto){
		$("#resultados_ajaxColonia").html("Mensaje: Cargando...");
		  },
		success: function(datos){
		$("#resultados_ajaxColonia").html(datos);
		$('#Button_guardar_colonia').attr("disabled", false);

			window.setTimeout(function() {
				$(".alert").fadeTo(150, 0).slideUp(150, function(){
				$(this).remove();});
				location.replace('colonia.php');
			}, 4000);


		}
	});
  event.preventDefault();
})


$( "#editar_colonia" ).submit(function( event ) {
  $('#Buttoneditar_colonia').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_colonia.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajaxEditarColonia").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajaxEditarColonia").html(datos);
			$('#Buttoneditar_colonia').attr("disabled", false);
			window.setTimeout(function() {
				$(".alert").fadeTo(150, 0).slideUp(150, function(){
				$(this).remove();});
				location.replace('colonia.php');
			}, 4000);
		  }
	});
  event.preventDefault();
})

function get_colonia_id(id){
$("#colonia_id_mod").val(id);
}

function obtener_datos(id){
	var colonia = $("#colonia"+id).val();
	var id = $("#id"+id).val();
	var id_colonia = $("#id_colonia"+id).val();
	var id_delegacion = $("#id_delegacion"+id).val();
	var DELEGACION = $("#DELEGACION"+id).val();
			
	$("#mod_id").val(id);
	$("#mod_colonia").val(colonia);
	$("#mod_id_colonia").val(id_colonia);
	$("#mod_id_delegacion").val(id_delegacion);
	$("#mod_DELEGACION").val(DELEGACION);
			
}

</script>



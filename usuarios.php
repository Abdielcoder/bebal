<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	$active_usuarios="active";	
        $active_colonias="";
        $active_delegaciones="";
        $active_giro="";
        $active_tramite="";
        $active_modalidad="";
        $active_serviciosAdicionales="";
        $active_reportes="";
	$active_principal="";



	$title="Usuarios | bebal";
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
	include("modal/registro_usuarios.php");
        include("modal/editar_usuarios.php");
        include("modal/cambiar_password.php");
        ?>
        <form class="form-horizontal" role="form" id="datos_cotizacion">

<div class="input-group mb-1">
  <input type="text" class="form-control" id="q" placeholder="Escribe el Usuario a Buscar" aria-label="Escribe el Usuario a Buscar" title="Enter Usuario" aria-describedby="basic-addon2"  onkeyup="load(1);">
  <div class="input-group-append">
    <button class="btn btn-outline-primary btn-sm" type="button" onclick="load(1);"><i class="bi bi-search"></i></button>

<button type='button' class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoUsuario" style="background-color:#AC905B;color:white"><i class="bi bi-plus-circle me-1"></i> Nuevo Usuario</button>


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
	<script type="text/javascript" src="js/usuarios.js"></script>

	
	


  </body>
</html>
<script>
$( "#guardar_usuario" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_usuario.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajaxUsuario").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajaxUsuario").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_usuario" ).submit(function( event ) {
  $('#actualizar_datos2').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_usuario.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajaxUsuario").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajaxUsuario").html(datos);
			$('#actualizar_datos2').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_password" ).submit(function( event ) {
  $('#actualizar_datos3').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_password.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajaxUsuario").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajaxUsuario").html(datos);
			$('#actualizar_datos3').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

function get_user_id(id){
$("#user_id_mod").val(id);
}

function obtener_datosUsuario(id){
var nombres = $("#nombres"+id).val();
var apellidos = $("#apellidos"+id).val();
var usuario = $("#usuario"+id).val();
var email = $("#email"+id).val();
			
$("#mod_id").val(id);
$("#mod_firstname2").val(nombres);
$("#mod_lastname2").val(apellidos);
$("#mod_user_name2").val(usuario);
$("#mod_user_email2").val(email);
		
}

</script>

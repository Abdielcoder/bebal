<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	$active_delegaciones="active";
	$active_principal="";
	$active_clientes="";
	$active_usuarios="";	
	$active_reportes="";
	$active_colonias="";
	$active_principal_temp="";


	$title="Delegacion | bebal";
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
        include("modal/registro_delegacion.php");
        include("modal/editar_delegacion.php");

        ?>
        <form class="form-horizontal" role="form" id="datos_cotizacion">

<div class="input-group mb-1">
  <input type="text" class="form-control" id="q" placeholder="Escribe el Delegacón a Buscar" aria-label="Escribe el Delegacón a Buscar" title="Enter Delegacón" aria-describedby="basic-addon2"  onkeyup="load(1);">
  <div class="input-group-append">
    <button class="btn btn-outline-primary btn-sm" type="button" onclick="load(1);"><i class="bi bi-search"></i></button>

<button type='button' class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#nuevaDelegacion" style="background-color:#AC905B;color:white"><i class="bi bi-plus-circle me-1"></i> Nueva Delegación</button>


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
	<script type="text/javascript" src="js/delegaciones.js"></script>
  </body>
</html>

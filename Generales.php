<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	$active_generales="active";
	$active_delegaciones="";
	$active_principal="";
	$active_clientes="";
	$active_usuarios="";	
	$active_reportes="";
	$active_colonias="";
	$active_principal_temp="";


	$title="Generales | bebal";
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
        //include("modal/registro_generales.php");
        include("modal/editar_generalesFirma.php");
        include("modal/editar_generales.php");

        ?>
        <form class="form-horizontal" role="form" id="datos_cotizacion">

<div class="input-group mb-1">
  <input type="text" class="form-control" id="q" placeholder="Escribe el Campo  a Buscar" aria-label="Escribe el Campo a Buscar" title="Enter Generales" aria-describedby="basic-addon2"  onkeyup="load(1);">
  <div class="input-group-append">
    <button class="btn btn-outline-primary btn-sm" type="button" onclick="load(1);"><i class="bi bi-search"></i></button>

<button type='button' class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#nuevaDelegacion" style="background-color:#AC905B;color:white"><i class="bi bi-plus-circle me-1"></i> Nuevo Gral</button>


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
	<script type="text/javascript" src="js/generales.js"></script>
  </body>
</html>


<script>

$( "#guardar_generalesFirma" ).submit(function( event ) {
  $('#Button_guardar_datosGeneralesFirma').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/editar_GeneralesFirma.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxGeneralesFirma").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxGeneralesFirma").html(datos);
                        $('#Button_guardar_datosGeneralesFirma').attr("disabled", false);

                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
                                location.replace('Generales.php');
                        }, 1000);
                  }
        });
  event.preventDefault();
})



function obtener_datosGenerales(id) {

var dato_general = $("#dato_general"+id).val();
var descripcion = $("#descripcion"+id).val();

//alert(id+", "+dato_general+", "+descripcion);

$("#mod_id").val(id);
$("#mod_dato_general").val(dato_general);
$("#mod_descripcion").val(descripcion);

}

function obtener_datosGeneralesFirma(idOtro) {

var dato_generalOtro = $("#dato_generalOtro"+idOtro).val();
var descripcionOtro = $("#descripcionOtro"+idOtro).val();

//alert(idOtro+", "+dato_generalOtro+", "+descripcionOtro);

$("#mod_idOtro").val(idOtro);
$("#mod_dato_generalOtro").val(dato_generalOtro);
$("#mod_descripcionOtro").val(descripcionOtro);

}



</script>


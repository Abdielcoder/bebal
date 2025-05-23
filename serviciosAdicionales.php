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
	$active_colonias="";
	$active_delegaciones="";
	$active_giro="";
	$active_tramite="";
	$active_modalidad="";
	$active_serviciosAdicionales="active";
	$active_reportes="";
	$active_principal_temp="";


	$title="Servicios Adicionales | Bebal";
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
        include("modal/registro_servicioadicional.php");
        include("modal/editar_servicioadicional.php");
        ?>
        <form class="form-horizontal" role="form" id="datos_cotizacion">

<div class="input-group mb-1">
  <input type="text" class="form-control" id="q" placeholder="Escribe el Servicio Adicional a Buscar" aria-label="Escribe el Servicio Adicional a Buscar" title="Enter Servicio Adicional" aria-describedby="basic-addon2"  onkeyup="load(1);">
  <div class="input-group-append">
    <button class="btn btn-outline-primary btn-sm" type="button" onclick="load(1);"><i class="bi bi-search"></i></button>

<button type='button' class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoServicioAdicional" style="background-color:#AC905B;color:white"><i class="bi bi-plus-circle me-1"></i> Nuevo Servicio Adicional</button>


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
<script type="text/javascript" src="js/serviciosAdicionales.js"></script>
  </body>
</html>


<script>

$( "#guardar_servicioadicional" ).submit(function( event ) {
  $('#Button_guardar_servicioadicional').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                type: "POST",
                url: "ajax/nuevo_servicioadicional.php",
                data: parametros,
                beforeSend: function(objeto){
                $("#resultados_ajaxServicioAdicional").html("Mensaje: Cargando...");
                  },
                success: function(datos){
                $("#resultados_ajaxServicioAdicional").html(datos);
                $('#Button_guardar_servicioadicional').attr("disabled", true);

                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
                                location.replace('serviciosAdicionales.php');
                        }, 4000);


                }
        });
  event.preventDefault();
})

$( "#editar_servicioadicional" ).submit(function( event ) {
  $('#Buttoneditar_servicioadicional').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/editar_servicioadicional.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxEditarServicioAdicional").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxEditarServicioAdicional").html(datos);
                        $('#Buttoneditar_servicioadicional').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
                                location.replace('serviciosAdicionales.php');
                        }, 4000);
                  }
        });
  event.preventDefault();
})




function get_servicioadicional(id){
$("#servicioadicional_id_mod").val(id);
}

function obtener_datosServicioAdicional(id){

        var id = $("#id"+id).val();
        var descripcion_servicios_adicionales = $("#descripcion_servicios_adicionales"+id).val();
        var cuenta = $("#cuenta"+id).val();
        var monto_umas = $("#monto_umas"+id).val();
        var monto_umas = $("#monto_umas_permiso_temporal"+id).val();
        var concepto = $("#concepto"+id).val();

        $("#mod_id").val(id);
        $("#mod_descripcion_servicios_adicionales").val(descripcion_servicios_adicionales);
        $("#mod_cuenta").val(cuenta);
        $("#mod_monto_umas").val(monto_umas);
        $("#mod_monto_umas_permiso_temporal").val(monto_umas_permiso_temporal);
        $("#mod_concepto").val(concepto);

}




</script>



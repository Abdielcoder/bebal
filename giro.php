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
	$active_giro="active";
	$active_tramite="";
	$active_modalidad="";
	$active_serviciosAdicionales="";
	$active_reportes="";


	$title="Giros | Bebal";
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
        include("modal/registro_giro.php");
        include("modal/editar_giro.php");
        ?>
        <form class="form-horizontal" role="form" id="datos_cotizacion">

<div class="input-group mb-1">
  <input type="text" class="form-control" id="q" placeholder="Escribe el Giro a Buscar" aria-label="Escribe el Giro a Buscar" title="Enter Giro" aria-describedby="basic-addon2"  onkeyup="load(1);">
  <div class="input-group-append">
    <button class="btn btn-outline-primary btn-sm" type="button" onclick="load(1);"><i class="bi bi-search"></i></button>

<button type='button' class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoGiro" style="background-color:#AC905B;color:white"><i class="bi bi-plus-circle me-1"></i> Nuevo Giro</button>


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
<script type="text/javascript" src="js/giros.js"></script>
  </body>
</html>


<script>

$( "#guardar_giro" ).submit(function( event ) {
  $('#Button_guardar_giro').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                type: "POST",
                url: "ajax/nuevo_giro.php",
                data: parametros,
                beforeSend: function(objeto){
                $("#resultados_ajaxGiro").html("Mensaje: Cargando...");
                  },
                success: function(datos){
                $("#resultados_ajaxGiro").html(datos);
                $('#Button_guardar_giro').attr("disabled", true);

                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
                                location.replace('giro.php');
                        }, 4000);


                }
        });
  event.preventDefault();
})

$( "#editar_giro" ).submit(function( event ) {
  $('#Buttoneditar_giro').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/editar_giro.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxEditarGiro").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxEditarGiro").html(datos);
                        $('#Buttoneditar_giro').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
                                location.replace('giro.php');
                        }, 4000);
                  }
        });
  event.preventDefault();
})



function get_giro(id){
$("#giro_id_mod").val(id);
}




function obtener_datosGiro(id){

        var id = $("#id"+id).val();
        var descripcion_giro = $("#descripcion_giro"+id).val();
        var horario_funcionamiento = $("#horario_funcionamiento"+id).val();
        var cuenta = $("#cuenta"+id).val();
        var monto_umas = $("#monto_umas"+id).val();
        var concepto = $("#concepto"+id).val();

        $("#mod_id").val(id);
        $("#mod_descripcion_giro").val(descripcion_giro);
        $("#mod_horario_funcionamiento").val(horario_funcionamiento);
        $("#mod_cuenta").val(cuenta);
        $("#mod_monto_umas").val(monto_umas);
        $("#mod_concepto").val(concepto);

}




</script>



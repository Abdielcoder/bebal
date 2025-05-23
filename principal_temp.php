<html>
<style>
#q:valid {
    color: green;
}
#q:invalid {
    color: red;
}
</style>



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
        $active_serviciosAdicionales="";
        $active_reportes="";
	$active_principal="";
	$active_principal_temp="active";


	$title="bebal";
	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];
	$ID_USER=$_SESSION['user_id'];

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
<?php
	//<div class="panel panel-success">
		//<div class="panel-heading d-flex justify-content-between align-items-center">
		//</div>
		//</div>
?>
		<div class="panel-body">
			
			<?php
			include("modal/registro_principal_temp.php");
			include("modal/editar_registro.php");
			include("modal/elegirTramite.php");
			include("modal/imprimir_permiso.php");
			?>
<form class="form-horizontal" role="form" id="datos_principal">


<?php
echo '<div class="input-group mb-1">';
echo '<table width="100%" border="0" align="right"><tr>';
echo '<td width="20%"><span id="loader"></span></td>';
if ( $PROFILE=='inspector' ) {
echo '<td width="50%"></td>';
echo '<td width="30%">';
echo '<input type="text" style="height:30px; width:250px"  id="q" size="10" placeholder="Buscar..." aria-label="Escribe el Folio a Buscar" title="Buscar Folio, Nombre establecimiento, Nombre Solicitante, Operación y Estatus" pattern="(3)(-)[\d]{1,}"  aria-describedby="basic-addon2" maxlength="9"   onkeyup="load(1);">';
echo '</td><td width="20%">';
} else {
echo '<td width="10%"></td>';
echo '<td width="70%" align="right">';
echo '<input type="text" style="height:30px; width:250px"  id="q" size="10" placeholder="Buscar..." aria-label="Escribe el Folio a Buscar" title="Buscar Folio, Nombre establecimiento, Nombre Solicitante, Operación y Estatus" pattern="(3)(-)[\d]{1,}"  aria-describedby="basic-addon2" maxlength="9"   onkeyup="load(1);">&nbsp;&nbsp;<button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#nuevoRegistroPrincipalTemporal" ><i class="bi bi-plus-circle me-1"></i><font size="1" color="pink">Registro Temporal</font></button>';

}
echo '</td></tr>';
echo '</table>';
//</div>
//</div>
//</div>
//<span id="loader"></span>
?>

				
</form>

<div id="resultados"></div><!-- Carga los datos ajax -->
<div class='outer_div'></div><!-- Carga los datos ajax -->

</div>
</div>
</div>
	<hr>
	<?php
	include("footer.php");
	include("modal/imagenes_modal.php"); // Modal para mostrar imágenes
	include("modal/pdf_modal.php"); // Modal para cargar PDFs
	?>
	<script type="text/javascript" src="js/principal_temp.js"></script>
	<script type="text/javascript" src="js/imagenes-modal.js"></script>
<script type="text/javascript" src="js/pdf-modal.js"></script>
<?php

//if(!$_POST) {
//if (isset($_GET['page'])){
//$page=$_GET['page'];
//echo '<script>load('.$page.');</script>';
//} else {
//echo '<script>load(5);</script>';
//}
//} else {
//if (isset($_POST['page'])){
//$page=$_POST['page'];
//echo '<script>load('.$page.');</script>';
//} else {
//echo '<script>load(1);</script>';
//}
//}
?>
  </body>
</html>

<script>

$( "#guardar_registroPrincipalTemporal" ).submit(function( event ) {
  $('#Button_guardar_registroPrincipalTemporal').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_registroPrincipalTemporal.php",
			data: parametros,
			 beforeSend: function(objeto){
			  $("#resultados_ajaxGuardarRegistroPrincipalTemporal").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajaxGuardarRegistroPrincipalTemporal").html(datos);
			$('#Button_guardar_registroPrincipalTemporal').attr("disabled", true);

                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
                                location.replace('principal_temp.php');
                        }, 2000);

		  }
	});
  event.preventDefault();
})



$( "#guardar_registroPrincipalLightTemporal" ).submit(function( event ) {
  $('#Button_guardar_registroPrincipalLightTemporal').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/nuevo_registroPrincipal_LightTemporal.php",
                        data: parametros,
                         beforeSend: function(objeto){
                          $("#resultados_ajaxGuardarRegistroPrincipalLightTemporal").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxGuardarRegistroPrincipalLightTemporal").html(datos);
                        $('#Button_guardar_registroPrincipalLightTemporal').attr("disabled", true);

                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
                                location.replace('principal_temp.php');
                        }, 2000);

                  }
        });
  event.preventDefault();
})



function obtener_datosParaCambio(id,pagina) {
var folio = $("#folio"+id).val();
var page = $("#page"+id).val();
var nombre_comercial_establecimiento = $("#nombre_comercial_establecimiento"+id).val();

$("#mod_nombre_comercial_establecimiento").val(nombre_comercial_establecimiento);
$("#mod_folio").val(folio);
$("#mod_id").val(id);
$("#pagina").val(pagina);
$("#mod_page").val(page);
}

function obtener_datosImprimirPermiso(id,pagina) {
var folio = $("#folio"+id).val();
var nombre_comercial_establecimiento = $("#nombre_comercial_establecimiento"+id).val();
var numero_permiso = $("#numero_permiso"+id).val();

$("#mod_nombre_comercial_establecimiento_imprimir").val(nombre_comercial_establecimiento);
$("#mod_id_imprimir").val(id);
$("#mod_folio_imprimir").val(folio);
$("#mod_numero_permiso_imprimir").val(numero_permiso);
}


function obtener_datos(id,pagina) {

var numero_permiso = $("#numero_permiso"+id).val();
var folio = $("#folio"+id).val();
var estatus = $("#estatus"+id).val();
var operacion = $("#operacion"+id).val();
var observaciones = $("#observaciones"+id).val();
var direccion = $("#direccion"+id).val();

var delegacion_id = $("#delegacion_id"+id).val();
var colonia_id = $("#colonia_id"+id).val();

var COLONIA = $("#COLONIA"+id).val();
var DELEGACION = $("#DELEGACION"+id).val();
var GIRO = $("#GIRO"+id).val();
var MODALIDAD_GA = $("#MODALIDAD_GA"+id).val();

var nombre_comercial_establecimiento = $("#nombre_comercial_establecimiento"+id).val();
var calle_establecimiento = $("#calle_establecimiento"+id).val();
var entre_calles_establecimiento = $("#entre_calles_establecimiento"+id).val();
var numero_establecimiento = $("#numero_establecimiento"+id).val();
var numerointerno_local_establecimiento = $("#numerointerno_local_establecimiento"+id).val();
var numerointerno_local_establecimiento = $("#numerointerno_local_establecimiento"+id).val();
var cp_establecimiento = $("#cp_establecimiento"+id).val();
var nombre_persona_fisicamoral_solicitante = $("#nombre_persona_fisicamoral_solicitante"+id).val();
var nombre_representante_legal_solicitante = $("#nombre_representante_legal_solicitante"+id).val();
var domicilio_solicitante = $("#domicilio_solicitante"+id).val();
var email_solicitante = $("#email_solicitante"+id).val();
var telefono_solicitante = $("#telefono_solicitante"+id).val();

var COLONIAyDELEGACION = $("#COLONIAyDELEGACION"+id).val();
var direccion_establecimiento_completa = $("#direccion_establecimiento_completa"+id).val();

$("#page").val(pagina);
$("#folio_data").val(folio);
$("#numero_permiso_data").val(numero_permiso);
$("#estatus_data").val(estatus);
$("#operacion_data").val(operacion);
$("#observaciones_data").val(observaciones);
$("#delegacion_id_data").val(delegacion_id);
$("#colonia_id_data").val(colonia_id);

$("#COLONIA_data").val(COLONIA);
$("#DELEGACION_data").val(DELEGACION);
$("#GIRO_data").val(GIRO);
$("#MODALIDAD_GA_data").val(MODALIDAD_GA);

$("#nombre_comercial_establecimiento_data").val(nombre_comercial_establecimiento);
$("#calle_establecimiento_data").val(calle_establecimiento);
$("#entre_calles_establecimiento_data").val(entre_calles_establecimiento);
$("#numero_establecimiento_data").val(numero_establecimiento);
$("#numerointerno_local_establecimiento_data").val(numerointerno_local_establecimiento);
$("#numerointerno_local_establecimiento_data").val(numerointerno_local_establecimiento);
$("#cp_establecimiento_data").val(cp_establecimiento);
$("#nombre_persona_fisicamoral_solicitante_data").val(nombre_persona_fisicamoral_solicitante);
$("#nombre_representante_legal_solicitante_data").val(nombre_representante_legal_solicitante);
$("#domicilio_solicitante_data").val(domicilio_solicitante);
$("#email_solicitante_data").val(email_solicitante);
$("#telefono_solicitante_data").val(telefono_solicitante);

$("#COLONIAyDELEGACION_data").val(COLONIAyDELEGACION);
$("#direccion_establecimiento_completa_data").val(direccion_establecimiento_completa);

}



</script>

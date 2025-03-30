<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	$active_vallas="active";
	$active_clientes="";
	$active_usuarios="";	
	$active_reportes="";
	$active_delegaciones="";
	$active_principal="active";


	$title="bebal";
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
	<div class="panel">
		<div class="panel-header-custom">
			<h5><i class="bi bi-search"></i> Buscar Registro</h5>
		    <button type='button' class="btn-registro-nuevo" data-bs-toggle="modal" data-bs-target="#nuevoRegistroPrincipal"><i class="bi bi-plus-circle"></i> Nuevo Registro</button>
		</div>
		<div class="panel-body-custom">
		
			
			
			<?php
			include("modal/registro_principal.php");
			include("modal/editar_registro.php");
			?>
			
			<!-- Modal para coordenadas/mapa -->
			<div class="modal fade" id="coordenadasModal" tabindex="-1" aria-labelledby="coordenadasModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="coordenadasModalLabel">Coordenadas del Establecimiento</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				  </div>
				  <div class="modal-body">
					<!-- Formulario para coordenadas -->
					<form class="form-horizontal" id="guardar_mapa" name="guardar_mapa">
						<input type="hidden" id="mod_id" name="mod_id">
						<input type="hidden" id="folio_data2" name="folio_data2">
						<input type="hidden" id="numero_permiso_data2" name="numero_permiso_data2">
						
						<div class="form-group mb-3">
							<label for="mapa_data2" class="control-label">Coordenadas</label>
							<div class="input-group">
								<input type="text" class="form-control" id="mapa_data2" name="mapa_data2" placeholder="Ingrese coordenadas">
								<button class="btn btn-primary" type="button" id="obtenerCoordenadas">Obtener</button>
							</div>
							<small class="text-muted">Formato: latitud,longitud (ej: 32.5149,-117.0382)</small>
						</div>
						
						<div id="map" style="width: 100%; height: 300px;"></div>
						
						<div class="alert alert-info" id="coordenadas_info" style="margin-top: 10px;">
							Ingrese las coordenadas manualmente o use el botón "Obtener" para detectar su ubicación actual.
						</div>
					</form>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary" id="guardar_coordenadas">Guardar</button>
				  </div>
				</div>
			  </div>
			</div>
			
			<form class="form-horizontal form-busqueda" role="form" id="datos_cotizacion">
				
				<div class="row mb-3">
					<label for="q" class="col-md-2 col-form-label">Dirección</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="q" placeholder="Escribe dirección" onkeyup='load(1);'>
					</div>
					<div class="col-md-4">
						<button type="button" class="btn btn-buscar-custom" onclick='load(1);'>
							<i class="bi bi-search"></i> Buscar
						</button>
						<span id="loader"></span>
					</div>
				</div>
				
			</form>
			
			<!-- Indicador de carga -->
			<div class="loading-overlay" id="loadingOverlay">
				<div class="loading-spinner"></div>
			</div>
			
			<div id="resultados"></div><!-- Carga los datos ajax -->
			<div class='outer_div'></div><!-- Carga los datos ajax -->


		</div>
	</div>
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/principal.js"></script>
<?php

if(!$_POST) {
if (isset($_GET['pagina'])){
$pagina=$_GET['pagina'];
echo '<script>load('.$pagina.');</script>';
} else {
echo '<script>load(1);</script>';
}
} else {
if (isset($_POST['pagina'])){
$pagina=$_POST['pagina'];
echo '<script>load('.$pagina.');</script>';
} else {
echo '<script>load(1);</script>';
}
}
?>
  </body>
</html>

<script>

$( "#guardar_registroPrincipal" ).submit(function( event ) {
  $('#guardar_datos_registroPrincipal').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_registroPrincipal.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar_datos_valla').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})


$( "#editar_valla" ).submit(function( event ) {
  $('#actualizar_datos_valla').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_valla.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos_valla').attr("disabled", false);

var PAGINA=document.getElementById("pagina").value;
			load(PAGINA);
		  }
	});
  event.preventDefault();
})


function mapa_valla(id){
var folio = $("#folio"+id).val();
var numero_permiso = $("#numero_permiso"+id).val();
var mapa = $("#mapa"+id).val();

$("#mod_id").val(id);
$("#folio_data2").val(folio);
$("#numero_permiso_data2").val(numero_permiso);
$("#mapa_data2").val(mapa);
}

function get_valla_id(id){
$("#id_valla").val(id);
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

$("#pagina").val(pagina);
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



$('#myModal33').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) // Button that triggered the modal
var folio = button.data('folio') // Extract info from data-* attributes
var numero_permiso = button.data('numero_permiso')
var estatus = button.data('estatus')
var direccion = button.data('direccion')
var foto = button.data('foto')
var id = button.data('id')
var ID = button.data('ID')
var modal = $(this)
modal.find('.modal-body #mod_numero_permiso').val(numero_permiso)
modal.find('.modal-body #mod_folio').val(folio)
modal.find('.modal-body #mod_estatus').val(estatus)
modal.find('.modal-body #mod_direccion').val(direccion)
modal.find('.modal-body #mod_foto').val(foto)
modal.find('.modal-body #mod_id').val(id)
modal.find('.modal-body #mod_ID').val(ID)
})



</script>



	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="EfectuarInspeccion" tabindex="-1" aria-labelledby="EfectuarInspeccionLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="EfectuarInspeccionLabel"><i class="bi bi-clipboard-check"></i> Registrar Inspección</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="registro_guardar_inspeccion" name="registro_guardar_inspeccion">
			<div id="resultados_ajaxInspeccion"></div>
<input type="hidden" id="mod_idprincipal" name="idprincipal">
<input type="hidden" id="mod_pagina" name="pagina">
<input type="hidden" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento">

			<div class="mb-3 row">

<label for="mod_nombre_comercial_establecimiento" class="col-sm-4 col-form-label">Nombre Establecimiento</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_nombre_comercial_establecimiento" name="mod_nombre_comercial_establecimiento"  disabled>
<input type="hidden" id="mod_id" name="mod_id">
</div>
</div>

<div class="mb-3 row">
<label for="mod_folio" class="col-sm-4 col-form-label">Folio</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_folio" name="mod_folio"  disabled>
</div>
</div>

<div class="mb-3 row">
<label for="superficie_establecimiento" class="col-sm-4 col-form-label">Superficie (m²)</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="superficie_establecimiento" name="superficie_establecimiento" required>
</div>
</div>

<div class="mb-3 row">
<label for="capacidad_comensales_personas" class="col-sm-4 col-form-label">Capacidad Comensales/Personas</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="capacidad_comensales_personas" name="capacidad_comensales_personas" required>
</div>
</div>

<?php
###
echo '<div class="mb-3 row">';
echo '<label for="latitud" class="col-sm-2 col-form-label">Latitud</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="latitud" name="latitud" required>';
echo '</div>';
//##
echo '<label for="longitud" class="col-sm-2 col-form-label">Longitud</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="longitud" name="longitud" required>';
echo '</div>';
echo '</div>';
###
?>



<div class="mb-3 row">
<label for="observaciones" class="col-sm-4 col-form-label">Observaciones</label>
<div class="col-sm-8">
<textarea class="form-control" id="observaciones" name="observaciones"   maxlength="1000" rows="3"></textarea>
</div>
</div>

<div class="alert alert-info">
  <i class="bi bi-info-circle"></i> Asegúrese de completar todos los campos con información precisa de la inspección.
</div>



			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-info" id="Button_registro_guardar_inspeccion">
			  <i class="bi bi-clipboard-check"></i> Registrar Inspección
			</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

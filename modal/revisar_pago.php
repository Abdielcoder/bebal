	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="revisarPago" tabindex="-1" aria-labelledby="revisarPagoLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="revisarPagoLabel"><i class='bi bi-credit-card'></i> Revisar y Registrar Pago</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="registro_guardar_pago" name="registro_guardar_pago">
			<div id="resultados_ajaxPago"></div>
<input type="hidden" id="mod_idprincipal" name="idprincipal">
<input type="hidden" id="mod_pagina" name="page">
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
<label for="numero_pago" class="col-sm-4 col-form-label">Número de Pago</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="numero_pago" name="numero_pago" required>
</div>
</div>

<div class="mb-3 row">
<label for="monto" class="col-sm-4 col-form-label">Monto</label>
<div class="col-sm-8">
<input type="number" class="form-control" id="monto" name="monto" required>
</div>
</div>

<div class="mb-3 row">
<label for="fecha_pago" class="col-sm-4 col-form-label">Fecha de Pago</label>
<div class="col-sm-8">

<?php
$today = date("Y-m-d");
echo '<input type="date" class="form-control" id="fecha_pago" value="'.$today.'"  name="fecha_pago" required>';
?>
</div>
</div>


			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-info" id="Button_registro_guardar_pago"> <i class="bi bi-check-circle"></i> Registrar Pago </button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

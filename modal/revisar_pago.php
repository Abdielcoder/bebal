	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
        <div class="modal fade" id="revisarPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#AC905B;color:white">
			<h5 class="modal-title" id="revisarPagoLabel"><i class='bi bi-credit-card'></i> Revisar y Registrar Pago</h5>
<!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>  --!>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="registro_guardar_pago" name="registro_guardar_pago">
			<div id="resultados_ajaxPago"></div>
<?php
echo '<input type="hidden" id="mod_idprincipal" name="idprincipal">';
echo '<input type="hidden" id="mod_folio" name="folio">';
echo '<input type="hidden" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento">';
echo '<input type="hidden" id="mod_tramite_pago" name="tramite_pago">';
echo '<input type="hidden" id="mod_tramite_pagoid" name="tramite_pagoid">';
?>

<div class="mb-3 row">
<label for="mod_tramite_pago" class="col-sm-4 col-form-label">Tramite Pago</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_tramite_pago" name="mod_tramite_pago"  disabled>
</div>
</div>


<div class="mb-3 row">
<label for="mod_nombre_comercial_establecimiento" class="col-sm-4 col-form-label">Nombre Establecimiento</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_nombre_comercial_establecimiento" name="mod_nombre_comercial_establecimiento"  disabled>
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


			
</div>  <!-- modal-body --!>

<div class="modal-footer">
<!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button> --!>
<button type="submit" class="btn btn-primary" id="Button_registro_guardar_pago"  style="background-color:#AC905B;color:black"> Registrar Pago </button>
</div>



		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

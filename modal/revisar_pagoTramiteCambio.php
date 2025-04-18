	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
        <div class="modal fade" id="revisarPagoTramiteCambio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#AC905B;color:white">
			<h6 class="modal-title" id="revisarPagoTramiteCambioLabel"><i class='bi bi-credit-card'></i> Revisar y Registrar Pago - Trámite Cambio</h6>
<!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>  --!>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="registro_guardar_pagoTramiteCambio" name="registro_guardar_pagoTramiteCambio">
			<div id="resultados_ajaxPagoTramiteCambio"></div>
<?php
echo '<input type="hidden" id="mod_idprincipal" name="idprincipal">';
echo '<input type="hidden" id="mod_folio" name="folio">';
echo '<input type="hidden" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento">';
echo '<input type="hidden" id="mod_tramite_pago" name="tramite_pago">';
echo '<input type="hidden" id="mod_tramite_pagoid" name="tramite_pagoid">';
echo '<input type="hidden" id="mod_id_pago_rad" name="id_pago_rad">';
echo '<input type="hidden" id="mod_id_pago_ins" name="id_pago_ins">';
echo '<input type="hidden" id="mod_total_umas_pagar" name="total_umas_pagar">';
echo '<input type="hidden" id="mod_id_tramite_solicitado" name="id_tramite_solicitado">';

echo '<input type="hidden" id="mod_id_proceso_tramites" name="id_proceso_tramites">';

?>


<div class="mb-3 row">
<label for="mod_tramite_pago" class="col-sm-4 col-form-label">Trámite Pago</label>
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
<input type="number" class="form-control" step="0.01" id="monto" name="monto" required>
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
<button type="submit" class="btn btn-primary" id="Button_registro_guardar_pagoTramiteCambio"  style="background-color:#AC905B;color:black"> Registrar Pago </button>
</div>



		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

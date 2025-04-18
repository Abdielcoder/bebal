	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
        <div class="modal fade" id="revisarPagoPresupuestoTramite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#AC905B;color:white">
			<h6 class="modal-title" id="revisarPagoLabel"><i class='bi bi-credit-card'></i> Tramite Pago Presupuesto</h6>
<!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>  --!>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="registro_guardar_pago_presupuestoTramite" name="registro_guardar_pago_presupuestoTramite">
			<div id="resultados_ajaxPagoPresupuestoTramite"></div>
<?php
echo '<input type="hidden" id="mod_idprincipal" name="idprincipal">';
echo '<input type="hidden" id="mod_folio" name="folio">';
echo '<input type="hidden" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento">';

echo '<input type="hidden" id="mod_id_proceso_tramites" name="id_proceso_tramites">';

//echo '<input type="hidden" id="mod_tramite_pagoid" name="tramite_pagoid">';
//echo '<input type="hidden" id="mod_id_pago_rad" name="id_pago_rad">';
//echo '<input type="hidden" id="mod_id_pago_ins" name="id_pago_ins">';

echo '<input type="hidden" id="mod_concepto_tramite" name="concepto_tramite">';
echo '<input type="hidden" id="mod_concepto_giro" name="concepto_giro">';
echo '<input type="hidden" id="mod_concepto_modalidad" name="concepto_modalidad">';
echo '<input type="hidden" id="mod_concepto_servicios_adicionales" name="concepto_servicios_adicionales">';
echo '<input type="hidden" id="mod_total_umas_pagar" name="total_umas_pagar">';

echo '<input type="hidden" id="mod_id_tramite" name="id_tramite">';


?>

<div class="mb-3 row">
<label for="mod_tramite_pago" class="col-sm-4 col-form-label">Tramite Pago</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_tramite_pago" name="tramite_pago"  disabled>
</div>
</div>

<?php
echo '<input type="hidden" id="mod_tramite_pago" name="tramite_pago">';
?>
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
<button type="submit" class="btn btn-primary" id="Button_registro_guardar_pago_presupuestoTramite"  style="background-color:#AC905B;color:black"> Registrar Pago Presupuesto</button>
</div>



		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

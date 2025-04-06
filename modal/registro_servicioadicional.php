	<?php
		if (isset($con))
		{

	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoServicioAdicional" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
<div class="modal-header"  style="background-color:#AC905B;color:white">
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Agregar Nuevo Servicio Adicional</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_servicioadicional" name="guardar_servicioadicional">
			<div id="resultados_ajaxServicioAdicional"></div>

<div class="form-group row">
<label for="descripcion_servicios_adicionales" class="col-sm-3 control-label">Servicio Adicional</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="descripcion_servicios_adicionales" name="descripcion_servicios_adicionales" required>
</div>
</div>

<div class="form-group row">
<label for="cuenta" class="col-sm-3 control-label">Cuenta</label>
<div class="col-sm-6">
<input type="text" class="form-control" id="cuenta" name="cuenta" required>
</div>
</div>

<div class="form-group row">
<label for="monto_umas" class="col-sm-3 control-label">Monto UMAS</label>
<div class="col-sm-6">
<input type="number" class="form-control" step="0.01" id="monto_umas" name="monto_umas" required>
</div>
</div>

<div class="form-group row">
<label for="concepto" class="col-sm-3 control-label">Concepto</label>
<div class="col-sm-6">
<input type="text" class="form-control" id="concepto" name="concepto" required>
</div>
</div>
			 
				  
			
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>
<button type="submit" class="btn btn-primary" id="Button_guardar_servicioadicional"> Guardar Servicio Adicional </button>
</div>
</form>
</div>
</div>
</div>
	<?php
		}
	?>

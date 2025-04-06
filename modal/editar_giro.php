	<?php
		if (isset($con))
		{

	?>
	<!-- Modal -->
	<div class="modal fade" id="editarGiro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h6 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Actualizar Registro Giro</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_giro" name="editar_giro">
			<div id="resultados_ajaxEditarGiro"></div>

<input type="hidden" id="mod_id" name="mod_id">


<div class="form-group row">
<label for="mod_descripcion_giro" class="col-sm-3 control-label">Giro</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_descripcion_giro" name="descripcion_giro" required>
</div>
</div>

<div class="form-group row">
<label for="mod_cuenta" class="col-sm-3 control-label">Cuenta</label>
<div class="col-sm-6">
<input type="text" class="form-control" id="mod_cuenta" name="cuenta" required>
</div>
</div>

<div class="form-group row">
<label for="mod_monto_umas" class="col-sm-3 control-label">Monto UMAS</label>
<div class="col-sm-6">
<input type="number" class="form-control" step="0.01" id="mod_monto_umas" name="monto_umas" required>
</div>
</div>

<div class="form-group row">
<label for="mod_concepto" class="col-sm-3 control-label">Concepto</label>
<div class="col-sm-6">
<input type="text" class="form-control" id="mod_concepto" name="concepto" required>
</div>
</div>

<div class="form-group row">
<label for="mod_horario_funcionamiento" class="col-sm-3 control-label">Horario Funcionamiento</label>
<div class="col-sm-6">
<input type="text" class="form-control" id="mod_horario_funcionamiento" name="horario_funcionamiento" required>
</div>
</div>

				  
			
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>
<button type="submit" class="btn btn-primary" id="Buttoneditar_giro"> Actualizar Datos </button>
</div>
</form>
</div>
</div>
</div>
	<?php
		}
	?>

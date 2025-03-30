	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="EfectuarInspeccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Inspección </h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="registro_guardar_inspeccion" name="registro_guardar_inspeccion">
			<div id="resultados_ajaxInspeccion"></div>
<input type="hidden" id="mod_idprincipal" name="idprincipal">
<input type="hidden" id="mod_pagina" name="pagina">
<input type="hidden" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento">

			<div class="form-group">

<label for="nombre_establecimiento" class="col-sm-3 control-label">Nombre Establecimiento</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_nombre_comercial_establecimiento" name="mod_nombre_comercial_establecimiento"  disabled>
<input type="hidden" id="mod_id" name="mod_id">
</div>
</div>

<div class="form-group">
<label for="folio" class="col-sm-3 control-label">Folio</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_folio" name="mod_folio"  disabled>
</div>
</div>

<div class="form-group">
<label for="superficie_establecimiento" class="col-sm-3 control-label">Superficie</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="superficie_establecimiento" name="superficie_establecimiento" required>
</div>
</div>

<div class="form-group">
<label for="capacidad_comensales_personas" class="col-sm-3 control-label">Capacidad Comensales/Personas</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="capacidad_comensales_personas" name="capacidad_comensales_personas" required>
</div>
</div>

<?php
###
echo '<div class="form-group">';
echo '<label for="latitud" class="col-sm-2 control-label">Latitud</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="latitud" name="latitud" required>';
echo '</div>';
//##
echo '<label for="longitud" class="col-sm-2 control-label">Longitud</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="longitud" name="longitud" required>';
echo '</div>';
echo '</div>';
###
?>



<div class="form-group">
<label for="observaciones" class="col-sm-3 control-label">Observaciones</label>
<div class="col-sm-8">
<textarea class="form-control" id="observaciones" name="observaciones"   maxlength="1000" ></textarea>
</div>
</div>



			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-info" id="Button_registro_guardar_inspeccion"> <i class="glyphicon glyphicon-check"></i> Realizar Registro </button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

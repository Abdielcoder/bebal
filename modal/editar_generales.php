	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="editarGenerales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

<div class="modal-header"  style="background-color:#AC905B;color:white">

			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Editar Datos Generales</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_generales" name="guardar_generales">
			<div id="resultados_ajaxGenerales"></div>


<input type="hidden" id="mod_id" name="id">


<div class="form-group row">
<label for="mod_dato_general" class="col-sm-2 control-label"><font size="1">Dato General</font></label>
<div class="col-sm-8">
 <input type="text" class="form-control" id="mod_dato_general" disabled>
</div>
</div>

<br>


<div class="form-group row">
<label for="mod_descripcion" class="col-sm-2 control-label"><font size="1">Descripción</font></label>
<div class="col-sm-10">
 <input type="text" class="form-control" id="mod_descripcion" name="descripcion" required>
</div>
</div>

<br>



			 
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-bs-dismiss="modal"><font size="2">Cerrar</font></button>
			<button type="submit" class="btn btn-primary" id="Button_guardar_datosGenerales"><font size="2">Guardar Datos</font></button>

		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

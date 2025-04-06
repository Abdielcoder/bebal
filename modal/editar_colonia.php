	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="editarColonia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Editar Colonia </h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_colonia" name="editar_colonia">
			<div id="resultados_ajaxEditarColonia"></div>

<input type="hidden" id="mod_id" name="mod_id">

	<div class="form-group">
	<label for="delegacion" class="col-sm-3 control-label">Delegación</label>
	<div class="col-sm-8">
	<input type="text" class="form-control" id="mod_DELEGACION" name="mod_DELEGACION" placeholder="Delegacion" disabled>
	</div>
	</div>

	<div class="form-group">
	<label for="colonia" class="col-sm-3 control-label">Colonia</label>
	<div class="col-sm-8">
	<input type="text" class="form-control" id="mod_colonia" name="mod_colonia" placeholder="Colonia" required>
	</div>
	</div>

						 	 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="Buttoneditar_colonia">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="EliminarRegistro" tabindex="-1" aria-labelledby="EliminarRegistroLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header bg-danger text-white">
			<h5 class="modal-title" id="EliminarRegistroLabel"><i class="bi bi-trash"></i> Eliminar Registro</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_usuario" name="editar_usuario">
			<div id="resultados_ajax2"></div>
			<div class="mb-3 row">
				<label for="mod_nombre_comercial_establecimiento" class="col-sm-4 col-form-label">Nombre Establecimiento</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="mod_nombre_comercial_establecimiento" name="mod_nombre_comercial_establecimiento" disabled>
					<input type="hidden" id="mod_id" name="mod_id">
				</div>
			</div>

			<div class="mb-3 row">
				<label for="mod_folio" class="col-sm-4 col-form-label">Folio</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="mod_folio" name="mod_folio" disabled>
				</div>
			</div>

			<div class="mb-3 row">
				<label for="passwd2" class="col-sm-4 col-form-label">Password 2</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" id="passwd2" name="passwd2" required>
				</div>
			</div>
			
			<div class="alert alert-warning">
				<i class="bi bi-exclamation-triangle"></i> Esta acción eliminará permanentemente el registro y no se podrá recuperar.
			</div>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-danger" id="eliinar_registro">
				<i class="bi bi-trash"></i> Eliminar Registro
			</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

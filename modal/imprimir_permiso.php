	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="ImprimirPermiso" tabindex="-1" aria-labelledby="EliminarRegistroLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header bg-danger text-white">
			<h5 class="modal-title" id="ImprimirPermisoLabel"><i class="bi bi-postcard"></i> Imprimir Permiso</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="imprimir_permiso" name="imprimir_permiso">
			<div id="resultados_ImprimirPermiso"></div>
			<div class="mb-3 row">
				<label for="mod_nombre_comercial_establecimiento" class="col-sm-4 col-form-label"><font size="2">Nombre Establecimiento</font></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="mod_nombre_comercial_establecimiento" name="mod_nombre_comercial_establecimiento" disabled>
					<input type="hidden" id="mod_id" name="mod_id">
				</div>
			</div>

			<div class="mb-3 row">
				<label for="mod_id" class="col-sm-4 col-form-label">Folio</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="mod_folio" name="mod_folio" disabled>
				</div>
			</div>

			<div class="mb-3 row">
				<label for="nip" class="col-sm-4 col-form-label">NIP </label>
				<div class="col-sm-8">
					<input type="password" class="form-control" id="nip" name="nip"  autocomplete="off"   required>
				</div>
			</div>
			
			<div class="alert alert-warning">
				<i class="bi bi-exclamation-triangle"></i> Esta acción Imprimirá el Permiso, requieres el NIP.
			</div>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
			<button type="submit" class="btn btn-danger" id="Button_imprimir_permiso">
				<i class="bi bi-key"></i> Validar NIP
			</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

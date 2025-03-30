	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Mapa Valla</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_usuario" name="editar_usuario">
			<div id="resultados_ajax2"></div>

<input type="hidden" id="mod_id" name="mod_id">

			<div class="form-group">
			<label for="folio_data2" class="col-sm-3 control-label">Folio</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" id="folio_data2" name="folio_data2" placeholder="Folio" required>
			</div>
			</div>

			<div class="form-group">
			<label for="numero_permiso_data2" class="col-sm-3 control-label">Número Permiso</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" id="numero_permiso_data2" name="numero_permiso_data2" placeholder="Numero Permiso" required>
			</div>
			</div>


			<div class="form-group">
			<label for="mapa_data" class="col-sm-3 control-label">Mapa Gooogle Maps</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" id="mapa_data2" name="mapa_data2" placeholder="Mapa Google Maps" required>
			</div>
			</div>
		  </div>


		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

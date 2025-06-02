	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="EliminarRegistroConstancia" tabindex="-1" aria-labelledby="EliminarRegistroLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header bg-danger text-white">
			<h6 class="modal-title" id="EliminarRegistroLabel"><i class="bi bi-trash"></i> Eliminar Datos Para la Constancia</h6>

	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="eliminar_registroConstancia" name="eliminar_registroConstancia">
			<div id="resultados_ajaxeliminar_registroConstancia"></div>

<?php

echo '<input type="hidden" name="idprincipal" value="'.$ID.'">';
##echo 'ID='.$ID;

?>

			
			<div class="alert alert-warning">
				<i class="bi bi-exclamation-triangle"></i><font size="2">Esta acción eliminará el registro y no se podrá recuperar.</font>
			</div>
			
		  </div>
		  <div class="modal-footer">
<!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>--!>
			<button type="submit" class="btn btn-danger" id="Button_eliminar_registroConstancia"><font size="2">Eliminar Registro</font></button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

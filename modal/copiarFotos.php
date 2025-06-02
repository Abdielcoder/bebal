	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="CopiarFotos" tabindex="-1" aria-labelledby="EliminarRegistroLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header bg-danger text-white">
			<h6 class="modal-title" id="EliminarRegistroLabel"><i class="bi c-square"></i> Copiar Las Imagenes-Fotografias</h6>

	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="copiarFotos" name="copiarFotos">
			<div id="resultados_ajaxcopiarFotos"></div>

<?php

echo '<input type="hidden" name="id_proceso_tramites_anterior" value="'.$ID_PT.'">';
echo '<input type="hidden" name="IDPRINCIPAL" value="'.$IDPRINCIPAL.'">';
echo '<input type="hidden" name="id_proceso_tramites_actual" value="'.$ID_PROCESO_TRAMITES.'">';


echo '<font color="red" size="2"><i class="bi bi-currency-dollar"></i></font><font color="black" size="2">  El Ultimo Tramite ('.$TRAMITE.') con ('.$CUENTA000.') Fotos </font><br>';

echo '<br>';

?>

			
			<div class="alert alert-warning">
				<i class="bi bi-exclamation-triangle"></i><font size="2">Esta acción Copiara las Imagenes-Fotografias del Tramite Anterior.</font>
			</div>
			
		  </div>
		  <div class="modal-footer">
<!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>--!>
			<button type="submit" class="btn btn-danger" id="Button_copiarFotos"><font size="2">Copiar</font></button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

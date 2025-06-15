	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="editarGeneralesFirma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">

<div class="modal-header"  style="background-color:#AC905B;color:white">

			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-key'></i>  Firma</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_generalesFirma" name="guardar_generalesFirma">
			<div id="resultados_ajaxGeneralesFirma"></div>


<input type="hidden" id="mod_idOtro" name="id">


<div class="form-group row">
<label for="mod_dato_generalOtro" class="col-sm-2 control-label">Dato General</label>
<div class="col-sm-8">
 <input type="text" class="form-control" id="mod_dato_generalOtro" disabled>
</div>
</div>

<br>


<div class="form-group row">
<label for="mod_descripcionOtro" class="col-sm-2 control-label">Firma</label>
<div class="col-sm-6">
<select class='form-control form-select' name='descripcion' id='mod_descripcionOtro' required>
<option value="">Seleccione</option>
<option value="Secretario">Secretario</option>
<option value="Director">Director</option>			
</select>			  
</div>
 </div>


<br>

			 
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-bs-dismiss="modal"><font size="2">Cerrar</font></button>
			<button type="submit" class="btn btn-primary" id="Button_guardar_datosGeneralesFirma"><font size="2">Guardar Datos Firma</font></button>

		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

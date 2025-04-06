	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="cambiarPassUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
<div class="modal-header"  style="background-color:#AC905B;color:red">
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Cambiar contraseña</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_password" name="editar_password">
			<div id="resultados_ajax3"></div>
			 
			 
			 
			 
<div class="form-group row">
<label for="user_password_new3" class="col-sm-4 control-label"><font size="2">Nueva contraseña</font></label>
<div class="col-sm-6">
<input type="password" class="form-control" id="user_password_new3" name="user_password_new3" placeholder="Nueva contraseña" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required>
<input type="hidden" id="user_id_mod" name="user_id_mod">
</div>
</div>

<br>

<div class="form-group row">
<label for="user_password_repeat3" class="col-sm-4 control-label"><font size="2">Repite contraseña</font></label>
<div class="col-sm-6">
<input type="password" class="form-control" id="user_password_repeat3" name="user_password_repeat3" placeholder="Repite contraseña" pattern=".{6,}" required>
</div>
</div>
			 
			  

			 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos3">Cambiar contraseña</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>	

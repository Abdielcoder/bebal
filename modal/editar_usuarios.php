	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="editarUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">

<div class="modal-header"  style="background-color:#AC905B;color:white">

			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Agregar nuevo usuario</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_usuario" name="guardar_usuario">
			<div id="resultados_ajaxUsuario"></div>




<div class="form-group row">
<label for="mod_firstname2" class="col-sm-2 control-label">Nombres</label>
<div class="col-sm-8">
 <input type="text" class="form-control" id="mod_firstname2" name="firstname" placeholder="Nombres" required>
</div>
</div>

<br>

<div class="form-group row">
<label for="mod_lastname2" class="col-sm-2 control-label">Apellidos</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_lastname2" name="lastname" placeholder="Apellidos" required>
</div>
</div>

<br>

<div class="form-group row">
<label for="mod_user_name2" class="col-sm-2 control-label">Usuario</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_user_name2" name="user_name" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)"required>
</div>
</div>

<br>

<div class="form-group row">
<label for="mod_profile" class="col-sm-2 control-label">Profile</label>
<div class="col-sm-6">
<select class='form-control form-select' name='user_profile' id='user_profile' required>
<option value="">Selecciona un Profile</option>
<option value="operador">Operador</option>
<option value="gestion">Gestion</option>			
<option value="admin">Admin</option>			
<option value="inspector">Inspector</option>			
<option value="director">Director</option>			
</select>			  
</div>
 </div>


<br>

<div class="form-group row">
<label for="mod_user_email2" class="col-sm-2 control-label">Email</label>
<div class="col-sm-8">
<input type="email" class="form-control" id="mod_user_email2" name="user_email" placeholder="Correo electrónico" required>
</div>
</div>

<br>

			 
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="Button_guardar_datos">Guardar datos</button>

		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

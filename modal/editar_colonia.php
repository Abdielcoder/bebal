	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="editarColonia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

<div class="modal-dialog modal-lg" role="document">

		<div class="modal-content">
<div class="modal-header"  style="background-color:#AC905B;color:white">
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Editar Colonia </h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_colonia" name="editar_colonia">
			<div id="resultados_ajaxEditarColonia"></div>

<input type="hidden" id="mod_id" name="mod_id">




<div class="form-group row">
<?php
echo '<input type="hidden" id="id_municipio" name="id_municipio" value="'.$ID_MUNICIPIO.'">';
echo '<label for="mod_id_delegacion" class="col-sm-3 control-label"><font color="blue">'.$MUNICIPIO.'</font>/Delegación</label>';
?>
<div class="col-sm-8">
<select class='form-control  form-select' name='mod_id_delegacion' id='mod_id_delegacion' required>
<?php
echo '<option value="">Seleccione</option>';
$query=mysqli_query($con,"SELECT * FROM delegacion WHERE id_municipio=".$ID_MUNICIPIO);
while($row=mysqli_fetch_array($query))  {
$id_delegacion=$row['id'];
$delegacion=$row['delegacion'];
echo '<option value="'.$id_delegacion.'">'.$delegacion.'</option>';
}
?>
</select>
</div>
</div>

<br>

<div class="form-group row">
<label for="mod_colonia" class="col-sm-3 control-label">Nombre Colonia</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_colonia" name="mod_colonia" required>
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

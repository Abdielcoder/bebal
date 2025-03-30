	<?php
		if (isset($con))
		{



	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Registro</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_valla" name="editar_valla">
			<div id="resultados_ajax2"></div>

<input type="hidden" id="id_valla" name="id_valla">
<input type="hidden" id="page" name="page">

			<div class="form-group">
			<label for="folio_data" class="col-sm-3 control-label">Folio</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" id="folio_data" name="folio_data" placeholder="Folio" required>
			</div>
			</div>

			<div class="form-group">
			<label for="numero_permiso_data" class="col-sm-3 control-label">Número Permiso</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" id="numero_permiso_data" name="numero_permiso_data" placeholder="Numero Permiso" required>
			</div>
			</div>
<?php
//			<div class="form-group">
//			<label for="estatus_data" class="col-sm-3 control-label">Estatus</label>
//			<div class="col-sm-8">
//			<input type="text" class="form-control" id="estatus_data" name="estatus_data" placeholder="Estatus" required>
//			</div>
//			</div>

//			<div class="form-group">
//			<label for="operacion_data" class="col-sm-3 control-label">Operación</label>
//			<div class="col-sm-8">
//			<input type="text" class="form-control" id="operacion_data" name="operacion_data" placeholder="Operacion" required>
//			</div>
//			</div>
?>



  <div class="form-group">
	<label for="delegacion" class="col-sm-3 control-label">Delegación</label>
	<div class="col-sm-8">
	<select class='form-control' name='delegacion_data' id='delegacion_data' required>
<?php 
echo '<option value="">Selecciona Delegación</option>';
if ( $PROFILE=='admin' ) {
$query_delegacion=mysqli_query($con,"SELECT * FROM delegacion ORDER BY id_municipio");
} else {
$query_delegacion=mysqli_query($con,"SELECT * FROM delegacion WHERE id_municipio=".$ID_MUNICIPIO);
}
while($row=mysqli_fetch_array($query_delegacion))	{

$id_delegacion=$row['id'];
$DELEGACION=$row['delegacion'];
$MUNICIPIO=$row['id_municipio'];
###
$sql_municipio="SELECT municipio FROM municipio WHERE id=".$MUNICIPIO;
$result_municipio = mysqli_query($con,$sql_municipio);
$row_municipio = mysqli_fetch_assoc($result_municipio);
$NOMBRE_MUNICIPIO=$row_municipio['municipio'];
####
echo '<option value="'.$id_delegacion.'">'.$DELEGACION.'-'.$NOMBRE_MUNICIPIO.'</option>';
}
?>
		</select>			  
	</div>
  </div>



			<div class="form-group">
			<label for="direccion_data" class="col-sm-3 control-label">Dirección</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" id="direccion_data" name="direccion_data" placeholder="Direccion" required>
			</div>
			</div>
						 	 
			<div class="form-group">
			<label for="descripcion_data" class="col-sm-3 control-label">Descripción</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" id="descripcion_data" name="descripcion_data" placeholder="Descripcion" required>
			</div>
			</div>

			<div class="form-group">
			<label for="video_url_data" class="col-sm-3 control-label">Video Url Youtube</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" id="video_url_data" name="video_url_data" placeholder="Video Url Youtube">
			</div>
			</div>

			<div class="form-group">
			<label for="mapa_data" class="col-sm-3 control-label">Mapa Gooogle Maps</label>
			<div class="col-sm-8">
			<input type="text" class="form-control" id="mapa_data" name="mapa_data" placeholder="Mapa Google Maps">
			</div>
			</div>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos_valla">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

	<?php
		if (isset($con))
		{
$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];
##
$sql_municipio="SELECT municipio FROM municipio WHERE id=".$ID_MUNICIPIO;
$result_municipio = mysqli_query($con,$sql_municipio);
$row_municipio = mysqli_fetch_assoc($result_municipio);
$MUNICIPIO=$row_municipio['municipio'];
##

	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevaDelegacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
<div class="modal-header"  style="background-color:#AC905B;color:white">

			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Agregar Nueva Delegación</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_delegacion" name="guardar_delegacion">
			<div id="resultados_ajaxDelegacion"></div>
<div class="form-group row">


<?php

echo '<input type="hidden" id="id_municipio" name="id_municipio" value="'.$ID_MUNICIPIO.'">';


echo '<label for="id_delegacion" class="col-sm-3 control-label"><font color="blue">'.$MUNICIPIO.'</font>/Delegación</label>';
?>
<div class="col-sm-8">
<select class='form-control form-select' name='id_delegacion' id='id_delegacion' required>
<?php 
echo '<option value="">Seleccione</option>';
$query=mysqli_query($con,"SELECT * FROM municipio");
while($row=mysqli_fetch_array($query))	{

$id_delegacion=$row['id'];
$municipio=$row['municipio'];

echo '<option value="'.$id_municipio.'">'.$municipio.'</option>';
}
?>
</select>			  
</div>
</div>

<br>

	<div class="form-group row">
	<label for="delegacion" class="col-sm-3 control-label">Nombre Delegacón</label>
	<div class="col-sm-8">
	<input type="text" class="form-control" id="delegacion" name="delegacion" required>
	</div>
	</div>
			 
				  
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="Button_guardar_delegacion"> Guardar Delegación </button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

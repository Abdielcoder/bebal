	<?php
		if (isset($con))
		{
$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	?>
	<!-- Modal -->
	<div class="modal fade" id="elegirGiro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
<div class="modal-header"  style="background-color:#AC905B;color:white">


<!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--!>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Seleccione Giro</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="elegir_tramite" name="elegir_tramite" action="aprobarPresupuestoCambio.php">
			<div id="resultados_ajaxElegirGiro"></div>


<input type="hidden" id="mod_idprincipal" name="IDPRINCIPAL">
<input type="hidden" id="mod_id_tramite_solicitado" name="ID_TRAMITE_SOLICITADO">
<input type="hidden" id="mod_pagina" name="page">


<div class="form-group row">
<label for="mod_nombre_comercial_establecimiento" class="col-sm-3 control-label">Establecimiento</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento" disabled>
</div>
</div>

<div class="form-group row">
<label for="mod_folio" class="col-sm-3 control-label">Folio</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_folio" name="mod_folio" disabled>
</div>
</div>

<div class="form-group row">
<label for="mod_descripcion_giro" class="col-sm-3 control-label">Giro Actual</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_descripcion_giro" name="mod_descripcion_giro" disabled>
</div>
</div>

<div class="form-group row">
<?php
echo '<label for="GIRO_SOLICITADO" class="col-sm-3 control-label">Seleccione Giro</label>';
?>
<div class="col-sm-8">
<select class='form-control  form-select' name='GIRO_SOLICITADO' id='GIRO_SOLICITADO' required>
<?php 
echo '<option value="">Seleccione</option>';
$query=mysqli_query($con,"SELECT * FROM giro");
while($row=mysqli_fetch_array($query))	{
$id_giro=$row['id'];
$descripcion_giro=$row['descripcion_giro'];
$monto_umas=$row['monto_umas'];
echo '<option value="'.$id_giro.'">'.$descripcion_giro.' ('.$monto_umas.' umas)</option>';
}
?>
</select>			  
</div>
</div>

<br>

			 
			
</div>
 <div class="modal-footer">
<!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>--!>
<button type="submit" class="btn btn-primary" id="Button_elegir_tramite"> Selecciona Giro </button>
  </div>
  </form>
 </div>
 </div>
</div>
	<?php
		}
	?>

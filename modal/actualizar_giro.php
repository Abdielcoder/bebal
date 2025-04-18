
<style> 
input[type=text] {
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 2px solid red;
  border-radius: 4px;
}

input[type=number] {
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 2px solid blue;
  border-radius: 4px;
}
input[type=email] {
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 2px solid green;
  border-radius: 4px;
}

#clave_catastral:valid {
    color: black;
background-color: #3CBC8D;
}
#clave_catastral:invalid {
    color: red;
}

#rfc_solicitante:valid {
    color: black;
background-color: #3CBC8D;
}
#rfc_solicitante:invalid {
    color: red;
}

</style>


<?php
	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];
	if (isset($con))
	{
	?>
	<!-- Modal -->
	<div class="modal fade" id="ActualizarGiro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#FF0000;color:black">
<!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--!>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i>Actualizar Giro</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_registroPrincipalGiro" name="guardar_registroPrincipalGiro">
			<div id="resultados_ajaxGuardarRegistroPrincipalGiro"></div>


<input type="hidden" id="mod_idprincipal" name="idprincipal">
<input type="hidden" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento">


<?php

##########################
##########################
echo '<h4><span style="background:black"><font color="white" size="3">Datos del Establecimiento</font></span></h4>';
###
echo '<div class="form-group row">';
echo '<label for="mod_nombre_comercial_establecimiento" class="col-sm-2 control-label">Nombre Comercial</label>';
echo '<div class="col-sm-5">';
echo '<input type="text" class="form-control form-control-sm" style="text-transform:uppercase" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento" disabled>';
echo '</div>';
echo '</div>';
//##
//echo '<div class="form-group row">';
//echo '<label for="mod_giro_id_seleccionado" class="col-sm-2 control-label">mod_giro_id_seleccionado</label>';
//echo '<div class="col-sm-5">';
//echo '<input type="text" class="form-control form-control-sm"  id="mod_giro_id_seleccionado" name="mod_giro_id_seleccionado" disabled>';
//echo '</div>';
//echo '</div>';
//##
echo '<div class="form-group row">';
echo '<label for="mod_nombre_nota" class="col-sm-2 control-label">Cambio Giro a:</label>';
echo '<div class="col-sm-10">';
echo '<input type="text" class="form-control form-control-sm" id="mod_nota" name="nota" disabled>';
echo '</div>';
echo '</div>';
###

echo '<br>';

#####################
### Giro
echo '<div class="form-group row">';
echo '<label for="mod_giro_id_seleccionado" class="col-sm-1 control-label">Giro</label>';

echo '<div class="col-sm-3"  style="background-color:#f4f0ec;color:black;">';
echo "<select class='form-control  form-select' name='id_giro' id='mod_giro_id_seleccionado' required>";
 
echo '<option value="">Seleccione Giro</option>';
$query_giro=mysqli_query($con,"SELECT * FROM giro");
while($rowGiro=mysqli_fetch_array($query_giro))	{
$id_giroDB=$rowGiro['id'];
$GIRO=$rowGiro['descripcion_giro'];
echo '<option value="'.$id_giroDB.'">'.$GIRO.'</option>';
}
echo '</select>';
echo '</div>';
echo '</div>';


?>

</div>

<div class="modal-footer">
<!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>--!>
<button type="submit" class="btn btn-primary" id="Button_guardar_registroPrincipalGiro"  style="background-color:#FF0000;color:black"> Actualizar Giro </button>
</div>

</form>
</div>
</div>
</div>
<?php
}
?>


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

$porcionesNOTAmodal = explode("**", $NOTA_proceso_tramites);
$GiroID_seleccionado_modal=trim($porcionesNOTAmodal[1]);

##echo 'GiroID_seleccionado_modal='.$GiroID_seleccionado_modal;
#####################
### Giro
echo '<div class="form-group row">';
echo '<label for="mod_giro_id_seleccionado" class="col-sm-1 control-label">Giro</label>';

echo '<div class="col-sm-4"  style="background-color:#f4f0ec;color:black;">';
echo "<select class='form-control  form-select' name='id_giro' id='mod_giro_id_seleccionado' required>";
 
echo '<option value="">Seleccione Giro</option>';
$query_giro=mysqli_query($con,"SELECT * FROM giro WHERE id=".$GiroID_seleccionado_modal);
while($rowGiro=mysqli_fetch_array($query_giro))	{
$id_giroDB=$rowGiro['id'];
$GIRO=$rowGiro['descripcion_giro'];
echo '<option value="'.$id_giroDB.'">'.$GIRO.'</option>';
}
echo '</select>';
echo '</div>';
echo '</div>';

echo '<br>';

#####################
### Modalidad de Graduacion Alcoholica
##echo 'Modalidad Graduaccion Alcoholica: '.$modalidad_graduacion_alcoholica.'<br>';
echo '<div class="form-group">';
echo '<label for="id_modalidad_GA" class="col-sm-4 control-label"><font size="2">Modalidad Graduación Alcohólica</font></label>';
echo '<div class="col-sm-6" style="background-color:#f4f0ec;color:black;">';

//echo "<select multiple class='form-control' name='id_modalidad_GA' id='id_modalidad_GA' required>";
$query_modalidad_GA=mysqli_query($con,"SELECT * FROM modalidad_graduacion_alcoholica");
while($rowmodalidad_GA=mysqli_fetch_array($query_modalidad_GA)) {
$id_modalidad_GADB=$rowmodalidad_GA['id'];
$monto_umas_MODALIDAD=$rowmodalidad_GA['monto_umas'];
$MODALIDAD=$rowmodalidad_GA['descripcion_modalidad_graduacion_alcoholica'];

if (str_contains($modalidad_graduacion_alcoholica,$MODALIDAD)) {
echo '<input type="checkbox" name="MODALIDAD_GA[]" value="'.$id_modalidad_GADB.'**'.$MODALIDAD.'**'.$monto_umas_MODALIDAD.'" checked>&nbsp; <font size="1">'.$MODALIDAD.'</font><br>';
} else {
echo '<input type="checkbox" name="MODALIDAD_GA[]" value="'.$id_modalidad_GADB.'**'.$MODALIDAD.'**'.$monto_umas_MODALIDAD.'">&nbsp; <font size="1">'.$MODALIDAD.'</font><br>';
}
//echo '<option value="'.$id_modalidad_GADB.'">'.$MODALIDAD.'</option>';
}
//echo '</select>';
echo '</div>';
echo '</div>';

####




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

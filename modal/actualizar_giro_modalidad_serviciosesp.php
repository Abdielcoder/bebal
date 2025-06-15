<script>

function getColonias(val) {
$.ajax({
type: "POST",
<?php

echo 'url: "ajax/get_colonias.php",';
?>
        data:'UNIDAD='+val,
        success: function(data){
                $("#colonias-list").html(data);
        }
        });
}

</script>


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
	<div class="modal fade" id="ActualizarGiroModalidadServiciosEsp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#FF0000;color:black">
<!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--!>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i>Actuaizar Registro Giro, Modalidad GA y/o Servicios Esp</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_registroPrincipalGMSE" name="guardar_registroPrincipalGMSE">
			<div id="resultados_ajaxGuardarRegistroPrincipalGMSE"></div>



<?php
#####################
### Giro
#

echo '<input type="hidden" name="idprincipal" value="'.$IDPRINCIPAL.'">';

echo '<div class="form-group row">';
echo '<label for="mod_id_giro" class="col-sm-1 control-label">Giro</label>';

echo '<div class="col-sm-5"  style="background-color:#f4f0ec;color:black;">'.$GIRO;
//echo "<select class='form-control  form-select' name='id_giro' id='mod_id_giro' required>";
 
//echo '<option value="">Seleccione Giro</option>';
//$query_giro=mysqli_query($con,"SELECT * FROM giro");
//while($rowGiro=mysqli_fetch_array($query_giro))	{
//$id_giroDB=$rowGiro['id'];
//$GIRO=$rowGiro['descripcion_giro'];
//echo '<option value="'.$id_giroDB.'">'.$GIRO.'</option>';
//}
//echo '</select>';
echo '</div>';
##echo '</div>';


#####################
### Modalidad de Graduacion Alcoholica
##echo '<div class="form-group">';
echo '<label for="id_modalidad_GA" class="col-sm-1 control-label"><font size="2">Modalidad Graduación Alcohólica</font></label>';
echo '<div class="col-sm-3" style="background-color:#f4f0ec;color:black;">';

//echo "<select multiple class='form-control' name='id_modalidad_GA' id='id_modalidad_GA' required>";
$query_modalidad_GA=mysqli_query($con,"SELECT * FROM modalidad_graduacion_alcoholica");
while($rowmodalidad_GA=mysqli_fetch_array($query_modalidad_GA))	{
$id_modalidad_GADB=$rowmodalidad_GA['id'];
$monto_umas_MODALIDAD=$rowmodalidad_GA['monto_umas'];
$MODALIDAD=$rowmodalidad_GA['descripcion_modalidad_graduacion_alcoholica'];


if (str_contains($modalidad_graduacion_alcoholica,$MODALIDAD)) {
echo '<input type="checkbox" name="MODALIDAD_GA[]" value="'.$id_modalidad_GADB.'**'.$MODALIDAD.'**'.$monto_umas_MODALIDAD.'" checked>&nbsp; <font size="1">'.$MODALIDAD.'</font><br>';
} else {
echo '<input type="checkbox" name="MODALIDAD_GA[]" value="'.$id_modalidad_GADB.'**'.$MODALIDAD.'**'.$monto_umas_MODALIDAD.'">&nbsp; <font size="1">'.$MODALIDAD.'</font><br>';
}
//echo '<option value="'.$id_modalidad_GADB.'">'.$MODALIDAD.'</option>';



//echo '<input type="checkbox" name="MODALIDAD_GA[]" value="'.$id_modalidad_GADB.'**'.$MODALIDAD.'**'.$monto_umas_MODALIDAD.'">&nbsp; <font size="1">'.$MODALIDAD.'</font><br>';

//echo '<option value="'.$id_modalidad_GADB.'">'.$MODALIDAD.'</option>';
}
//echo '</select>';
echo '</div>';

#####################
### Servicios Adicionales
##echo '<div class="form-group">';
//echo '<label for="id_serviciosA" class="col-sm-1 control-label"><font size="2">Servicios Adicionales</font></label>';
//echo '<div class="col-sm-3" style="background-color:#f4f0ec;color:black;">';
//$query_ServiciosAd=mysqli_query($con,"SELECT * FROM servicios_adicionales");
//while($rowServiciosAd=mysqli_fetch_array($query_ServiciosAd))	{
//$id_SA=$rowServiciosAd['id'];
//$monto_umas_SA=$rowServiciosAd['monto_umas'];
//$SERVICIOS_ADICIONALES=$rowServiciosAd['descripcion_servicios_adicionales'];
//echo '<input type="checkbox" name="SERVICIOS_ADICIONALES[]" value="'.$id_SA.'**'.$SERVICIOS_ADICIONALES.'**'.$monto_umas_SA.'">&nbsp; <font size="1">'.$SERVICIOS_ADICIONALES.'</font><br>';
//}


//echo '</div>';
echo '</div>';

echo '<br>';
###
echo '<div class="form-group row">';
echo '<div class="col-sm-10">';
echo 'Modalidad Graduación Alcohólica';
echo '<input type="text" class="form-control form-control-sm" id="mod_modalidad_graduacion_alcoholica" disabled>';
echo '<br>Servicios Adicionales ';
echo '<input type="text" class="form-control form-control-sm" id="mod_servicios_adicionales" disabled>';
echo '</div>';
echo '</div>';

?>

</div>

<div class="modal-footer">
<!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>--!>
<button type="submit" class="btn btn-primary" id="Button_guardar_registroPrincipalGMSE"  style="background-color:#FF0000;color:black"> Guardar Datos </button>
</div>

</form>
<p><font color="white" size="1">modal/actualizar_giro_modalidad_serviciosesp.php-(Button_guardar_registroPrincipalGMSE)->ajax/actualizar_giro_modalidad_serviciosesp.php</font></p>
</div>
</div>
</div>
<?php
}
?>

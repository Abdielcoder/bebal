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

#mod_clave_catastral:valid {
    color: black;
background-color: #3CBC8D;
}
#mod_clave_catastral:invalid {
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
	<div class="modal fade" id="ActualizarDatosEstablecimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#FF0000;color:black">
<!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--!>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i>Actualizar Registro Datos Establecimiento</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_PrincipalEstablecimientoInicio" name="guardar_PrincipalEstablecimientoInicio">
			<div id="resultados_ajaxGuardarPrincipalEstablecimientoInicio"></div>

<input type="hidden" id="mod_idprincipal" name="idprincipal">


<?php

##########################
##########################
echo '<h4><span style="background:black"><font color="white" size="2">Datos del Establecimiento</font></span></h4>';
###
echo '<div class="form-group row">';
echo '<label for="mod_nombre_comercial_establecimiento" class="col-sm-1 control-label"><font size="2">Nombre Comercial</font></label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control form-control-sm" style="text-transform:uppercase" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento" required>';
echo '</div>';
//##

echo '<label for="mod_clave_catastral" class="col-sm-1 control-label" align="right"><font color="blue" size="2">Número Catastro</font></label>';
echo '<div class="col-sm-2 form-check">';
//echo '<label class="form-check-label" for="clave_catastral">Dato Número Catastral</label>';
echo '<input type="text" class="form-control required" id="mod_clave_catastral" name="clave_catastral"   pattern="[A-Z]{2}(-)[0-9]{3}(-){1}[0-9]{3}"  title="Formato VALIDO -->  AA-NNN-NNN" minlength="10" maxlength="10" autocomplete="off"  required>';
echo '</div>';

//##

echo '<label for="mod_clave_catastral" class="col-sm-1 control-label" align="right"><font color="blue" size="2">Número Cuenta</font></label>';
echo '<div class="col-sm-2 form-check">';
//echo '<label class="form-check-label" for="clave_catastral">Dato Número Catastral</label>';
echo '<input type="text" class="form-control required" id="mod_numero_cuenta" name="numero_cuenta"   pattern="[0-9]{6}"  title="Formato VALIDO -->  AA-NNN-NNN" minlength="6" maxlength="6" autocomplete="off"  required>';
echo '</div>';


echo '</div>';


###
echo '<div class="form-group row">';
echo '<label for="mod_calle_establecimiento" class="col-sm-2 control-label">Calle, Ave o Blvd</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control form-control-sm" style="text-transform:uppercase" id="mod_calle_establecimiento" name="calle_establecimiento" required>';
echo '</div>';
//##
echo '<label for="mod_entre_calles_establecimiento" class="col-sm-1 control-label">Entre</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" style="text-transform:uppercase" id="mod_entre_calles_establecimiento" name="entre_calles_establecimiento" required>';
echo '</div>';
echo '</div>';
###
echo '<div class="form-group row">';
echo '<label for="mod_numero_establecimiento" class="col-sm-2 control-label">Número</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="mod_numero_establecimiento" name="numero_establecimiento" required>';
echo '</div>';
//##
echo '<label for="mod_numerointerno_local_establecimiento" class="col-sm-1 control-label">Local/Int.</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="mod_numerointerno_local_establecimiento" name="numerointerno_local_establecimiento">';
echo '</div>';
echo '</div>';
###




##
$sql_municipio="SELECT municipio FROM municipio WHERE id=".$ID_MUNICIPIO;
$result_municipio = mysqli_query($con,$sql_municipio);
$row_municipio = mysqli_fetch_assoc($result_municipio);
$MUNICIPIO=$row_municipio['municipio'];
##

echo '<div class="form-group row">';
echo '<label for="id_delegacion" class="col-sm-2 control-label">Delegación </label>';

echo '<div class="col-sm-4">';
echo "<select class='form-control  form-select' name='id_delegacion' id='id_delegacion' onChange='getColonias(this.value);' required>";
 
echo '<option value="">Selecciona Delegación</option>';
if ( $PROFILE=='admin' ) {
##$query_delegacion=mysqli_query($con,"SELECT * FROM delegacion ORDER BY id_municipio");
$query_delegacion=mysqli_query($con,"SELECT * FROM delegacion WHERE id_municipio=".$ID_MUNICIPIO);
} else {
$query_delegacion=mysqli_query($con,"SELECT * FROM delegacion WHERE id_municipio=".$ID_MUNICIPIO);
}
while($row=mysqli_fetch_array($query_delegacion))	{

$id_delegacion=$row['id'];
$DELEGACION=$row['delegacion'];
$MUNICIPIO=$row['id_municipio'];

echo '<option value="'.$id_delegacion.'">'.$DELEGACION.'</option>';

}


echo '</select>';
echo '</div>';
##echo '</div>';


#####################
### Colonias
echo '<label for="id_colonia" class="col-sm-1 control-label">Colonia</label>';

echo '<div class="col-sm-4">';
echo "<select class='form-control  form-select' name='id_colonia' id='colonias-list' required>";
 
echo '<option value="">Seleccione Colonia</option>';

echo '</select>';
echo '</div>';
echo '</div>';

###
echo '<div class="form-group row">';
echo '<label for="mod_cp_establecimiento" class="col-sm-1 control-label">Código Postal</label>';
echo '<div class="col-sm-2">';
echo '<input type="number" class="form-control" id="mod_cp_establecimiento" name="cp_establecimiento" required>';
echo '</div>';
//##

echo '<label for="mod_capacidad_comensales_personas" class="col-sm-2 control-label">Número Comensales</label>';
echo '<div class="col-sm-2">';
echo '<input type="number" class="form-control" id="mod_capacidad_comensales_personas" name="capacidad_comensales_personas" required>';
echo '</div>';
//
echo '<label for="mod_superficie_establecimiento" class="col-sm-2 control-label" align="right">Superficie (m²)</label>';
echo '<div class="col-sm-2">';
echo '<input type="number" class="form-control" id="mod_superficie_establecimiento" name="superficie_establecimiento" required>';
echo '</div>';

echo '</div>';


?>

<div class="form-group row">
<label for="mod_observaciones" class="col-sm-2 control-label">Observaciones</label>
<div class="col-sm-8">
<textarea class="form-control" id="mod_observaciones" name="observaciones"   maxlength="1000" ></textarea>
</div>
</div>

				  

</div>

<div class="modal-footer">
<!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>--!>
<button type="submit" class="btn btn-primary" id="Button_guardar_PrincipalEstablecimientoInicio"  style="background-color:#FF0000;color:black"> Guardar Datos </button>
</div>

</form>
<p><font color="white" size="1">modal/actualizar_datos_establecimiento.php-(Button_guardar_PrincipalEstablecimientoInicio)->ajax/ActualizarDatosEstablecimientoInicio.php</font></p>
</div>
</div>
</div>
<?php
}
?>

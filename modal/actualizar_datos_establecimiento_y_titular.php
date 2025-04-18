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
	<div class="modal fade" id="ActualizarDatosEstablecimiento_y_Titular" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#FF0000;color:black">
<!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--!>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i>Actualizar - Domicilio Establecimiento y Titular</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_registroPrincipalEstablecimiento_y_Titular" name="guardar_registroPrincipalEstablecimiento_y_Titular">
			<div id="resultados_ajaxActualizarDatosEstaTitular"></div>

<input type="hidden" id="mod_idprincipal" name="idprincipal">


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
//##

echo '<label for="mod_clave_catastral" class="col-sm-2 control-label" align="right"><font color="blue">Número Catastro</font></label>';
echo '<div class="col-sm-2 form-check">';
//echo '<label class="form-check-label" for="clave_catastral">Dato Número Catastral</label>';
echo '<input type="text" class="form-control required" id="mod_clave_catastral" name="clave_catastral"   pattern="[A-Z]{2}(-)[0-9]{3}(-){1}[0-9]{3}"  title="Formato VALIDO -->  AA-NNN-NNN" minlength="10" maxlength="10" autocomplete="off"  required>';
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
echo '<label for="mod_id_delegacion" class="col-sm-2 control-label">Delegación </label>';

echo '<div class="col-sm-4">';
echo "<select class='form-control  form-select' name='id_delegacion' id='mod_id_delegacion' onChange='getColonias(this.value);' required>";
 
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
echo '<label for="mod_id_colonia" class="col-sm-1 control-label">Colonia</label>';

echo '<div class="col-sm-4">';
echo "<select class='form-control  form-select' name='mod_id_colonia' id='colonias-list' required>";
 
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
<label for="mod_observaciones" class="col-sm-2 control-label"><b>Observaciones</b></label>
<div class="col-sm-10">
<textarea class="form-control" id="mod_observaciones" name="observaciones" rows="2"  maxlength="1000" ></textarea>
</div>
</div>


<?php


### Nombre Persona Fisica/Moral
echo '<div class="form-group row">';
echo '<label for="mod_nombre_persona_fisicamoral_solicitante" class="col-sm-3 control-label">Nombre Persona Fisica/Moral</label>';
echo '<div class="col-sm-5"  style="background-color:#f4f0ec;color:black;">';
echo '<input type="text" class="form-control" style="text-transform:uppercase" id="mod_nombre_persona_fisicamoral_solicitante" name="nombre_persona_fisicamoral_solicitante" required>';
echo '</div>';
//##
echo '<label for="mod_fisica_o_moral" class="col-sm-1 control-label">Persona</label>';
echo '<div class="col-sm-3">';

echo '<select name="mod_fisica_o_moral" id="mod_fisica_o_moral"  class="form-control form-select" required>';
echo '<option value="">Fisica o Moral</option>';
echo '<option value="Fisica">Fisica</option>';
echo '<option value="Moral">Moral</option>';
echo '</select>';

echo '</div>';
echo '</div>';
#####################
### Nombre Titular
echo '<div class="form-group row">';
echo '<label for="mod_nombre_representante_legal_solicitante" class="col-sm-3 control-label">Nombre Representante Legal</label>';
echo '<div class="col-sm-5">';
echo '<input type="text" class="form-control" style="text-transform:uppercase" id="mod_nombre_representante_legal_solicitante" name="nombre_representante_legal_solicitante" required>';
echo '</div>';
//##
echo '<label for="mod_rfc_solicitante" class="col-sm-1 control-label">RFC</label>';
echo '<div class="col-sm-3">';
echo '<input type="text" class="form-control title="Enter RFC"" pattern="^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([A-Z\d]{3})?$" title="Enter RFC"  id="mod_rfc" name="rfc_solicitante" utocomplete="off"  required>';
echo '</div>';
echo '</div>';
#####################
### Domicilio Solicitante
echo '<div class="form-group row">';
echo '<label for="mod_domicilio_solicitante" class="col-sm-4 control-label">Domicilio Para Recibir Notificaciones</label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control" style="text-transform:uppercase"  id="mod_domicilio_solicitante" name="domicilio_solicitante" required>';
echo '</div>';
echo '</div>';
###
echo '<div class="form-group row">';
echo '<label for="mod_email_solicitante" class="col-sm-2 control-label">Email</label>';
echo '<div class="col-sm-4">';
echo '<input type="email" class="form-control" id="mod_email_solicitante" name="email_solicitante" required>';
echo '</div>';
//##
echo '<label for="mod_telefono_solicitante" class="col-sm-1 control-label">Teléfono</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="mod_telefono_solicitante" name="telefono_solicitante" required>';
echo '</div>';
echo '</div>';
#################


?>




</div>

<div class="modal-footer">
<!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>--!>
<button type="submit" class="btn btn-primary" id="Button_guardar_registroPrincipalEstablecimiento_y_Titular"  style="background-color:#FF0000;color:black"> Actualizar Registro </button>
</div>

</form>
</div>
</div>
</div>
<?php
}
?>

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
	<div class="modal fade" id="nuevoRegistroPrincipal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#AC905B;color:white">
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Agregar Nuevo Registro</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_registroPrincipal" name="guardar_registroPrincipal">
			<div id="resultados_ajaxGuardarRegistroPrincipal"></div>



<?php
#####################
### Giro
echo '<div class="form-group row">';
echo '<label for="id_giro" class="col-sm-1 control-label">Giro</label>';

echo '<div class="col-sm-3"  style="background-color:#f4f0ec;color:black;">';
echo "<select class='form-control  form-select' name='id_giro' id='id_giro' required>";
 
echo '<option value="">Seleccione Giro</option>';
$query_giro=mysqli_query($con,"SELECT * FROM giro WHERE siglas!='' OR siglas!=NULL");
while($rowGiro=mysqli_fetch_array($query_giro))	{
$id_giroDB=$rowGiro['id'];
$GIRO=$rowGiro['descripcion_giro'];
$SIGLAS=$rowGiro['siglas'];
echo '<option value="'.$id_giroDB.'">'.$GIRO.'-'.$SIGLAS.'</option>';
}
echo '</select>';
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
echo '<input type="checkbox" name="MODALIDAD_GA[]" value="'.$id_modalidad_GADB.'**'.$MODALIDAD.'**'.$monto_umas_MODALIDAD.'">&nbsp; <font size="1">'.$MODALIDAD.'</font><br>';
//echo '<option value="'.$id_modalidad_GADB.'">'.$MODALIDAD.'</option>';
}
//echo '</select>';
echo '</div>';

#####################
### Servicios Adicionales
##echo '<div class="form-group">';
echo '<label for="serviciosAdicionales" class="col-sm-1 control-label"><font size="2">Servicios Adicionales</font></label>';
##echo '<label for="id_serviciosA" class="col-sm-1 control-label"><font size="2">Servicios Adicionales</font></label>';
echo '<div class="col-sm-3" style="background-color:#f4f0ec;color:black;">';
##$query_ServiciosAd=mysqli_query($con,"SELECT * FROM servicios_adicionales WHERE descripcion_servicios_adicionales!='Mesas de Billar, por cada Mesa'");
##$query_ServiciosAd=mysqli_query($con,"SELECT * FROM servicios_adicionales");
##while($rowServiciosAd=mysqli_fetch_array($query_ServiciosAd))	{
##$id_SA=$rowServiciosAd['id'];
##$monto_umas_SA=$rowServiciosAd['monto_umas'];
##$SERVICIOS_ADICIONALES=$rowServiciosAd['descripcion_servicios_adicionales'];
##echo '<input type="checkbox" name="SERVICIOS_ADICIONALES[]" value="'.$id_SA.'**'.$SERVICIOS_ADICIONALES.'**'.$monto_umas_SA.'">&nbsp; <font size="1">'.$SERVICIOS_ADICIONALES.'</font><br>';
##}

//echo '</div>';
//echo '</div>';


//echo '<div class="col-sm-3" style="background-color:#f4f0ec;color:black;">';

echo "<select name='pista_de_baile' id='pista_de_baile' style='font-size: 0.8em;'>";

echo '<option value="Zero" selected>No</option>';
echo '<option value="1">Si</option>';
echo '</select>';
echo '<font size="1">&nbsp;&nbsp;Pista de Baile</font>';

echo '<br><br>';

##echo '<div class="col-sm-3"  style="background-color:#f4f0ec;color:black;">';
echo "<select name='numero_mesas_de_billar' id='numero_mesas_de_billar' style='font-size: 0.8em;'>";
 
echo '<option value="Zero" selected>No</option>';
echo '<option value="1">1</option>';
echo '<option value="2">2</option>';
echo '<option value="3">3</option>';
echo '<option value="4">4</option>';
echo '<option value="5">5</option>';
echo '<option value="6">6</option>';
echo '<option value="7">7</option>';
echo '<option value="8">8</option>';
echo '<option value="9">9</option>';
echo '<option value="10">10</option>';
echo '<option value="11">11</option>';
echo '<option value="12">12</option>';
echo '<option value="13">13</option>';
echo '<option value="14">14</option>';
echo '<option value="15">15</option>';
echo '<option value="16">16</option>';
echo '<option value="17">17</option>';
echo '<option value="18">18</option>';
echo '<option value="19">19</option>';
echo '<option value="20">20</option>';
echo '</select>';
echo '<font size="1">&nbsp;&nbsp;Mesas de Billar</font>';

echo '<p> </p>';

echo "<select name='musica_grabada_y_aparatos' id='musica_grabada_y_aparatos' style='font-size: 0.8em;'>";

echo '<option value="Zero" selected>No</option>';
echo '<option value="1">Si</option>';
echo '</select>';
echo '<font size="1">&nbsp;&nbsp;Musica Grabada y Aparatos</font>';

echo '<p> </p>';

echo "<select name='conjunto_musicales' id='conjunto_musicales' style='font-size: 0.8em;'>";

echo '<option value="Zero" selected>No</option>';
echo '<option value="1">Si</option>';
echo '</select>';
echo '<font size="1">&nbsp;&nbsp;Conjunto Musicales</font>';

echo '<p> </p>';

echo "<select name='espectaculos_artisticos' id='espectaculos_artisticos' style='font-size: 0.8em;'>";

echo '<option value="Zero" selected>No</option>';
echo '<option value="1">Si</option>';
echo '</select>';
echo '<font size="1">&nbsp;&nbsp;Espectaculos Artisticos</font>';

##echo '</div>';
echo '</div>';
echo '</div>';

##########################
##########################
echo '<h4><span style="background:black"><font color="white" size="3">Datos del Establecimiento</font></span></h4>';
###
echo '<div class="form-group row">';
echo '<label for="nombre_comercial_establecimiento" class="col-sm-2 control-label">Nombre Comercial</label>';
echo '<div class="col-sm-5">';
echo '<input type="text" class="form-control form-control-sm" style="text-transform:uppercase" id="nombre_comercial_establecimiento" name="nombre_comercial_establecimiento" required>';
echo '</div>';
//##

echo '<label for="clave_catastral" class="col-sm-2 control-label" align="right"><font color="blue">Número Catastro</font></label>';
echo '<div class="col-sm-2 form-check">';
//echo '<label class="form-check-label" for="clave_catastral">Dato Número Catastral</label>';
echo '<input type="text" class="form-control required" id="clave_catastral" name="clave_catastral"   pattern="[A-Z]{2}(-)[0-9]{3}(-){1}[0-9]{3}"  title="Formato VALIDO -->  AA-NNN-NNN" minlength="10" maxlength="10" autocomplete="off"  required>';
echo '</div>';
echo '</div>';


###
echo '<div class="form-group row">';
echo '<label for="calle_establecimiento" class="col-sm-2 control-label">Calle, Ave o Blvd</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control form-control-sm" style="text-transform:uppercase" id="calle_establecimiento" name="calle_establecimiento" required>';
echo '</div>';
//##
echo '<label for="entre_calles_establecimiento" class="col-sm-1 control-label">Entre</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" style="text-transform:uppercase" id="entre_calles_establecimiento" name="entre_calles_establecimiento" required>';
echo '</div>';
echo '</div>';
###
echo '<div class="form-group row">';
echo '<label for="numero_establecimiento" class="col-sm-2 control-label">Número</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="numero_establecimiento" name="numero_establecimiento" required>';
echo '</div>';
//##
echo '<label for="numerointerno_local_establecimiento" class="col-sm-1 control-label">Local/Int.</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="numerointerno_local_establecimiento" name="numerointerno_local_establecimiento">';
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
$query_delegacion=mysqli_query($con,"SELECT * FROM delegacion WHERE id_municipio=".$ID_MUNICIPIO."  AND siglas!='' OR siglas!=NULL");
} else {
$query_delegacion=mysqli_query($con,"SELECT * FROM delegacion WHERE id_municipio=".$ID_MUNICIPIO."  AND siglas!='' OR siglas!=NULL");
}
while($row=mysqli_fetch_array($query_delegacion))	{

$id_delegacion=$row['id'];
$DELEGACION=$row['delegacion'];
$MUNICIPIO=$row['id_municipio'];
$SIGLASdelegacion=$row['siglas'];

echo '<option value="'.$id_delegacion.'">'.$DELEGACION.'-'.$SIGLASdelegacion.'</option>';

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
echo '<label for="cp_establecimiento" class="col-sm-1 control-label">Código Postal</label>';
echo '<div class="col-sm-2">';
echo '<input type="number" class="form-control" id="cp_establecimiento" name="cp_establecimiento" required>';
echo '</div>';
//##

echo '<label for="capacidad_comensales_personas" class="col-sm-2 control-label">Número Comensales</label>';
echo '<div class="col-sm-2">';
echo '<input type="number" class="form-control" id="capacidad_comensales_personas" name="capacidad_comensales_personas" required>';
echo '</div>';
//
echo '<label for="superficie_establecimiento" class="col-sm-2 control-label" align="right">Superficie (m²)</label>';
echo '<div class="col-sm-2">';
echo '<input type="number" class="form-control" id="superficie_establecimiento" name="superficie_establecimiento" required>';
echo '</div>';

echo '</div>';


##########################
##########################
echo '<h4><span style="background:black"><font color="white" size="3">Datos del Solicitante</font></span></h4>';
##

### Nombre Persona Fisica/Moral
echo '<div class="form-group row">';
echo '<label for="nombre_persona_fisicamoral_solicitante" class="col-sm-3 control-label">Nombre Persona Fisica/Moral</label>';
echo '<div class="col-sm-5"  style="background-color:#f4f0ec;color:black;">';
echo '<input type="text" class="form-control" style="text-transform:uppercase" id="nombre_persona_fisicamoral_solicitante" name="nombre_persona_fisicamoral_solicitante" required>';
echo '</div>';
//##
echo '<label for="fisica_o_moral" class="col-sm-1 control-label">Persona</label>';
echo '<div class="col-sm-3">';

echo '<select name="fisica_o_moral" id="fisica_o_moral"  class="form-control form-select" required>';
echo '<option value="">Fisica o Moral</option>';
echo '<option value="Fisica">Fisica</option>';
echo '<option value="Moral">Moral</option>';
echo '</select>';

echo '</div>';
echo '</div>';
#####################
### Nombre Titular
echo '<div class="form-group row">';
echo '<label for="nombre_representante_legal_solicitante" class="col-sm-3 control-label">Nombre Representante Legal</label>';
echo '<div class="col-sm-5">';
echo '<input type="text" class="form-control" style="text-transform:uppercase" id="nombre_representante_legal_solicitante" name="nombre_representante_legal_solicitante" required>';
echo '</div>';
//##
echo '<label for="rfc_solicitante" class="col-sm-1 control-label">RFC</label>';
echo '<div class="col-sm-3">';
echo '<input type="text" class="form-control title="Enter RFC"" pattern="^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([A-Z\d]{3})?$" title="Enter RFC"  id="rfc_solicitante" name="rfc_solicitante" utocomplete="off"  required>';
echo '</div>';
echo '</div>';
#####################
### Domicilio Solicitante
echo '<div class="form-group row">';
echo '<label for="domicilio_solicitante" class="col-sm-4 control-label">Domicilio Para Recibir Notificaciones</label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control" style="text-transform:uppercase"  id="domicilio_solicitante" name="domicilio_solicitante" required>';
echo '</div>';
echo '</div>';
###
echo '<div class="form-group row">';
echo '<label for="email_solicitante" class="col-sm-2 control-label">Email</label>';
echo '<div class="col-sm-4">';
echo '<input type="email" class="form-control" id="email_solicitante" name="email_solicitante" required>';
echo '</div>';
//##
echo '<label for="telefono_solicitante" class="col-sm-1 control-label">Teléfono</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="telefono_solicitante" name="telefono_solicitante" required>';
echo '</div>';
echo '</div>';
###



#################
?>

<div class="form-group row">
<label for="observaciones" class="col-sm-2 control-label">Observaciones</label>
<div class="col-sm-6">
<textarea class="form-control" id="observaciones" name="observaciones"   maxlength="1000" ></textarea>
</div>
<label for="fecha_alta" class="col-sm-2 control-label">Fecha Alta</label>
<div class="col-sm-2">

<?php
$today = date("Y-m-d");
echo '<input type="date" class="form-control" id="fecha_alta" value="'.$today.'"  name="fecha_alta" required>';
?>
</div>
</div>

				  

<?php
//<div class="form-group">
//<label for="video_url" class="col-sm-3 control-label">Video URL Youtube</label>
//<div class="col-sm-8">
//<input type="text" class="form-control" id="video_url" name="video_url"   maxlength="500" >
//</div>
//</div>

//<div class="form-group">
//<label for="mapa" class="col-sm-3 control-label">Mapa Google Maps</label>
//<div class="col-sm-8">
//<input type="text" class="form-control" id="mapa" name="mapa"   maxlength="500" >
//</div>
//</div>
?>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>
<button type="submit" class="btn btn-primary" id="Button_guardar_registroPrincipal"  style="background-color:#AC905B;color:black"> Guardar Datos </button>
</div>

</form>
</div>
</div>
</div>
<?php
}
?>

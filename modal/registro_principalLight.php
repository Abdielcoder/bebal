
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
	<div class="modal fade" id="nuevoRegistroPrincipalLight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#AC905B;color:white">
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Agregar Nuevo Registro Light</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_registroPrincipalLight" name="guardar_registroPrincipalLight">
			<div id="resultados_ajaxGuardarRegistroPrincipalLight"></div>



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

echo '</div>';
echo '</div>';

##########################
##########################
echo '<h4><span style="background:black"><font color="white" size="3">Datos del Establecimiento</font></span></h4>';
###
echo '<div class="form-group row">';
echo '<label for="nombre_comercial_establecimiento" class="col-sm-2 control-label"><font size="2">Nombre Comercial</font></label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control form-control-sm" style="text-transform:uppercase" id="nombre_comercial_establecimiento" name="nombre_comercial_establecimiento" required>';
echo '</div>';
//##

echo '</div>';


echo '<br>';

##########################
##########################
echo '<h4><span style="background:black"><font color="white" size="3">Datos del Solicitante</font></span></h4>';
##

#####################
### Nombre Representante Legal
echo '<div class="form-group row">';
echo '<label for="nombre_representante_legal_solicitante" class="col-sm-2 control-label"><font size="2">Nombre Representante Legal</font></label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control" style="text-transform:uppercase" id="nombre_representante_legal_solicitante" name="nombre_representante_legal_solicitante" required>';
echo '</div>';
//##
echo '</div>';
#####################

#################
?>

<div class="form-group row">
<label for="observaciones" class="col-sm-2 control-label"><font size="2">Observaciones</font></label>
<div class="col-sm-6">
<textarea class="form-control" id="observaciones" name="observaciones"   maxlength="1000" ></textarea>
</div>
<label for="fecha_alta" class="col-sm-1 control-label"><font size="2">Fecha Alta</font></label>
<div class="col-sm-2">

<?php
$today = date("Y-m-d");
echo '<input type="date" class="form-control" id="fecha_alta" value="'.$today.'"  name="fecha_alta" required>';
?>
</div>
</div>

<br>
				  

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
<button type="submit" class="btn btn-primary" id="Button_guardar_registroPrincipalLight"  style="background-color:#AC905B;color:black"> Guardar Datos </button>
</div>

</form>
<p><font color="white" size="1">modal/registro_principalLight.php-(Button_guardar_registroPrincipalLight)->ajax/nuevo_registroPrincipal_Light.php</font></p>
</div>
</div>
</div>
<br>
<br>
<?php
}
?>

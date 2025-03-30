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


<?php
	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];
	if (isset($con))
	{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoRegistroPrincipal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#AC905B;color:white">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Nuevo Registro</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_registroPrincipal" name="guardar_registroPrincipal">
			<div id="resultados_ajax"></div>
<?php
#####################
### Giro
echo '<div class="form-group">';
echo '<label for="id_giro" class="col-sm-1 control-label">Giro</label>';

echo '<div class="col-sm-4">';
echo "<select class='form-control' name='id_giro' id='id_giro' required>";
 
echo '<option value="">Seleccione Giro</option>';
$query_giro=mysqli_query($con,"SELECT * FROM giro");
while($rowGiro=mysqli_fetch_array($query_giro))	{
$id_giroDB=$rowGiro['id'];
$GIRO=$rowGiro['descripcion_giro'];
echo '<option value="'.$id_giroDB.'">'.$GIRO.'</option>';
}
echo '</select>';
echo '</div>';
##echo '</div>';


#####################
### Modalidad de Graduacion Alcoholica
##echo '<div class="form-group">';
echo '<label for="id_modalidad_GA" class="col-sm-2 control-label">Modalidad GA</label>';

echo '<div class="col-sm-4">';
echo "<select class='form-control' name='id_modalidad_GA' id='id_modalidad_GA' required>";
 
echo '<option value="">Seleccione Modalidad GA</option>';
$query_modalidad_GA=mysqli_query($con,"SELECT * FROM modalidad_graduacion_alcoholica");
while($rowmodalidad_GA=mysqli_fetch_array($query_modalidad_GA))	{
$id_modalidad_GADB=$rowmodalidad_GA['id'];
$MODALIDAD=$rowmodalidad_GA['descripcion_modalidad_graduacion_alcoholica'];
echo '<option value="'.$id_modalidad_GADB.'">'.$MODALIDAD.'</option>';
}
echo '</select>';
echo '</div>';
echo '</div>';

##########################
##########################
echo '<h4><span style="background:black"><font color="white">Datos del Establecimiento</font></span></h4>';
##
echo '<div class="form-group">';
echo '<label for="nombre_comercial_establecimiento" class="col-sm-3 control-label">Nombre Comercial</label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control" id="nombre_comercial_establecimiento" name="nombre_comercial_establecimiento" required>';
echo '</div>';
echo '</div>';
###
echo '<div class="form-group">';
echo '<label for="calle_establecimiento" class="col-sm-2 control-label">Calle, Ave o Blvd</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control form-control-sm" id="calle_establecimiento" name="calle_establecimiento" required>';
echo '</div>';
//##
echo '<label for="entre_calles_establecimiento" class="col-sm-1 control-label">Entre</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="entre_calles_establecimiento" name="entre_calles_establecimiento" required>';
echo '</div>';
echo '</div>';
###
echo '<div class="form-group">';
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

echo '<div class="form-group">';
echo '<label for="id_delegacion" class="col-sm-2 control-label">Delegación </label>';

echo '<div class="col-sm-4">';
echo "<select class='form-control' name='id_delegacion' id='id_delegacion' onChange='getColonias(this.value);' required>";
 
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
echo "<select class='form-control' name='id_colonia' id='colonias-list' required>";
 
echo '<option value="">Seleccione Colonia</option>';

echo '</select>';
echo '</div>';
echo '</div>';

###
echo '<div class="form-group">';
echo '<label for="cp_establecimiento" class="col-sm-2 control-label">CP</label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="cp_establecimiento" name="cp_establecimiento" required>';
echo '</div>';
//##
echo '<label for="clave_catastral" class="col-sm-1 control-label"><font color="blue">Número Catastro</font></label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="clave_catastral" name="clave_catastral" required>';
echo '</div>';
echo '</div>';
###

##########################
##########################
echo '<h4><span style="background:black"><font color="white">Datos del Solicitante</font></span></h4>';
##

echo '<div class="form-group">';
echo '<label for="nombre_persona_fisicamoral_solicitante" class="col-sm-4 control-label">Nombre Persona Fisica/Moral</label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control" id="nombre_persona_fisicamoral_solicitante" name="nombre_persona_fisicamoral_solicitante" required>';
echo '</div>';
echo '</div>';
#####################
### Nombre Titular
echo '<div class="form-group">';
echo '<label for="nombre_representante_legal_solicitante" class="col-sm-4 control-label">Nombre Representante Legal</label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control" id="nombre_representante_legal_solicitante" name="nombre_representante_legal_solicitante" required>';
echo '</div>';
echo '</div>';
#####################
### Domicilio Solicitante
echo '<div class="form-group">';
echo '<label for="domicilio_solicitante" class="col-sm-4 control-label">Domicilio Para Recibir Notificaciones</label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control" id="domicilio_solicitante" name="domicilio_solicitante" required>';
echo '</div>';
echo '</div>';
###
echo '<div class="form-group">';
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

<div class="form-group">
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
<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
<button type="submit" class="btn btn-primary" id="guardar_datos_registroPrincipal"  style="background-color:#AC905B;color:black">Guardar datos</button>
</div>

</form>
</div>
</div>
</div>
<?php
}
?>

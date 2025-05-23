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
	<div class="modal fade" id="RevaldacionPermiso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#FF0000;color:black">
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-p-square'></i>  Revaldación Permiso</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_RevaldacionPermiso" name="guardar_RevaldacionPermiso">
			<div id="resultados_ajaxDatosRevalidacionPermiso"></div>

<input type="hidden" id="mod_idprincipal" name="idprincipal">
<input type="hidden" id="mod_folio" name="folio">
<?php
echo '<input type="hidden" id="id_giro" name="id_giro" value="'.$id_giro.'">';
?>


<?php

##########################
##########################
##echo '<h4><span style="background:black"><font color="white" size="3">Datos del Establecimiento</font></span></h4>';
###
echo '<div class="form-group row">';
echo '<label for="mod_nombre_comercial_establecimiento" class="col-sm-3 control-label"><font size="2">Nombre Comercial</font></label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control form-control-sm" style="text-transform:uppercase" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento" disabled>';
echo '</div>';
echo '</div>';
//##

echo '<br>';

###
echo '<div class="form-group row">';
echo '<label for="folio" class="col-sm-3 control-label"><font size="2">Número Permiso</font></label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control form-control-sm" id="numero_permiso" name="numero_permiso" value="'.$numero_permiso.'"  disabled>';
echo '</div>';
echo '</div>';
//##

###
echo '<div class="form-group row">';
echo '<label for="folio" class="col-sm-3 control-label"><font size="2">Folio</font></label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control form-control-sm" id="mod_folio" name="md_folio" disabled>';
echo '</div>';
echo '</div>';
//##
echo '<div class="form-group row">';
echo '<label for="fecha_expiracion" class="col-sm-3 control-label"><font size="2">fecha Expiración</font></label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control form-control-sm" id="fecha_expiracion" name="fecha_expiracion" value="'.$fecha_expiracion.'"  disabled>';
echo '</div>';
echo '</div>';
//##



?>



</div>

<div class="modal-footer">
<!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>--!>
<button type="submit" class="btn btn-primary" id="Button_guardar_RevalidacionPermiso"  style="background-color:#FF0000;color:black"> Revalidar </button>
</div>

</form>
</div>
</div>
</div>
<?php
}
?>

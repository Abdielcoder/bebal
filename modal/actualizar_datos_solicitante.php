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

#mod_rfc:valid {
    color: black;
background-color: #3CBC8D;
}
#mod_rfc:invalid {
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
	<div class="modal fade" id="ActualizarDatosSolicitante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#FF0000;color:black">
<!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--!>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Actualizar Registro Datos Solicitante</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_PrincipalSolicitanteInicio" name="guardar_PrincipalSolicitanteInicio">
			<div id="resultados_ajaxGuardarPrincipalSolicitanteInicio"></div>

<input type="hidden" id="mod_idprincipal" name="idprincipal">


<?php

##########################
##########################
echo '<h4><span style="background:black"><font color="white" size="3">Datos del Solicitante</font></span></h4>';
##

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
<button type="submit" class="btn btn-primary" id="Button_guardar_PrincipalSolicitanteInicio"  style="background-color:#FF0000;color:black"> Guardar Datos </button>
</div>

</form>
</div>
</div>
</div>
<?php
}
?>

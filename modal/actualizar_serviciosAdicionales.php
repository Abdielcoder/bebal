
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
	<div class="modal fade" id="elegirServicioAdicional" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#661C32;color:white">
<!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--!>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i>  Servicios Adicionales</h6>
		  </div>
		  <div class="modal-body">
                        <form class="form-horizontal" method="post" id="elegir_ServiciosAdicionales" name="elegir_ServiciosAdicionales" action="aprobarPresupuestoCambio.php">


			<div id="resultados_ajaxGuardarRegistroPrincipalSA"></div>


<input type="hidden" id="mod_idprincipal" name="IDPRINCIPAL">
<input type="hidden" id="mod_id_tramite_solicitado" name="ID_TRAMITE_SOLICITADO">
<input type="hidden" id="mod_pagina" name="page">



<?php

##########################
##########################
echo '<div class="form-group row">';
echo '<label for="mod_nombre_comercial_establecimiento" class="col-sm-4 control-label"><font size="2">Nombre Comercial</font></label>';
echo '<div class="col-sm-8">';
echo '<label for="nombre_comercial_establecimiento" class="col-sm-7 control-label"><font size="2" color="blue">'.$nombre_comercial_establecimiento.'</font></label>';
echo '</div>';
echo '</div>';
##########################
echo '<div class="form-group row">';
echo '<label for="folio" class="col-sm-4 control-label"><font size="2">Folio:</font></label>';
echo '<div class="col-sm-7">';
echo '<label for="folio" class="col-sm-7 control-label"><font size="2" color="blue">'.$folio.'</font></label>';
echo '</div>';
echo '</div>';
##
echo '<div class="form-group row">';
echo '<label for="numero_permiso" class="col-sm-4 control-label"><font size="2">Número de Permiso:</font></label>';
echo '<div class="col-sm-7">';
echo '<label for="numero_permiso" class="col-sm-7 control-label"><font size="2" color="blue">'.$numero_permiso.'</font></label>';
echo '</div>';
echo '</div>';

##echo 'id='.$IDPRINCIPAL;
##echo 'id_tramite_solicitado='.$ID_TRAMITE_SOLICITADO;
###

echo '<br>';

#####################
#####################
### Servicios Adicionales
$sql_Cuenta_SA="SELECT COUNT(*) AS CUENTA_SA FROM  proceso_tramites WHERE id_tramite=".$ID_TRAMITE_SOLICITADO;
##echo $sql_Cuenta_SA."<br>";
$result_Cuenta_SA = mysqli_query($con,$sql_Cuenta_SA);
$row_Cuenta_SA = mysqli_fetch_assoc($result_Cuenta_SA);
$EXISTE_Cuenta_SA=$row_Cuenta_SA['CUENTA_SA'];
##echo "TRAMITES=".$EXISTE_Cuenta_SA."<br>";

if ( $EXISTE_Cuenta_SA==0 ) {
## BUSCAR EL id_proceso_tramites DE LA ALTA NUEVA
$sql_SA2="SELECT *  FROM  proceso_tramites WHERE id_tramite=1 AND id_principal=".$IDPRINCIPAL;
$result_SA2 = mysqli_query($con,$sql_SA2);
$row_SA2 = mysqli_fetch_assoc($result_SA2);
$ID_PROCESO_TRAMITES_MOD=$row_SA2['id'];
$sql_SA="SELECT * FROM servicios_adicionales_permisionario WHERE id_principal=".$IDPRINCIPAL." AND id_proceso_tramites=".$ID_PROCESO_TRAMITES_MOD;

} else {
$sql_SA="SELECT * FROM servicios_adicionales_permisionario WHERE id_principal=".$IDPRINCIPAL." AND id_proceso_tramites=".$id_proceso_tramites;
}

$sql_SA="SELECT * FROM servicios_adicionales_permisionario WHERE id=".$ID_SERVICIOS_ADICIONALES_PERMISIONARIO;

##echo $sql_SA;
$result_SA = mysqli_query($con,$sql_SA);
$row_SA = mysqli_fetch_assoc($result_SA);
$FOLIO_SA=$row_SA['folio'];
$MUSICA_GRABADA_Y_APARATOS=$row_SA['musica_grabada_y_aparatos'];
$MONTO_MUSICA_GRABADA_Y_APARATOS=$row_SA['monto_musica_grabada_y_aparatos'];
$CONJUNTO_MUSICALES=$row_SA['conjunto_musicales'];
$MONTO_CONJUNTO_MUSICALES=$row_SA['monto_conjunto_musicales'];
$MESAS_DE_BILLAR=$row_SA['mesas_de_billar'];
$MONTO_MESAS_DE_BILLAR=$row_SA['monto_mesas_de_billar'];
$ESPECTACULOS_ARTISTICOS=$row_SA['espectaculos_artisticos'];
$MONTO_ESPECTACULOS_ARTISTICOS=$row_SA['monto_espectaculos_artisticos'];
$PISTA_DE_BAILE=$row_SA['pista_de_baile'];
$MONTO_PISTA_DE_BAILE=$row_SA['monto_pista_de_baile'];

//echo '<font size="1" color="blue">Pistas de Baile: '.$PISTA_DE_BAILE.',  Mesas de Billar: '.$MESAS_DE_BILLAR.', Musica Grabada y Aparatos: '.$MUSICA_GRABADA_Y_APARATOS.', Conjunto Musicales: '.$CONJUNTO_MUSICALES.' y  Espectaculos Artisticos: '.$ESPECTACULOS_ARTISTICOS.'</font><br>';

##echo '<div class="form-group">';
echo '<div class="form-group row">';
echo '<label for="serviciosAdicionales" class="col-sm-3 control-label"><font size="2">Servicios Adicionales</font></label>';
##echo '<label for="id_serviciosA" class="col-sm-1 control-label"><font size="2">Servicios Adicionales</font></label>';
echo '<div class="col-sm-8" style="background-color:#f4f0ec;color:black;">';

echo "<select name='pista_de_baile_presupuesto' style='font-size: 0.8em;'>";

if ( $PISTA_DE_BAILE==0 ) {
echo '<option value="Zero" selected>No</option>';
echo '<option value="1">Si</option>';
} else {
echo '<option value="'.$PISTA_DE_BAILE.'">Si</option>';
echo '<option value="Zero">No</option>';
}
echo '</select>';
if ( $PISTA_DE_BAILE==0 ) echo '<font size="1">&nbsp;&nbsp;Pista de Baile</font>';
else echo '<font size="1" color="red"><b>&nbsp;&nbsp;Pista de Baile</b></font>';

echo '<br><br>';

echo "<select name='numero_mesas_de_billar_presupuesto' style='font-size: 0.8em;'>";

if ( $MESAS_DE_BILLAR==0 ) {
echo '<option value="Zero" selected>No</option>';
echo '<option value="1">1</option>'; echo '<option value="2">2</option>'; echo '<option value="3">3</option>'; echo '<option value="4">4</option>'; echo '<option value="5">5</option>'; echo '<option value="6">6</option>'; echo '<option value="7">7</option>'; echo '<option value="8">8</option>'; echo '<option value="9">9</option>'; echo '<option value="10">10</option>'; echo '<option value="11">11</option>'; echo '<option value="12">12</option>'; echo '<option value="13">13</option>'; echo '<option value="14">14</option>'; echo '<option value="15">15</option>'; echo '<option value="16">16</option>'; echo '<option value="17">17</option>'; echo '<option value="18">18</option>'; echo '<option value="19">19</option>'; echo '<option value="20">20</option>';
} else {
echo '<option value="'.$MESAS_DE_BILLAR.'">'.$MESAS_DE_BILLAR.'</option>';
echo '<option value="Zero">No</option>'; echo '<option value="1">1</option>'; echo '<option value="2">2</option>'; echo '<option value="3">3</option>'; echo '<option value="4">4</option>'; echo '<option value="5">5</option>'; echo '<option value="6">6</option>'; echo '<option value="7">7</option>'; echo '<option value="8">8</option>'; echo '<option value="9">9</option>'; echo '<option value="10">10</option>'; echo '<option value="11">11</option>'; echo '<option value="12">12</option>'; echo '<option value="13">13</option>'; echo '<option value="14">14</option>'; echo '<option value="15">15</option>'; echo '<option value="16">16</option>'; echo '<option value="17">17</option>'; echo '<option value="18">18</option>'; echo '<option value="19">19</option>'; echo '<option value="20">20</option>';
}
echo '</select>';

if ( $MESAS_DE_BILLAR==0 ) echo '<font size="1">&nbsp;&nbsp;Mesas de Billar</font>';
else echo '<font size="1" color="red"><b>&nbsp;&nbsp;Mesas de Billar</b></font>';

echo '<p> </p>';

echo "<select name='musica_grabada_y_aparatos_presupuesto' style='font-size: 0.8em;'>";


if ( $MUSICA_GRABADA_Y_APARATOS==0 ) {
echo '<option value="Zero" selected>No</option>';
echo '<option value="1">Si</option>';
} else {
echo '<option value="'.$MUSICA_GRABADA_Y_APARATOS.'" selected>Si</option>';
echo '<option value="Zero">No</option>';
}

echo '</select>';
if ( $MUSICA_GRABADA_Y_APARATOS==0 ) echo '<font size="1">&nbsp;&nbsp;Musica Grabada y Aparatos</font>';
else echo '<font size="1" color="red"><b>&nbsp;&nbsp;Musica Grabada y Aparatos</b></font>';

echo '<p> </p>';

echo "<select name='conjunto_musicales_presupuesto' style='font-size: 0.8em;'>";

if ( $CONJUNTO_MUSICALES==0 ) {
echo '<option value="Zero" selected>No</option>';
echo '<option value="1">Si</option>';
} else {
echo '<option value="'.$CONJUNTO_MUSICALES.'" selected>Si</option>';
echo '<option value="Zero">No</option>';
}

echo '</select>';
if ( $CONJUNTO_MUSICALES==0 ) echo '<font size="1">&nbsp;&nbsp;Conjunto Musicales</font>';
else echo '<font size="1" color="red"><b>&nbsp;&nbsp;Conjunto Musicales</b></font>';

echo '<p> </p>';

echo "<select name='espectaculos_artisticos_presupuesto' style='font-size: 0.8em;'>";

if ( $ESPECTACULOS_ARTISTICOS==0 ) {
echo '<option value="Zero" selected>No</option>';
echo '<option value="1">Si</option>';
} else {
echo '<option value="'.$ESPECTACULOS_ARTISTICOS.'" selected>Si</option>';
echo '<option value="Zero">No</option>';
}

echo '</select>';
if ( $ESPECTACULOS_ARTISTICOS==0 ) echo '<font size="1">&nbsp;&nbsp;Espectaculos Artisticos</font>';
else echo '<font size="1" color="red"><b>&nbsp;&nbsp;Espectaculos Artisticos</b></font>';

echo '</div>';
echo '</div>';
echo '</div>';


?>


<div class="modal-footer">
<!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>--!>
<button type="submit" class="btn btn-primary btn-sm" id="elegir_ServiciosAdicionales"  name="elegir_ServiciosAdicionales"  style="background-color:#661C32;color:white"> Actualizar Servicios Adicionales </button>
</div>

</form>
</div>
</div>
</div>
<?php
}
?>

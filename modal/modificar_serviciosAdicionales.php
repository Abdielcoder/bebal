
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
	<div class="modal fade" id="modificarServicioAdicional" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#661C32;color:white">
<!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--!>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i>  Servicios Adicionales</h6>
		  </div>
		  <div class="modal-body">
                        <form class="form-horizontal" method="post" id="modificar_ServiciosAdicionales" name="modificar_ServiciosAdicionales" action="aprobarPresupuestoCambio.php">


			<div id="resultados_ajaxGuardarServicioAdicional"></div>



<?php


echo '<input type="hidden"  name="idprincipal"  value="'.$IDPRINCIPAL.'">';
echo '<input type="hidden" name="id_proceso_tramites"  value="'.$id_proceso_tramites.'">';
echo '<input type="hidden" name="page"  value="'.$page.'">';
echo '<input type="hidden" name="folio"   value="'.$folio.'">';
echo '<input type="hidden" name="id_tramite" value="'.$ID_TRAMITE_SOLICITADO.'">';



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

$porcionesNOTA = explode("CHANG_SA", $NOTA_proceso_tramites);
$SA_seleccionado=trim($porcionesNOTA[1]);
##echo '<font size="1">'.$SA_seleccionado.'</font>';
##   **10--MesasdeBillar****1--PistadeBaile****1--MusicaGrabadayAparatosMusicales****1--ConjuntoMusicales****0--EspectaculosArtisticos**
$porcionesITEMS = explode("****", $SA_seleccionado);
$CUENTA=count($porcionesITEMS);
##echo 'CUENTA='.$CUENTA;
#
for ( $i=0; $i<$CUENTA; $i++ ) {

$porcionesAtom = explode("--",$porcionesITEMS[$i]);
if ( $porcionesAtom[1]=='MesasdeBillar' ) {
$Numero_mesas_de_billar=$porcionesAtom[0];
$Numero_mesas_de_billar=str_replace("*","",$Numero_mesas_de_billar);
if ($Numero_mesas_de_billar==0) {
$Numero_mesas_de_billar_String='No';
$Numero_mesas_de_billar='Zero';
} else {
$Numero_mesas_de_billar_String=$Numero_mesas_de_billar;
$Numero_mesas_de_billar=$Numero_mesas_de_billar;
}
} 
##
if ( $porcionesAtom[1]=='PistadeBaile' ) {
$Numero_pista_de_baile=$porcionesAtom[0];
$Numero_pista_de_baile=str_replace("*","",$Numero_pista_de_baile);
if ($Numero_pista_de_baile==0 ) {
$Numero_pista_de_baile_String='No';
$Numero_pista_de_baile='Zero';
} else {
$Numero_pista_de_baile_String='Si';
$Numero_pista_de_baile='1';
}
}
##
if ( $porcionesAtom[1]=='MusicaGrabadayAparatosMusicales' ) {
$Numero_musica_grabada_y_aparatos_musicales=$porcionesAtom[0];
$Numero_musica_grabada_y_aparatos_musicales=str_replace("*","",$Numero_musica_grabada_y_aparatos_musicales);
if  ( $Numero_musica_grabada_y_aparatos_musicales==0 ) {
$Numero_musica_grabada_y_aparatos_musicales_String='No';
$Numero_musica_grabada_y_aparatos_musicales='Zero';
} else {
$Numero_musica_grabada_y_aparatos_musicales_String='Si';
$Numero_musica_grabada_y_aparatos_musicales='1';
}
}
##
if ( $porcionesAtom[1]=='ConjuntoMusicales' ) {
$Numero_conjunto_musicales=$porcionesAtom[0];
$Numero_conjunto_musicales=str_replace("*","",$Numero_conjunto_musicales);
if ($Numero_conjunto_musicales==0 ) {
$Numero_conjunto_musicales_String='No';
$Numero_conjunto_musicales='Zero';
} else {
$Numero_conjunto_musicales_String='Si';
$Numero_conjunto_musicales='1';
}
}
##
if ( $porcionesAtom[1]=='EspectaculosArtisticos**' ) {
$Numero_espectaculos_artisticos=$porcionesAtom[0];
$Numero_espectaculos_artisticos=str_replace("*","",$Numero_espectaculos_artisticos);
if ($Numero_espectaculos_artisticos==0) {
$Numero_espectaculos_artisticos_String='No';
$Numero_espectaculos_artisticos='Zero';
} else {
$Numero_espectaculos_artisticos_String='Si';
$Numero_espectaculos_artisticos='1';
}
}




}


##//echo '<font size="1" color="blue">Pistas de Baile: '.$PISTA_DE_BAILE.',  Mesas de Billar: '.$MESAS_DE_BILLAR.', Musica Grabada y Aparatos: '.$MUSICA_GRABADA_Y_APARATOS.', Conjunto Musicales: '.$CONJUNTO_MUSICALES.' y  Espectaculos Artisticos: '.$ESPECTACULOS_ARTISTICOS.'</font><br>';

echo '<div class="form-group">';
#echo '<div class="form-group row">';
##echo '<label for="serviciosAdicionales" class="col-sm-3 control-label"><font size="2">Servicios Adicionales</font></label>';
echo '<label for="id_serviciosA" class="col-sm-3 control-label"><font size="2">Servicios Adicionales</font></label>';



echo '<div class="col-sm-8" style="background-color:#f4f0ec;color:black;">';

echo "<select name='pista_de_baile' style='font-size: 0.8em;'>";
echo '<option value="'.$Numero_pista_de_baile.'" selected>'.$Numero_pista_de_baile_String.'</option>';

echo '</select>';
echo '<font size="1"><b>&nbsp;&nbsp;Pista de Baile</b></font>';

echo '<br><br>';

echo "<select name='numero_mesas_de_billar' style='font-size: 0.8em;'>";
echo '<option value="'.$Numero_mesas_de_billar.'" selected>'.$Numero_mesas_de_billar_String.'</option>';
echo '</select>';

echo '<font size="1"><b>&nbsp;&nbsp;Mesas de Billar</b></font>';

echo '<p> </p>';

echo "<select name='musica_grabada_y_aparatos' style='font-size: 0.8em;'>";
echo '<option value="'.$Numero_musica_grabada_y_aparatos_musicales.'" selected>'.$Numero_musica_grabada_y_aparatos_musicales_String.'</option>';
echo '</select>';
echo '<font size="1"><b>&nbsp;&nbsp;Musica Grabada y Aparatos</b></font>';

echo '<p> </p>';

echo "<select name='conjunto_musicales' style='font-size: 0.8em;'>";
echo '<option value="'.$Numero_conjunto_musicales.'" selected>'.$Numero_conjunto_musicales_String.'</option>';
echo '</select>';
echo '<font size="1"><b>&nbsp;&nbsp;Conjunto Musicales</b></font>';

echo '<p> </p>';

echo "<select name='espectaculos_artisticos' style='font-size: 0.8em;'>";
echo '<option value="'.$Numero_espectaculos_artisticos.'" selected>'.$Numero_espectaculos_artisticos_String.'</option>';
echo '</select>';
echo '<font size="1"><b>&nbsp;&nbsp;Espectaculos Artisticos</b></font>';

echo '</div>';
echo '</div>';
echo '</div>';


?>


<div class="modal-footer">
<!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>--!>
<button type="submit" class="btn btn-primary btn-sm" id="Buttonmodificar_ServiciosAdicionales"  name="Buttonmodificar_ServiciosAdicionales"  style="background-color:#661C32;color:white"> Actualizar Servicios Adicionales </button>
</div>

</form>
</div>
</div>
</div>
<?php
}
?>

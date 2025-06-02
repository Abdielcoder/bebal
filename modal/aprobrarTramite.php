	<?php
		if (isset($con))
		{
$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	?>
	<!-- Modal -->
	<div class="modal fade" id="aprobrarTramite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
		<div class="modal-content">
<div class="modal-header"  style="background-color:#AC905B;color:white">


<!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--!>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Aprobrar Tramite</h6>
		  </div>
		  <div class="modal-body"   style="background-color:#FFFFFF;color:black">

			<form class="form-horizontal" method="post" id="aprobrarTramitePost" name="aprobrarTramitePost">

			<div id="resultados_ajaxaprobrarTramite"></div>


<input type="hidden" id="mod_folio" name="folio">

<input type="hidden" id="mod_idprincipal" name="IDPRINCIPAL">
<input type="hidden" id="mod_pagina" name="page">

<input type="hidden" id="mod_id_tramite_solicitado" name="id_tramite_solicitado">
<input type="hidden" id="mod_tramite_solicitado" name="tramite_solicitado">

<input type="hidden" id="mod_cambio_giro_solicitado" name="cambio_giro_solicitado">
<input type="hidden" id="mod_cambio_de_giro" name="cambio_de_giro">
<input type="hidden" id="mod_monto_umas_tramite_solicitado" name="monto_umas_tramite_solicitado">

<input type="hidden" id="mod_descripcion_tramite_solicitado" name="descripcion_tramite_solicitado">
<input type="hidden" id="mod_cambio_id_giro_solicitado" name="cambio_id_giro_solicitado">
<input type="hidden" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento">
<input type="hidden" id="mod_cambio_de_sa" name="cambio_de_sa">
<input type="hidden" id="mod_servicios_adicionales_agregados" name="servicios_adicionales_agregados">
<input type="hidden" id="mod_servicios_adicionales_agregados_raw" name="servicios_adicionales_agregados_raw">
<input type="hidden" id="mod_servicios_adicionales_total" name="servicios_adicionales_total">
<input type="hidden" id="mod_servicios_adicionales_total_raw" name="servicios_adicionales_total_raw">

<?php
echo '<font size="2">Establecimiento: </font><font size="2" color="blue">'.$nombre_comercial_establecimiento.'</font><br>';
echo '<font size="2">Folio: </font><font size="2" color="blue">'.$folio.'</font><br>';
echo '<font size="2">Tramite Solicitado: </font><font size="2" color="blue">'.$TRAMITE_tramite_SOLICITADO.' ( </font><font size="2" color="red">'.number_format($MONTO_UMAS_tramite_SOLICITADO,2).' umas</font><font size="2" color="blue">)</font><br>';
echo '<br>';
##
$kuery00="SELECT COUNT(*) AS CUENTA00 FROM pagos WHERE id_principal=$IDPRINCIPAL  AND concepto='Inspeccion' AND estatus_pago='PAGADO'";
$arreglo_INS00=mysqli_fetch_array(mysqli_query($con,$kuery00));
$CUENTA00=$arreglo_INS00['CUENTA00'];
if ( $CUENTA00>0 ) {
$kuery800="SELECT * FROM pagos WHERE id_principal=$IDPRINCIPAL  AND concepto='Inspeccion' AND estatus_pago='PAGADO'  ORDER by ID DESC LIMIT 1";
$arreglo_INS800=mysqli_fetch_array(mysqli_query($con,$kuery800));
$FECHA_PAGO_INS=$arreglo_INS800['fecha_pago'];
$CONCEPTO_PAGO_INS=$arreglo_INS800['concepto_pago'];
echo '<font color="red" size="2"><i class="bi bi-currency-dollar"></i></font><font color="black" size="1">  Pago de Inspeccion - Fecha Pago ('.$FECHA_PAGO_INS.') '.$CONCEPTO_PAGO_INS.'</font><br>';
} else {
echo '<font color="black" size="2"><i class="bi bi-sign-no-parking"></i>   No existe Pago de Inspeccion.</font><br>';
}
#
##
$kuery000="SELECT COUNT(*) AS CUENTA000 FROM pagos WHERE id_principal=$IDPRINCIPAL  AND concepto='Recepcion y Analisis Documentos' AND estatus_pago='PAGADO'";
$arreglo_RAD00=mysqli_fetch_array(mysqli_query($con,$kuery000));
$CUENTA000=$arreglo_RAD00['CUENTA000'];
if ( $CUENTA000>0 ) {
$kuery8000="SELECT * FROM pagos WHERE id_principal=$IDPRINCIPAL  AND concepto='Recepcion y Analisis Documentos' AND estatus_pago='PAGADO'  ORDER by ID DESC LIMIT 1";
$arreglo_RAD8000=mysqli_fetch_array(mysqli_query($con,$kuery8000));
$FECHA_PAGO_RAD=$arreglo_RAD8000['fecha_pago'];
$CONCEPTO_PAGO_RAD=$arreglo_RAD8000['concepto_pago'];
echo '<font color="red" size="2"><i class="bi bi-currency-dollar"></i></font><font color="black" size="1">  Pago de Recepción y Analisis Documentos - Fecha Pago ('.$FECHA_PAGO_RAD.') '.$CONCEPTO_PAGO_RAD.'</font><br>';
} else {
echo '<font color="black" size="2"><i class="bi bi-sign-no-parking"></i>   No existe Pago de Rcepción y Analisis Documentos.</font><br>';
}
#

//<div class="form-group row">
//<label for="mod_monto_umas_tramite_solicitado" class="col-sm-3 control-label">Monto UMAS</label>
//<div class="col-sm-8">
//<input type="text" class="form-control" id="mod_monto_umas_tramite_solicitado" name="mod_monto_umas_tramite_solicitado" disabled>
//</div>
//</div>
?>

<br>

<div class="alert alert-info">
<i class="bi bi-info-circle"></i><font size="1"><b> Asegúrese de que el Contribuyente Conoce el Presupuesto para el Trámite.</b></font>
</div>


<?php

if ( $presupuestoConstancia>0 ) echo '<font color="red" size="2">Está Información fue tomada de los datos Propuesta Constancia.</font><br>';
echo '<font color="red" size="2"><b><u>Datos para la orden de Pago:</u></b></font><br>';

echo '<font size="2">Nombre Persona Fisica/Moral: </font><font size="2" color="blue">'.$NOMBRE_PERSONA_FISICAMORAL_SOLICITANTEConstancia.'</font><br>';
echo '<font size="2">Representante Legal: </font><font size="2" color="blue">'.$NOMBRE_REPRESENTANTE_SOLICITANTEConstancia.'</font><br>';
echo '<font size="2">RFC: </font><font size="2" color="blue">'.$RFCConstancia.'  ( '.$FISICA_O_MORALConstancia.' )</font><br>';
echo '<font size="2">Domicilio: </font><font size="2" color="blue">'.$DOMICILIO_SOLICITANTEConstancia.'</font><br>';
echo '<font size="2">Email: </font><font size="2" color="blue">'.$EMAIL_SOLICITANTEConstancia.'</font><font size="2">, Telefono: </font><font size="2" color="blue">'.$TELEFONO_SOLICITANTEConstancia.'</font><br>';
echo '<font size="2">Número Permiso Anterior: </font><font size="2" color="blue">'.$NUMERO_PERMISO_ANTERIOR.'</font><br>';
echo '<font size="2">Número Permiso Nuevo: </font><font size="2" color="blue">'.$NUMERO_PERMISO_NUEVO.'</font><br>';
echo '<font size="2">concepto_recaudacion: </font><font size="2" color="blue">'.$concepto_recaudacion.'</font><br>';

##
echo '<input type="hidden" name="nombre_persona_fisicamoral_solicitante" value="'.$NOMBRE_PERSONA_FISICAMORAL_SOLICITANTEConstancia.'">';
echo '<input type="hidden" name="nombre_representante_legal_solicitante" value="'.$NOMBRE_REPRESENTANTE_SOLICITANTEConstancia.'">';
echo '<input type="hidden" name="rfc" value="'.$RFCConstancia.'">';
echo '<input type="hidden" name="fisica_o_moral" value="'.$FISICA_O_MORALConstancia.'">';
echo '<input type="hidden" name="domicilio_solicitante"value="'.$DOMICILIO_SOLICITANTEConstancia.'">';
echo '<input type="hidden" name="telefono_solicitante" value="'.$EMAIL_SOLICITANTEConstancia.'">';
echo '<input type="hidden" name="email_solicitante" value="'.$TELEFONO_SOLICITANTEConstancia.'">';

echo '<input type="hidden" name="concepto_recaudacion" value="'.$concepto_recaudacion.'">';
echo '<input type="hidden" name="numero_permiso_anterior" value="'.$NUMERO_PERMISO_ANTERIOR.'">';
echo '<input type="hidden" name="numero_permiso_nuevo" value="'.$NUMERO_PERMISO_NUEVO.'">';
echo '<input type="hidden" name="presupuestoConstancia" value="'.$presupuestoConstancia.'">';


?>


<div class="mb-3">
<label for="message-text" class="col-form-label"><font size="2"><b>Campo Memo: </b></font></label>
<textarea class="form-control" name="memo" rows="3"></textarea>
</div>



</div>
 <div class="modal-footer">
<!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>--!>
<button type="submit" class="btn btn-primary" id="Button_aprobrarTramite"> <font size="2">Aprobar Trámite </font></button>
  </div>
  </form>
<p><font color="white" size="1">modal/aprobrarTramite.php-(Button_aprobrarTramite)->ajax/aprobrarTramite.php</font></p>
 </div>
 </div>
</div>
	<?php
		}
	?>

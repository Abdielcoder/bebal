	<?php
		if (isset($con))
		{
$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	?>
	<!-- Modal -->
	<div class="modal fade" id="elegirTramitePresupuesto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
<div class="modal-header"  style="background-color:#AC905B;color:white">


			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-calculator'></i> Agregar Datos Constancia</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="elegir_tramitePresupuesto" name="elegir_tramitePresupuesto">


			<div id="resultados_ajaxElegirTramitePresupuesto"></div>



<?php

echo '<input type="hidden" name="id" value="'.$ID.'">';
echo '<input type="hidden" name="page" value="'.$page.'">';

echo '<font size="2">Establecimiento: </font><font size="2" color="blue">'.$nombre_comercial_establecimiento.'</font><br>';
echo '<font size="2">Folio: </font><font size="2" color="blue">'.$folio.'</font><br>';

?>


<br>

<div class="form-group row">
<?php
echo '<label for="ID_TRAMITE_SOLICITADO" class="col-sm-1 control-label"><font size="2">Seleccione Tramite</font></label>';
?>
<div class="col-sm-3">
<?php 
$query=mysqli_query($con,"SELECT * FROM tramite WHERE operacion='Cambio' ORDER BY operacion");

while($row=mysqli_fetch_array($query))	{

$id_tramite=$row['id'];
$descripcion_tramite=$row['descripcion_tramite'];
$monto_umas=$row['monto_umas'];
$descuento=$row['descuento'];

echo '<input type="checkbox" name="TRAMITES[]" value="'.$id_tramite.'**'.$descripcion_tramite.'**'.$monto_umas.'**">&nbsp; <font size="1">'.$descripcion_tramite.'</font><br>';
}


##mysqli_close($con);

echo '</select>';
echo '</div>';
#######3

echo '<div class="col-sm-8">';

echo '<h4><span style="background:black"><font color="white" size="3">Datos del Solicitante</font></span></h4>';
##

### Nombre Persona Fisica/Moral
echo '<div class="form-group row">';
echo '<label for="nombre_persona_fisicamoral_solicitante" class="col-sm-2 control-label"><font size="1">Nombre Persona Fisica/Morali</font></label>';
echo '<div class="col-sm-5"  style="background-color:#f4f0ec;color:black;">';
echo '<input type="text" class="form-control" style="text-transform:uppercase" id="nombre_persona_fisicamoral_solicitante" name="nombre_persona_fisicamoral_solicitante" required>';
echo '</div>';
//##
//echo '<label for="fisica_o_moral" class="col-sm-1 control-label">Persona</label>';
echo '<div class="col-sm-3">';
echo '<select name="fisica_o_moral" id="fisica_o_moral"  class="form-control form-select" required>';
echo '<option value="">Fisica o Moral</option>';
echo '<option value="Fisica">Fisica</option>';
echo '<option value="Moral">Moral</option>';
echo '</select>';

echo '</div>';
echo '</div>';
###

#####################
### Nombre Titular
echo '<div class="form-group row">';
echo '<label for="nombre_representante_legal_solicitante" class="col-sm-2 control-label"><font size="1">Nombre Representante Legal</font></label>';
echo '<div class="col-sm-5">';
echo '<input type="text" class="form-control" style="text-transform:uppercase" id="nombre_representante_legal_solicitante" name="nombre_representante_legal_solicitante" required>';
echo '</div>';
//##
echo '<label for="rfc_solicitante" class="col-sm-1 control-label"><font size="1">RFC</font></label>';
echo '<div class="col-sm-3">';
echo '<input type="text" class="form-control title="Enter RFC"" pattern="^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([A-Z\d]{3})?$" title="Enter RFC"  id="rfc_solicitante" name="rfc_solicitante" utocomplete="off"  required>';
echo '</div>';
echo '</div>';
#####################
### Domicilio Solicitante
echo '<div class="form-group row">';
echo '<label for="domicilio_solicitante" class="col-sm-2 control-label"><font size="1">Domicilio Para Recibir Notificaciones</font></label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control" style="text-transform:uppercase"  id="domicilio_solicitante" name="domicilio_solicitante" required>';
echo '</div>';
echo '</div>';
###
echo '<div class="form-group row">';
echo '<label for="email_solicitante" class="col-sm-2 control-label"><font size="1">Email</font></label>';
echo '<div class="col-sm-4">';
echo '<input type="email" class="form-control" id="email_solicitante" name="email_solicitante" required>';
echo '</div>';
//##
echo '<label for="telefono_solicitante" class="col-sm-1 control-label"><font size="1">Teléfono</font></label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control" id="telefono_solicitante" name="telefono_solicitante" required>';
echo '</div>';
echo '</div>';
###




#
echo '</div>';

echo '<div class="form-group row">';
echo '<label for="observaciones" class="col-sm-2 control-label">Observaciones</label>';
echo '<div class="col-sm-8">';
echo '<textarea class="form-control" id="observaciones" name="observaciones"   maxlength="1000" ></textarea>';
echo '</div>';
echo '</div>';




##################
echo '</div>';
?>

			
</div>
 <div class="modal-footer">
<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>
<button type="submit" class="btn btn-primary" id="Button_elegir_tramitePresupuesto"> Aplica </button>
  </div>
<font size='1' color='white'>modal/elegirTramitePresupuesto.php-(Button_elegir_tramitePresupuesto)->ajax/agregar_TramitePresupuestoConstancia.php</font>
  </form>
 </div>
 </div>
</div>
	<?php
		}
	?>

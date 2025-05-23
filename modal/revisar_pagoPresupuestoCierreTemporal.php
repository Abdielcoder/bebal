<style>

.content_PP6 {
  background: #A4A5A8;
  color: #fff;
}

.content2_PP6 {
  background: #AC905B;
  color: #fff;
}

.content3_PP6 {
  background: #FF0000;
  color: #fff;
}


      .blink_PP6 {
        animation: blink-animation 1s steps(5, start) infinite;
        -webkit-animation: blink-animation 1s steps(5, start) infinite;
      }
      @keyframes blink-animation {
        to {
          visibility: hidden;
        }
      }
      @-webkit-keyframes blink-animation {
        to {
          visibility: hidden;
        }
      }
</style>


<script>

function procesando_PP6() {
  var element = document.getElementById("Respuesta_PP6");
  element.classList.remove("content2_PP6");
  element.classList.toggle("content_PP6");
  element.classList.toggle("blink_PP6");
document.getElementById("Respuesta_PP6").innerHTML = "Procesando Consulta Sistema Tesoreria .......";
}

function finalizado_PP6() {
document.getElementById("mensaje").innerHTML = "Finalizado";
}


function getRecibo_PP6(forma) {
var val=forma.numero_pago.value;

if (val === "") {
alert("Numero de Pago Vacio");
} else {
alert("Consultar Recibo Numero de Pago: "+val);
procesando_PP6();

setTimeout(() => {
$.ajax({
type: "POST",
url: "wsAyuntamientoTij/ws-ConsultaRecibo.php",
data:'referencia='+val,
//async : false,
timeout: 5000,
  success: function(data){
  //alert('success'+data);
  var xmlDoc = data;
  var mensajeX = xmlDoc.documentElement.getElementsByTagName("mensaje")[0];
  var mensaje = mensajeX.childNodes[0];
  var importeX = xmlDoc.documentElement.getElementsByTagName("importe")[0];
  var importe = importeX.childNodes[0];
  var idstatusX = xmlDoc.documentElement.getElementsByTagName("idstatus")[0];
  var idstatus = idstatusX.childNodes[0];

  //alert('mensaje: '+mensaje.nodeValue+', importe: '+importe.nodeValue);



  //document.getElementById("mensaje").innerHTML = mensaje.nodeValue;
  //document.getElementById("importe").innerHTML = importe.nodeValue;
  //document.getElementById("idstatus").innerHTML = idstatus.nodeValue;
  var Respuesta_PP6=mensaje.nodeValue+" $"+importe.nodeValue+" estatus ("+idstatus.nodeValue+")";

  var element = document.getElementById("Respuesta_PP6");
  element.classList.remove("blink_PP6");
  element.classList.toggle("content2_PP6");

  document.getElementById("Respuesta_PP6").innerHTML = Respuesta_PP6;
  },
error: function(){
  var element = document.getElementById("Respuesta_PP6");
  element.classList.remove("blink_PP6");
  element.classList.toggle("content3_PP6");

  document.getElementById("Respuesta_PP6").innerHTML = 'Fallo Consulta del Recibo de Pago';
  alert('Fallo Consulta del Recibo de Pago');
  }
});
}, 2000);
}
}
</script>


<?php
		if (isset($con))
		{
?>
	<!-- Modal -->
        <div class="modal fade" id="revisarPagoPresupuestoCierreTemporal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#AC905B;color:white">
			<h6 class="modal-title" id="revisarPagoLabel"><i class='bi bi-c-square'></i>  Pago Presupuesto Cierre Temporal</h6>
<!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>  --!>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="registro_guardar_pago_presupuestoTramiteCierreTemporal" name="registro_guardar_pago_presupuestoTramiteCierreTemporal">
			<div id="resultados_ajaxPagoPresupuestoTramiteCierreTemporal"></div>
<?php
echo '<input type="hidden" id="mod_idprincipal" name="idprincipal">';
echo '<input type="hidden" id="mod_folio" name="folio">';
echo '<input type="hidden" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento">';

echo '<input type="hidden" id="mod_id_proceso_tramites" name="id_proceso_tramites">';

//echo '<input type="hidden" id="mod_tramite_pagoid" name="tramite_pagoid">';
//echo '<input type="hidden" id="mod_id_pago_rad" name="id_pago_rad">';
//echo '<input type="hidden" id="mod_id_pago_ins" name="id_pago_ins">';

echo '<input type="hidden" id="mod_concepto_tramite" name="concepto_tramite">';
echo '<input type="hidden" id="mod_concepto_giro" name="concepto_giro">';
echo '<input type="hidden" id="mod_concepto_modalidad" name="concepto_modalidad">';
echo '<input type="hidden" id="mod_concepto_servicios_adicionales" name="concepto_servicios_adicionales">';
echo '<input type="hidden" id="mod_total_umas_pagar" name="total_umas_pagar">';

echo '<input type="hidden" id="mod_id_tramite" name="id_tramite">';


?>

<div class="mb-3 row">
<label for="mod_tramite_pago" class="col-sm-4 col-form-label">Tramite Pago</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_tramite_pago" name="tramite_pago"  disabled>
</div>
</div>

<?php
echo '<input type="hidden" id="mod_tramite_pago" name="tramite_pago">';
?>
<div class="mb-3 row">
<label for="mod_nombre_comercial_establecimiento" class="col-sm-4 col-form-label">Nombre Establecimiento</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_nombre_comercial_establecimiento" name="mod_nombre_comercial_establecimiento"  disabled>
</div>
</div>

<div class="mb-3 row">
<label for="mod_folio" class="col-sm-4 col-form-label">Folio</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_folio" name="mod_folio"  disabled>
</div>
</div>


<div class="mb-3 row">
<?php
echo '<div class="col-sm-4">';
echo '<label for="numero_pago" class="col-form-label"><font size="2">Número de Pago</font></label>';
echo '<a href="javascript:getRecibo_PP6(document.registro_guardar_pago_presupuestoTramiteCierreTemporal)" style="background-color:#000000;color:white"><font size="1">Consultar Recibo</font></a>';
echo '</div>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control" id="numero_pago" name="numero_pago" pattern="[2025]{4}[0-9]{11}"  title="Formato VALIDO -->  AAAANNNNNNNNNNN" minlength="15" maxlength="15" autocomplete="off"  required>';
echo '<div id="Respuesta_PP6" style="color:black;font-size:12px;"></div>';
echo '</div>';
echo '<div class="col-sm-2">';

?>
</div>
</div>



<div class="mb-3 row">
<label for="monto" class="col-sm-4 col-form-label">Monto</label>
<div class="col-sm-8">
<input type="number" class="form-control" step="0.01" id="monto" name="monto" required>
</div>
</div>

<div class="mb-3 row">
<label for="fecha_pago" class="col-sm-4 col-form-label">Fecha de Pago</label>
<div class="col-sm-8">

<?php
$today = date("Y-m-d");
echo '<input type="date" class="form-control" id="fecha_pago" value="'.$today.'"  name="fecha_pago" required>';
?>
</div>
</div>


			
</div>  <!-- modal-body --!>

<div class="modal-footer">
<!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button> --!>
<button type="submit" class="btn btn-primary" id="Button_registro_guardar_pago_presupuestoTramiteCierreTemporal"  style="background-color:#AC905B;color:black"> Registrar Pago Presupuesto</button>
</div>



		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

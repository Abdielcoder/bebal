<?php
include('ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado


error_reporting(0);
session_start();

	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	include("modal/recibo_Inspeccion.php");
	include("modal/revisar_pago.php");
	include("modal/eliminar_registro.php");
	include("modal/efectuar_inspeccion.php");

	$active_principal="active";
	$active_clientes="";
	$active_usuarios="";	
	$active_reportes="";


	$title="bebal";
	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>


    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
	
<div class="container">
<?php

#################################
if (isset($_GET['id'])) {
$IDPRINCIPAL=$_GET['id'];
$page=$_GET['page'];
} else {
$IDPRINCIPAL=$_POST['IDPRINCIPAL'];
$page=$_POST['page'];
}
#################################
#################################


$sqlPrincipal="SELECT * FROM principal WHERE id=".$IDPRINCIPAL;
$row = mysqli_fetch_array(mysqli_query($con,$sqlPrincipal));


					$principal_id=$row['id'];
					$folio=$row['folio'];

$nombre_comercial_establecimiento=$row['nombre_comercial_establecimiento'];
$calle_establecimiento=$row['calle_establecimiento'];
$entre_calles_establecimiento=$row['entre_calles_establecimiento'];
$numero_establecimiento=$row['numero_establecimiento'];
$numerointerno_local_establecimiento=$row['numerointerno_local_establecimiento'];
$cp_establecimiento=$row['cp_establecimiento'];
$nombre_persona_fisicamoral_solicitante=$row['nombre_persona_fisicamoral_solicitante'];
$nombre_representante_legal_solicitante=$row['nombre_representante_legal_solicitante'];
$domicilio_solicitante=$row['domicilio_solicitante'];
$email_solicitante=$row['email_solicitante'];
$telefono_solicitante=$row['telefono_solicitante'];

$id_giro=$row['giro'];
$id_modalidad_graduacion_alcoholica=$row['modalidad_graduacion_alcoholica'];


	$numero_permiso=$row['numero_permiso'];
	$estatus=$row['estatus'];
	$operacion=$row['operacion'];

	$observaciones=$row['observaciones'];
	$fecha_alta=$row['fecha_alta'];
	$id_municipio=$row['id_municipio'];
	$delegacion_id=$row['id_delegacion'];
	$colonia_id=$row['id_colonia'];
	$foto=$row['foto'];

##
$sql_giro="SELECT descripcion_giro FROM giro WHERE id=".$id_giro;
$result_giro = mysqli_query($con,$sql_giro);
$row_giro = mysqli_fetch_assoc($result_giro);
$GIRO=$row_giro['descripcion_giro'];
##
$sql_modalidad_graduacion_alcoholica="SELECT descripcion_modalidad_graduacion_alcoholica FROM modalidad_graduacion_alcoholica WHERE id=".$id_modalidad_graduacion_alcoholica;
$result_modalidad_graduacion_alcoholica = mysqli_query($con,$sql_modalidad_graduacion_alcoholica);
$row_modalidad_graduacion_alcoholica = mysqli_fetch_assoc($result_modalidad_graduacion_alcoholica);
$MODALIDAD_GA=$row_modalidad_graduacion_alcoholica['descripcion_modalidad_graduacion_alcoholica'];
##
$sql_municipio="SELECT municipio FROM municipio WHERE id=".$id_municipio;
$result_municipio = mysqli_query($con,$sql_municipio);
$row_municipio = mysqli_fetch_assoc($result_municipio);
$MUNICIPIO=$row_municipio['municipio'];
##
$sql_delegacion="SELECT delegacion FROM delegacion WHERE id=".$delegacion_id;
$result_delegacion = mysqli_query($con,$sql_delegacion);
$row_delegacion = mysqli_fetch_assoc($result_delegacion);
$DELEGACION=$row_delegacion['delegacion'];
##
$sql_colonia="SELECT colonia FROM colonias WHERE id=".$colonia_id;
$result_colonia = mysqli_query($con,$sql_colonia);
$row_colonia = mysqli_fetch_assoc($result_colonia);
$COLONIA=$row_colonia['colonia'];
##


echo '<table width="90%" align="center"><tr>';
echo "<td align='center'><h6>PROGRAMA DE IDENTIFICACIÓN, EMPADRONAMIENTO, REGULARIZACIÓN Y REVALIDACIÓN DE ESTABLECIMIENTOS QUE EXPIDEN Y VENDEN AL PÚBLICO, EN ENVASE CERRADO Y ABIERTO, BEBIDAS CON CONTENIDO ALCOHÓLICO</h4></td>";
echo '</tr></table>';

echo '<table width="90%" align="center"><tr>';
echo "<td align='center' bgcolor='#AC905B'><h4>Datos del Establecimiento</h4></td>";
echo '</tr></table>';

echo '<table width="90%" align="center"><tr>';
echo '<td width="10%" bgcolor="#f4f0ec"><h5>Folio</h5></td>';
echo "<td width='10%'><h5>".$folio."</h5></td>";
echo '<td width="10%" bgcolor="#f4f0ec"><h5>Giro</h5></td>';
echo "<td width='20%'><h5>".$GIRO."</h5></td>";
echo '<td width="25%" bgcolor="#f4f0ec"><h5>Modalidad Graduación Alcohólica</h5></td>';
echo "<td width='25%'><h5>".$MODALIDAD_GA."</h5></td>";
echo '</tr></table>';

echo '<table width="90%" align="center"><tr>';
echo '<td width="20%" bgcolor="#dcdcdc"><h5>Nombre Comercial</h5></td>';
echo "<td><h5><B>".$nombre_comercial_establecimiento."</B></h5></td>";
echo '</tr></table>';

echo '<table width="90%" align="center"><tr>';
echo '<td width="20%" bgcolor="#f4f0ec"><h5>Domicilio</h5></td>';
echo "<td><h5>".$calle_establecimiento." #".$numero_establecimiento." ".$numerointerno_local_establecimiento."</h5></td>";
echo '<td width="5%" bgcolor="#f4f0ec"><h5>CP</h5></td>';
echo "<td width='10%'><h5>".$cp_establecimiento."</h5></td>";
echo '</tr></table>';

echo '<table width="90%" align="center"><tr>';
echo '<td width="10%" bgcolor="#dcdcdc"><h5>Colonia</h5></td>';
echo "<td width='20%'><h5>".$COLONIA."</h5></td>";
echo '<td width="15%" bgcolor="#dcdcdc"><h5>Delegación</h5></td>';
echo "<td width='20%'><h5>".$DELEGACION."</h5></td>";
echo '<td width="15%" bgcolor="#dcdcdc"><h5>Ciudad</h5></td>';
echo "<td width='20%'><h5>".$MUNICIPIO."</h5></td>";
echo '</tr></table>';
##############################

echo '<br>';
echo '<table width="90%" align="center"><tr>';
echo "<td align='center' bgcolor='#AC905B'><h4>Datos del Solicitante</h4></td>";
echo '</tr></table>';

echo '<table width="90%" align="center"><tr>';
echo '<td width="20%" bgcolor="#dcdcdc"><h5>Persona Fisica/Moral</h5></td>';
echo "<td><h5>".$nombre_persona_fisicamoral_solicitante."</h5></td>";
echo '</tr></table>';

echo '<table width="90%" align="center"><tr>';
echo '<td width="20%" bgcolor="#f4f0ec"><h5>Representante Legal</h5></td>';
echo "<td><h5>".$nombre_representante_legal_solicitante."</h5></td>";
echo '</tr></table>';

echo '<table width="90%" align="center"><tr>';
echo '<td width="20%" bgcolor="#dcdcdc"><h5>Domicilio</h5></td>';
echo "<td><h5>".$domicilio_solicitante."</h5></td>";
echo '</tr></table>';

echo '<table width="90%" align="center"><tr>';
echo '<td width="10%" bgcolor="#f4f0ec"><h5>Email</h5></td>';
echo "<td width='40%'><h5>".$email_solicitante."</h5></td>";
echo '<td width="10%" bgcolor="#f4f0ec"><h5>Telefono</h5></td>';
echo "<td width='40%'><h5>".$telefono_solicitante."</h5></td>";
echo '</tr></table>';

echo '<br>';

echo '<table width="90%" align="center"><tr>';
echo '<td width="10%" bgcolor="#997a8d"><h5><font color=white>Estatus</font></h5></td>';
echo "<td width='25%'><h5>".$estatus."</h5></td>";
echo '<td width="15%" bgcolor="#997a8d"><h5><font color=white>Operación</font></h5></td>';
echo "<td width='20%'><h5>".$operacion."</h5></td>";
echo '<td width="10%" bgcolor="#997a8d"><h5><font color=white>Fecha Alta</font></h5></td>';
echo "<td width='10%'><h5>".$fecha_alta."</h5></td>";
echo '</tr></table>';


echo '<table width="90%" align="center"><tr>';
echo '<td><font size="1">';
echo "Mediante Acuerdo del Cabildo de fecha once de diciembre del dos mil veinticuatro en el punto de acuerdo número VI.3, se autoriza a la Secretaría de Gobierno Municipal para que instrumente el programa de identificación, empadronamiento y regularización de la situación jurídica y administrativa de las personas físicas o morales que se dediquen a la expedición y venta, en envase cerrado y abierto, de bebidas con contenido alcohólico, a fin de que se actualice su situación jurídica. Para cumplir con los objetivos del programa, por medio de la presente, se autoriza la recepción de documentos del solicitante para revisión de su expediente y posterior determinación. Este documento no implica que se vaya a expedir un permiso nuevo y/o autorizar la regularización de uno previo, situación que se le informa al solicitante y acepta de conformidad, firmando al calce.";
echo '</font></td>';
echo '</tr></table>';


echo '<br>';
echo '<FORM action="principal.php" name="ir_aPrincipal" method="POST">';
echo '<input type="hidden" name="pagina" value="'.$page.'">';

echo '<button class="btn btn-default" name="ir_aPrincipal" type="submit" title="Regresar" class="button" style="color:black;" /><i class="glyphicon glyphicon-arrow-left"></i><font color="black">&nbsp;&nbsp;Regresar</font></button>';

echo '&nbsp;&nbsp;';

// Eliminar el botón de PDF y modificar el botón HTML para hacerlo más prominente
echo '<a href="generar_pdf_html.php?id='.$IDPRINCIPAL.'" target="_blank" class="btn btn-success"><i class="glyphicon glyphicon-file"></i> Generar Recibo</a>';

echo '&nbsp;&nbsp;';

if ( $estatus=='Generar Recibo Inspeccion'  ) {
echo '<a href="#reciboInspeccion" data-toggle="modal" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'"  class="btn btn-warning" title="Imagen"> <i class="glyphicon glyphicon-print"></i> Imprimir Recibo </a>';

echo '&nbsp;&nbsp;';

echo '<a href="#revisarPago" data-toggle="modal" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" class="btn btn-info" title="Imagen"> <i class="glyphicon glyphicon-check"></i> Revisar Pago </a>';

echo '&nbsp;&nbsp;';

echo '<a href="#EliminarRegistro" data-toggle="modal" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'"  data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'"  class="btn btn-danger" title="Imagen"> <i class="glyphicon glyphicon-trash"></i> Eliminar Registro </a>';

} else {

if ( $estatus=='Efectuar Inspeccion'  ) {
echo '<a href="#EfectuarInspeccion" data-toggle="modal" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" class="btn btn-info" title="Imagen"> <i class="glyphicon glyphicon-check"></i> Registrar Inspección </a>';
} else {
}

}




echo "</FORM>";
echo '<br><br>';
?>	
</div>
		 
	<hr>
	<?php
	include("footer.php");
?>

  </body>
</html>

<script>


$( "#registro_guardar_pago" ).submit(function( event ) {
  $('#Button_registro_guardar_pago').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/registro_guardar_pago.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajaxPago").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajaxPago").html(datos);
			$('#Button_registro_guardar_pago').attr("disabled", true);
			window.setTimeout(function() {
				$(".alert").fadeTo(150, 0).slideUp(150, function(){
				$(this).remove();});
				location.replace('principal.php');
			}, 4000);

		  }
	});
  event.preventDefault();
})



$( "#registro_guardar_inspeccion" ).submit(function( event ) {
  $('#Button_registro_guardar_inspeccion').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/registro_guardar_inspeccion.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajaxInspeccion").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajaxInspeccion").html(datos);
			$('#Button_registro_guardar_inspeccion').attr("disabled", true);
			window.setTimeout(function() {
				$(".alert").fadeTo(150, 0).slideUp(150, function(){
				$(this).remove();});
				location.replace('principal.php');
			}, 4000);

		  }
	});
  event.preventDefault();
})


$('#reciboInspeccion').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Button that triggered the modal
	var nombre_comercial_establecimiento=button.data('nombre_comercial_establecimiento') // Extract info from data-* attributes
	var folio=button.data('folio')

	var modal = $(this)
	modal.find('.modal-body #mod_nombre_comercial_establecimiento').val(nombre_comercial_establecimiento)
	modal.find('.modal-body #mod_folio').val(folio)
})



$('#revisarPago').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) // Button that triggered the modal
var nombre_comercial_establecimiento=button.data('nombre_comercial_establecimiento') // Extract info from data-* attributes
var folio=button.data('folio')
var pagina=button.data('pagina')
var idprincipal=button.data('idprincipal')

var modal = $(this)
modal.find('.modal-body #mod_nombre_comercial_establecimiento').val(nombre_comercial_establecimiento)
modal.find('.modal-body #mod_folio').val(folio)
modal.find('.modal-body #mod_pagina').val(pagina)
modal.find('.modal-body #mod_idprincipal').val(idprincipal)
})


$('#EfectuarInspeccion').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) // Button that triggered the modal
var nombre_comercial_establecimiento=button.data('nombre_comercial_establecimiento') // Extract info from data-* attributes
var folio=button.data('folio')
var pagina=button.data('pagina')
var idprincipal=button.data('idprincipal')

var modal = $(this)
modal.find('.modal-body #mod_nombre_comercial_establecimiento').val(nombre_comercial_establecimiento)
modal.find('.modal-body #mod_folio').val(folio)
modal.find('.modal-body #mod_pagina').val(pagina)
modal.find('.modal-body #mod_idprincipal').val(idprincipal)
})


$('#EliminarRegistro').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) // Button that triggered the modal
var nombre_comercial_establecimiento=button.data('nombre_comercial_establecimiento') // Extract info from data-* attributes
var folio=button.data('folio')
var pagina=button.data('pagina')
var idprincipal=button.data('idprincipal')

var modal = $(this)
modal.find('.modal-body #mod_nombre_comercial_establecimiento').val(nombre_comercial_establecimiento)
modal.find('.modal-body #mod_folio').val(folio)
modal.find('.modal-body #mod_pagina').val(pagina)
modal.find('.modal-body #mod_idprincipal').val(idprincipal)
})

</script>



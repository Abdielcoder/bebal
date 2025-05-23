

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

<body>

<?php
include("head.php");
include("navbar.php");
	
################################
$total=0;

$ANO='2025';
$MES='05';

##AND DATE_FORMAT(CAST(fecha_fin as DATE), '%Y-%m')= '".$todayANO."-".$MES."'"

$KueryPT_Fin="SELECT * FROM `proceso_tramites` WHERE `id_tramite`=1 AND en_proceso='Fin' AND DATE_FORMAT(CAST(fecha_fin as DATE), '%Y-%m')= '".$ANO."-".$MES."'";

##$KueryPT_Fin="SELECT folio,numero_permiso,id FROM principal WHERE id IN ( SELECT id_principal FROM `proceso_tramites` WHERE `id_tramite`=1 AND en_proceso='Fin' );";

##echo $KueryPT_Fin."<br>";
$result0 = mysqli_query($con, $KueryPT_Fin);
$rows0 = mysqli_num_rows($result0);

echo '<font size="1">Registros Nuevos '.$rows0.', Mes '.$MES.', Ano '.$ANO.'<br><br>';

echo '<table width="90%" align="center">';
echo '<tr bgcolor="#AC905B">';
echo '<td><font size="1">Folio</td><td><font size="1">Número Permiso</font></td><td><font size="1">Giro</font></td><td><font size="1">Fecha</font></td><td><font size="1">Inspección</font></td><td><font size="1">RAD</font></td><td><font size="1">Presupuesto</font></td><td><font size="1">Total</font></td>';
echo '</tr>';
echo '<tbody>';
for ($jj=0;$jj<$rows0;$jj++) {
$rowPT_Fin= mysqli_fetch_array($result0,MYSQLI_NUM);

$ID_PROCESO_TRAMITES_Alta=$rowPT_Fin[0];
$ID_PRINCIPALdb=$rowPT_Fin[1];
$ID_TRAMITEdb=$rowPT_Fin[2];
$FECHA_INICIOdb=$rowPT_Fin[3];
$FECHA_FINdb=$rowPT_Fin[4];
$numero_permiso_db=$rowPT_Fin[6];
if ( empty($numero_permiso_db) || $numero_permiso_db==NULL || $numero_permiso_db=='' )  $numero_permiso_db='ND';

$subtotal=0;

echo '<tr>';

$sqlPrincipal="SELECT COUNT(*) AS CUENTA0 FROM principal WHERE id=".$ID_PRINCIPALdb;
$result_Cuenta0=mysqli_query($con,$sqlPrincipal);
$row_cuenta0 = mysqli_fetch_assoc($result_Cuenta0);
$CUENTA0=$row_cuenta0['CUENTA0'];
#
if ($CUENTA0 > 0) {
$sqlPrincipal="SELECT * FROM principal WHERE id=".$ID_PRINCIPALdb;
##echo $sqlPrincipal.'<br>';
$row = mysqli_fetch_array(mysqli_query($con,$sqlPrincipal));

$principal_id=$row['id'];
$folio=$row['folio'];
$id_giro=$row['giro'];
} else {
$folio='ND';
$id_giro=0;
$GIRO='ND';
}
##
echo '<td><font size="1">'.$folio.'</font></td><td><font size="1">'.$numero_permiso_db.'</font></td>';
$sql_giro="SELECT COUNT(*) FROM giro WHERE id=".$id_giro;
$result_Cuenta1=mysqli_query($con,$sql_giro);
if (mysqli_num_rows($result_Cuenta1) > 0) {
$sql_giro="SELECT * FROM giro WHERE id=".$id_giro;
$result_giro = mysqli_query($con,$sql_giro);
$row_giro = mysqli_fetch_assoc($result_giro);
$GIRO=$row_giro['descripcion_giro'];
} else {
$GIRO='ND';
}
echo '<td><font size="1">'.$GIRO.'</font></td><td><font size="1">'.$FECHA_FINdb.'</font></td>';
##
##$sql_tramite0="SELECT * FROM tramite WHERE id=".$ID_TRAMITEdb;
##echo $sql_tramite0.'<br>';
##$result_tramite0 = mysqli_query($con,$sql_tramite0);
##$row_tramite0 = mysqli_fetch_assoc($result_tramite0);
##$TRAMITE=$row_tramite0['descripcion_tramite'];
#############
$sql_Pagos_AltaINS="SELECT COUNT(*) AS CUENTA2 FROM pagos WHERE concepto='Inspeccion' AND id_proceso_tramites=".$ID_PROCESO_TRAMITES_Alta;
$result_Cuenta2=mysqli_query($con,$sql_Pagos_AltaINS);
$row_cuenta2 = mysqli_fetch_assoc($result_Cuenta2);
$CUENTA2=$row_cuenta2['CUENTA2'];
if ($CUENTA2 > 0) {
$sql_Pagos_AltaINS="SELECT * FROM pagos WHERE concepto='Inspeccion' AND id_proceso_tramites=".$ID_PROCESO_TRAMITES_Alta;
##echo $sql_Pagos_alta.'<br>';
$ArregloPago_AltaINS = mysqli_fetch_array(mysqli_query($con,$sql_Pagos_AltaINS));
if ( $montoINS=='' || $total_umas_pagarINS=='' ) {
$montoINS=0;
$total_umas_pagarINS=0;
} else {
$montoINS=$ArregloPago_AltaINS[5];
$total_umas_pagarINS = $ArregloPago_AltaINS[6];
}
} else {
$montoINS=0;
$total_umas_pagarINS=0;
}
echo '<td><font size="1">'.$montoINS.'</font></td>';
#############
$sql_Pagos_AltaRAD="SELECT COUNT(*) AS CUENTA3 FROM pagos WHERE concepto='Recepcion y Analisis Documentos' AND id_proceso_tramites=".$ID_PROCESO_TRAMITES_Alta;
$result_Cuenta3=mysqli_query($con,$sql_Pagos_AltaRAD);
$row_cuenta3 = mysqli_fetch_assoc($result_Cuenta3);
$CUENTA3=$row_cuenta3['CUENTA3'];
if ($CUENTA3 > 0) {
$sql_Pagos_AltaRAD="SELECT * FROM pagos WHERE concepto='Recepcion y Analisis Documentos' AND id_proceso_tramites=".$ID_PROCESO_TRAMITES_Alta;
##echo $sql_Pagos_alta.'<br>';
$ArregloPago_AltaRAD = mysqli_fetch_array(mysqli_query($con,$sql_Pagos_AltaRAD));
if ( $montoRAD=='' || $total_umas_pagarRAD=='' ) {
$montoRAD=0;
$total_umas_pagarRAD=0;
} else {
$montoRAD=$ArregloPago_AltaRAD[5];
$total_umas_pagarRAD=$ArregloPago_AltaRAD[6];
}
} else {
$montoRAD=0;
$total_umas_pagarRAD=0;
}
echo '<td><font size="1">'.$montoRAD.'</font></td>';
#############
$sql_Pagos_AltaPRES="SELECT COUNT(*) AS CUENTA4 FROM pagos WHERE concepto='Permiso Nuevo Presupuesto' AND id_proceso_tramites=".$ID_PROCESO_TRAMITES_Alta;
$result_Cuenta4=mysqli_query($con,$sql_Pagos_AltaPRES);
$row_cuenta4 = mysqli_fetch_assoc($result_Cuenta4);
$CUENTA4=$row_cuenta4['CUENTA4'];
if ($CUENTA4 > 0) {
$sql_Pagos_AltaPRES="SELECT * FROM pagos WHERE concepto='Permiso Nuevo Presupuesto' AND id_proceso_tramites=".$ID_PROCESO_TRAMITES_Alta;
##echo $sql_Pagos_AltaPRES.'<br>';
$ArregloPago_AltaPRES = mysqli_fetch_array(mysqli_query($con,$sql_Pagos_AltaPRES));
if ( $montoPRES=='' || $total_umas_pagarPRES=='' ) {
$montoPRES=0;
$total_umas_pagarPRES=0;
} else {
$montoPRES = $ArregloPago_AltaPRES[5];
$total_umas_pagarPRES = $ArregloPago_AltaPRES[6];
}
} else {
$montoPRES=0;
$total_umas_pagarPRES=0;
}
echo '<td><font size="1">'.$montoPRES.'</font></td>';
$subtotal=$montoINS+$montoRAD+$montoPRES;
$total=$subtotal+$total;
echo '<td><font size="1">'.$subtotal.'</font></td>';
###########################################################
echo '</tr>';
}

echo '</tbody>';
echo '</table>';

echo '<br>Total '.$total.'<br>';
	

##echo '<button type="button" onclick="window.location.href=\'principal.php?page='.$page.'&action=ajax\'" class="btn btn-info bs-sm" style="background-color:#FFFFFF; color:black !important;"> <i class="bi bi-arrow-left"></i><font size="1"> Regresar</font></button>';

?>

<br>
<br>
<br>
<hr>
<?php 

mysqli_close($con);

include("footer.php"); 

?>

</body>
</html>

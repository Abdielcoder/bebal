<?php

include_once('../config/db.php');
$_SESSION["conf"] = $conf;


$con = mysqli_connect($conf["host"], $conf["usuario"], $conf["contrasena"],$conf["basededatos"]);
if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
exit();
}


## E-XXYYDDDDDD
## XX ( Delegacion )
## YY ( Giro )
#####################
#####################

$folio=$_GET['folio'];
$user_id=$_GET['user_id'];
$id_principal=$_GET['id_principal'];

date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");
#################
$sqlPrincipal="SELECT * FROM principal WHERE id=".$id_principal;
$row=mysqli_fetch_array(mysqli_query($con,$sqlPrincipal));

$id_giro=$row['giro'];
$id_delegacion=$row['id_delegacion'];
#################
$arregloSiglasGiro=mysqli_fetch_array(mysqli_query($con,"SELECT  siglas  FROM giro WHERE id=$id_giro"));
$SIGLAS_GIRO=$arregloSiglasGiro[0];
echo 'SIGLAS_GIRO='.$SIGLAS_GIRO.'<br>';
##
$arregloSiglasDelegacion=mysqli_fetch_array(mysqli_query($con,"SELECT  siglas  FROM delegacion WHERE id=$id_delegacion"));
$SIGLAS_DELEGACION=$arregloSiglasDelegacion[0];
echo 'SIGLAS_DELEGACION='.$SIGLAS_DELEGACION.'<br>';
################
$id_giro_siglas=$id_giro.'-'.$SIGLAS_GIRO;
$id_delegacion_siglas=$id_delegacion.'-'.$SIGLAS_DELEGACION;

################
################
echo "SELECT  COUNT(*)  FROM `numero_permiso` WHERE folio='$folio' AND id_delegacion_siglas='$id_delegacion_siglas' AND id_giro_siglas='$id_giro_siglas' <br>";
$arregloCuenta=mysqli_fetch_array(mysqli_query($con,"SELECT  COUNT(*)  FROM `numero_permiso` WHERE folio='$folio' AND id_delegacion_siglas='$id_delegacion_siglas' AND id_giro_siglas='$id_giro_siglas'"));
$CUENTA=$arregloCuenta[0];
###############
##########
if ( $CUENTA>0 ) {
echo 'El Folio ya cuenta con un Numero de permiso<br>';
} else {

################
$NP='';
$siglas='E-'.$SIGLAS_GIRO.$SIGLAS_DELEGACION;
###############
$sql_INSERT="INSERT INTO numero_permiso (
folio,
id_principal,
user_id,
id_giro_siglas,
id_delegacion_siglas,
fecha ) VALUES (
'$folio',
$id_principal,
$user_id,
'$id_giro_siglas',
'$id_delegacion_siglas',
'$today')";

$query_new_insert = mysqli_query($con,$sql_INSERT);
if ($query_new_insert) {
$arregloMaxid = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `numero_permiso`"));
$ID=intval($arregloMaxid[0]);

$tamano=strlen($ID);

echo 'Tamano='.$tamano.'<br>';


switch ($tamano) {
    case 1:
	$NP=$siglas.'00000'.$ID;
	break;
    case 2:
        $NP=$siglas.'0000'.$ID;
	    break;
    case 3:
        $NP=$siglas.'000'.$ID;
	    break;
    case 4:
        $NP=$siglas.'00'.$ID;
	    break;
    case 5:
        $NP=$siglas.'0'.$ID;
	    break;
    case 6:
        $NP=$siglas.''.$ID;
	    break;
}

$Kuery_Update="UPDATE numero_permiso SET numero_permiso='$NP'  WHERE id=".$ID;
mysqli_query($con,$Kuery_Update);

}
}


?>

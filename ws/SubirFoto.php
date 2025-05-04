<?php
require 'jwt.php';
require 'database.php'; // Este archivo debería contener la conexión a la base de datos.

require '../config/db.php';


function Subir($IDPRINCIPAL, $id_municipio, $ID_PROCESO_TRAMITES,$estatus, $Archivo ) {
	global $conexionDB;
	
###
    $sqlEstatus="SELECT estatus FROM principal WHERE id=".$IDPRINCIPAL;
    $stmtEstatus = $conexionDB->prepare($sqlEstatus);
    $stmtEstatus->execute();
    $resultadoEstatus= $stmtEstatus->fetch();
    $principalESTATUS=$resultadoEstatus[0];
###

if ( $principalESTATUS=='RAD Realizado' || $principalESTATUS=='Pagos IRAD' ||  $principalESTATUS=='Pagos-IRAD-Cambio' ) {

include("../functions_hm.php");

    date_default_timezone_set('America/Los_Angeles');
    $todayAMD = date("Y-m-d");
    $today = date("Y-m-d H:i:s");
##
    $sql="INSERT INTO fotos (descripcion,idprincipal,id_proceso_tramites) VALUES ('Inserta Row, idprincipal=".$IDPRINCIPAL."',".$IDPRINCIPAL.",".$ID_PROCESO_TRAMITES.");";
    $stmtID = $conexionDB->prepare($sql);
    $stmtID->execute();
##
    $sqlMax="SELECT max(`idfoto`) FROM fotos";
    $stmtMax = $conexionDB->prepare($sqlMax);
    $stmtMax->execute();
    $resultadoMAX= $stmtMax->fetch();
    $nextidf=$resultadoMAX[0];
##

    $filename=$IDPRINCIPAL.'-'.$ID_PROCESO_TRAMITES.'-'.$nextidf.'.jpg';

        if ($_FILES["nuevafoto"]['type']!='image/jpeg') {
          ###
           $resultado="La foto debe estar en formato jpg";
           $queryUPDATE="UPDATE fotos SET descripcion='".$resultado.", idprincipal=".$IDPRINCIPAL."', idprincipal=0 WHERE idfoto=".$nextidf." AND idprincipal=".$IDPRINCIPAL;
           $stmt = $conexionDB->prepare($queryUPDATE);
           $stmt->execute();
	   ##if (!$stmt) echo mysqli_error();
           ##if (!mysqli_query($con,$queryUPDATE)) echo mysqli_error();
          ###
        } 
        else if (($size=getimagesize($_FILES["nuevafoto"]['tmp_name']))==NULL) {
          ###
          $resultado="Error el archivo es NULL";
          $queryUPDATE="UPDATE fotos SET descripcion='".$resultado.", idprincipal=".$IDPRINCIPAL."', idprincipal=0 WHERE idfoto=".$nextidf." AND idprincipal=".$IDPRINCIPAL;
           $stmt = $conexionDB->prepare($queryUPDATE);
           $stmt->execute();
           ##if (!$stmt) echo mysqli_error();
           ##if (!mysqli_query($con,$queryUPDATE)) echo mysqli_error();
          ###
        }
        else if (($size[0]<640) OR ($size[1]<480)) {
          ###
           $resultado="Imagen con poca resolución. Imagen actual: ".$size[0]."x".$size[1]."px. Mínimo 640x480px";
           $queryUPDATE="UPDATE fotos SET descripcion='".$resultado.", idprincipal=".$IDPRINCIPAL."', idprincipal=0 WHERE idfoto=".$nextidf." AND idprincipal=".$IDPRINCIPAL;
           $stmt = $conexionDB->prepare($queryUPDATE);
           $stmt->execute();
           ##if (!$stmt) echo mysqli_error();
           ##if (!mysqli_query($con,$queryUPDATE)) echo mysqli_error();
          ###
        }
        else if (!move_uploaded_file($_FILES["nuevafoto"]['tmp_name'],'../../'.FOTOSORIGINALES.$filename)) {
                // echo FOTOSORIGINALES.$filename;
                ###
                 $resultado='../../'.FOTOSORIGINALES.$filename."Error al subir la foto";
                 $queryUPDATE="UPDATE fotos SET descripcion='".$resultado.", idprincipal=".$IDPRINCIPAL."', idprincipal=0 WHERE idfoto=".$nextidf." AND idprincipal=".$IDPRINCIPAL;
                $stmt = $conexionDB->prepare($queryUPDATE);
                $stmt->execute();
                 ##if (!mysqli_query($con,$queryUPDATE)) echo mysqli_error();
                ###
                }
        else {
        superscaleimage('../../'.FOTOSORIGINALES.$filename,'../../'.FOTOSMEDIAS.$filename,ANCHOMEDIO,ALTOMEDIO,95);
        // echo '<img src="'.FOTOSMEDIAS.$filename.'">';
        superscaleimage('../../'.FOTOSORIGINALES.$filename,'../../'.FOTOSTHUMB.$filename,ANCHOTHUMB,ALTOTHUMB,95);
        // echo '<img src="'.FOTOSTHUMB.$filename.'">';

        // Grabarla en la base de datos
        // echo "** Next".$conector->next_table_id("fotos");
        $queryUPDATE="UPDATE fotos SET descripcion='OK' WHERE idfoto=".$nextidf." AND idprincipal=".$IDPRINCIPAL." AND id_proceso_tramites=".$ID_PROCESO_TRAMITES;
        $stmt = $conexionDB->prepare($queryUPDATE);
        $stmt->execute();
        ##if (!$stmt) echo mysqli_error();
$resultado='El Archivo se subio con Exito !!';
// Si hay una sola la establece como principal
$sqlFotosCuantosReg="SELECT COUNT(*) FROM fotos WHERE idprincipal=".$IDPRINCIPAL." AND id_proceso_tramites=".$ID_PROCESO_TRAMITES;
$stmtCuantos3 = $conexionDB->prepare($sqlFotosCuantosReg);
$stmtCuantos3->execute();
$resultadoCuantos3= $stmtCuantos3->fetch();
$rowsFotosCuantosReg=$resultadoCuantos3[0];

if ($rowsFotosCuantosReg==1) {
$sqlUpdate1="UPDATE principal SET foto='$nextidf' WHERE id=".$IDPRINCIPAL;
mysqli_query($con, $sqlUpdate1);
$stmt = $conexionDB->prepare($sqlUpdate1);
$stmt->execute();
}


}

} else {
$resultado='Error: El estatus no es el correcto !!! estatus actual='.$principalESTATUS;
}



    ##$conexionDBsaveh->close();

    return $resultado;

}

// Verificar el token antes de realizar cualquier acción
$headers = apache_request_headers();
$authHeader = $headers['Authorization'] ?? '';

if ($authHeader) {
    preg_match('/Bearer\s(\S+)/', $authHeader, $matches);
    if (isset($matches[1])) {
        $jwt = $matches[1];
        $decoded = decode_jwt($jwt);

        if ($decoded && $decoded['exp'] >= time()) {
	   // Token es válido, obtener los vehículos
	   //
################
       	    $id = $_POST['id'] ?? '';
            $id_municipio = $_POST['id_municipio'] ?? '';
            $id_proceso_tramites = $_POST['id_proceso_tramites'] ?? '';
            $estatus = $_POST['estatus'] ?? '';
            $Archivo = $_FILES['nuevafoto'] ?? '';
################
            if ( $ROWS = Subir($id, $id_municipio, $id_proceso_tramites,$estatus ,$Archivo) ) {
	      echo json_encode(['success' => true, 'data' => $ROWS,'message' => 'OK', 'errors' => null  ]);
	    } else {
		##header('HTTP/1.1 500 Internal Server Error');
		echo json_encode(['success' => false, 'data' => NULL, 'message' => 'HTTP/1.1 500 Internal Server Error', 'error' => 'Error al Consultar count_rows Tabla  '.$tabla ]);
	    }
	    ####
        } else {
            ##header('HTTP/1.1 401 Unauthorized');
	    echo json_encode(['success' => false, 'data' => NULL, 'message' => 'HTTP/1.1 401 Unauthorized', 'error' => 'Token NO Valido o Expirado' ]);
        }
    } else {
        ##header('HTTP/1.1 400 Bad Request');
	echo json_encode(['success' => false, 'data' => NULL, 'message' => 'HTTP/1.1 400 Bad Request', 'error' => 'Error en el Token Proporcionado' ]);
    }
} else {
    ##header('HTTP/1.1 400 Bad Request');
    echo json_encode(['success' => false, 'data' => NULL, 'message' => 'HTTP/1.1 400 Bad Request', 'error' => 'No Se Proporciono el Encabezado de Autorizacion' ]);
}
?>

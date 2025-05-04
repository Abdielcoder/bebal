<?php
require 'jwt.php';
require 'database.php'; // Este archivo debería contener la conexión a la base de datos.

// Función para obtener numero de Rows ($tabla) de la base de datos
function obtenerRows($id, $id_municipio, $id_proceso_tramites,$estatus, $superficie_establecimiento, $capacidad_comensales_personas, $latitud, $longitud ) {
	global $conexionDB;

    date_default_timezone_set('America/Los_Angeles');
    $todayAMD = date("Y-m-d");
    $today = date("Y-m-d H:i:s");
##
    $sql_UPDATE22="UPDATE inspeccion  SET superficie_establecimiento=".$superficie_establecimiento.", capacidad_comensales_personas=".$capacidad_comensales_personas.", en_proceso='FIN', fecha_fin='$todayAMD'  WHERE id_principal=".$id." AND id_proceso_tramites=".$id_proceso_tramites;
    $sql_UPDATE2="UPDATE inspeccion  SET superficie_establecimiento=".$superficie_establecimiento.", capacidad_comensales_personas=".$capacidad_comensales_personas.", fecha_fin='$todayAMD'  WHERE id_principal=".$id." AND id_proceso_tramites=".$id_proceso_tramites;
    $stmt = $conexionDB->prepare($sql_UPDATE2);
    $stmt->execute();
##
    ##
    ### Significa que ya se realizo el Revision y Analisis de Documentos a cerrar la Inspeccion y cambiar de estatus en tabla principal
    if ( $estatus=='RAD Realizado' ) {
    $sql_UPDATE11="UPDATE principal SET latitud='".$latitud."', longitud='".$longitud."', estatus='Presupuesto' WHERE id=".$id;
    $sql_UPDATE1="UPDATE principal SET latitud='".$latitud."', longitud='".$longitud."' WHERE id=".$id;
    }   
    ##
    if ( $estatus=='Pagos IRAD' ||  $estatus=='Pagos-IRAD-Cambio' ) {
    $sql_UPDATE11="UPDATE principal SET latitud='".$latitud."', longitud='".$longitud."', estatus='Inspeccion Realizada' WHERE id=".$id;
    $sql_UPDATE1="UPDATE principal SET latitud='".$latitud."', longitud='".$longitud."' WHERE id=".$id;
    }   
    $stmt = $conexionDB->prepare($sql_UPDATE1);
    $stmt->execute();
    ##
    $resultado= "Proceso : Inspeccion Registrada Exitosamente";

    $conexionDBsaveh=null;
    $conexionDB=null;
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
            $superficie_establecimiento = $_POST['superficie_establecimiento'] ?? '';
            $capacidad_comensales_personas = $_POST['capacidad_comensales_personas'] ?? '';
            $latitud = $_POST['latitud'] ?? '';
            $longitud = $_POST['longitud'] ?? '';
################
            if ( $ROWS = obtenerRows($id, $id_municipio, $id_proceso_tramites,$estatus ,$superficie_establecimiento, $capacidad_comensales_personas, $latitud, $longitud) ) {
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

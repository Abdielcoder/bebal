<?php
require 'jwt.php';
require 'database.php'; // Este archivo debería contener la conexión a la base de datos.

// Función para obtener numero de Rows ($tabla) de la base de datos
function obtenerRows($tabla, $id_municipio, $estatus) {
    global $conexionDB;
##
    $sql="SELECT COUNT(*) FROM ".$tabla." WHERE id_municipio=".$id_municipio;
    if ( $estatus!=NULL || $estatus!='' )
       $sql=$sql." AND estatus='".$estatus."'";
##
##echo json_encode(['sql' => $sql]);
    $stmt = $conexionDB->prepare($sql);
    $stmt->execute();
    $resultado= $stmt->fetchAll(PDO::FETCH_ASSOC);
    ##$filas = count($resultado);
    //### cerrar conexion PDO
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
       	    $tabla = $_POST['tabla'] ?? '';
            $id_municipio = $_POST['id_municipio'] ?? '';
            $estatus = $_POST['estatus'] ?? '';
################
            if ( $ROWS = obtenerRows($tabla, $id_municipio, $estatus) ) {
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

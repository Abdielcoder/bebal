<?php
// Archivo para eliminar documentos PDF

// Incluir archivos necesarios
include('is_logged.php'); // Verificar que el usuario esté logueado
require_once ("../config/db.php"); // Variables de configuración
require_once ("../config/conexion.php"); // Función que conecta a la base de datos

// Comprobar que se ha recibido el ID del PDF
if (!isset($_POST['id_pdf']) || empty($_POST['id_pdf'])) {
    echo json_encode(array(
        'success' => false,
        'message' => 'ID del PDF no proporcionado'
    ));
    exit;
}

$id_pdf = intval($_POST['id_pdf']);

// Obtener información del PDF antes de eliminarlo
$query = mysqli_query($con, "SELECT id_registro, nombre_archivo FROM documentos_pdf WHERE id = $id_pdf");

if (!$query) {
    echo json_encode(array(
        'success' => false,
        'message' => 'Error al consultar la base de datos: ' . mysqli_error($con)
    ));
    exit;
}

if (mysqli_num_rows($query) == 0) {
    echo json_encode(array(
        'success' => false,
        'message' => 'El documento PDF no existe'
    ));
    exit;
}

$row = mysqli_fetch_assoc($query);
$id_registro = $row['id_registro'];
$nombre_archivo = $row['nombre_archivo'];

// Ruta del archivo a eliminar
$ruta_archivo = "../uploads/pdfs/$id_registro/$nombre_archivo";

// Eliminar el registro de la base de datos
$delete_query = mysqli_query($con, "DELETE FROM documentos_pdf WHERE id = $id_pdf");

if (!$delete_query) {
    echo json_encode(array(
        'success' => false,
        'message' => 'Error al eliminar el registro: ' . mysqli_error($con)
    ));
    exit;
}

// Eliminar el archivo físico si existe
if (file_exists($ruta_archivo)) {
    if (!unlink($ruta_archivo)) {
        echo json_encode(array(
            'success' => true,
            'message' => 'El registro se eliminó de la base de datos, pero no se pudo eliminar el archivo físico'
        ));
        exit;
    }
}

// Comprobar si el directorio está vacío y eliminarlo si es así
$directorio = "../uploads/pdfs/$id_registro";
if (file_exists($directorio) && is_dir($directorio)) {
    $files = scandir($directorio);
    if (count($files) <= 2) { // Solo . y ..
        rmdir($directorio);
    }
}

echo json_encode(array(
    'success' => true,
    'message' => 'Documento PDF eliminado correctamente'
));
?> 
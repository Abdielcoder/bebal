<?php
// Archivo para procesar la subida de archivos PDF

// Incluir archivos necesarios
include('is_logged.php'); // Verificar que el usuario esté logueado
require_once ("../config/db.php"); // Variables de configuración
require_once ("../config/conexion.php"); // Función que conecta a la base de datos

// Comprobar que se han recibido los datos necesarios
if (!isset($_POST['id_registro']) || empty($_POST['id_registro']) ||
    !isset($_FILES['pdf_archivo']) || empty($_FILES['pdf_archivo']['name'])) {
    
    echo json_encode(array(
        'success' => false,
        'message' => 'Faltan datos requeridos'
    ));
    exit;
}

$id_registro = intval($_POST['id_registro']);
$pdf_archivo = $_FILES['pdf_archivo'];
$conjunto = $_POST['conjunto'];
$folio = $_POST['folio'];
$id_proceso_tramites = $_POST['id_proceso_tramites'];
$page = $_POST['page'];

// Verificar que el archivo es un PDF
$tipo_archivo = strtolower(pathinfo($pdf_archivo['name'], PATHINFO_EXTENSION));
if ($tipo_archivo != 'pdf') {
    echo json_encode(array(
        'success' => false,
        'message' => 'Solo se permiten archivos PDF'
    ));
    exit;
}

// Verificar tamaño máximo (20MB)
$max_size = 20 * 1024 * 1024; // 20MB en bytes
if ($pdf_archivo['size'] > $max_size) {
    echo json_encode(array(
        'success' => false,
        'message' => 'El archivo excede el tamaño máximo permitido (20MB)'
    ));
    exit;
}

// Crear directorio para los PDFs si no existe
$directorio_base = '../../bebal_docs';
if (!file_exists($directorio_base)) {
    mkdir($directorio_base, 0777, true);
}

$directorio_registro=$directorio_base;
if (!file_exists($directorio_registro)) {
    mkdir($directorio_registro, 0777, true);
}

// Generar nombre único para el archivo
//$nombre_archivo = uniqid() . '_' . time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '', $pdf_archivo['name']);
$nombre_archivo=$id_registro.'-'.$id_proceso_tramites.'-'.$conjunto.'.pdf';
$ruta_destino = $directorio_registro . '/' . $nombre_archivo;

// Mover el archivo subido al directorio destino
if (move_uploaded_file($pdf_archivo['tmp_name'], $ruta_destino)) {
    // Usar el nombre del archivo como descripción
    $nombre_original = $pdf_archivo['name'];
    
    // Guardar información en la base de datos
    ##$query = "INSERT INTO documentos_pdf (id_registro, descripcion, nombre_archivo) 
    ##VALUES ($id_registro, '$nombre_original', '$nombre_archivo')";


switch ($conjunto) {
  case "c1":
        $query="UPDATE proceso_tramites SET docs_pdf1='$nombre_archivo', estatus_docs_pdf1='OK'  WHERE id=$id_proceso_tramites AND id_principal=".$id_registro;
    break;
  case "c2":
        $query="UPDATE proceso_tramites SET docs_pdf2='$nombre_archivo', estatus_docs_pdf2='OK'  WHERE id=$id_proceso_tramites AND id_principal=".$id_registro;
    break;
  case "c3":
        $query="UPDATE proceso_tramites SET docs_pdf3='$nombre_archivo', estatus_docs_pdf3='OK'  WHERE id=$id_proceso_tramites AND id_principal=".$id_registro;
    break;
  case "c4":
        $query="UPDATE proceso_tramites SET docs_pdf4='$nombre_archivo', estatus_docs_pdf4='OK'  WHERE id=$id_proceso_tramites AND id_principal=".$id_registro;
    break;
}




    if (mysqli_query($con, $query)) {
        echo json_encode(array(
            'success' => true,
            'message' => 'Documento PDF subido correctamente',
            'pdf_id' => mysqli_insert_id($con),
            'ruta' => '../../bebal_docs/'.$nombre_archivo
        ));
    } else {
        // Si hay error en la inserción, eliminar el archivo
        unlink($ruta_destino);
        echo json_encode(array(
            'success' => false,
            'message' => 'Error al guardar en la base de datos: ' . mysqli_error($con)
        ));
    }
} else {
    echo json_encode(array(
        'success' => false,
        'message' => 'Error al subir el archivo'
    ));
}
?> 

<?php
// Archivo para obtener los PDFs asociados a un registro

// Incluir archivos necesarios
include('is_logged.php'); // Verificar que el usuario esté logueado
require_once ("../config/db.php"); // Variables de configuración
require_once ("../config/conexion.php"); // Función que conecta a la base de datos

// Comprobar que se recibió el ID del registro
if (!isset($_POST['id_registro']) || empty($_POST['id_registro'])) {
    echo json_encode(array(
        'success' => false,
        'message' => 'ID de registro no proporcionado'
    ));
    exit;
}

$id_registro = intval($_POST['id_registro']);

// Comprobar si existe la tabla de PDFs
$check_table = mysqli_query($con, "SHOW TABLES LIKE 'documentos_pdf'");
if (mysqli_num_rows($check_table) == 0) {
    // Si la tabla no existe, la creamos
    $create_table = "CREATE TABLE documentos_pdf (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        id_registro INT(11) NOT NULL,
        descripcion VARCHAR(255) NOT NULL,
        nombre_archivo VARCHAR(255) NOT NULL,
        fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_registro) REFERENCES principal(id) ON DELETE CASCADE
    )";
    
    if (!mysqli_query($con, $create_table)) {
        echo json_encode(array(
            'success' => false,
            'message' => 'Error al crear la tabla de documentos PDF: ' . mysqli_error($con)
        ));
        exit;
    }
}

// Consultar los PDFs asociados al registro
$query = mysqli_query($con, "SELECT * FROM documentos_pdf WHERE id_registro = $id_registro ORDER BY fecha_subida DESC");

if (!$query) {
    echo json_encode(array(
        'success' => false,
        'message' => 'Error al consultar documentos: ' . mysqli_error($con)
    ));
    exit;
}

// Preparar respuesta
$pdfs = array();
while ($row = mysqli_fetch_assoc($query)) {
    // Construir la URL del PDF
    $rutaPdf = 'uploads/pdfs/' . $row['id_registro'] . '/' . $row['nombre_archivo'];
    
    $pdfs[] = array(
        'id' => $row['id'],
        'descripcion' => $row['descripcion'],
        'nombre_archivo' => $row['nombre_archivo'],
        'rutaPdf' => $rutaPdf,
        'fecha_subida' => date('d-m-Y H:i', strtotime($row['fecha_subida']))
    );
}

// Devolver respuesta
echo json_encode(array(
    'success' => true,
    'pdfs' => $pdfs
));
?> 
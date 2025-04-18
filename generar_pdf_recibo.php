<?php

include('ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
// Activar mostrado de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


        if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
                exit;
        }



// Incluir configuración de base de datos
require_once ("config/db.php");
require_once ("config/conexion.php");

// Verificar si se trata de una descarga o visualización
$download_mode = isset($_GET['download']) && $_GET['download'] == 1;

// Verificar que se recibió el ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: No se especificó un ID válido");
}

$id = intval($_GET['id']);

// Consultar datos del establecimiento
$sql = "SELECT p.*, 
        g.descripcion_giro AS giro_desc, 
        m.descripcion_modalidad_graduacion_alcoholica AS modalidad_desc,
        mu.municipio AS municipio_desc,
        d.delegacion AS delegacion_desc,
        c.colonia AS colonia_desc
        FROM principal p
        LEFT JOIN giro g ON p.giro = g.id
        LEFT JOIN modalidad_graduacion_alcoholica m ON p.modalidad_graduacion_alcoholica = m.id
        LEFT JOIN municipio mu ON p.id_municipio = mu.id
        LEFT JOIN delegacion d ON p.id_delegacion = d.id
        LEFT JOIN colonias c ON p.id_colonia = c.id
        WHERE p.id = " . $id;

$resultado = mysqli_query($con, $sql);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    die("Error: No se encontró el registro solicitado");
}

$datos = mysqli_fetch_assoc($resultado);

// Nombre del archivo PDF
$filename = 'Recibo_Inspeccion_'.$datos['folio'].'.pdf';

// Generar una representación simple del PDF como HTML
if ($download_mode) {
    // Si es modo descarga, configurar cabeceras para descargar
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
} else {
    // Si es modo visualización, configurar cabeceras para mostrar en el navegador
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="'.$filename.'"');
}

// Generar un PDF básico para demostración
echo "%PDF-1.4\n";
echo "1 0 obj\n<</Type/Catalog/Pages 2 0 R>>\nendobj\n";
echo "2 0 obj\n<</Type/Pages/Kids[3 0 R]/Count 1>>\nendobj\n";
echo "3 0 obj\n<</Type/Page/Parent 2 0 R/MediaBox[0 0 612 792]/Resources<<>>>>\nendobj\n";
echo "4 0 obj\n<</Length 150>>\nstream\nBT\n/F1 12 Tf\n50 700 Td\n(Recibo de Inspeccion) Tj\n0 -20 Td\n(Folio: ".$datos['folio'].") Tj\n0 -20 Td\n(Establecimiento: ".$datos['nombre_comercial_establecimiento'].") Tj\nET\nendstream\nendobj\n";
echo "xref\n0 5\n0000000000 65535 f\n0000000009 00000 n\n0000000056 00000 n\n0000000111 00000 n\n0000000200 00000 n\n";
echo "trailer\n<</Size 5/Root 1 0 R>>\nstartxref\n400\n%%EOF";

exit;
?> 

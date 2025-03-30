<?php
// Archivo para obtener todas las imágenes de un registro
include('is_logged.php'); // Verificar que el usuario esté logueado

// Conexión a la base de datos
require_once ("../config/db.php");
require_once ("../config/conexion.php");

// Respuesta por defecto
$response = array(
    'success' => false,
    'message' => 'No se pudieron obtener las imágenes',
    'imagenes' => array()
);

// Verificar que venga el ID del registro
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $response['message'] = 'No se proporcionó un ID de registro válido';
    echo json_encode($response);
    exit;
}

// Obtener ID del registro
$id_registro = intval($_GET['id']);

// Verificar que el registro exista
$query_registro = mysqli_query($con, "SELECT * FROM principal WHERE id = $id_registro");
if (mysqli_num_rows($query_registro) == 0) {
    $response['message'] = 'El registro no existe';
    echo json_encode($response);
    exit;
}

// Obtener los datos del registro
$registro = mysqli_fetch_assoc($query_registro);
$foto_principal = $registro['foto'];

// Array para almacenar todas las imágenes
$imagenes = array();

// Primero buscar la imagen principal
if (!empty($foto_principal) && is_numeric($foto_principal)) {
    // Construir rutas posibles
    $posibles_rutas = array(
        "../".FOTOSMEDIAS.$id_registro."-".$foto_principal.".jpg", // Ruta relativa superior
        FOTOSMEDIAS.$id_registro."-".$foto_principal.".jpg", // Ruta directa
        "bebal_images/medias/".$id_registro."-".$foto_principal.".jpg", // Ruta específica
        "../bebal_images/medias/".$id_registro."-".$foto_principal.".jpg" // Otra ruta alternativa
    );
    
    $ruta_encontrada = false;
    foreach ($posibles_rutas as $ruta) {
        if (file_exists($ruta)) {
            // Convertir ruta del sistema a URL
            $url_imagen = $ruta;
            if (strpos($url_imagen, '../') === 0) {
                $url_imagen = str_replace('../', '/', $url_imagen);
            }
            
            $imagenes[] = array(
                'id' => $foto_principal,
                'esPrincipal' => true,
                'rutaImagen' => $url_imagen
            );
            
            $ruta_encontrada = true;
            break;
        }
    }
    
    // Si no se encontró la imagen principal, usar URL base fija
    if (!$ruta_encontrada) {
        $url_base = "http://98.80.116.118/bebal_images/medias/";
        $url_imagen = $url_base.$id_registro."-".$foto_principal.".jpg";
        
        $imagenes[] = array(
            'id' => $foto_principal,
            'esPrincipal' => true,
            'rutaImagen' => $url_imagen
        );
    }
}

// Luego buscar todas las imágenes asociadas al registro
$query_fotos = mysqli_query($con, "SELECT * FROM fotos WHERE idprincipal = $id_registro ORDER BY idfoto");
if (mysqli_num_rows($query_fotos) > 0) {
    while ($foto = mysqli_fetch_assoc($query_fotos)) {
        $id_foto = $foto['idfoto'];
        
        // No repetir la imagen principal
        if (!empty($foto_principal) && $id_foto == $foto_principal) {
            continue;
        }
        
        // Construir rutas posibles
        $posibles_rutas = array(
            "../".FOTOSMEDIAS.$id_registro."-".$id_foto.".jpg",
            FOTOSMEDIAS.$id_registro."-".$id_foto.".jpg",
            "bebal_images/medias/".$id_registro."-".$id_foto.".jpg",
            "../bebal_images/medias/".$id_registro."-".$id_foto.".jpg"
        );
        
        $ruta_encontrada = false;
        foreach ($posibles_rutas as $ruta) {
            if (file_exists($ruta)) {
                // Convertir ruta del sistema a URL
                $url_imagen = $ruta;
                if (strpos($url_imagen, '../') === 0) {
                    $url_imagen = str_replace('../', '/', $url_imagen);
                }
                
                $imagenes[] = array(
                    'id' => $id_foto,
                    'esPrincipal' => false,
                    'rutaImagen' => $url_imagen
                );
                
                $ruta_encontrada = true;
                break;
            }
        }
        
        // Si no se encontró la imagen, usar URL base fija
        if (!$ruta_encontrada) {
            $url_base = "http://98.80.116.118/bebal_images/medias/";
            $url_imagen = $url_base.$id_registro."-".$id_foto.".jpg";
            
            $imagenes[] = array(
                'id' => $id_foto,
                'esPrincipal' => false,
                'rutaImagen' => $url_imagen
            );
        }
    }
}

// Retornar respuesta exitosa con las imágenes
$response['success'] = true;
$response['message'] = 'Imágenes obtenidas correctamente';
$response['imagenes'] = $imagenes;
echo json_encode($response);
?> 
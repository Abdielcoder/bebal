<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar que el usuario esté logueado
include("is_logged.php");

// Conexión a la base de datos
require_once ("../config/db.php");
require_once ("../config/conexion.php");

// Procesar la subida de la imagen
if ($_FILES && isset($_FILES['foto']) && isset($_POST['id_registro_foto'])) {
    $id_registro = intval($_POST['id_registro_foto']);
    
    // Verificar que el ID sea válido
    if ($id_registro <= 0) {
        echo "Error: ID de registro no válido.";
        exit;
    }
    
    // Verificar que se haya subido un archivo
    if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
        $error = '';
        switch ($_FILES['foto']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $error = 'El archivo excede el tamaño máximo permitido por el servidor.';
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $error = 'El archivo excede el tamaño máximo permitido por el formulario.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $error = 'El archivo se subió parcialmente.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $error = 'No se seleccionó ningún archivo.';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $error = 'No se encontró la carpeta temporal.';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $error = 'Error al escribir el archivo en el disco.';
                break;
            case UPLOAD_ERR_EXTENSION:
                $error = 'Una extensión de PHP detuvo la subida del archivo.';
                break;
            default:
                $error = 'Error desconocido al subir el archivo.';
        }
        echo "Error al subir la imagen: " . $error;
        exit;
    }
    
    // Validar que sea una imagen
    $file_info = getimagesize($_FILES['foto']['tmp_name']);
    if ($file_info === false) {
        echo "El archivo subido no es una imagen válida.";
        exit;
    }
    
    // Tipos de archivo permitidos
    $allowed_types = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF);
    if (!in_array($file_info[2], $allowed_types)) {
        echo "Tipo de archivo no permitido. Solo se aceptan JPG, PNG y GIF.";
        exit;
    }
    
    // Comprobar el tamaño (máximo 5MB)
    $max_size = 5 * 1024 * 1024; // 5MB en bytes
    if ($_FILES['foto']['size'] > $max_size) {
        echo "El archivo es demasiado grande. Tamaño máximo: 5MB.";
        exit;
    }
    
    // Crear directorio si no existe
    $upload_dir = '../img/fotos/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Generar un nombre único para la imagen
    $file_extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $new_filename = 'registro_' . $id_registro . '_' . time() . '.' . $file_extension;
    $target_file = $upload_dir . $new_filename;
    
    // Mover el archivo
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
        // Actualizar la base de datos
        $sql = "UPDATE principal SET foto = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'si', $new_filename, $id_registro);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "La imagen se subió correctamente y se actualizó el registro.";
            } else {
                echo "Error al actualizar la base de datos: " . mysqli_error($con);
                // Intentar eliminar el archivo si hubo error en la base de datos
                unlink($target_file);
            }
            
            mysqli_stmt_close($stmt);
        } else {
            echo "Error en la preparación de la consulta: " . mysqli_error($con);
            // Intentar eliminar el archivo si hubo error
            unlink($target_file);
        }
    } else {
        echo "Error al mover el archivo subido a la ubicación final.";
    }
} else {
    echo "No se proporcionó una imagen o un ID de registro válido.";
}
?> 
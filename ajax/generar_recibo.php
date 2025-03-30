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

// Configuración para el retorno de datos JSON
header('Content-Type: application/json');

// Procesar la generación de recibo
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    // Verificar que el ID sea válido
    if ($id <= 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID de registro no válido.'
        ]);
        exit;
    }
    
    // Obtener datos del registro
    $sql = "SELECT * FROM principal WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                
                // Actualizar el estatus a INSPECCION
                $update_sql = "UPDATE principal SET estatus = 'INSPECCION' WHERE id = ?";
                $update_stmt = mysqli_prepare($con, $update_sql);
                
                if ($update_stmt) {
                    mysqli_stmt_bind_param($update_stmt, 'i', $id);
                    
                    if (mysqli_stmt_execute($update_stmt)) {
                        // Aquí iría la lógica para generar el PDF del recibo
                        // Por ahora solo simularemos un mensaje de éxito
                        
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Recibo de inspección generado correctamente para ' . $row['nombre_comercial_establecimiento'],
                            // 'pdf_url' => 'recibos/recibo_' . $id . '.pdf' // Descomentar cuando se implemente la generación de PDF
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Error al actualizar el estatus: ' . mysqli_error($con)
                        ]);
                    }
                    
                    mysqli_stmt_close($update_stmt);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Error en la preparación de la consulta de actualización: ' . mysqli_error($con)
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No se encontró el registro con ID: ' . $id
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al ejecutar la consulta: ' . mysqli_error($con)
            ]);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error en la preparación de la consulta: ' . mysqli_error($con)
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No se proporcionó un ID válido.'
    ]);
}
?> 
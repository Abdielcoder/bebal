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

// Procesar la actualización de coordenadas
if (isset($_POST['id']) && isset($_POST['coordenadas'])) {
    $id = intval($_POST['id']);
    $coordenadas = mysqli_real_escape_string($con, $_POST['coordenadas']);
    
    // Verificar que el ID sea válido
    if ($id <= 0) {
        echo "Error: ID de registro no válido.";
        exit;
    }
    
    // Actualizar la base de datos
    $sql = "UPDATE principal SET mapa = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'si', $coordenadas, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Las coordenadas se actualizaron correctamente.";
        } else {
            echo "Error al actualizar las coordenadas: " . mysqli_error($con);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($con);
    }
} else {
    echo "No se proporcionó un ID o coordenadas válidas.";
}
?> 
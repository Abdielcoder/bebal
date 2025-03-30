<?php
/**
 * Archivo base para la biblioteca FPDF simplificada
 * Esta es una implementación mínima para permitir la ejecución del script
 */

// Definiciones básicas necesarias
define('FPDF_VERSION', '1.84');

// Constantes
define('FPDF_FONTPATH', 'font/');
define('FPDF_UNICODE_DATA', 'unicode.dat');

// Funciones de ayuda
function utf8_decode($str) {
    return $str;
}

function utf8_encode($str) {
    return $str;
}
?> 
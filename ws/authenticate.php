<?php
require 'jwt.php';

$userData = [
    'id' => 1,
    'username' => 'usuario'
];

// Agregar los tiempos de emisión y expiración al payload del JWT
$issuedAt = time();
$expirationTime = $issuedAt + 3600;  // jwt válido por 1 hora
$payload = [
    'iat' => $issuedAt,
    'exp' => $expirationTime,
    'userData' => $userData
];

// Generar el JWT
$jwt = encode_jwt($payload);

// Devolver el JWT al cliente
header('Content-Type: application/json');
echo json_encode(['token' => $jwt]);
?>

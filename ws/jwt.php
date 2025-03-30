<?php
// Definir la clave secreta

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$My_str=substr(str_shuffle($permitted_chars), 0, 16);
##echo "My_str=".$My_str."<br>";
//define('SECRET_KEY', $My_str );

define('SECRET_KEY', 'tu_clave_secreta');

// Codificar un JWT
function encode_jwt($payload) {
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, SECRET_KEY, true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    return $jwt;
}

// Decodificar un JWT
function decode_jwt($jwt) {
    $parts = explode('.', $jwt);
    if (count($parts) === 3) {
        $header = base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[0]));
        $payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1]));
        $signatureProvided = base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[2]));

        // Verificar la firma
        $expectedSignature = hash_hmac('sha256', "$parts[0].$parts[1]", SECRET_KEY, true);
        if (hash_equals($expectedSignature, $signatureProvided)) {
            return json_decode($payload, true);
        } else {
            return false;
        }
    }
    return false;
}
?>

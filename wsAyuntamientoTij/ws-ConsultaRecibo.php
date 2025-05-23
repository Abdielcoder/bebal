<?php
// Obtener el parámetro 'referencia' del cuerpo POST
$referencia = isset($_POST['referencia']) ? $_POST['referencia'] : null;

// Validar si el parámetro fue recibido
if (!$referencia) {
    echo json_encode([
        "error" => true,
        "message" => "El parámetro 'referencia' es obligatorio."
    ]);
    exit;
}

// URL del servicio SOAP
$url = "https://www.tijuana.gob.mx/wspruebas/WSConsultaRecibos.asmx?op=ConsultaRecibo";

// XML que enviarás en el cuerpo de la solicitud
$requestXml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns="http://tempuri.org/">
   <soapenv:Header/>
   <soapenv:Body>
   <ConsultaRecibo xmlns="http://tempuri.org/">
            <referencia>{$referencia}</referencia>
            <usuario>usrsegob</usuario>
            <password>s3g0b25</password>
        </ConsultaRecibo>
   </soapenv:Body>
</soapenv:Envelope>
XML;

// Inicializar cURL
$ch = curl_init($url);

// Configurar opciones de cURL
curl_setopt($ch, CURLOPT_POST, true); // Método POST
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: text/xml; charset=utf-8", // Tipo de contenido
    "Content-Length: " . strlen($requestXml) // Longitud del contenido
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml); // Cuerpo de la solicitud
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retornar la respuesta como string

// Ejecutar la solicitud
$response = curl_exec($ch);

// Manejar errores
if (curl_errno($ch)) {
    echo "Error en cURL: " . curl_error($ch);
} else {
    // Mostrar la respuesta cruda en formato XML
    header("Content-Type: application/xml; charset=utf-8"); // Establecer el encabezado para XML
    echo $response;
}

// Cerrar cURL
curl_close($ch);

?>

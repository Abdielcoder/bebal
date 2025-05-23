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
$url = "https://pagos.tijuana.gob.mx/wsPagosExternos/wsPagosExternos.asmx?op=ConsultadePagoConDetalle";

// XML que enviarás en el cuerpo de la solicitud
$requestXml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns="http://tempuri.org/">
   <soapenv:Header/>
   <soapenv:Body>
        <ConsultadePagoConDetalle xmlns="http://tempuri.org/">
            <Usuario>usrsegob</Usuario>
            <Contrasena>s3g0b25</Contrasena>
            <IdCadena>1</IdCadena>
            <Referencia>{$referencia}</Referencia>
            <idSucursal>0</idSucursal>
            <cruzRoja>0</cruzRoja>
        </ConsultadePagoConDetalle>
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
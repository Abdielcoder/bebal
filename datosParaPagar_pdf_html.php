<?php
// Activar mostrado de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir configuración de base de datos
require_once ("config/db.php");
require_once ("config/conexion.php");

// Verificar que se recibió el ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: No se especificó un ID válido");
}

$ID = $_GET['id'];
##$ID = intval($_GET['id']);

$porciones = explode("--", $ID);
$id=intval($porciones[0]);
$ID_TRAMITE=intval($porciones[1]);
$ID_TRAMITE_SOLICITADO=$porciones[2];
$ID_PAGO=$porciones[3];

##

if ($ID_TRAMITE_SOLICITADO=='0X') {
$sql_tramite="SELECT * FROM tramite WHERE descripcion_tramite='Inspeccion'";
$result_tramite = mysqli_query($con,$sql_tramite);
$row_tramite = mysqli_fetch_assoc($result_tramite);
$DESCRIPCION_TRAMITE=$row_tramite['descripcion_tramite'];
$CUENTA=$row_tramite['cuenta'];
$MONTO_UMAS=$row_tramite['monto_umas'];
$CONCEPTO=$row_tramite['concepto'];


$sql_tramite1="SELECT * FROM tramite WHERE descripcion_tramite='Revalidacion del Permiso'";
$result_tramite1 = mysqli_query($con,$sql_tramite1);
$row_tramite1 = mysqli_fetch_assoc($result_tramite1);
$DESCRIPCION_TRAMITE_SOLICITADO=$row_tramite1['descripcion_tramite'];
$CUENTA_SOLICITADO=$row_tramite1['cuenta'];
$MONTO_UMAS_SOLICITADO=$row_tramite1['monto_umas'];
$CONCEPTO_SOLICITADO=$row_tramite1['concepto'];

} else {
$ID_TRAMITE_SOLICITADO=intval($porciones[2]);
$sql_tramite="SELECT * FROM tramite WHERE id=".$ID_TRAMITE;
$result_tramite = mysqli_query($con,$sql_tramite);
$row_tramite = mysqli_fetch_assoc($result_tramite);
$DESCRIPCION_TRAMITE=$row_tramite['descripcion_tramite'];
$CUENTA=$row_tramite['cuenta'];
$MONTO_UMAS=$row_tramite['monto_umas'];
$CONCEPTO=$row_tramite['concepto'];
##

##
$sql_tramite1="SELECT * FROM tramite WHERE id=".$ID_TRAMITE_SOLICITADO;
$result_tramite1 = mysqli_query($con,$sql_tramite1);
$row_tramite1 = mysqli_fetch_assoc($result_tramite1);
$DESCRIPCION_TRAMITE_SOLICITADO=$row_tramite1['descripcion_tramite'];
$CUENTA_SOLICITADO=$row_tramite1['cuenta'];
$MONTO_UMAS_SOLICITADO=$row_tramite1['monto_umas'];
$CONCEPTO_SOLICITADO=$row_tramite1['concepto'];
##

}




// Consultar datos del establecimiento
$sql = "SELECT p.*, 
        g.descripcion_giro AS giro_desc, 
        mu.municipio AS municipio_desc,
        d.delegacion AS delegacion_desc,
        c.colonia AS colonia_desc
        FROM principal p
        LEFT JOIN giro g ON p.giro = g.id
        LEFT JOIN municipio mu ON p.id_municipio = mu.id
        LEFT JOIN delegacion d ON p.id_delegacion = d.id
        LEFT JOIN colonias c ON p.id_colonia = c.id
        WHERE p.id = " . $id;

$resultado = mysqli_query($con, $sql);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    die("Error: No se encontró el registro solicitado");
}

$datos = mysqli_fetch_assoc($resultado);

##
$sql_generales="SELECT descripcion FROM generales WHERE dato_general='UMAS'";
$result_generales = mysqli_query($con,$sql_generales);
$row_generales = mysqli_fetch_assoc($result_generales);
$TIPO_CAMBIO_UMAS=$row_generales['descripcion'];
$TOTAL_A_PAGAR_MN=$MONTO_UMAS*$TIPO_CAMBIO_UMAS;
##
// Cabecera que indica que esto es un documento HTML
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="format-detection" content="telephone=no">
    <meta name="print-mode" content="no-headers-footers">
    <title>Orden de Pago</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <style>

        @media print {
            /* Configuración de página sin headers/footers */
            @page {
                size: letter;
                margin: 0 !important;
                /* Eliminar completamente headers y footers automáticos */
                @top-left-corner { content: ""; }
                @top-left { content: ""; }
                @top-center { content: ""; }
                @top-right { content: ""; }
                @top-right-corner { content: ""; }
                @bottom-left-corner { content: ""; }
                @bottom-left { content: ""; }
                @bottom-center { content: ""; }
                @bottom-right { content: ""; }
                @bottom-right-corner { content: ""; }
                @left-top { content: ""; }
                @left-middle { content: ""; }
                @left-bottom { content: ""; }
                @right-top { content: ""; }
                @right-middle { content: ""; }
                @right-bottom { content: ""; }
            }
            
            /* Eliminar elementos específicos del navegador */
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
                box-sizing: border-box !important;
            }
            
            html {
                width: 100% !important;
                height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
                /* Eliminar cualquier contenido generado automáticamente */
                -webkit-appearance: none !important;
                -moz-appearance: none !important;
                appearance: none !important;
            }
            
            body {
                width: 210mm !important;
                height: 297mm !important;
                margin: 0 !important;
                padding: 4mm 2mm 4mm 2mm !important; /* Padding comprimido: arriba izquierda abajo derecha */
                font-size: 8px !important; /* Fuente base ligeramente más grande */
                line-height: 1.0 !important;
                overflow: hidden !important;
                position: relative !important;
                /* Eliminar elementos automáticos del navegador */
                -webkit-appearance: none !important;
                -moz-appearance: none !important;
                appearance: none !important;
            }
            
            /* Eliminar específicamente headers y footers automáticos */
            body::before,
            body::after,
            html::before,
            html::after,
            *::before,
            *::after {
                content: "" !important;
                display: none !important;
                visibility: hidden !important;
            }
            
            .no-print {
                display: none !important;
                visibility: hidden !important;
            }
            
            .page-break {
                page-break-before: always;
            }
            
            .container {
                padding: 0 !important;
                margin: 0 !important;
                border: none !important;
                box-shadow: none !important;
                background: white !important;
                width: 100% !important;
                height: 100% !important;
                position: relative !important;
                overflow: hidden !important;
            }
            
            .header {
                display: flex !important;
                align-items: flex-start !important;
                justify-content: space-between !important;
                padding-bottom: 8px !important;
                margin-bottom: 3px !important;
                min-height: 110px !important;
                position: relative !important;
                margin-top: 25mm !important; /* Margen superior aumentado 10% hacia abajo */
                border-bottom: none !important;
                clear: both !important;
            }
            
            .logo {
                width: 320px !important; /* Logo 7x para impresión, optimizado */
                flex-shrink: 0 !important;
            }
            
            .logo img {
                max-width: 100%;
                height: auto;
            }
            
            /* Eliminar el title del header - ya no está en el centro */
            .title {
                display: none !important; /* Mantener oculto */
            }
            
            .date {
                width: 110px !important;
                text-align: center !important;
            }
            
            .date img {
                width: 100px !important;
                height: 100px !important;
                display: block !important;
                margin: 0 auto !important;
            }
            
            /* Nueva sección para el título centrado debajo */
            .centered-title {
                text-align: center !important;
                margin: 3px 0 8px 0 !important;
                padding: 8px 0 !important;
                border-bottom: 1px solid #AC905B !important;
            }
            
            .centered-title h2 {
                font-size: 14px !important;
                font-weight: bold !important;
                color: #333 !important;
                margin: 0 !important;
            }
            
            .main-title {
                margin: 2px 0 !important;
                text-align: center !important;
                clear: both !important;
            }
            
            .main-title h1 {
                font-size: 11px !important;
                margin: 1px 0 !important;
            }
            
            .main-title h3 {
                font-size: 7px !important;
                margin: 0px 0 !important;
                line-height: 1.0 !important;
            }
            
            .section {
                margin: 2px 0 !important;
                clear: both !important;
            }
            
            .section-title {
                font-size: 9px !important;
                padding: 2px 4px !important;
            }
            
            table, th, td {
                font-size: 6px !important;
                border: 1px solid #ddd !important;
                padding: 1px !important;
            }
            
            .compact-table th, .compact-table td {
                padding: 1px !important;
            }
            
            .info-text {
                font-size: 6px !important;
                margin: 2px 0 !important;
                line-height: 1.0 !important;
            }
            
            .signature {
                margin-top: 3px !important;
                font-size: 6px !important;
            }
            
            .folio {
                font-size: 8px !important;
                margin: 1px 0 !important;
            }
            
            /* Asegurar que no haya contenido flotante que cause sobreposiciones */
            * {
                float: none !important;
                position: relative !important;
            }
            
            /* El QR ya no necesita posición absoluta con la nueva estructura */
            .date {
                position: relative !important;
            }
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 15px;
            max-width: 21cm;
            margin: 0 auto;
            background-color: #f9f9f9;
            font-size: 10px;
        }


        .print-button {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .container {
            background: white;
            padding: 15px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between; /* Distribuir logo y QR en extremos */
            padding-bottom: 10px;
            margin-bottom: 5px;
            min-height: 140px; /* Altura reducida sin título en medio */
            position: relative;
            margin-top: 15mm;
            border-bottom: none; /* Sin línea aquí */
        }
        
        .logo {
            width: 420px; /* Logo 7x */
            flex-shrink: 0;
        }
        
        .logo img {
            max-width: 100%;
            height: auto;
        }
        
        /* Eliminar el title del header - ya no está en el centro */
        .title {
            display: none; /* Ocultar el título del header */
        }
        
        .date {
            width: 140px;
            text-align: center;
        }
        
        .date img {
            width: 120px;
            height: 120px;
            display: block;
            margin: 0 auto;
        }
        
        /* Nueva sección para el título centrado debajo */
        .centered-title {
            text-align: center;
            margin: 10px 0 15px 0;
            padding: 15px 0;
            border-bottom: 2px solid #AC905B; /* Línea dorada aquí */
        }
        
        .centered-title h2 {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }
        
        .main-title {
            text-align: center;
            margin: 10px 0;
        }
        
        .main-title h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        
        .main-title h3 {
            margin: 2px 0;
            font-size: 12px;
            color: #666;
            font-weight: normal;
        }
        
        .folio {
            text-align: right;
            margin: 5px 0;
            font-size: 14px;
            color: #AC905B;
            font-weight: bold;
        }
        
        .section {
            margin: 10px 0;
        }
        
        .section-title {
            background-color: #AC905B;
            color: white;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }
        
        table, th, td {
            border: 1px solid #ddd;
        }
        
        th, td {
            padding: 5px;
            text-align: left;
            font-size: 12px;
        }
        
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 30%;
        }
        
        .compact-table th, .compact-table td {
            padding: 3px;
        }
        
        .two-column {
            display: flex;
            gap: 10px;
        }
        
        .column {
            flex: 1;
        }
        
        .monto-table td {
            padding: 8px;
        }
        
        .monto-label {
            font-size: 14px;
            font-weight: bold;
            width: 30%;
        }
        
        .monto-value {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }
        
        .info-text {
            margin: 10px 0;
            font-size: 12px;
            text-align: justify;
        }
        
        .legal {
            font-size: 10px;
            color: #666;
            margin: 10px 0;
            text-align: justify;
        }
        
        .signatures {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }
        
        .signature {
            width: 40%;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="imprimirSinCabeceras()">Imprimir Recibo</button>
    
    <div class="container">
<?php
switch ($DESCRIPCION_TRAMITE) {
case "Inspeccion":
	$DESCRIPCION_TRAMITE='Inspección';
        break;
case "Recepcion y Analisis Documentos":
	$DESCRIPCION_TRAMITE='Recepción y Análisis Documentos';
	break;
//default:
}

$todayANO = date("Y");
####################
####################
$sql_pago="SELECT * FROM `pagos` WHERE id=$ID_PAGO";
$result_pago = mysqli_query($con,$sql_pago);
if (mysqli_num_rows($result_pago) > 0) {
$row_pago = mysqli_fetch_assoc($result_pago);
$ORDEN_PAGO = isset($row_pago['orden_pago']) ? $row_pago['orden_pago'] : 'ORDEN_PAGO_INDETERMINADA';
$CONCEPTO_RECAUDACION = (isset($row_pago['concepto_recaudacion']) && $row_pago['concepto_recaudacion'] !== null) ? $row_pago['concepto_recaudacion'] : 'No disponible';

} else {

$id_proceso_tramites=$datos['id_proceso_tramites'];
$ORDEN_PAGO='';
$CONCEPTO_RECAUDACION='No disponible';
if ( $DESCRIPCION_TRAMITE=='Inspección' ) {
$ORDEN_PAGO='PI-'.$id.$ID_PAGO.'-'.$todayANO;
} else {
	if ( $DESCRIPCION_TRAMITE=='Recepción y Análisis Documentos' ) {
	$ORDEN_PAGO='PA-'.$id.$ID_PAGO.'-'.$todayANO;
	} else {
	$ORDEN_PAGO='PX-'.$id.$ID_PAGO.'-'.$todayANO;
	}
}
}
?>

        <div class="header">
            <div class="logo">
                <img src="img/SGM_LOGO_UTM-02.png" alt="Logo" width="420">
            </div>
            <div class="date">
                <?php
                $Folio=$datos['folio'];
                echo '<img src="qrcode.php?s=qrl&d=https://sgm.tijuana.gob.mx/bebal/login.php?bid='.$Folio.'&op='.$ORDEN_PAGO.'" style="width: 120px; height: 120px;">';
                ?>
            </div>
        </div>
        
        <!-- Nueva sección para el título centrado debajo del header -->
        <div class="centered-title">
            <h2><?php echo $DESCRIPCION_TRAMITE; ?></h2>
        </div>

        <div class="main-title">
             <h1><font size="5px;">Orden de Pago: <?php echo $ORDEN_PAGO; ?></font></h1>
             
             <?php
             // Generar y mostrar el código de barras para ORDEN_PAGO usando JsBarcode
             if (isset($ORDEN_PAGO) && trim($ORDEN_PAGO) !== '') {
                 $orden_pago_clean = trim($ORDEN_PAGO);
                 echo '<div style="text-align: center; margin: 3px 0;">';
                 echo '    <svg id="barcode-orden-pago"></svg>';
                 echo '</div>';
                 echo '<script>';
                 echo 'document.addEventListener("DOMContentLoaded", function() {';
                 echo '    if (typeof JsBarcode !== "undefined") {';
                 echo '        JsBarcode("#barcode-orden-pago", "'.htmlspecialchars($orden_pago_clean).'", {';
                 echo '            format: "CODE39",';
                 echo '            width: 1.5,';
                 echo '            height: 40,';
                 echo '            displayValue: false,';
                 echo '            margin: 0';
                 echo '        });';
                 echo '    }';
                 echo '});';
                 echo '</script>';
             }
             ?>
             
             <h3>PROGRAMA DE IDENTIFICACIÓN, EMPADRONAMIENTO, REGULARIZACIÓN Y REVALIDACIÓN</h3>
             <h3>DE ESTABLECIMIENTOS QUE EXPIDEN Y VENDEN AL PÚBLICO BEBIDAS CON CONTENIDO ALCOHÓLICO</h3>
        </div>
        
        <div class="folio">
            BID: <?php echo $datos['folio']; ?>
        </div>
        
            <div class="column">
                <div class="section">
                    
                    <div class="section-title">DATOS DEL SOLICITANTE</div>
                    <table class="compact-table">
                        <tr>
                            <th>Nombre Comercial</th>
                            <td><?php echo $datos['nombre_comercial_establecimiento']; ?></td>
			</tr>

<?php

######################
$NUMERO_PERMISO_ANTERIOR='';
$sql_Cuenta_Paso="SELECT COUNT(*) CUENTA_PASO FROM de_paso WHERE id_principal=$id";
$result_CuentaPaso=mysqli_query($con,$sql_Cuenta_Paso);
$row_cuentaPaso = mysqli_fetch_assoc($result_CuentaPaso);
$CUENTA_PASO=$row_cuentaPaso['CUENTA_PASO'];
if ( $CUENTA_PASO>0 ) {
$sql_Paso="SELECT * FROM de_paso WHERE id_principal=$id";
$result_Paso=mysqli_query($con,$sql_Paso);
$row_Paso = mysqli_fetch_assoc($result_Paso);
$NUMERO_PERMISO_ANTERIOR=$row_Paso['numero_permiso'];
} else {
$NUMERO_PERMISO_ANTERIOR='ND';
}
######################

if ( $DESCRIPCION_TRAMITE_SOLICITADO=='Permiso Nuevo' ) {
} else {
echo '<tr>';
if ( $CUENTA_PASO>0 ) {
echo '<th>Número Permiso Anterior</th>';
echo '<td><font size="2"><b>'.$NUMERO_PERMISO_ANTERIOR.'</b></font></td>';
} else {
echo '<th>Número Permiso</th>';
echo '<td><font size="2"><b>'.$datos["numero_permiso"].'</b></font></td>';
}
echo '</tr>';
}
?>


                        <tr>
                            <th>Giro</th>
                            <td><?php echo $datos['giro_desc']; ?></td>
                        </tr>
                        <tr>
                            <th>Concepto Recaudación</th>
                            <td><font size="2"><?php echo $CONCEPTO_RECAUDACION; ?></font></td>
			</tr>

                        <tr>
                            <th>Inciso </th>
                            <td><font size="2"><B><?php echo $CUENTA; ?></B></font></td>
                        </tr>


<?php

//<tr>
//<th>Modalidad Graduación Alcohólica</th>
//<td>'.$datos['modalidad_graduacion_alcoholica'].' '.$datos['numero_modalidad_graduacion_alcoholica.'</td>
//</tr>

echo '<tr>';
echo '<th>Domicilio</th>';
if ( $datos['calle_establecimiento']=='' || $datos['calle_establecimiento']==NULL || empty($datos['calle_establecimiento']) ) {
$domicilio_establecimiento='NA';
} else {
$domicilio_establecimiento=$datos['calle_establecimiento'].' '.$datos['numero_establecimiento'];
}
###
if ( $datos['colonia_desc']=='' || empty($datos['colonia_desc']) ) $COLONIA='NA';
else $COLONIA=$datos['colonia_desc'];
##
if ( $datos['delegacion_desc']=='' || empty($datos['delegacion_desc']) ) $DELEGACION='NA';
else $DELEGACION=$datos['delegacion_desc'];
##
if ( $datos['municipio_desc']=='' || empty($datos['municipio_desc']) ) $MUNICIPIO='';
else $MUNICIPIO=$datos['municipio_desc'];
##
if ( $datos['cp_establecimiento']=='' || empty($datos['cp_establecimiento']) ) $CP='';
else $CP=$datos['cp_establecimiento'];
##

$colonia_delegacion_municipio_establecimiento='Colonia: '.$COLONIA.', Delegación: '.$DELEGACION.' / '.$MUNICIPIO.' / '.$CP;


echo '<td>'.$domicilio_establecimiento.' '.$colonia_delegacion_municipio_establecimiento.'</td>';

?>
			</tr>

                        <tr>
			    <th>Persona Física/Moral</th>

<?php
$nombre_persona_fisicamoral_solicitante=$datos['nombre_persona_fisicamoral_solicitante'];
if ( empty($nombre_persona_fisicamoral_solicitante) || $nombre_persona_fisicamoral_solicitante=='' ) {
echo '<td>NA</td>';
} else {
echo '<td>'.$nombre_persona_fisicamoral_solicitante.'</td>';
}
?>
                        </tr>
                        <tr>
                            <th>Representante Legal</th>
                            <td><?php echo $datos['nombre_representante_legal_solicitante']; ?></td>
			</tr>
                    </table>
                </div>
                
            </div>
        
        <div class="section">
            <div class="section-title">MONTO A PAGAR</div>
            <table class="monto-table">
                <tr>
		    <td class="monto-label">Total a Pagar:</td>
<?php
echo '<td class="monto-value"> <font color="blue">$'.number_format($TOTAL_A_PAGAR_MN,2).'</font>  ( '.number_format($MONTO_UMAS).' umas )</td>';
?>
                </tr>
            </table>
        </div>
        
        <div class="section">
            <div class="section-title">INFORMACIÓN DE PAGO</div>
            <p class="info-text">
                El pago debe realizarse en la caja de recaudación municipal presentando este recibo. 
                Una vez realizado el pago, conserve su comprobante y preséntelo para continuar con el trámite de inspección.
            </p>
	</div>

<div style="margin-top: 10px;">
<center>
            <div class="signature">
                <div class="signature-line"></div>
                <p><b>Lic. Arnulfo Guerrero León</b><br>
                Secretario de Gobierno Municipal<br>
                XXV Ayuntamiento de Tijuana, Baja California
            </div>
        </div>
</center>

    <script>
        // Función para eliminar completamente cabeceras y pies de página
        function configurarImpresionLimpia() {
            // Crear estilo específico para eliminar headers/footers
            var style = document.createElement('style');
            style.type = 'text/css';
            style.media = 'print';
            style.innerHTML = `
                @page { 
                    size: letter; 
                    margin: 0 !important;
                }
                @media print {
                    * { 
                        -webkit-print-color-adjust: exact !important;
                        print-color-adjust: exact !important;
                    }
                    body {
                        margin: 0 !important;
                        padding: 10mm !important;
                        width: 210mm !important;
                        height: 297mm !important;
                        overflow: hidden !important;
                    }
                }
            `;
            document.head.appendChild(style);
            
            // Limpiar título temporalmente
            var originalTitle = document.title;
            document.title = '';
            
            // Configurar evento beforeprint
            window.addEventListener('beforeprint', function() {
                document.title = '';
                // Ocultar cualquier elemento que pueda generar headers/footers
                var metaTags = document.querySelectorAll('meta');
                metaTags.forEach(function(meta) {
                    if (meta.name === 'author' || meta.name === 'description') {
                        meta.content = '';
                    }
                });
            });
            
            // Restaurar título después de imprimir
            window.addEventListener('afterprint', function() {
                document.title = originalTitle || 'Orden de Pago';
            });
            
            // Forzar configuración de impresión sin headers/footers
            setTimeout(function() {
                window.print();
            }, 100);
        }
        
        // Función principal de impresión
        function imprimirSinCabeceras() {
            configurarImpresionLimpia();
        }
        
        // Auto-configurar al cargar la página
        window.onload = function() {
            // Eliminar título inicial
            document.title = '';
            
            // Configurar botón de impresión
            setTimeout(function() {
                var printButton = document.querySelector('.print-button');
                if (printButton) {
                    printButton.style.display = 'block';
                    printButton.onclick = imprimirSinCabeceras;
                }
            }, 500);
        };
        
        // Prevenir headers/footers automáticos
        document.addEventListener('DOMContentLoaded', function() {
            document.title = '';
            
            // Eliminar metadatos que puedan generar headers/footers
            var metas = document.querySelectorAll('meta[name="author"], meta[name="description"], meta[name="generator"]');
            metas.forEach(function(meta) {
                meta.remove();
            });
        });
    </script>
</body>
</html> 

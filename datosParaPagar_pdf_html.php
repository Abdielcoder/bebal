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
$ID_TRAMITE_SOLICITADO=intval($porciones[2]);

##
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

// Cabecera que indica que esto es un documento HTML
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Inspección - <?php echo $datos['nombre_comercial_establecimiento']; ?></title>
    <style>
        @media print {
            body {
                width: 210mm;
                height: 279mm; /* Tamaño carta exacto */
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .page-break {
                page-break-before: always;
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
            font-size: 12px;
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
            align-items: center;
            border-bottom: 2px solid #AC905B;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        
        .logo {
            width: 70px;
            margin-right: 15px;
        }
        
        .title {
            flex: 1;
        }
        
        .title h1 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }
        
        .title h2 {
            margin: 2px 0;
            font-size: 14px;
            color: #666;
            font-weight: normal;
        }
        
        .date {
            text-align: right;
            font-style: italic;
            font-size: 12px;
            color: #666;
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
    <button class="print-button no-print" onclick="window.print()">Imprimir Recibo</button>
    
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="img/SGM_LOGO_UTM-02.png" alt="Logo" width="400">
            </div>
<?php
            echo '<div class="title">';
                //<h1>GOBIERNO MUNICIPAL DE TIJUANA</h1>
                //<h2>SECRETARÍA DE GOBIERNO MUNICIPAL</h2>
	    echo '</div>';

$Folio=$datos['folio'];
            echo '<div class="date">';
		echo 'Fecha de Impresión: '.date('d/m/Y');
echo '<p><img src="qrcode.php?s=qrl&d='.$Folio.'"></p>';
	    echo '</div>';
?>
        </div>
        
	<div class="main-title">
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


echo '<h1>Datos Para Pago <b><u>'.$DESCRIPCION_TRAMITE.'</u></b></h1>';
echo '<h2>Tramite: <u>'.$DESCRIPCION_TRAMITE_SOLICITADO.'</u></b></h2>';
?>
            <h4>PROGRAMA DE IDENTIFICACIÓN, EMPADRONAMIENTO, REGULARIZACIÓN Y REVALIDACIÓN</h4>
            <h4>DE ESTABLECIMIENTOS QUE EXPIDEN Y VENDEN AL PÚBLICO BEBIDAS CON CONTENIDO ALCOHÓLICO</h4>
        </div>
        
        <div class="folio">
            Folio: <?php echo $datos['folio']; ?>
        </div>
        
            <div class="column">
                <div class="section">
                    <div class="section-title">DATOS DEL SOLICITANTE</div>
                    <table class="compact-table">
                        <tr>
                            <th>Nombre Comercial</th>
                            <td><?php echo $datos['nombre_comercial_establecimiento']; ?></td>
                        </tr>
                        <tr>
                            <th>Giro</th>
                            <td><?php echo $datos['giro_desc']; ?></td>
                        </tr>
                        <tr>
                            <th>Modalidad Graduación Alcoólica</th>
                            <td><?php echo $datos['modalidad_graduacion_alcoholica']; ?> * [<?php echo $datos['numero_modalidad_graduacion_alcoholica']; ?>]</td>
                        </tr>
                        <tr>
                            <th>Persona Física/Moral</th>
                            <td><?php echo $datos['nombre_persona_fisicamoral_solicitante']; ?></td>
                        </tr>
                        <tr>
                            <th>Representante Legal</th>
                            <td><?php echo $datos['nombre_representante_legal_solicitante']; ?></td>
                        </tr>
                        <tr>
                            <th>Inciso </th>
                            <td><font size="2"><B><?php echo $CUENTA; ?></B></font></td>
                        </tr>
                        <tr>
                            <th>Concepto</th>
                            <td><font size="2"><?php echo $CONCEPTO; ?></font></td>
                        </tr>
                        <tr>
                            <th>Descripcion</th>
                            <td><font size="2"><?php echo $DESCRIPCION_TRAMITE; ?></font></td>
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
echo '<td class="monto-value">'.number_format($MONTO_UMAS).' UMAS</td>';
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
        
        
    <script>
        // Auto-print when the page loads
        window.onload = function() {
            // Esperar un momento para que se cargue la página completamente
            setTimeout(function() {
                document.querySelector('.print-button').style.display = 'block';
            }, 1000);
        };
    </script>
</body>
</html> 

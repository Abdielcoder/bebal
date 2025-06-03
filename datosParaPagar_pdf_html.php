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
    <title>Recibo de I&RAD - <?php echo $datos['nombre_comercial_establecimiento']; ?></title>
    <style>



        @media print {
            html {
                width: 100%;
                height: 100%;
                margin: 0 !important; /* Asegurar que html no tenga márgenes */
                padding: 0 !important; /* Asegurar que html no tenga padding */
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                overflow: hidden;
            }
            body {
                width: 210mm; /* Tamaño carta exacto */
                height: 279mm; /* Tamaño carta exacto */
                margin: 0 !important; /* El body en sí no debe tener margen, el html lo centrará */
                padding: 0 !important; /* El body en sí no debe tener padding */
                /* Otros estilos específicos del body para impresión pueden ir aquí si es necesario */
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
                <img src="img/SGM_LOGO_UTM-02.png" alt="Logo" width="500">
            </div>
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
$ORDEN_PAGO=$row_pago['orden_pago'];
$CONCEPTO_RECAUDACION=$row_pago['concepto_recaudacion'];

} else {

$id_proceso_tramites=$datos['id_proceso_tramites'];
$ORDEN_PAGO='';
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


            echo '<div class="title">';
                //echo '<h1>GOBIERNO MUNICIPAL DE TIJUANA</h1>';
//echo '<h2>SECRETARÍA DE GOBIERNO MUNICIPAL</h2>';
echo '<br><br>';
echo '<br><br>';
echo '<br><br>';
echo '<br><br>';
echo '<table width="90%" align="center" style="border: none; background: transparent;"><tr style="border: none; background: transparent;"><td style="border: none; background: transparent;"><center><font size="6px">'.$DESCRIPCION_TRAMITE.'</center></td></tr></table>';
	    echo '</div>';

$Folio=$datos['folio'];
         echo '<div class="date">';
	//echo 'Fecha de Impresión: '.date('d/m/Y');
echo '<p><img src="qrcode.php?s=qrl&d=https://sgm.tijuana.gob.mx/bebal/login.php?bid='.$Folio.'&op='.$ORDEN_PAGO.'"></p>';
echo '</div>';
echo '</div>';
?>
        
	<div class="main-title">
<?php


echo '<h1><font size="5px;">Orden de Pago: '.$ORDEN_PAGO.'</font></h1>';
//echo '<h1>Orden de Pago ( '.$NUMERO_RECIBO.') <b><u>'.$DESCRIPCION_TRAMITE.'</u></b></h1>';
//echo '<h2>Tramite: <u>'.$DESCRIPCION_TRAMITE_SOLICITADO.'</u></b></h2>';
?>
            <h4>PROGRAMA DE IDENTIFICACIÓN, EMPADRONAMIENTO, REGULARIZACIÓN Y REVALIDACIÓN</h4>
            <h4>DE ESTABLECIMIENTOS QUE EXPIDEN Y VENDEN AL PÚBLICO BEBIDAS CON CONTENIDO ALCOHÓLICO</h4>
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

<br><br>
<br><br>
<br><br>

<center>
            <div class="signature">
                <div class="signature-line"></div>
                <p><b>Lic. Arnulfo Guerrero León</b><br>
                Secretario de Gobierno Municipal<br>
                XXV Ayuntamiento de Tijuana, Baja California
            </div>
        </div>
</center>



   <style>
@media print {
  @page { margin: 0; }
  body { margin: 0.5cm; }
 </style>


 </style>
        
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

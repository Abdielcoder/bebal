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

##$porciones = explode("--", $ID);

$ID = $_GET['id'];
##$ID = intval($_GET['id']);

$porciones = explode("--", $ID);

$id=intval($porciones[0]);
$ID_TRAMITE_SOLICITADO=$porciones[1];
$INSPECCION_tramite_SOLICITADO=$porciones[2];
$RAD_tramite_SOLICITADO=$porciones[3];




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
##################
##################
#### Importante
##################
$estatus=$datos['estatus'];
if ($estatus=='Presupuesto') {
} else {
die("Error: Estatus Sin Solucción");
}
##################
##################

// Cabecera que indica que esto es un documento HTML
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo Presupuesto - <?php echo $datos['nombre_comercial_establecimiento']; ?></title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
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
            font-family: 'ITC Avant Garde Std', Arial, Helvetica, sans-serif;
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
################
$id_tramite=$datos['id_tramite'];
$id_proceso_tramites=$datos['id_proceso_tramites'];
$id_giro=$datos['giro'];
#
$sql_tramite="SELECT * FROM tramite WHERE id=$id_tramite";
$result_tramite = mysqli_query($con,$sql_tramite);
$row_tramite = mysqli_fetch_assoc($result_tramite);
$ID_TRAMITE=$row_tramite['id'];
$CUENTA_tramite=$row_tramite['cuenta'];
$MONTO_UMAS_tramite=$row_tramite['monto_umas'];
$DESCRIPCION_TRAMITE=$row_tramite['descripcion_tramite'];
#
$sql_giro="SELECT * FROM giro WHERE id=$id_giro";
$result_giro = mysqli_query($con,$sql_giro);
$row_giro = mysqli_fetch_assoc($result_giro);
$DESCRIPCION_GIRO=$row_giro['descripcion_giro'];
$CUENTA_giro=$row_giro['cuenta'];
$MONTO_UMAS_giro=$row_giro['monto_umas'];
##$MONTO_UMAS_REV_CAMB_giro=$row_giro['monto_umas_revalidacion_cambios'];
#############

            echo '<div class="title">';
                //<h1>GOBIERNO MUNICIPAL DE TIJUANA</h1>
//<h2>SECRETARÍA DE GOBIERNO MUNICIPAL</h2>

echo '<br><br>';
echo '<br><br>';
echo '<br><br>';
echo '<br><br>';
echo '<table width="90%" align="center" style="border: none; background: transparent;"><tr style="border: none; background: transparent;"><td style="border: none; background: transparent;"><center><font size="6px">'.$DESCRIPCION_TRAMITE.'</center></td></tr></table>';

	    echo '</div>';
?>

<?php

$COBRO_UMAS_giro=$MONTO_UMAS_giro;	//##  Permiso Nuevo

##echo 'Cobro Giro='.$COBRO_UMAS_giro;

$modalidad_graduacion_alcoholicaDB=$datos['modalidad_graduacion_alcoholica'];
$modalidad_graduacion_alcoholica_rawDB=$datos['modalidad_graduacion_alcoholica_raw'];
$numero_modalidad_graduacion_alcoholicaDB=$datos['numero_modalidad_graduacion_alcoholica'];
$monto_umas_total_modalidad_graduacion_alcoholicaDB=$datos['monto_umas_total_modalidad_graduacion_alcoholica'];
################################
### Modalidad Graduacion Alcoholica
###   raw
###   1**Exclusivamente Cerveza**401--2**Exclusivamente Vinos de Produccion Nacional**402----3**Cerveza y Vinos de Mesa**403----4**Cerveza, Vinos y Licores**404-- --5**Bebidas Alcoholicas en Envase Abierto**405
### numero_modalidad_graduacion_alcoholica -->  5
###  modalidad_graduacion_alcoholica
### (Exclusivamente Cerveza), (Exclusivamente Vinos de Produccion Nacional), (Cerveza y Vinos de Mesa), (Cerveza, Vinos y Licores) Y (Bebidas Alcoholicas en Envase Abierto)
### monto_umas_total_modalidad_graduacion_alcoholica --> 2015


if ( $numero_modalidad_graduacion_alcoholicaDB==0 ) {
$STRING_MODALIDAD="-";
} else {

if ( $numero_modalidad_graduacion_alcoholicaDB==1 ) {
$porcionesMODALIDAD = explode("**", $modalidad_graduacion_alcoholica_rawDB);
$MODALIDADGA_ID=$porcionesMODALIDAD[0];
$DESCRIPCION_MODALIDADGA=$porcionesMODALIDAD[1];
$MONTO_MODALIDADGA=$porcionesMODALIDAD[2];
$sql_Modalidad="SELECT * FROM modalidad_graduacion_alcoholica WHERE id=$MODALIDADGA_ID";
$result_Modalidad = mysqli_query($con,$sql_Modalidad);
$row_Modalidad = mysqli_fetch_assoc($result_Modalidad);
$CUENTA_MODALIDAD=$row_Modalidad['cuenta'];

$STRING_MODALIDAD=$DESCRIPCION_MODALIDADGA." <font size='3' color='blue'>".$CUENTA_MODALIDAD."</font> ".$MONTO_MODALIDADGA." umas";
} 

##
if ( $numero_modalidad_graduacion_alcoholicaDB>1 ) {
$porcionesMODALIDAD = explode("--", $modalidad_graduacion_alcoholica_rawDB);
$cuentaMODALIDAD=count($porcionesMODALIDAD);

//echo "cuentaMODALIDAD=".$cuentaMODALIDAD."<br>";
$STRING_MODALIDAD="";
for ($i=0;$i<$cuentaMODALIDAD;$i++) {
$UNIDAD_porcionesMODALIDAD=$porcionesMODALIDAD[$i];

$porcionesMODALIDAD_UNIDAD = explode("**", $UNIDAD_porcionesMODALIDAD);
$MODALIDADGA_ID=$porcionesMODALIDAD_UNIDAD[0];
$DESCRIPCION_MODALIDADGA=$porcionesMODALIDAD_UNIDAD[1];
$MONTO_MODALIDADGA=$porcionesMODALIDAD_UNIDAD[2];

//echo "MODALIDADGA_ID=$MODALIDADGA_ID, DESCRIPCION_MODALIDADGA=$DESCRIPCION_MODALIDADGA, MONTO_MODALIDADGA= $MONTO_MODALIDADGA<br>";

$sql_Modalidad="SELECT * FROM modalidad_graduacion_alcoholica WHERE id=$MODALIDADGA_ID";
$result_Modalidad = mysqli_query($con,$sql_Modalidad);
$row_Modalidad = mysqli_fetch_assoc($result_Modalidad);
$CUENTA_MODALIDAD=$row_Modalidad['cuenta'];

$STRING_MODALIDAD.=$DESCRIPCION_MODALIDADGA." <font size='3' color='blue'>".$CUENTA_MODALIDAD."</font> <font color='red'>".$MONTO_MODALIDADGA." umas</font>";

}
}
}

#########################
$servicios_adicionalesDB=$datos['servicios_adicionales'];
$servicios_adicionales_rawDB=$datos['servicios_adicionales_raw'];
$numero_servicios_adicionalesDB=$datos['numero_servicios_adicionales'];
$monto_umas_total_servicios_adicionalesDB=$datos['monto_umas_total_servicios_adicionales'];
################################
### Servicios Adicionales
###   raw
###  1**Musica Grabada y Aparatos Musicales**301--2**Conjunto Musicales**302----3**Mesas de Billar**303----4**Espectaculos Artisticos**304-- --5**Pista de Baile**305
###  numero_servicios_adicionales   -->   5 
### servicios_adicionales
### (Musica Grabada y Aparatos Musicales), (Conjunto Musicales), (Mesas de Billar), (Espectaculos Artisticos) Y (Pista de Baile)
###  monto_umas_total_servicios_adicionalesDB -->    1515

if ( $numero_servicios_adicionalesDB==0 ) {
$STRING_SERVICIOS_ADICIONALES="-";
} else {
if ( $numero_servicios_adicionalesDB==1 ) {
$porcionesSA = explode("**", $servicios_adicionales_rawDB);
$SA_ID=$porcionesSA[0];
$DESCRIPCION_SA=$porcionesSA[1];
$MONTO_SA=$porcionesSA[2];
$sql_SA="SELECT * FROM servicios_adicionales WHERE id=$SA_ID";
$result_SA = mysqli_query($con,$sql_SA);
$row_SA = mysqli_fetch_assoc($result_SA);
$CUENTA_SA=$row_SA['cuenta'];

$STRING_SERVICIOS_ADICIONALES=$DESCRIPCION_SA." <font size='3' color='blue'>".$CUENTA_SA."</font><font color='red'>  ".$MONTO_SA." umas</font>";
}

##
##if ( $numero_servicios_adicionalesDB>1 ) {
##$porcionesSA = explode("--", $servicios_adicionales_rawDB);
##$cuentaSA=count($porcionesSA);

##echo "cuentaSA=".$cuentaSA."<br>";
##$STRING_SERVICIOS_ADICIONALES="";
###for ($j=0;$j<$cuentaSA;$j++) {
##$UNIDAD_porcionesSA=$porcionesSA[$j];

###$porcionesSA_UNIDAD = explode("**", $UNIDAD_porcionesSA);
###$SA_ID=$porcionesSA_UNIDAD[0];
###$DESCRIPCION_SA=$porcionesSA_UNIDAD[1];
###$MONTO_SA=$porcionesSA_UNIDAD[2];

###$sql_SA="SELECT * FROM servicios_adicionales WHERE id=$SA_ID";
###$result_SA = mysqli_query($con,$sql_SA);
###$row_SA = mysqli_fetch_assoc($result_SA);
###$CUENTA_SA=$row_SA['cuenta'];

###$STRING_SERVICIOS_ADICIONALES.=$DESCRIPCION_SA." <font size='3' color='blue'>".$CUENTA_SA."</font><font color='red'>  ".$MONTO_SA." umas</font>";

###}
##}
}

##############################

$Folio=$datos['folio'];
            echo '<div class="date">';
		//echo 'Fecha de Impresión: '.date('d/m/Y');
echo '<p><img src="qrcode.php?s=qrl&d=https://sgm.tijuana.gob.mx/consulta-constancia/?folio='.$Folio.'"></p>';
	    echo '</div>';
?>
        </div>
        
	<div class="main-title">
<?php
$todayANO = date("Y");
$ORDEN_PAGO='PX-'.$id.$id_proceso_tramites.'-'.$todayANO;
echo '<h1><font size="5px;">Orden de Pago: '.$ORDEN_PAGO.'</font></h1>';


// Generar y mostrar el código de barras para ORDEN_PAGO usando JsBarcode
if (isset($ORDEN_PAGO) && trim($ORDEN_PAGO) !== '') {
    $orden_pago_clean = trim($ORDEN_PAGO);
    echo '<div style="text-align: center; margin-top: 5px; margin-bottom: 15px;">';
    echo '    <svg id="barcode-orden-pago"></svg>';
    echo '</div>';
    echo '<script>';
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    echo '    if (typeof JsBarcode !== "undefined") {';
    echo '        JsBarcode("#barcode-orden-pago", "'.htmlspecialchars($orden_pago_clean).'", {';
    echo '            format: "CODE39",';
    echo '            width: 2,';
    echo '            height: 50,';
    echo '            displayValue: false,';
    echo '            margin: 0';
    echo '        });';
    echo '    }';
    echo '});';
    echo '</script>';
} else {
    // Opcional: si quieres un mensaje si $ORDEN_PAGO está vacía para el barcode
    // echo '<p style="text-align:center; color:red; margin-bottom: 10px;">Código de Barras para Orden de Pago no disponible.</p>';
}

//echo '<h1>Orden de Pago ( '.$NUMERO_RECIBO.') <b><u>'.$DESCRIPCION_TRAMITE.'</u></b></h1>';
//echo '<h2>Tramite: <u>'.$DESCRIPCION_TRAMITE_SOLICITADO.'</u></b></h2>';


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
                            <th>Tramite</th>
			    <td><?php echo $DESCRIPCION_TRAMITE; ?> </td>
                        </tr>


			<tr>


			    <th>Giro</th>
<?php
echo '<td>';
echo $datos['giro_desc']; 
echo '   <font color="blue" size="3">'.number_format($COBRO_UMAS_giro,2).' umas </font>';
echo '</td>';
?>
			</tr>


			<tr>
<?php
$MONTO_TOTAL_UMAS=$monto_umas_total_servicios_adicionalesDB+$COBRO_UMAS_giro;
$CONCEPTO_RECAUDACION=$DESCRIPCION_TRAMITE.';'.$MONTO_TOTAL_UMAS;
echo '<th>Concepto Barandilla</th>';
echo '<td><font size="2">'.$CONCEPTO_RECAUDACION.'</font></td>';
?>
                        </tr>

                        <tr>
                            <th>Inciso </th>
                            <td><font size="2"><B><?php echo $CUENTA_tramite; ?></B></font></td>
                        </tr>
















                        <tr>
                            <th>Modalidad Graduación Alcohólica</th>
<?php
echo '<td>';
echo $datos['modalidad_graduacion_alcoholica']."   * [".$datos['numero_modalidad_graduacion_alcoholica']."]"; 
echo '</td>';
?>
			</tr>

                        <tr>
                            <th>Servicios Adicionales</th>
<?php
echo '<td>';
echo $datos['servicios_adicionales']."   * [".$datos['numero_servicios_adicionales']."]"; 
echo '   <font color="blue" size="3">'.number_format($monto_umas_total_servicios_adicionalesDB,2).' umas </font>';
echo '</td>';


?>
			</tr>



                        <tr>
                            <th>Persona Física/Moral</th>
                            <td><?php echo $datos['nombre_persona_fisicamoral_solicitante']; ?></td>
                        </tr>
                        <tr>
                            <th>Representante Legal</th>
                            <td><?php echo $datos['nombre_representante_legal_solicitante']; ?></td>
			</tr>
<?php
//<tr>
//<th>Descripcion</th>
//<td><font size="2">'.$DESCRIPCION_TRAMITE.'</font></td>
//</tr>
?>
                    </table>
                </div>
                
            </div>
        
        <div class="section">
            <div class="section-title">MONTO A PAGAR</div>
            <table class="monto-table">
                <tr>
		    <td class="monto-label">Total a Pagar:</td>
<?php
echo '<td class="monto-value"><font color="blue">'.number_format($MONTO_TOTAL_UMAS,2).' umas</font></td>';
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
  body { margin: 2cm; }
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


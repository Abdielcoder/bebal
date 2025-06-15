<?php

include('ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

// Activar mostrado de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}



// Incluir configuración de base de datos
require_once ("config/db.php");
require_once ("config/conexion.php");

// Verificar que se recibió el ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: No se especificó un ID válido");
}

$id = intval($_GET['id']);

// Consultar datos del establecimiento
$sql = "SELECT p.*, 
        g.descripcion_giro AS giro_desc, 
        g.horario_funcionamiento AS horario_funcionamiento, 
        mu.municipio AS municipio_desc,
        d.delegacion AS delegacion_desc,
        c.colonia AS colonia_desc
        FROM principal_temp p
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
    <title>Datos Generales - <?php echo $datos['nombre_comercial_establecimiento']; ?></title>
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
            echo '<div class="title">';
                //<h1>GOBIERNO MUNICIPAL DE TIJUANA</h1>
                //<h2>SECRETARÍA DE GOBIERNO MUNICIPAL</h2>
	    echo '</div>';

$Folio=$datos['folio'];
            echo '<div class="date">';
		//echo 'Fecha de Impresión: '.date('d/m/Y');
echo '<p><img src="qrcode.php?s=qrl&d=https://sgm.tijuana.gob.mx/consulta-constancia/?folio='.$Folio.'"></p>';
	    echo '</div>';
?>
        </div>
        
	<div class="main-title">
<center>
<h3>SOLICITUD DEL PROGRAMA DE IDENTIFICACIÓN, EMPADRONAMIENTO, REGULARIZACIÓN Y REVALIDACIÓN DE ESTABLECIMIENTOS QUE EXPIDEN Y VENDEN AL PÚBLICO BEBIDAS CON CONTENIDO ALCOHÓLICO</h3>
</center>
        </div>
        
        <div class="folio">
            BID: <?php echo $datos['folio']; ?>
	</div>


            <div class="column">
		<div class="section">
<?php
echo '<div class="section-title">PERMISO TEMPORAL</div>';
?>
                    <table class="compact-table">
                        <tr>
                            <th>Giro</th>
                            <td><?php echo $datos['giro_desc']; ?></td>
                        </tr>

                        <tr>
                            <th>Modalidad de Graduación Alcohólica</th>
                            <td><?php echo $datos['modalidad_graduacion_alcoholica']; ?> * [<?php echo $datos['numero_modalidad_graduacion_alcoholica']; ?>]</td>
			</tr>

                        <tr>
                            <th>Servicios Adicionales</th>
                            <td><?php echo $datos['servicios_adicionales']; ?> * [<?php echo $datos['numero_servicios_adicionales']; ?>]</td>
			</tr>


                        <tr>
                            <th>Fecha Registro</th>
                            <td><?php echo $datos['fecha_alta']; ?></td>
                        </tr>

                    </table>
                </div>
            </div>



            <div class="column">
                <div class="section">
                    <div class="section-title">DATOS DEL ESTABLECIMIENTO</div>
                    <table class="compact-table">
                        <tr>
                            <th>Nombre Comercial</th>
                            <td><?php echo $datos['nombre_comercial_establecimiento']; ?></td>
                        </tr>
<?php
if ( $datos['calle_establecimiento']=='' || $datos['calle_establecimiento']==NULL || empty($datos['calle_establecimiento']) ) {
} else {
echo '<tr>';
echo '<th>Domicilio</th>';
echo '<td>'.$datos['calle_establecimiento'].' #'.$datos['numero_establecimiento'];
if ( !empty($datos['numerointerno_local_establecimiento']) ) echo ' Int. '.$datos['numerointerno_local_establecimiento'];
echo '</td>';
echo '</tr>';
}

if ( $datos['clave_catastral']=='' || $datos['clave_catastral']==NULL || empty($datos['clave_catastral'])) {

echo '<tr>';
echo '<th>Colonia Delegación / Ciudad / CP</th>';
echo '<td> </td>';
echo '</tr>';

echo '<tr>';
echo '<th>Número de Cuenta / Clave Catastral</th>';
echo '<td> NA / NA</td>';
echo '</tr>';


echo '<tr>';
echo '<tr>';
echo '<th>No. de Comensales / Superficie (m²)</th>';
echo '<td></td>';
echo '</tr>';




} else {

echo '<tr>';
echo '<th>Colonia Delegación / Ciudad / CP</th>';
echo '<td>'.$datos['colonia_desc'].' '.$datos['delegacion_desc'].' / '.$datos['municipio_desc'].' / '.$datos['cp_establecimiento'].'</td>';
echo '</tr>';

$numero_cuenta=$datos['numero_cuenta'];
if ( empty($numero_cuenta) || $numero_cuenta=='' ) $numero_cuenta='-';

echo '<tr>';
echo '<th>Número de Cuenta / Clave Catastral</th>';
echo '<td>'.$numero_cuenta.' /  '.$datos['clave_catastral'].'</td>';
echo '</tr>';


echo '<tr>';
echo '<tr>';
echo '<th>No. de Comensales / Superficie</th>';
echo '<td>'.$datos['capacidad_comensales_personas'].' Personas / '.$datos['superficie_establecimiento'].' (m²)</td>';
echo '</tr>';
}
?>
                        <tr>
                            <th>Horario Funcionamiento</th>
                            <td><?php echo $datos['horario_funcionamiento']; ?> </td>
                        </tr>


                    </table>
                </div>
            </div>




            <div class="column">
                <div class="section">
                    <div class="section-title">DATOS DEL SOLICITANTE</div>
		    <table class="compact-table">

<?php

if ( $datos['nombre_persona_fisicamoral_solicitante']=='' || $datos['nombre_persona_fisicamoral_solicitante']==NULL  || empty($datos['nombre_persona_fisicamoral_solicitante'])  ) {

echo '<tr>';
echo '<th>Persona Física/Moral</th>';
echo '<td> </td>';
echo '</tr>';
echo '<tr>';
echo '<th>Representante Legal</th>';
echo '<td>'.$datos['nombre_representante_legal_solicitante'].'</td>';
echo '</tr>';
echo '<tr>';
echo '<th>RFC / Persona Física o Moral</th>';
echo '<td> </td>';
echo '</tr>';
echo '<tr>';
echo '<th>Domicilio</th>';
echo '<td> </td>';
echo '</tr>';
echo '<tr>';
echo '<th>Email / Teléfono</th>';
echo '<td> </td>';
echo '</tr>';

} else {
echo '<tr>';
echo '<th>Persona Física/Moral</th>';
echo '<td>'.$datos['nombre_persona_fisicamoral_solicitante'].'</td>';
echo '</tr>';
echo '<tr>';
echo '<th>Representante Legal</th>';
echo '<td>'.$datos['nombre_representante_legal_solicitante'].'</td>';
echo '</tr>';
echo '<tr>';
echo '<th>RFC</th>';
echo '<td>'.$datos['rfc'].' <font color="blue">Persona ( '.$datos['fisica_o_moral'].'</font> )</td>';
echo '</tr>';
echo '<tr>';
echo '<th>Domicilio</th>';
echo '<td>'.$datos['domicilio_solicitante'].'</td>';
echo '</tr>';
echo '<tr>';
echo '<th>Email / Teléfono</th>';
echo '<td>'.$datos['email_solicitante'].' / '.$datos['telefono_solicitante'].'</td>';
echo '</tr>';
}
?>
                    </table>
                </div>
	</div>


        <div class="legal"><font size="1"><i>
            Mediante Acuerdo del Cabildo de fecha once de diciembre del dos mil veinticuatro en el punto de acuerdo número VI.3, 
            se autoriza a la Secretaría de Gobierno Municipal para que instrumente el programa de identificación, empadronamiento 
            y regularización de la situación jurídica y administrativa de las personas físicas o morales que se dediquen a la 
            expedición y venta, en envase cerrado y abierto, de bebidas con contenido alcohólico, a fin de que se actualice su 
            situación jurídica. Este documento no implica que se vaya a expedir un permiso nuevo y/o autorizar la regularización de uno previo.
        </i></font></div>

<p>&nbsp;</p>
<br>

        <div class="signatures">
            <div class="signature">
                <div class="signature-line"></div>
                Firma del Solicitante<br>
       <b><?php echo $datos['nombre_representante_legal_solicitante']; ?></b>
            </div>
            <div class="signature">
		<div class="signature-line"></div>


<?php
##
$sql_generales="SELECT descripcion FROM generales WHERE dato_general='Firma'";
$result_generales = mysqli_query($con,$sql_generales);
$row_generales = mysqli_fetch_assoc($result_generales);
$FIRMA=$row_generales['descripcion'];
##
#
if ( $FIRMA=='Secretario' ) {
echo '<p><b>Lic. Arnulfo Guerrero León</b><br>';
echo 'Secretario de Gobierno Municipal<br>';
echo 'XXV Ayuntamiento de Tijuana, Baja California';
} else {

echo '<p><b>Dr. José Alonso López Sepúlveda</b><br>';
echo 'Director General de Gobierno<br>';
echo 'Secretaria de Gobierno Municipal<br>';
echo 'XV Ayuntamiento de Tijuana, Baja California';
}


?>



            </div>
        </div>
    </div>

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

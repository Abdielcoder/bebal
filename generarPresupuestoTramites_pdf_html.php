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
$page = intval($_GET['page']);
#######################

$arregloPresupuesto=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `presupuesto` WHERE id_principal=$id AND estatus='Inicio'"));
$TRAMITES_PRESUPUESTO=$arregloPresupuesto['tramites'];
$RFC=$arregloPresupuesto['rfc'];
$FISICA_O_MORAL=$arregloPresupuesto['fisica_o_moral'];
$NOMBRE_PERSONA_FISICAMORAL_SOLICITANTE=$arregloPresupuesto['nombre_persona_fisicamoral_solicitante'];
$NOMBRE_REPRESENTANTE_SOLICITANTE=$arregloPresupuesto['nombre_representante_legal_solicitante'];
$DOMICILIO_SOLICITANTE=$arregloPresupuesto['domicilio_solicitante'];
$EMAIL_SOLICITANTE=$arregloPresupuesto['email_solicitante'];
$TELEFONO_SOLICITANTE=$arregloPresupuesto['telefono_solicitante'];

#####################



// Consultar datos del establecimiento
$sql = "SELECT p.*, 
        g.descripcion_giro AS giro_desc, 
        g.horario_funcionamiento AS horario_funcionamiento, 
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

###############################

if ( $datos['calle_establecimiento']=='' || $datos['calle_establecimiento']==NULL || empty($datos['calle_establecimiento']) ) {
$domicilio_establecimiento='NA';
} else {
$domicilio_establecimiento=$datos['calle_establecimiento'].' '.$datos['numero_establecimiento'];
}


if ( $datos['clave_catastral']=='' || $datos['clave_catastral']==NULL || empty($datos['clave_catastral'])) {
$clave_catastral='NA';
} else {
$clave_catastral=$datos['clave_catastral'];
}

###
if ( $datos['capacidad_comensales_personas']=='' || empty($datos['capacidad_comensales_personas']) ) {
$CAPACIDAD_COMENSALES_PERSONAS='NA';
} else {
$CAPACIDAD_COMENSALES_PERSONAS=$datos['capacidad_comensales_personas'].' Personas';
}
###
if ( $datos['superficie_establecimiento']=='' || empty($datos['superficie_establecimiento']) ) {
$SUPERFICIE_ESTABLECIMIENTO='NA';
} else {
$SUPERFICIE_ESTABLECIMIENTO=$datos['superficie_establecimiento'].' (m²)';
}
###
$GRUPO4=$CAPACIDAD_COMENSALES_PERSONAS.' / '.$SUPERFICIE_ESTABLECIMIENTO;
###

$colonia_delegacion_municipio_establecimiento=$datos['colonia_desc'].' '.$datos['delegacion_desc'].' / '.$datos['municipio_desc'].' / '.$datos['cp_establecimiento'];

#########################
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
$NUMERO_PERMISO_ANTERIOR='No Disponible';
}

$numero_cuenta=$datos['numero_cuenta'];
if ( empty($numero_cuenta) || $numero_cuenta=='' ) $numero_cuenta='No Disponible';

########################
$url = "https://landingbebal-production.up.railway.app/api/datorapido";

$data = [
    "folio" => $datos['folio'],
    "giro" => $datos['giro_desc'],
    "modalidad_graduacion_alcoholica" => $datos['modalidad_graduacion_alcoholica'],
    "servicios_adicionales" => $datos['servicios_adicionales'],
    "numero_servicios_adicionales" => $datos['numero_servicios_adicionales'],
    "fecha_registro" => $datos['fecha_alta'],
    "nombre_comercial" => $datos['nombre_comercial_establecimiento'],
    "domicilio" => $domicilio_establecimiento,
    "colonia_delegacion_ciudad_cp" => $colonia_delegacion_municipio_establecimiento,
    "clave_catastral" => $clave_catastral,
    "comensales_superficie" => $GRUPO4,
    "horario_funcionamiento" => $datos['horario_funcionamiento'],
    "tramites_presupuesto"=> $TRAMITES_PRESUPUESTO,
"rfc_solicitante"=> $RFC,
"fisica_o_moral_solicitante"=> $FISICA_O_MORAL,
"nombre_persona_fisicamoral_solicitante"=> $NOMBRE_PERSONA_FISICAMORAL_SOLICITANTE,
"nombre_representante_legal_solicitante"=> $NOMBRE_REPRESENTANTE_SOLICITANTE,
"domicilio_solicitante"=> $DOMICILIO_SOLICITANTE,
"email_solicitante"=> $EMAIL_SOLICITANTE,
"telefono_solicitante"=> $TELEFONO_SOLICITANTE,
"numero_permiso_anterior"=> $NUMERO_PERMISO_ANTERIOR,
"numero_permiso_nuevo"=> $datos['numero_permiso'],
"numero_cuenta"=> $datos['numero_cuenta']
];

$options = [
    'http' => [
        'header'  => "Content-Type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
        'ignore_errors' => true
    ]
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    // Manejo de error
    echo "Error al consumir la API";
} else {
    // Respuesta de la API
    ##echo $result;
}




###############################
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
            font-size: 10px;
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
            font-size: 12px;
            font-weight: bold;
            width: 30%;
        }
        
        .monto-value {
            font-size: 14px;
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
<br>
<?php
            echo '<div class="title">';
                //<h1>GOBIERNO MUNICIPAL DE TIJUANA</h1>
		//<h2>SECRETARÍA DE GOBIERNO MUNICIPAL</h2>
echo '<br><br>';
echo '<br><br>';
echo '<br><br>';
echo '<br><br>';
echo '<table width="100%" align="center" style="border: none; background: transparent;"><tr style="border: none; background: transparent;"><td style="border: none; background: transparent;"><center><font size="5px"><b>CUMPLIMIENTO DE REQUISITOS CONSTANCIA</b></center></td></tr></table>';

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
<p><font size="2px">PROGRAMA DE IDENTIFICACIÓN, EMPADRONAMIENTO, REGULARIZACIÓN Y REVALIDACIÓN DE ESTABLECIMIENTOS QUE EXPIDEN Y VENDEN AL PÚBLICO BEBIDAS CON CONTENIDO ALCOHÓLICO</font></p>
</center>
        </div>
        
        <div class="folio">
            BID: <?php echo $datos['folio']; ?>
	</div>


            <div class="column">
		<div class="section">
<?php
if ( $datos['operacion']=='NUEVO' ) {
echo '<div class="section-title">TRAMITE: PERMISO NUEVO</div>';
} else {
echo '<div class="section-title"> <font color="black">TRAMITE(S): '.$TRAMITES_PRESUPUESTO.'</font></div>';
}
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
<?php
//<tr>
//<th>Número de Permiso Nuevo</th>
//<td>'.$datos['numero_permiso.'</td>
//</tr>
?>

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
echo '<td> NA </td>';
echo '</tr>';

echo '<tr>';
echo '<th>Número de Cuenta / Clave Catastral</th>';
echo '<td> NA / NA </td>';
echo '</tr>';


echo '<tr>';
echo '<tr>';
echo '<th>No. de Comensales / Superficie (m²)</th>';
echo '<td> NA </td>';
echo '</tr>';




} else {

echo '<tr>';
echo '<th>Colonia Delegación / Ciudad / CP</th>';
echo '<td>'.$datos['colonia_desc'].' '.$datos['delegacion_desc'].' / '.$datos['municipio_desc'].' / '.$datos['cp_establecimiento'].'</td>';
echo '</tr>';

echo '<tr>';
echo '<th>Número de Cuenta / Clave Catastral</th>';
echo '<td>'.$numero_cuenta.' / '.$datos['clave_catastral'].'</td>';
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
                        <tr>
                            <th>Número de Permiso Anterior</th>
                            <td><?php echo $NUMERO_PERMISO_ANTERIOR; ?></td>
                        </tr>


                    </table>
                </div>
            </div>




            <div class="column">
                <div class="section">
                    <div class="section-title">DATOS DEL SOLICITANTE</div>
		    <table class="compact-table">

<?php

if ( $NOMBRE_PERSONA_FISICAMORAL_SOLICITANTE=='' || $NOMBRE_PERSONA_FISICAMORAL_SOLICITANTE==NULL  || empty($NOMBRE_PERSONA_FISICAMORAL_SOLICITANTE)  ) {

echo '<tr>';
echo '<th>Persona Física/Moral</th>';
echo '<td> NA </td>';
echo '</tr>';
echo '<tr>';
echo '<th>Representante Legal</th>';
echo '<td>'.$datos['nombre_representante_legal_solicitante'].'</td>';
echo '</tr>';
echo '<tr>';
echo '<th>RFC / Persona Física o Moral</th>';
echo '<td> NA </td>';
echo '</tr>';
echo '<tr>';
echo '<th>Domicilio</th>';
echo '<td> NA </td>';
echo '</tr>';
echo '<tr>';
echo '<th>Email / Teléfono</th>';
echo '<td> NA </td>';
echo '</tr>';

} else {
echo '<tr>';
echo '<th>Persona Física/Moral</th>';
echo '<td>'.$NOMBRE_PERSONA_FISICAMORAL_SOLICITANTE.'</td>';
echo '</tr>';
echo '<tr>';
echo '<th>Representante Legal</th>';
echo '<td>'.$NOMBRE_REPRESENTANTE_SOLICITANTE.'</td>';
echo '</tr>';
echo '<tr>';
echo '<th>RFC</th>';
echo '<td>'.$RFC.' <font color="blue">Persona ( '.$FISICA_O_MORAL.'</font> )</td>';
echo '</tr>';
echo '<tr>';
echo '<th>Domicilio</th>';
echo '<td>'.$DOMICILIO_SOLICITANTE.'</td>';
echo '</tr>';
echo '<tr>';
echo '<th>Email / Teléfono</th>';
echo '<td>'.$EMAIL_SOLICITANTE.' / '.$TELEFONO_SOLICITANTE.'</td>';
echo '</tr>';
}
?>
                    </table>
                </div>
	    </div>


        <?php
        // IMPORTANTE: Asegúrate de que la variable $ORDEN_PAGO esté definida y tenga un valor ANTES de este bloque.
        // Por ejemplo, podría venir de una consulta a la base de datos o de otra variable:
        // if (isset($datos['tu_campo_orden_pago'])) { $ORDEN_PAGO = $datos['tu_campo_orden_pago']; }
        // else { $ORDEN_PAGO = 'VALOR_POR_DEFECTO_O_ERROR'; }

        if (isset($ORDEN_PAGO) && trim($ORDEN_PAGO) !== '') {
            // Code 39 requiere que el valor esté rodeado de asteriscos (*).
            // Usualmente se usa en mayúsculas y solo permite caracteres alfanuméricos y algunos símbolos (- . $ / + % espacio).
            $barcode_display_value = '*' . strtoupper(trim($ORDEN_PAGO)) . '*';
            $human_readable_value = htmlspecialchars(trim($ORDEN_PAGO));
        ?>
            <div style="text-align: center; margin-top: 20px; margin-bottom: 20px;">
                 Falls back to a generic cursive font if 'barcode-font' is not defined or the specific font is not available. -->
                <div class="barcode-font" style="font-size: 48px; line-height: 1; margin-bottom: 5px; font-family: 'Libre Barcode 39', 'Free 3 of 9', cursive;"><?php echo htmlspecialchars($barcode_display_value); ?></div>
                <div style="font-size: 12px;"><?php echo $human_readable_value; ?></div>
            </div>
        <?php
        } else {
            // Opcional: Si quieres mostrar un mensaje cuando $ORDEN_PAGO no está disponible o está vacía, descomenta la siguiente línea:
            // echo '<p style="text-align:center; color:red; margin-top: 20px; margin-bottom: 20px;">Código de Barras no disponible: Valor ORDEN_PAGO no encontrado.</p>';
        }
        ?>

        <div class="legal"><font size="1"><i>
            Mediante Acuerdo del Cabildo de fecha once de diciembre del dos mil veinticuatro en el punto de acuerdo número VI.3, 
            se autoriza a la Secretaría de Gobierno Municipal para que instrumente el programa de identificación, empadronamiento 
            y regularización de la situación jurídica y administrativa de las personas físicas o morales que se dediquen a la 
            expedición y venta, en envase cerrado y abierto, de bebidas con contenido alcohólico, a fin de que se actualice su 
            situación jurídica. Este documento no implica que se vaya a expedir un permiso nuevo y/o autorizar la regularización de uno previo.
        </i></font></div>

<p>&nbsp;</p>

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

echo '<p><b>LIC. ARNULFO GUERRERO LEÓN</b><br>';
echo 'Secretario de Gobierno Municipal<br>';
echo 'XXV Ayuntamiento de Tijuana, Baja California';
} else {
echo '<p><b>DR. JOSÉ ALONSO LÓPEZ SEPÚLVEDA</b><br>';
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

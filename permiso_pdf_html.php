<?php

include('ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado


$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];
$ID_USER=$_SESSION['user_id'];


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

date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");
$fecha_datetime_hoy=date("Y-m-d H:i:s");


// Verificar que se recibió el ID
if (!isset($_POST['id']) || empty($_POST['id'])) {
$Kuery_Insert ="INSERT INTO impresiones (
numero_permiso,
folio,
folio_carton,
id_principal,
user_id,
fecha_hora,
nota
) VALUES (
'ND',
'ND',
'ND',
0,
$ID_USER,
'$fecha_datetime_hoy',
'Error: No se especificó un ID válido'
);";
$query_Insert = mysqli_query($con,$Kuery_Insert);

die("Error: No se especificó un ID válido");
}

$id = intval($_POST['id']);
$nip = $_POST['nip'];
$folio_carton = $_POST['folio_carton'];





####################################################


function funcion_MES ($mes) {

switch ($mes) {
        case "01":
        return "ENERO";
        break;
        case "02":
        return "FEBRERO";
        break;
        case "03":
        return "MARZO";
        break;
        case "04":
        return "ABRIL";
        break;
        case "05":
        return "MAYO";
        break;
        case "06":
        return "JUNIO";
        break;
        case "07":
        return "JULIO";
        break;
        case "08":
        return "AGOSTO";
        break;
        case "09":
        return "SEPTIEMBRE";
        break;
        case "10":
        return "OCTUBRE";
        break;
        case "11":
        return "NOVIEMBRE";
        break;
        case "12":
        return "DICIEMBRE";
        break;
}

}


####################################################

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
$Kuery_Insert ="INSERT INTO impresiones (
numero_permiso,
folio,
folio_carton,
id_principal,
user_id,
fecha_hora,
nota
) VALUES (
'ND',
'ND',
'ND',
$id,
$ID_USER,
'$fecha_datetime_hoy',
'Error: No se encontró el registro solicitado'
);";
$query_Insert = mysqli_query($con,$Kuery_Insert);
###
ie("Error: No se encontró el registro solicitado");
}

##################
$datos = mysqli_fetch_assoc($resultado);
$NIPdb=$datos['nip'];
##################

$numero_permisoDB=$datos['numero_permiso'];
$folioDB=$datos['folio'];


if ( $nip!=$NIPdb ) {

$Kuery_Insert ="INSERT INTO impresiones (
numero_permiso,
folio,
folio_carton,
id_principal,
user_id,
fecha_hora,
nota
) VALUES (
'$numero_permisoDB',
'$folioDB',
'$folio_carton',
$id,
$ID_USER,
'$fecha_datetime_hoy',
'Error: El NIP no coincide'
);";
$query_Insert = mysqli_query($con,$Kuery_Insert);

//echo 'El NIP no coincide';
die("Error: El NIP no coincide");
//sleep(2);
//header("location: index.php");
}


$Kuery_Insert ="INSERT INTO impresiones (
numero_permiso,
folio,
folio_carton,
id_principal,
user_id,
fecha_hora,
nota
) VALUES (
'$numero_permisoDB',
'$folioDB',
'$folio_carton',
$id,
$ID_USER,
'$fecha_datetime_hoy',
'OK'
);";
$query_Insert = mysqli_query($con,$Kuery_Insert);



// Cabecera que indica que esto es un documento HTML
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permiso de Alcoholes  - <?php echo $datos['nombre_comercial_establecimiento']; ?></title>
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
            font-family: 'ITC Avant Garde Std', Arial, Helvetica, sans-serif;
            margin: 0;
            margin: 0 auto;
            font-size: 16px;
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
        

.tab {
    display: inline-block;
    margin-left: 10px;  /* for e.g: value = 40px*/
} 

.tab2 {
    display: inline-block;
    margin-left: 20px;  /* for e.g: value = 40px*/
} 

.tab10 {
    display: inline-block;
    margin-left: 100px;  /* for e.g: value = 40px*/
} 

.tab15 {
    display: inline-block;
    margin-left: 150px;  /* for e.g: value = 40px*/
} 

.tab20 {
    display: inline-block;
    margin-left: 300px;  /* for e.g: value = 40px*/

    </style>
</head>

<body>
    <button class="print-button no-print" onclick="window.print()">Imprimir Permiso</button>
    
<?php
//<div class="header">
echo '<table width="800px">';
echo '<tbody>';
echo '<tr>';
echo '<td width="600px">&nbsp; </td>';
$numero_permiso=$datos['numero_permiso'];
$Folio=$datos['folio'];
echo '<td><img src="qrcode.php?s=qrl&d='.$numero_permiso.'"></td>';
echo '</tr>';
echo '</tbody>';
echo '</table>';
?>

<p>&nbsp; </p>
<p>&nbsp; </p>

<p style="line-height: 27px;">&nbsp; </p>
<?php
echo '<table width="800px">';
echo '<tbody>';
echo '<tr>';
echo '<td class="tab" width="570px"></td>';
echo '<td class="tab"><font color="red"><b>'.$datos['numero_permiso'].'</b></font></td>';
echo '</tbody>';
echo '</tr>';
echo '</table>';

echo '<p style="line-height: 0.2px;">&nbsp; </p>';

$NOMBRE_PERSONA_FISICAMORAL_SOLICITANTE=strtoupper($datos['nombre_persona_fisicamoral_solicitante']);
$RFC=strtoupper($datos['rfc']);
echo '<table width="800px">';
echo '<tbody>';
echo '<tr>';
echo '<td class="tab" width="380px">'.$NOMBRE_PERSONA_FISICAMORAL_SOLICITANTE.'</td>';
echo '<td class="tab">'.$RFC.'</td>';
echo '</tr>';
echo '</tbody>';
echo '</table>';

echo '<p style="line-height: 0.2px;">&nbsp; </p>';

$NOMBRE_COMERCIAL_ESTABLECIMIENTO=strtoupper($datos['nombre_comercial_establecimiento']);

echo '<table width="800px">';
echo '<tbody>';
echo '<tr>';
echo '<td class="tab">'.$NOMBRE_COMERCIAL_ESTABLECIMIENTO.'</td>';
echo '</tr>';
echo '</tbody>';
echo '</table>';

###
##mysqli_real_escape_string($con,(strip_tags($_POST["observaciones"],ENT_QUOTES)))

##$CALLE=mysqli_real_escape_string($con,(strip_tags($datos['calle_establecimiento'],ENT_QUOTES)))
#
$CALLE=strtoupper($datos['calle_establecimiento']);

###$CALLE=$datos['calle_establecimiento'];
$CALLE=str_replace("á","Á",$CALLE);
$CALLE=str_replace("é","É",$CALLE);
$CALLE=str_replace("í","Í",$CALLE);
$CALLE=str_replace("ó","Ó",$CALLE);
$CALLE=str_replace("ú","Ú",$CALLE);

$COLONIA=strtoupper($datos['colonia_desc']);
$DELEGACION=strtoupper($datos['delegacion_desc']);
$MUNICIPIO=strtoupper($datos['municipio_desc']);

echo '<table width="800px"  style="margin-top: 25px;">';
echo '<tbody>';
echo '<tr>';
echo '<td class="tab"><font size="2">'.$CALLE.' #'.$datos['numero_establecimiento'];
if ( !empty($datos['numerointerno_local_establecimiento']) ) echo ' Int. '.$datos['numerointerno_local_establecimiento'];

echo ' '.$COLONIA.', DELEGACION '.$DELEGACION.' / '.$MUNICIPIO.' / CP '.$datos['cp_establecimiento'];
echo '</font></td>';
echo '</tr>';
echo '</tbody>';
echo '</table>';

#
echo '<p style="line-height:0px;">&nbsp; </p>';
##echo '<br>';
$CLAVE_CATASTRAL=strtoupper($datos['clave_catastral']);
echo '<table width="800px">';
echo '<tbody>';
echo '<tr>';
echo '<td class="tab" width="380px">'.$CLAVE_CATASTRAL.'</td>';
echo '<td class="tab">'.$datos['superficie_establecimiento'].' m²</td>';
echo '</tr>';
echo '</tbody>';
echo '</table>';

##echo '<p style="line-height: 0.2;">&nbsp; aqui --> 0.2 </p>';
echo '<br>';

$GIRO=strtoupper($datos['giro_desc']);
$HF=strtoupper($datos['horario_funcionamiento']);

echo '<table width="800px"  style="margin-top: 13px;">';
echo '<tbody>';
echo '<tr>';
echo '<td class="tab" width="380px">'.$GIRO.'</td>';
echo '<td class="tab"><font size="1">'.$HF.'</font></td>';
echo '</tr>';
echo '</tbody>';
echo '</table>';


##echo '<p style="line-height: 0.2;">&nbsp; aqui --> 0.2 </p>';
echo '<br>';

if ( $datos['fecha_autorizacion']==''  ||  empty($datos['fecha_autorizacion']) ) { 
$FECHA_AUTORIZACION='ND';
} else {
$fecha_autorizacion=$datos['fecha_autorizacion'];
$FechaPorciones3=explode("-",$fecha_autorizacion);
$ANOp3=$FechaPorciones3[0];
$MESp3=$FechaPorciones3[1];
$DIAp3=$FechaPorciones3[2];
$MES_LETRAp3=funcion_MES($MESp3);
$FECHA_AUTORIZACION=$DIAp3.'/'.$MES_LETRAp3.'/'.$ANOp3;
}
##
$fecha_alta=$datos['fecha_alta'];
$FechaPorciones4=explode("-",$fecha_alta);
$ANOp4=$FechaPorciones4[0];
$MESp4=$FechaPorciones4[1];
$DIAp4=$FechaPorciones4[2];
$MES_LETRAp4=funcion_MES($MESp4);
$FECHA_ALTA=$DIAp4.'/'.$MES_LETRAp4.'/'.$ANOp4;
##
echo '<table width="800px" style="margin-top: 13px;">';
echo '<tbody>';
echo '<tr>';
echo '<td class="tab" width="380px">'.$FECHA_AUTORIZACION.'</td>';
echo '<td class="tab">'.$FECHA_ALTA.'</td>';
echo '</tr>';
echo '</tbody>';
echo '</table>';

##echo '<p style="line-height: 0.2;">&nbsp; aqui --> 0.2 </p>';
echo '<br>';

$MODALIDAD=strtoupper($datos['modalidad_graduacion_alcoholica']);

//echo '<table width="800px"  style="height: 50px;margin-top:7px;">';
echo '<table width="800px"  style="height: 46px;margin-top:2px;">';
echo '<tbody>';
echo '<tr>';
echo '<td class="tab" width="370px"><font size="1">--'.$MODALIDAD.'--</font></td>';
echo '<td class="tab2">'.$datos['capacidad_comensales_personas'].'</td>';
echo '</tr>';
echo '</tbody>';
echo '</table>';

$SA=strtoupper($datos['servicios_adicionales']);

echo '<table width="800px"  style="height: 50px;margin-top:7px;">';
echo '<tbody>';
echo '<tr>';
if ( $datos['numero_servicios_adicionales']==0 ) {
echo '<td class="tab"><font size="1">--Sin Servicios Adicionales--</font></td>';
} else {
echo '<td class="tab"><font size="1">---'.$SA.'---</font></td>';
}
echo '</tr>';
echo '</tbody>';
echo '</table>';


$OBSERVACIONES=strtoupper($datos['observaciones']);

echo '<table width="800px"  style="height: 34px;margin-top:5px;">';
echo '<tbody>';
echo '<tr>';
if ( $datos['observaciones']==0 || empty($datos['observaciones']) ) {
echo '<td class="tab">-<font size="1">--('.$datos['folio'].'-'.$folio_carton.') Sin Observaciones---</font></td>';
} else {
echo '<td class="tab"><font size="1">---('.$datos['folio'].'-'.$folio_carton.') '.$OBSERVACIONES.'---</font></td>';
}
echo '</tr>';
echo '</tbody>';
echo '</table>';

#####################

##echo '<table width="800px" style="margin-top: 180px;">';
##echo '<tbody>';
##echo '<tr>';
##echo '<td class="tab" width="550px"> </td>';
##echo '<td class="tab"><font size="4" color="#661C32"><b>'.$datos['folio'].'</b></font></td>';
##echo '</tr>';
##echo '</tbody>';
##echo '</table>';


?>


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

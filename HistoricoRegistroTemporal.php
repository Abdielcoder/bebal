
<style>
.dropbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 120px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>


<?php
include('ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado


error_reporting(0);
session_start();

	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	// Eliminar la inclusión del modal de recibo que ya no usamos
	//include("modal/revisar_pago.php");
	//include("modal/revisar_pagoPresupuesto.php");
	//include("modal/eliminar_registro.php");
	//include("modal/efectuar_inspeccion.php");
	//include("modal/actualizar_datos_solicitante.php");
	//include("modal/actualizar_datos_establecimiento.php");
	//include("modal/actualizar_giro_modalidad_serviciosesp.php");

	$active_principal="active";
	$active_clientes="";
	$active_usuarios="";	
	$active_reportes="";


	$title="bebal";
	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>


    <?php include("head.php");?>
    <style>
        .encabezado-programa {
            background-color: var(--color-tertiary-light);
            border-radius: 4px;
            padding: 10px 15px;
            margin-bottom: 15px;
            text-align: center;
            border-left: 3px solid var(--color-primary);
            border-right: 3px solid var(--color-primary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .seccion-datos {
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            overflow: hidden;
            max-width: 85%;
            margin-left: auto;
            margin-right: auto;
        }
        
        .seccion-datos .encabezado {
            background-color: var(--color-primary);
            color: white;
            padding: 5px 12px;
            text-align: center;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }
        
        .seccion-datos .encabezado h4 {
            margin: 0;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .seccion-datos .contenido {
            padding: 8px;
        }
        
        .fila-datos {
            margin-bottom: 4px;
        }
        
        .etiqueta {
            background-color: #f4f0ec;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 0.8rem;
        }
        
        .valor {
            padding: 3px 8px;
            font-size: 0.85rem;
        }
        
        .valor-destacado {
            font-weight: 600;
        }

        .area-botones {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 15px auto 50px auto;
            max-width: 85%;
            justify-content: center;
        }
        
        .estatus-seccion {
            background-color: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            max-width: 85%;
            margin-left: auto;
            margin-right: auto;
        }
        
        .nota-legal {
            background-color: #f8f9fa;
            border-radius: 4px;
            padding: 8px;
            font-size: 0.7rem;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            max-width: 85%;
            margin-left: auto;
            margin-right: auto;
        }
        
        @media (max-width: 768px) {
            .etiqueta, .valor {
                padding: 6px 8px;
            }

            .area-botones {
                flex-direction: column;
            }
            
            .area-botones .btn {
                width: 100%;
                margin-bottom: 6px;
            }
        }
    </style>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
	
<div class="container">
<?php


################################
$IDPRINCIPAL = $_POST['idHistorico'];
$page = $_POST['paginaHistorico'];
#################################

$sqlPrincipal="SELECT * FROM principal_temp WHERE id=".$IDPRINCIPAL;
##echo $sqlPrincipal,'<br>';
$row = mysqli_fetch_array(mysqli_query($con,$sqlPrincipal));

$principal_id=$row['id'];
$folio=$row['folio'];
$fecha_autorizacion=$row['fecha_autorizacion'];
$nip=$row['nip'];

$fecha_expiracion=$row['fecha_expiracion'];
$numero_permiso=$row['numero_permiso'];

$clave_catastral=$row['clave_catastral'];
$nombre_comercial_establecimiento=$row['nombre_comercial_establecimiento'];
$calle_establecimiento=$row['calle_establecimiento'];
$entre_calles_establecimiento=$row['entre_calles_establecimiento'];
$numero_establecimiento=$row['numero_establecimiento'];
$numerointerno_local_establecimiento=$row['numerointerno_local_establecimiento'];
$cp_establecimiento=$row['cp_establecimiento'];
$nombre_persona_fisicamoral_solicitante=$row['nombre_persona_fisicamoral_solicitante'];
$nombre_representante_legal_solicitante=$row['nombre_representante_legal_solicitante'];
$domicilio_solicitante=$row['domicilio_solicitante'];
$email_solicitante=$row['email_solicitante'];
$telefono_solicitante=$row['telefono_solicitante'];
################
$id_tramite=$row['id_tramite'];
$id_proceso_tramites=$row['id_proceso_tramites'];

$ID_TRAMITE_SOLICITADO=$id_tramite;
################
$id_giro=$row['giro'];
$modalidad_graduacion_alcoholica=$row['modalidad_graduacion_alcoholica'];
$modalidad_graduacion_alcoholica_raw=$row['modalidad_graduacion_alcoholica_raw'];
$monto_umas_total_modalidad_graduacion_alcoholica=$row['monto_umas_total_modalidad_graduacion_alcoholica'];
$numero_modalidad_graduacion_alcoholica=$row['numero_modalidad_graduacion_alcoholica'];

$servicios_adicionales=$row['servicios_adicionales'];
$servicios_adicionales_raw=$row['servicios_adicionales_raw'];
$numero_servicios_adicionales=$row['numero_servicios_adicionales'];
$monto_umas_total_servicios_adicionales=$row['monto_umas_total_servicios_adicionales'];

$numero_permiso=$row['numero_permiso'];
$estatus=$row['estatus'];
$operacion=$row['operacion'];

$superficie_establecimiento=$row['superficie_establecimiento'];
$capacidad_comensales_personas=$row['capacidad_comensales_personas'];
$rfc=$row['rfc'];
$fisica_o_moral=$row['fisica_o_moral'];

$observaciones=$row['observaciones'];
$fecha_alta=$row['fecha_alta'];
$id_municipio=$row['id_municipio'];
$delegacion_id=$row['id_delegacion'];
$colonia_id=$row['id_colonia'];
$foto=$row['foto'];

##
$sql_tramite0="SELECT * FROM tramite WHERE id=".$id_tramite;
$result_tramite0 = mysqli_query($con,$sql_tramite0);
$row_tramite0 = mysqli_fetch_assoc($result_tramite0);
$TRAMITE=$row_tramite0['descripcion_tramite'];
$MONTO_UMAS_tramite=$row_tramite0['monto_umas'];
$CUENTA_tramite=$row_tramite0['cuenta'];
##
$sql_giro="SELECT * FROM giro WHERE id=".$id_giro;
$result_giro = mysqli_query($con,$sql_giro);
$row_giro = mysqli_fetch_assoc($result_giro);
$GIRO=$row_giro['descripcion_giro'];
$HORARIO_FUNCIONAMIENTO=$row_giro['horario_funcionamiento'];
$MONTO_UMAS_giro=$row_giro['monto_umas_permiso_temporal'];
$MONTO_UMAS_REV_CAMB_giro=$row_giro['monto_umas_revalidacion_cambios'];
$CUENTA_giro=$row_giro['cuenta'];

$COBRO_UMAS_giro=$MONTO_UMAS_giro;      //##  Permiso Nuevo


##
##$sql_modalidad_graduacion_alcoholica="SELECT descripcion_modalidad_graduacion_alcoholica FROM modalidad_graduacion_alcoholica WHERE id=".$id_modalidad_graduacion_alcoholica;
##$result_modalidad_graduacion_alcoholica = mysqli_query($con,$sql_modalidad_graduacion_alcoholica);
##$row_modalidad_graduacion_alcoholica = mysqli_fetch_assoc($result_modalidad_graduacion_alcoholica);
##$MODALIDAD_GA=$row_modalidad_graduacion_alcoholica['descripcion_modalidad_graduacion_alcoholica'];
##
$sql_municipio="SELECT municipio FROM municipio WHERE id=".$id_municipio;
$result_municipio = mysqli_query($con,$sql_municipio);
$row_municipio = mysqli_fetch_assoc($result_municipio);
$MUNICIPIO=$row_municipio['municipio'];
##

if ( empty($delegacion_id) ) {
$DELEGACION='ND';
$COLONIA='ND';
} else {
$sql_delegacion="SELECT delegacion FROM delegacion WHERE id=".$delegacion_id;
$result_delegacion = mysqli_query($con,$sql_delegacion);
$row_delegacion = mysqli_fetch_assoc($result_delegacion);
$DELEGACION=$row_delegacion['delegacion'];
##
$sql_colonia="SELECT colonia FROM colonias WHERE id=".$colonia_id;
$result_colonia = mysqli_query($con,$sql_colonia);
$row_colonia = mysqli_fetch_assoc($result_colonia);
$COLONIA=$row_colonia['colonia'];
##
}
##################################################
##################################################
$KueryPT_Alta="SELECT * FROM proceso_tramites_temp WHERE id_tramite=22 AND id_principal=$IDPRINCIPAL";
##echo $KueryPT;
$arregloPT_Alta = mysqli_fetch_array(mysqli_query($con,$KueryPT_Alta));
$ID_PROCESO_TRAMITES_Alta=$arregloPT_Alta['id'];
$en_proceso_Alta=$arregloPT_Alta['en_proceso'];
$fecha_inicio_Alta=$arregloPT_Alta['fecha_inicio'];
$fecha_fin_Alta=$arregloPT_Alta['fecha_fin'];
$nota_Alta=$arregloPT_Alta['nota'];
$numero_permiso_Alta=$arregloPT_Alta['numero_permiso'];
$el_cambio_Alta=$arregloPT_Alta['el_cambio'];
#############
$sql_Pagos_AltaINS="SELECT * FROM pagos_temp WHERE concepto='Inspeccion' AND id_proceso_tramites=".$ID_PROCESO_TRAMITES_Alta;
##echo $sql_Pagos_alta.'<br>';
$ArregloPago_AltaINS = mysqli_fetch_array(mysqli_query($con,$sql_Pagos_AltaINS));

$id_pagoINS = $ArregloPago_AltaINS[0];
$numero_pagoINS = $ArregloPago_AltaINS[4];
$montoINS = $ArregloPago_AltaINS[5];
$total_umas_pagarINS = $ArregloPago_AltaINS[6];
$estatus_pagoINS = $ArregloPago_AltaINS[8];
$concepto_pagoINS = $ArregloPago_AltaINS[9];
$conceptoINS = $ArregloPago_AltaINS[7];
$fecha_pagoINS = $ArregloPago_AltaINS[10];

##
if ( $total_umas_pagarINS=='' || $total_umas_pagarINS==NULL ) $string_total_umas_pagarINS='ND';
else $string_total_umas_pagarINS='[por pagar '.$total_umas_pagarINS.'  umas]';
##
if ( $estatus_pagoINS=='' || $estatus_pagoINS==NULL ||  $estatus_pagoINS=='Pendiente' ) {
$string_pagoINS='Espera Pago';
} else {
$string_pagoINS=$estatus_pagoINS.', $'.$montoINS.' , Fecha Pago ('.$fecha_pagoINS.')';
}

#############
$sql_Pagos_AltaRAD="SELECT * FROM pagos_temp WHERE concepto='Recepcion y Analisis Documentos' AND id_proceso_tramites=".$ID_PROCESO_TRAMITES_Alta;
##echo $sql_Pagos_alta.'<br>';
$ArregloPago_AltaRAD = mysqli_fetch_array(mysqli_query($con,$sql_Pagos_AltaRAD));

$id_pagoRAD = $ArregloPago_AltaRAD[0];
$numero_pagoRAD = $ArregloPago_AltaRAD[4];
$montoRAD = $ArregloPago_AltaRAD[5];
$total_umas_pagarRAD = $ArregloPago_AltaRAD[6];
$estatus_pagoRAD = $ArregloPago_AltaRAD[8];
$concepto_pagoRAD = $ArregloPago_AltaRAD[9];
$conceptoRAD = $ArregloPago_AltaRAD[7];
$fecha_pagoRAD = $ArregloPago_AltaRAD[10];

##
if ( $total_umas_pagarRAD=='' || $total_umas_pagarRAD==NULL ) $string_total_umas_pagarRAD='ND';
else $string_total_umas_pagarRAD='[por pagar '.$total_umas_pagarRAD.'  umas]';
##
if ( $estatus_pagoRAD=='' || $estatus_pagoRAD==NULL  ||  $estatus_pagoRAD=='Pendiente'  ) {
$string_pagoRAD='Espera Pago';
} else {
$string_pagoRAD=$estatus_pagoRAD.', $'.$montoRAD.' , Fecha Pago ('.$fecha_pagoRAD.')';
}

#############
$sql_Pagos_AltaPRES="SELECT * FROM pagos_temp WHERE concepto='Permiso Nuevo Presupuesto' AND id_proceso_tramites=".$ID_PROCESO_TRAMITES_Alta;
##echo $sql_Pagos_AltaPRES.'<br>';
$ArregloPago_AltaPRES = mysqli_fetch_array(mysqli_query($con,$sql_Pagos_AltaPRES));

$id_pagoPRES = $ArregloPago_AltaPRES[0];
$numero_pagoPRES = $ArregloPago_AltaPRES[4];
$montoPRES = $ArregloPago_AltaPRES[5];
$total_umas_pagarPRES = $ArregloPago_AltaPRES[6];
$estatus_pagoPRES = $ArregloPago_AltaPRES[8];
$concepto_pagoPRES = $ArregloPago_AltaPRES[9];
$conceptoPRES = $ArregloPago_AltaPRES[7];
$fecha_pagoPRES = $ArregloPago_AltaPRES[10];

##
if ( $total_umas_pagarPRES=='' || $total_umas_pagarPRES==NULL ) $string_total_umas_pagarPRES='ND';
else $string_total_umas_pagarPRES='[por pagar '.$total_umas_pagarPRES.'  umas]';
##
if ( $estatus_pagoPRES=='' || $estatus_pagoPRES==NULL ) {
$string_pagoPRES='-';
} else {
$string_pagoPRES=$estatus_pagoPRES.', $'.$montoPRES.' , Fecha Pago ('.$fecha_pagoPRES.')';
}

###########################################################

$AltaINS="SELECT * FROM inspeccion_temp WHERE  id_proceso_tramites=".$ID_PROCESO_TRAMITES_Alta;
##echo $INS;
$arregloAltaINS = mysqli_fetch_array(mysqli_query($con,$AltaINS));
$en_procesoTrabajoINS=$arregloAltaINS['en_proceso'];
$fecha_inicioTrabajoINS=$arregloAltaINS['fecha_inicio'];
$fecha_finTrabajoINS=$arregloAltaINS['fecha_fin'];

if ( $en_procesoTrabajoINS=='En Proceso' ||  $en_procesoTrabajoINS=='Espera Pago') {
$string_TrabajoINS="<font color='red'>".$en_procesoTrabajoINS."</font>";
} else {
$string_TrabajoINS=$en_procesoTrabajoINS.", Fecha Fin ".$fecha_finTrabajoINS;
}


$AltaRAD="SELECT * FROM recepcion_analisis_documentos_temp WHERE  id_proceso_tramites=".$ID_PROCESO_TRAMITES_Alta;
##echo $AltaRAD;
$arregloAltaRAD = mysqli_fetch_array(mysqli_query($con,$AltaRAD));
$en_procesoTrabajoRAD=$arregloAltaRAD['en_proceso'];
$fecha_inicioTrabajoRAD=$arregloAltaRAD['fecha_inicio'];
$fecha_finTrabajoRAD=$arregloAltaRAD['fecha_fin'];


if ( $en_procesoTrabajoRAD=='En Proceso' || $en_procesoTrabajoRAD=='Espera Pago' ) {
$string_TrabajoRAD="<font color='red'>".$en_procesoTrabajoRAD."</font>";
} else {
$string_TrabajoRAD=$en_procesoTrabajoRAD.", Fecha Fin ".$fecha_finTrabajoRAD;
}




if ( $fecha_autorizacion=='' || $fecha_autorizacion==NULL ) $fecha_autorizacion='No Disponible';

?>


    <div class="mt-4">
        <!-- Encabezado del programa -->
        <div class="encabezado-programa">
	<h6 class="mb-0">Histórico  Registro    Folio  (<?php echo $folio; ?>)</h6>
        </div>
        
        <!-- Sección de datos del establecimiento -->
        <div class="seccion-datos">
	    <div class="encabezado">
<?php

##############
$KueryPT="SELECT * FROM proceso_tramites_temp WHERE id_principal=$IDPRINCIPAL AND id=$ID_PROCESO_TRAMITES_Alta";
##echo $KueryPT;
$arregloPT = mysqli_fetch_array(mysqli_query($con,$KueryPT));

$en_proceso=$arregloPT['en_proceso'];

$docs_pdf1DB=$arregloPT['docs_pdf1'];
$estatus_docs_pdf1DB=$arregloPT['estatus_docs_pdf1'];
##
$docs_pdf2DB=$arregloPT['docs_pdf2'];
$estatus_docs_pdf2DB=$arregloPT['estatus_docs_pdf2'];
##
$docs_pdf3DB=$arregloPT['docs_pdf3'];
$estatus_docs_pdf3DB=$arregloPT['estatus_docs_pdf3'];
##
$docs_pdf4DB=$arregloPT['docs_pdf4'];
$estatus_docs_pdf4DB=$arregloPT['estatus_docs_pdf4'];
##############
echo '<h4>Proceso Permiso Temporal - Alta ';


if ( $estatus=='Permiso Temporal Autorizado' ) {

echo '<div class="dropdown">';
//echo '<button class="dropbtn">Dropdown</button>';
echo '<font size="1">&nbsp;&nbsp;&nbsp;&nbsp;<i class="bi bi-file-earmark-pdf"></i>&nbsp;<u>PDFs</u></font>';
echo '<div class="dropdown-content">';

echo '<a href="#" data-bs-toggle="modal" data-bs-target="#ModalPDF1"><i class="bi bi-file-earmark-pdf"></i> PDF C1</a>';
echo '<a href="#" data-bs-toggle="modal" data-bs-target="#ModalPDF2"><i class="bi bi-file-earmark-pdf"></i> PDF C2</a>';
echo '<a href="#" data-bs-toggle="modal" data-bs-target="#ModalPDF3"><i class="bi bi-file-earmark-pdf"></i> PDF C3</a>';
echo '<a href="#" data-bs-toggle="modal" data-bs-target="#ModalPDF4"><i class="bi bi-file-earmark-pdf"></i> PDF C4</a>';

echo '</div>';
echo '</div>';

echo '<a href="#" data-bs-toggle="modal" data-bs-target="#myScrollGalleryAlta"><font color="white" size="1">&nbsp;&nbsp;&nbsp;<i class="bi bi-card-image"></i>&nbsp;<u>Imagenes</u> </font></a>';
echo '</h4>';


########################################################
###  MODAL PDFs
#
echo '<div class="modal" id="ModalPDF1" tabindex="-1" role="dialog">';
echo '<div class="modal-dialog" role="document">';
echo '<div class="modal-content">';

echo '<div class="modal-header"  style="background-color:#AC905B;color:white">';
echo '<h6 class="modal-title" id="myModalLabel"><i class="bi bi-file-earmark-pdf"></i>PDF C1  '.$docs_pdf1DB.'</h6>';
echo '<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">';
echo '<span aria-hidden="true">&times;</span>';
echo '</button>';
echo '</div>';
echo '<div class="modal-body">';
//echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="http://'.IPADDRESS.'/bebal_docs/'.$docs_pdf1DB.'"></object>';
echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="../bebal_docs/'.$docs_pdf1DB.'"></object>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
#
echo '<div class="modal" id="ModalPDF2" tabindex="-1" role="dialog">';
echo '<div class="modal-dialog" role="document">';
echo '<div class="modal-content">';

echo '<div class="modal-header"  style="background-color:#AC905B;color:white">';
echo '<h6 class="modal-title" id="myModalLabel"><i class="bi bi-file-earmark-pdf"></i>PDF C2  '.$docs_pdf2DB.'</h6>';
echo '<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">';
echo '<span aria-hidden="true">&times;</span>';
echo '</button>';
echo '</div>';
echo '<div class="modal-body">';
//echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="http://'.IPADDRESS.'/bebal_docs/'.$docs_pdf2DB.'"></object>';
echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="../bebal_docs/'.$docs_pdf2DB.'"></object>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
#
echo '<div class="modal" id="ModalPDF3" tabindex="-1" role="dialog">';
echo '<div class="modal-dialog" role="document">';
echo '<div class="modal-content">';

echo '<div class="modal-header"  style="background-color:#AC905B;color:white">';
echo '<h6 class="modal-title" id="myModalLabel"><i class="bi bi-file-earmark-pdf"></i>PDF C3  '.$docs_pdf3DB.'</h6>';
echo '<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">';
echo '<span aria-hidden="true">&times;</span>';
echo '</button>';
echo '</div>';
echo '<div class="modal-body">';
//echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="http://'.IPADDRESS.'/bebal_docs/'.$docs_pdf3DB.'"></object>';
echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="../bebal_docs/'.$docs_pdf3DB.'"></object>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
#
echo '<div class="modal" id="ModalPDF4" tabindex="-1" role="dialog">';
echo '<div class="modal-dialog" role="document">';
echo '<div class="modal-content">';

echo '<div class="modal-header"  style="background-color:#AC905B;color:white">';
echo '<h6 class="modal-title" id="myModalLabel"><i class="bi bi-file-earmark-pdf"></i>PDF C4   '.$docs_pdf4DB.'</h6>';
echo '<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">';
echo '<span aria-hidden="true">&times;</span>';
echo '</button>';
echo '</div>';
echo '<div class="modal-body">';
//echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="http://'.IPADDRESS.'/bebal_docs/'.$docs_pdf4DB.'"></object>';
echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="../bebal_docs/'.$docs_pdf4DB.'"></object>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
########################################################

}

?>
            </div>
	    <div class="contenido">

                <div class="row fila-datos">
                    <div class="col-10">
                        <div class="etiqueta">Datos para la Alta</div>
			<div class="valor"><font size="1"><?php echo $el_cambio_Alta; ?></font></div>

                    </div>
                    <div class="col-md-2 col-4">
                        <div class="etiqueta">Fecha</div>
                        <div class="valor"><?php echo $fecha_inicio_Alta; ?></div>
                    </div>
                </div>


<!-----------------------!>
                <div class="row fila-datos">
                    <div class="col-md-4 col-4">
		    <div class="etiqueta">Pago Inspección <br><font color="blue" size="1"><?php echo $string_total_umas_pagarINS; ?></font></div>
                        <div class="valor"><font size="1"><?php echo $string_pagoINS; ?></font></div>
                    </div>
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Pago RAD <br><font color="blue" size="1"><?php echo $string_total_umas_pagarRAD; ?></font></div>
                        <div class="valor"><font size="1"><?php echo $string_pagoRAD; ?></font></div>
                    </div>
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Pago Presupuesto <br><font color="blue" size="1"><?php echo $string_total_umas_pagarPRES; ?></font></div>
                        <div class="valor"><font size="1"><?php echo $string_pagoPRES;   ?></font></div>
                    </div>
                </div>

<!-----------------------!>

               <div class="row fila-datos">
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Trabajo Inspección</div>
                        <div class="valor"><font size="1"><?php echo $string_TrabajoINS; ?></font></div>
                    </div>
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Trabajo RAD</div>
                        <div class="valor"><font size="1"><?php echo $string_TrabajoRAD; ?></font></div>
                    </div>
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Fecha Autorización</div>
                        <div class="valor"><font size="1"><?php echo $fecha_autorizacion;   ?></font></div>
                    </div>
                    </div>
<!-----------------------!>

               <div class="row fila-datos">
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Giro</div>
                        <div class="valor"><font size="1"><?php echo $GIRO; ?></font></div>
                    </div>
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Número de Permiso</div>
                        <div class="valor"><font size="1"><?php echo $numero_permiso_Alta; ?></font></div>
                    </div>
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Fecha Expiración</div>
                        <div class="valor"><font size="1"><?php echo $fecha_expiracion;   ?></font></div>
                    </div>
		</div>
		</div>


            </div>
        </div>

<?php

##########################
##########################
###  Scroll Gallery
$ciclo='Alta';
echo '<div class="modal fade" id="myScrollGallery'.$ciclo.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"  align="center">';


echo '<div class="modal-dialog modal-lg">';
echo '<div class="modal-content"  style="background-color: black;">';
echo '<div class="modal-body">';

$sqlFotos="SELECT * FROM fotos_temp WHERE idprincipal=".$IDPRINCIPAL." AND id_proceso_tramites=".$ID_PROCESO_TRAMITES_Alta;
##echo $sqlFotos;
$resultFotos2 = mysqli_query($con, $sqlFotos);
$rowsFotosCuantosReg2 = mysqli_num_rows($resultFotos2);


echo "<h6><font color='white'>Proceso Permiso Temporal - Alta<br>Folio: ".$folio." / ".$nombre_comercial_establecimiento."  (".$GIRO.")</font></h6>";
echo "<p><font color='white'>Número de Fotografias: ".$rowsFotosCuantosReg2."</font></p>";

echo '<div class="scroll-container">';
for ($jj=0;$jj<$rowsFotosCuantosReg2;$jj++) {
$rowFotos= mysqli_fetch_array($resultFotos2,MYSQLI_NUM);
$idfoto_db=$rowFotos[0];
$idprincipal_db=$rowFotos[2];
$id_proceso_tramites_db=$rowFotos[3];

##85-130-354.jpg  ejemplo Nombre Archivo
#
$foto_fileCarusel='../../'.FOTOSMEDIAS.'T-'.$idprincipal_db.'-'.$id_proceso_tramites_db.'-'.$idfoto_db.'.jpg';
echo '<img class="img-size" src="'.$foto_fileCarusel.'" alt="Trabajo '.$jj.'" style="width:200px;height:180;"  >';
}


echo '</div>';
#############
echo '<div class="modal-footer">';
echo '<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>';
echo '</div>';

echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
##############################



?>




        


        <!-- Botones de acción -->
	<!-- <div class="area-botones"> --!>
	<center><div>


<?php

echo '<button type="button" onclick="window.location.href=\'principal_temp.php?page='.$page.'&action=ajax\'" class="btn btn-info bs-sm" style="background-color:#FFFFFF; color:black !important;"> <i class="bi bi-arrow-left"></i><font size="1"> Regresar</font></button>';
echo '<font color="white" size="1">'.$nip.'</font>';

?>

    </div>
</div>
<br>
<hr>
<?php 

mysqli_close($con);
include("footer.php"); 

?>

</body>
</html>

<style>
.dropbtn {
  background-color: #000000;
  color: white;
  padding: 10px;
  font-size: 16px;
  border: none;
}

.dropup {
  position: relative;
  display: inline-block;
}

.dropup-content {
  display: none;
  position: absolute;
  bottom: 35px;
  background-color: #f1f1f1;
  min-width: 220px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropup-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropup-content a:hover {background-color: #ccc}

.dropup:hover .dropup-content {
  display: block;
}

.dropup:hover .dropbtn {
  background-color: #FF0000;
}
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
	include("modal/revisar_pagoTramiteCambio.php");

	include("modal/revisar_pagoInspRAD_CierreTemporal.php");

	include("modal/revisar_pagoRevalidacion.php");

	include("modal/revisar_pagoPresupuestoTramite.php");
	include("modal/revisar_pagoPresupuestoTramiteRevalidacion.php");
	include("modal/revisar_pagoPresupuestoCierreTemporal.php");
	include("modal/revisar_pagoPresupuestoImprimirPermiso.php");

	include("modal/actualizar_datos_establecimiento_y_titular.php");
	include("modal/actualizar_datos_domicilio.php");
	include("modal/actualizar_datos_titularHerencia.php");
	include("modal/actualizar_datos_titular.php");
	include("modal/actualizar_datos_nombre_comercial.php");
	include("modal/actualizar_giro.php");

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

#################################
if (isset($_GET['id'])) {
    $IDPRINCIPAL = $_GET['id'];
    //$page = isset($_GET['page']) ? $_GET['page'] : 1; // Asegurarse que siempre existe page
    
$ID = $_GET['id'];
##$ID = intval($_GET['id']);
$porciones = explode("--", $ID);
$IDPRINCIPAL=intval($porciones[0]);
$page=$porciones[1];
$ID_TRAMITE_SOLICITADO=$porciones[2];

} else {
    $IDPRINCIPAL = $_POST['IDPRINCIPAL'];
    $ID_TRAMITE_SOLICITADO = $_POST['ID_TRAMITE_SOLICITADO'];
    $page = isset($_POST['page']) ? $_POST['page'] : 1; // Asegurarse que siempre existe page

}

###################################


if ( $ID_TRAMITE_SOLICITADO=='0X' ) {
$sql_tramite10="SELECT * FROM tramite WHERE descripcion_tramite='Revalidacion del Permiso'";
$result_tramite10 = mysqli_query($con,$sql_tramite10);
$row_tramite10 = mysqli_fetch_assoc($result_tramite10);
$TRAMITE_tramite_SOLICITADO=$row_tramite10['descripcion_tramite'];
##$MONTO_UMAS_tramite_SOLICITADO=$row_tramite10['monto_umas'];
$CUENTA_tramite_SOLICITADO=$row_tramite10['cuenta'];
$INSPECCION_tramite_SOLICITADO=$row_tramite10['inspeccion'];
$RAD_tramite_SOLICITADO=$row_tramite10['revision_analisis_docs'];
$DESCUENTO_tramite_SOLICITADO=$row_tramite10['descuento'];

} else  {


if ( $ID_TRAMITE_SOLICITADO=='1X' ) {

$sql_tramite10="SELECT * FROM tramite WHERE descripcion_tramite='Impresión de Permiso'";
$result_tramite10 = mysqli_query($con,$sql_tramite10);
$row_tramite10 = mysqli_fetch_assoc($result_tramite10);
$TRAMITE_tramite_SOLICITADO=$row_tramite10['descripcion_tramite'];
$MONTO_UMAS_tramite_SOLICITADO=$row_tramite10['monto_umas'];
$CUENTA_tramite_SOLICITADO=$row_tramite10['cuenta'];
$INSPECCION_tramite_SOLICITADO=$row_tramite10['inspeccion'];
$RAD_tramite_SOLICITADO=$row_tramite10['revision_analisis_docs'];
$DESCUENTO_tramite_SOLICITADO=$row_tramite10['descuento'];

} else {
$sql_tramite10="SELECT * FROM tramite WHERE id=".$ID_TRAMITE_SOLICITADO;
$result_tramite10 = mysqli_query($con,$sql_tramite10);
$row_tramite10 = mysqli_fetch_assoc($result_tramite10);
$TRAMITE_tramite_SOLICITADO=$row_tramite10['descripcion_tramite'];
##$MONTO_UMAS_tramite_SOLICITADO=$row_tramite10['monto_umas'];
$CUENTA_tramite_SOLICITADO=$row_tramite10['cuenta'];
$INSPECCION_tramite_SOLICITADO=$row_tramite10['inspeccion'];
$RAD_tramite_SOLICITADO=$row_tramite10['revision_analisis_docs'];
$DESCUENTO_tramite_SOLICITADO=$row_tramite10['descuento'];
}

}


#################################
include("modal/elegirGiro.php");
#################################

$sqlPrincipal="SELECT * FROM principal WHERE id=".$IDPRINCIPAL;
$row = mysqli_fetch_array(mysqli_query($con,$sqlPrincipal));

$principal_id=$row['id'];
$folio=$row['folio'];
$estatus=$row['estatus'];
$operacion=$row['operacion'];

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
###
##$sql_pagoTramite="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Tramite Cambio' AND `estatus_pago`='Pendiente' AND id_proceso_tramites=".$id_proceso_tramites;
#########################
#########################
#########################
if ($TRAMITE_tramite_SOLICITADO=='Revalidacion del Permiso') {
$sql_pagoTramite="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Revalidacion' AND id_proceso_tramites=0 AND estatus_pago='Pendiente'";
$result_pagoTramite = mysqli_query($con,$sql_pagoTramite);
$row_pagoTramite = mysqli_fetch_assoc($result_pagoTramite);
$MONTO_UMAS_tramite_SOLICITADO=$row_pagoTramite['total_umas_pagar'];
##
$ID_PROCESO_TRAMITES=0;
$NOTA_proceso_tramites='';

} else {

if ($TRAMITE_tramite_SOLICITADO=='Impresión de Permiso') {

##$MONTO_UMAS_tramite_SOLICITADO=$row_tramite10['monto_umas'];

} else {

if ($TRAMITE_tramite_SOLICITADO=='Cierre Temporal') {

$MONTO_UMAS_tramite_SOLICITADO=$row_tramite10['monto_umas'];

$piecesOperacion=explode("-", $operacion);
$id_cierre_temporal=$piecesOperacion[1]; 

} else {

$sql_pagoTramite="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Tramite Cambio' AND id_proceso_tramites=".$id_proceso_tramites;
$result_pagoTramite = mysqli_query($con,$sql_pagoTramite);
$row_pagoTramite = mysqli_fetch_assoc($result_pagoTramite);
$MONTO_UMAS_tramite_SOLICITADO=$row_pagoTramite['total_umas_pagar'];
##
$sql_proceso_tramite10="SELECT * FROM  proceso_tramites WHERE id=".$id_proceso_tramites." AND id_principal=".$IDPRINCIPAL." AND en_proceso='EN PROCESO'";
$result_proceso_tramite10 = mysqli_query($con,$sql_proceso_tramite10);
$row_tramite10 = mysqli_fetch_assoc($result_proceso_tramite10);
$ID_PROCESO_TRAMITES=$row_tramite10['id'];
$NOTA_proceso_tramites=$row_tramite10['nota'];
}
}
}
#########################
#########################
$fecha_autorizacion=$row['fecha_autorizacion'];
$fecha_expiracion=$row['fecha_expiracion'];
$numero_permiso=$row['numero_permiso'];
$id_giro=$row['giro'];
include("modal/revalidacion_permiso.php");
#########################
################
$modalidad_graduacion_alcoholica=$row['modalidad_graduacion_alcoholica'];
$modalidad_graduacion_alcoholica_raw=$row['modalidad_graduacion_alcoholica_raw'];
$monto_umas_total_modalidad_graduacion_alcoholica=$row['monto_umas_total_modalidad_graduacion_alcoholica'];
$numero_modalidad_graduacion_alcoholica=$row['numero_modalidad_graduacion_alcoholica'];

$servicios_adicionales=$row['servicios_adicionales'];
$servicios_adicionales_raw=$row['servicios_adicionales_raw'];
$numero_servicios_adicionales=$row['numero_servicios_adicionales'];
$monto_umas_total_servicios_adicionales=$row['monto_umas_total_servicios_adicionales'];



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
$MONTO_UMAS_giro=$row_giro['monto_umas'];
$MONTO_UMAS_REV_CAMB_giro=$row_giro['monto_umas_revalidacion_cambios'];
$CUENTA_giro=$row_giro['cuenta'];

$COBRO_UMAS_giro=$MONTO_UMAS_giro;      //##  Permiso Nuevo


##################################################
$sql_municipio="SELECT municipio FROM municipio WHERE id=".$id_municipio;
$result_municipio = mysqli_query($con,$sql_municipio);
$row_municipio = mysqli_fetch_assoc($result_municipio);
$MUNICIPIO=$row_municipio['municipio'];
##
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

####################
#####################
include("modal/modificar_serviciosAdicionales.php");
####################
#####################

?>

    <div class="mt-4">
        <!-- Encabezado del programa -->
	<div class="encabezado-programa">
<?php
if ($TRAMITE_tramite_SOLICITADO=='Revalidacion del Permiso') {
echo '<h6 class="mb-0">Revalidación del Permiso</h6>';
} else {
if ($TRAMITE_tramite_SOLICITADO=='Impresión de Permiso') {
echo '<h6 class="mb-0">Impresión de Permiso</h6>';
} else {
echo '<h6 class="mb-0">Moduló de Cambios - Registro Establecimiento y Solicitante Operación</h6>';
}
}
?>
        </div>

        <!-- Sección de datos del establecimiento -->
        <div class="seccion-datos">
                <div class="row fila-datos">
                    <div class="col-10">
			<div class="etiqueta">Tramite</div>
<?php
if ( $TRAMITE_tramite_SOLICITADO=='Mantenimiento Servicios Adicionales' ) {
$porcionesSA = explode("Quedando", $NOTA_proceso_tramites);
$NOTA_proceso_tramites=$porcionesSA[0];
}
?>

			<div class="valor valor-destacado"><font color="red"><?php echo $TRAMITE_tramite_SOLICITADO; ?>  {<?php echo $MONTO_UMAS_tramite_SOLICITADO; ?> umas}</font><br><font color="black" size="1"><?php echo $NOTA_proceso_tramites; ?> </font></div>



                    </div>


                    <div class="col-md-2 col-4">
                        <div class="etiqueta">Folio</div>
                        <div class="valor"><?php echo $folio; ?></div>
                    </div>
                </div>



            <div class="encabezado">
                <h4>Datos del Establecimiento</h4>
            </div>
	    <div class="contenido">



                <div class="row fila-datos">
                    <div class="col-4">
                        <div class="etiqueta">Giro</div>
			<div class="valor"><?php echo $GIRO; ?></div>
                    </div>
                    <div class="col-8">
                        <div class="etiqueta">Servicios Adicionales</div>
			<div class="valor valor-destacado"><?php echo $servicios_adicionales; ?> * [<?php echo $numero_servicios_adicionales; ?>]</div>
		    </div>
		  </div>


                <div class="row fila-datos">
                    <div class="col-md-9 col-6">
                        <div class="etiqueta">Modalidad Graduación Alcohólica</div>
			<div class="valor"><?php echo $modalidad_graduacion_alcoholica; ?> * [<?php echo $numero_modalidad_graduacion_alcoholica; ?>]</div>

                    </div>
                    <div class="col-md-3 col-6 mt-md-0">
                        <div class="etiqueta">Número de Permiso</div>
                        <div class="valor"><font color="blue"><?php echo $numero_permiso; ?></font></div>


                    </div>
                </div>
<!-----------------------!>
                <div class="row fila-datos">
                    <div class="col-md-9 col-6">
                        <div class="etiqueta">Nombre Comercial</div>
                        <div class="valor valor-destacado"><?php echo $nombre_comercial_establecimiento; ?></div>
                    </div>
                    <div class="col-md-3 col-6 mt-md-0">
                        <div class="etiqueta">Clave Catastral</div>
                        <div class="valor"><?php echo $clave_catastral; ?></div>
                    </div>
                </div>

<!-----------------------!>

                <div class="row fila-datos">
                    <div class="col-md-9 col-6">
                        <div class="etiqueta">Domicilio</div>
                        <div class="valor">
                            <?php echo $calle_establecimiento; ?> #<?php echo $numero_establecimiento; ?> 
                            <?php if (!empty($numerointerno_local_establecimiento)) echo $numerointerno_local_establecimiento; ?>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mt-md-0">
                        <div class="etiqueta">CP</div>
                        <div class="valor"><?php echo $cp_establecimiento; ?></div>
                    </div>
                </div>
<!-----------------------!>
                <div class="row fila-datos">
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Colonia</div>
                        <div class="valor"><?php echo $COLONIA; ?></div>
                    </div>
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Delegación</div>
                        <div class="valor"><?php echo $DELEGACION; ?></div>
                    </div>
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Ciudad</div>
                        <div class="valor"><?php echo $MUNICIPIO; ?></div>
                    </div>
		</div>


                <div class="row fila-datos">
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Superficie</div>
                        <div class="valor"><?php echo $superficie_establecimiento; ?> Metros Cuadrados</div>
                    </div>
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Capacidad Comensales</div>
                        <div class="valor"><?php echo $capacidad_comensales_personas; ?> Personadas</div>
                    </div>
                    <div class="col-md-4 col-4">
                        <div class="etiqueta">Horario Funcionamiento</div>
                        <div class="valor"><?php echo $HORARIO_FUNCIONAMIENTO; ?></div>
                    </div>
		</div>

                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">Servicios Adicionales</div>
			<div class="valor valor-destacado"><?php echo $servicios_adicionales; ?> * [<?php echo $numero_servicios_adicionales; ?>]</div>
                    </div>
                </div>



            </div>
        </div>
        
<!-- Botones de acción -->
<!-- <div class="area-botones"> --!>
<center><div>

<?php
echo '<button type="button" onclick="window.location.href=\'principal.php?page='.$page.'&action=ajax\'" class="btn btn-info bs-sm" style="background-color:#FFFFFF;"> <i class="bi bi-arrow-left"></i><font size="1" color="black"> Regresar</font></button>&nbsp;';

#####################################
#####################################
###  REVISA PAGOS DE TRAMITES
#####################################

##echo 'operacion='.$operacion.', estatus='.$estatus;

if (  ( $operacion=='Tramite' || $operacion=='Activo') && ( $estatus!='Presupuesto' || $estatus=='Tramite Recibos IRAD' )  )  {

#################
//** Inspección ( tabla tramites )
##
$sql_tramite="SELECT * FROM tramite WHERE descripcion_tramite='Inspeccion'";
$result_tramite = mysqli_query($con,$sql_tramite);
$row_tramite = mysqli_fetch_assoc($result_tramite);
$ID_TRAMITE=$row_tramite['id'];
$MONTO_UMAS_Inspeccion=$row_tramite['monto_umas'];
###$$$$
$RECIBO_INSPECCION_PAGADO="";
$sql_pagoI22="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Inspeccion' AND `estatus_pago`='PAGADO' AND id_proceso_tramites=".$id_proceso_tramites;
$result_pagoI22 = mysqli_query($con,$sql_pagoI22);
if (mysqli_num_rows($result_pagoI22) > 0) {
$RECIBO_INSPECCION_PAGADO="SI";
} else {
$RECIBO_INSPECCION_PAGADO="NO";
}
##echo "RECIBO_INSPECCION_PAGADO=".$RECIBO_INSPECCION_PAGADO;
###$$$$
#### RECIBO INSPECCION
if ( ($estatus=='Pago INS-Cambio' || $estatus=='Pagos-IRAD-Cambio') || $RECIBO_INSPECCION_PAGADO=='SI'  )  {
} else {
echo '<a href="datosParaPagar_pdf_html.php?id='.$IDPRINCIPAL.'--'.$ID_TRAMITE.'--'.$ID_TRAMITE_SOLICITADO.'" target="_blank" class="btn btn-danger bs-sm" style="background-color:#AC905B;"> <i class="bi bi-file-earmark-pdf"></i><font size="1"> Recibo Inspección</font></a>&nbsp;';
}
#### Revisar Pago INSP
$ID_PAGO_INS=0;
$ID_PAGO_RAD=0;
##
$sql_pagoI="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Inspeccion' AND `estatus_pago`='Pendiente' AND id_proceso_tramites=".$id_proceso_tramites;
##echo $sql_pagoI;
$result_pagoI = mysqli_query($con,$sql_pagoI);
if (mysqli_num_rows($result_pagoI) > 0) {
$row_pagoI = mysqli_fetch_assoc($result_pagoI);
$ID_PAGO_INS=$row_pagoI['id'];
} else {
$ID_PAGO_INS=0;
}
##
if ( $estatus=='Pago INS-Cambio' || $ID_PAGO_INS!=0 )  {
$sql_pagoI2="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Inspeccion' AND `estatus_pago`='Pendiente' AND id_proceso_tramites=".$id_proceso_tramites;
##echo $sql_pagoI2;
$result_pagoI2 = mysqli_query($con,$sql_pagoI2);
if (mysqli_num_rows($result_pagoI2) > 0) {
$row_pagoI2 = mysqli_fetch_assoc($result_pagoI2);
$fecha_pagoI2=$row_pagoI2['fecha_pago'];
$montoI2=$row_pagoI2['monto'];
##echo '<font size="1"><b>[Inspección Pagada ('.$fecha_pagoI2.') $'.number_format($montoI2,2).'] </b></font>&nbsp;';

echo '<a href="#revisarPagoTramiteCambio" data-bs-toggle="modal" data-bs-target="#revisarPagoTramiteCambio" data-id_pago_ins="'.$ID_PAGO_INS.'"  data-id_pago_rad="'.$ID_PAGO_RAD.'"  data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'"
 data-total_umas_pagar="'.$MONTO_UMAS_Inspeccion.'"
 data-id_tramite_solicitado="'.$ID_TRAMITE_SOLICITADO.'" 
 data-id_proceso_tramites="'.$id_proceso_tramites.'" 
 data-tramite_pagoid="'.$ID_TRAMITE.'" data-tramite_pago="Inspeccion"  class="btn btn-danger bs-sm" title="Pago Inspeción"><i class="bi bi-check-circle"></i><font size="1">Pago Inspeción('.$ID_PAGO_INS.')</font></a>&nbsp;';

} else {
if ( $RECIBO_INSPECCION_PAGADO=="SI") {
echo '<a href="#" class="btn btn-success bs-sm"><i class="bi bi-currency-dollar"></i><font color="white" size="1">INSP Pagado</font></a>&nbsp;';
} else {
echo '<font size="1" color="red"><b>Error Pago Inspeccion</b></font>&nbsp;';
}
}
}

### RECEPCION ANALISIS DE DOCUMENTOS
//** Análisis y Revisión Documentos ( tabla tramites )
##
$sql_tramite="SELECT * FROM tramite WHERE descripcion_tramite='Recepcion y Analisis Documentos'";
$result_tramite = mysqli_query($con,$sql_tramite);
$row_tramite = mysqli_fetch_assoc($result_tramite);
$ID_TRAMITE=$row_tramite['id'];
$MONTO_UMAS_RAD=$row_tramite['monto_umas'];
###$$$$
$RECIBO_RAD_PAGADO="";
$sql_pagoRAD22="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Recepcion y Analisis Documentos' AND `estatus_pago`='PAGADO' AND id_proceso_tramites=".$id_proceso_tramites;
$result_pagoRAD22 = mysqli_query($con,$sql_pagoRAD22);
if (mysqli_num_rows($result_pagoRAD22) > 0) {
$RECIBO_RAD_PAGADO="SI";
} else {
$RECIBO_RAD_PAGADO="NO";
}
##echo "RECIBO_RAD_PAGADO=".$RECIBO_RAD_PAGADO;
###$$$$
##
##  RECIBO AR Docs
if ( ( $estatus=='Pago RAD-Cambio'  || $estatus=='Pagos-IRAD-Cambio') || $RECIBO_RAD_PAGADO=='SI' )  {
} else {
echo '<a href="datosParaPagar_pdf_html.php?id='.$IDPRINCIPAL.'--'.$ID_TRAMITE.'--'.$ID_TRAMITE_SOLICITADO.'" target="_blank" class="btn btn-danger bs-sm" style="background-color:#AC905B;"> <i class="bi bi-file-earmark-pdf"></i><font size="1">Recibo AR Docs</font></a>&nbsp;';
}
#### Revisar Pago RAD
####

$sql_pagoRAD="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Recepcion y Analisis Documentos' AND `estatus_pago`='Pendiente' AND id_proceso_tramites=".$id_proceso_tramites;

$result_pagoRAD = mysqli_query($con,$sql_pagoRAD);
if (mysqli_num_rows($result_pagoRAD) > 0) {
$row_pagoRAD = mysqli_fetch_assoc($result_pagoRAD);
$ID_PAGO_RAD=$row_pagoRAD['id'];
} else {
$ID_PAGO_RAD=0;
}
##
##
if ( $estatus=='Pago RAD-Cambio' || $ID_PAGO_RAD!=0 )  {
$sql_pagoRAD2="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Recepcion y Analisis Documentos' AND `estatus_pago`='Pendiente' AND id_proceso_tramites=".$id_proceso_tramites;
$result_pagoRAD2 = mysqli_query($con,$sql_pagoRAD2);
if (mysqli_num_rows($result_pagoRAD2) > 0) {
$row_pagoRAD2 = mysqli_fetch_assoc($result_pagoRAD2);
$fecha_pagoRAD2=$row_pagoRAD2['fecha_pago'];
$montoRAD2=$row_pagoRAD2['monto'];
##echo '<font size="1"><b> [RAD Pagado ('.$fecha_pagoRAD2.') $'.number_format($montoRAD2,2).']</b></font>&nbsp;';

echo '<a href="#revisarPagoTramiteCambio" data-bs-toggle="modal" data-bs-target="#revisarPagoTramiteCambio" data-id_pago_ins="'.$ID_PAGO_INS.'"  data-id_pago_rad="'.$ID_PAGO_RAD.'" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" data-tramite_pagoid="'.$ID_TRAMITE.'"
 data-total_umas_pagar="'.$MONTO_UMAS_RAD.'"
 data-id_tramite_solicitado="'.$ID_TRAMITE_SOLICITADO.'"  
 data-id_proceso_tramites="'.$id_proceso_tramites.'" 
 data-tramite_pago="Recepcion y Analisis Documentos"  class="btn btn-danger bs-sm" title="Revisar Pago RA Documentos"><i class="bi bi-check-circle"></i><font size="1">Pago RADocs('.$ID_PAGO_RAD.')</font></a>&nbsp;';

} else {
$sql_pagoRAD22="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Recepcion y Analisis Documentos' AND `estatus_pago`='PAGADO' AND id_proceso_tramites=".$id_proceso_tramites;
$result_pagoRAD22 = mysqli_query($con,$sql_pagoRAD22);
if (mysqli_num_rows($result_pagoRAD22) > 0) {
echo '<a href="#" class="btn btn-success bs-sm"><i class="bi bi-currency-dollar"></i><font color="white" size="1">RAD Pagado</font></a>&nbsp;';
} else {
echo '<font size="1" color="red"><b>Error Pago RAD</b></font>&nbsp;';
}
}
}

###################
###################

}


#####################################
#####################################
###  REVISA PAGOS DE CIERRE TEMPORAL
#####################################

##echo 'operacion='.$operacion.', estatus='.$estatus;
//chang

if ( str_contains($operacion, 'Cierre Temporal') && $estatus=='CTemp Recibo Insp' )  {

$piecesOperacion=explode("-", $operacion);
$id_cierre_temporal=$piecesOperacion[1]; 
## vamos a usar el  id_cierre_temporal  ( id_proceso_tramites )
#################
//** Inspección ( tabla tramites )
##
$sql_tramite="SELECT * FROM tramite WHERE descripcion_tramite='Inspeccion'";
$result_tramite = mysqli_query($con,$sql_tramite);
$row_tramite = mysqli_fetch_assoc($result_tramite);
$ID_TRAMITE=$row_tramite['id'];
$MONTO_UMAS_Inspeccion=$row_tramite['monto_umas'];
###$$$$
$RECIBO_INSPECCION_PAGADO="";
$sql_pagoI22="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Inspeccion' AND `estatus_pago`='PAGADO' AND id_proceso_tramites=".$id_cierre_temporal;
$result_pagoI22 = mysqli_query($con,$sql_pagoI22);
if (mysqli_num_rows($result_pagoI22) > 0) {
$RECIBO_INSPECCION_PAGADO="SI";
} else {
$RECIBO_INSPECCION_PAGADO="NO";
}
##echo "RECIBO_INSPECCION_PAGADO=".$RECIBO_INSPECCION_PAGADO;
###$$$$
#### RECIBO INSPECCION
if ( ($estatus=='Pago INS-Cambio' || $estatus=='Pagos-IRAD-Cambio') || $RECIBO_INSPECCION_PAGADO=='SI'  )  {
} else {
echo '<a href="datosParaPagar_pdf_html.php?id='.$IDPRINCIPAL.'--'.$ID_TRAMITE.'--'.$ID_TRAMITE_SOLICITADO.'" target="_blank" class="btn btn-danger bs-sm" style="background-color:#AC905B;"> <i class="bi bi-file-earmark-pdf"></i><font size="1"> Recibo Inspección</font></a>&nbsp;';
}
#### Revisar Pago INSP
$ID_PAGO_INS=0;
$ID_PAGO_RAD=0;
##
$sql_pagoI="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Inspeccion' AND `estatus_pago`='Pendiente' AND id_proceso_tramites=".$id_cierre_temporal;
##echo $sql_pagoI;
$result_pagoI = mysqli_query($con,$sql_pagoI);
if (mysqli_num_rows($result_pagoI) > 0) {
$row_pagoI = mysqli_fetch_assoc($result_pagoI);
$ID_PAGO_INS=$row_pagoI['id'];
} else {
$ID_PAGO_INS=0;
}
##
if ( $estatus=='Pago INS-Cambio' || $ID_PAGO_INS!=0 )  {
$sql_pagoI2="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Inspeccion' AND `estatus_pago`='Pendiente' AND id_proceso_tramites=".$id_cierre_temporal;
##echo $sql_pagoI2;
$result_pagoI2 = mysqli_query($con,$sql_pagoI2);
if (mysqli_num_rows($result_pagoI2) > 0) {
$row_pagoI2 = mysqli_fetch_assoc($result_pagoI2);
$fecha_pagoI2=$row_pagoI2['fecha_pago'];
$montoI2=$row_pagoI2['monto'];
##echo '<font size="1"><b>[Inspección Pagada ('.$fecha_pagoI2.') $'.number_format($montoI2,2).'] </b></font>&nbsp;';

echo '<a href="#revisarPagoInspRAD_CierreTemporal" data-bs-toggle="modal" data-bs-target="#revisarPagoInspRAD_CierreTemporal" data-id_pago_ins="'.$ID_PAGO_INS.'"  data-id_pago_rad="'.$ID_PAGO_RAD.'"  data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'"
 data-total_umas_pagar="'.$MONTO_UMAS_Inspeccion.'"
 data-id_tramite_solicitado="'.$ID_TRAMITE_SOLICITADO.'" 
 data-id_proceso_tramites="'.$id_cierre_temporal.'" 
 data-tramite_pagoid="'.$ID_TRAMITE.'" data-tramite_pago="Inspeccion"  class="btn btn-danger bs-sm" title="Pago Inspeción"><i class="bi bi-check-circle"></i><font size="1">Pago Inspeción('.$ID_PAGO_INS.')</font></a>&nbsp;';

} else {
if ( $RECIBO_INSPECCION_PAGADO=="SI") {
echo '<a href="#" class="btn btn-success bs-sm"><i class="bi bi-currency-dollar"></i><font color="white" size="1">INSP Pagado</font></a>&nbsp;';
} else {
echo '<font size="1" color="red"><b>Error Pago Inspeccion</b></font>&nbsp;';
}
}
}

### RECEPCION ANALISIS DE DOCUMENTOS
//** Análisis y Revisión Documentos ( tabla tramites )
##
$sql_tramite="SELECT * FROM tramite WHERE descripcion_tramite='Recepcion y Analisis Documentos'";
$result_tramite = mysqli_query($con,$sql_tramite);
$row_tramite = mysqli_fetch_assoc($result_tramite);
$ID_TRAMITE=$row_tramite['id'];
$MONTO_UMAS_RAD=$row_tramite['monto_umas'];
###$$$$
$RECIBO_RAD_PAGADO="";
$sql_pagoRAD22="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Recepcion y Analisis Documentos' AND `estatus_pago`='PAGADO' AND id_proceso_tramites=".$id_cierre_temporal;
$result_pagoRAD22 = mysqli_query($con,$sql_pagoRAD22);
if (mysqli_num_rows($result_pagoRAD22) > 0) {
$RECIBO_RAD_PAGADO="SI";
} else {
$RECIBO_RAD_PAGADO="NO";
}
##echo "RECIBO_RAD_PAGADO=".$RECIBO_RAD_PAGADO;
###$$$$
##
##  RECIBO AR Docs
if ( ( $estatus=='Pago RAD-Cambio'  || $estatus=='Pagos-IRAD-Cambio') || $RECIBO_RAD_PAGADO=='SI' )  {
} else {
echo '<a href="datosParaPagar_pdf_html.php?id='.$IDPRINCIPAL.'--'.$ID_TRAMITE.'--'.$ID_TRAMITE_SOLICITADO.'" target="_blank" class="btn btn-danger bs-sm" style="background-color:#AC905B;"> <i class="bi bi-file-earmark-pdf"></i><font size="1">Recibo AR Docs</font></a>&nbsp;';
}
#### Revisar Pago RAD
####

$sql_pagoRAD="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Recepcion y Analisis Documentos' AND `estatus_pago`='Pendiente' AND id_proceso_tramites=".$id_cierre_temporal;

$result_pagoRAD = mysqli_query($con,$sql_pagoRAD);
if (mysqli_num_rows($result_pagoRAD) > 0) {
$row_pagoRAD = mysqli_fetch_assoc($result_pagoRAD);
$ID_PAGO_RAD=$row_pagoRAD['id'];
} else {
$ID_PAGO_RAD=0;
}
##
##
if ( $estatus=='Pago RAD-Cambio' || $ID_PAGO_RAD!=0 )  {
$sql_pagoRAD2="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Recepcion y Analisis Documentos' AND `estatus_pago`='Pendiente' AND id_proceso_tramites=".$id_cierre_temporal;
$result_pagoRAD2 = mysqli_query($con,$sql_pagoRAD2);
if (mysqli_num_rows($result_pagoRAD2) > 0) {
$row_pagoRAD2 = mysqli_fetch_assoc($result_pagoRAD2);
$fecha_pagoRAD2=$row_pagoRAD2['fecha_pago'];
$montoRAD2=$row_pagoRAD2['monto'];
##echo '<font size="1"><b> [RAD Pagado ('.$fecha_pagoRAD2.') $'.number_format($montoRAD2,2).']</b></font>&nbsp;';

echo '<a href="#revisarPagoInspRAD_CierreTemporal" data-bs-toggle="modal" data-bs-target="#revisarPagoInspRAD_CierreTemporal" data-id_pago_ins="'.$ID_PAGO_INS.'"  data-id_pago_rad="'.$ID_PAGO_RAD.'" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" data-tramite_pagoid="'.$ID_TRAMITE.'"
 data-total_umas_pagar="'.$MONTO_UMAS_RAD.'"
 data-id_tramite_solicitado="'.$ID_TRAMITE_SOLICITADO.'"  
 data-id_proceso_tramites="'.$id_cierre_temporal.'" 
 data-tramite_pago="Recepcion y Analisis Documentos"  class="btn btn-danger bs-sm" title="Revisar Pago RA Documentos"><i class="bi bi-check-circle"></i><font size="1">Pago RADocs('.$ID_PAGO_RAD.')</font></a>&nbsp;';

} else {
$sql_pagoRAD22="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Recepcion y Analisis Documentos' AND `estatus_pago`='PAGADO' AND id_proceso_tramites=".$id_cierre_temporal;
$result_pagoRAD22 = mysqli_query($con,$sql_pagoRAD22);
if (mysqli_num_rows($result_pagoRAD22) > 0) {
echo '<a href="#" class="btn btn-success bs-sm"><i class="bi bi-currency-dollar"></i><font color="white" size="1">RAD Pagado</font></a>&nbsp;';
} else {
echo '<font size="1" color="red"><b>Error Pago RAD</b></font>&nbsp;';
}
}
}

###################
###################
###################
}


###################
###################
###################

if ( $estatus=='IP Proceso'  )  {
echo '<a href="datosParaPagar_pdf_Presupuesto_html.php?id='.$IDPRINCIPAL.'&ri=1X" target="_blank" class="btn btn-danger bs-sm" style="background-color:#AC905B;"> <i class="bi bi-file-earmark-pdf"></i><font size="1" color="black"> Recibo Presupuesto</font></a>&nbsp;';

echo '<a href="#revisarPagoPresupuestoImprimirPermiso" data-bs-toggle="modal" data-bs-target="#revisarPagoPresupuestoImprimirPermiso"
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'"
 data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'"
 data-concepto_tramite="'.$concepto_tramite.'"
 data-tramite_pago="Impresión de Permiso"
 data-concepto_giro="'.$concepto_giro.'"
 data-id_tramite="'.$id_tramite.'"
 data-concepto_modalidad="'.$concepto_modalidad.'"
 data-concepto_servicios_adicionales="'.$concepto_servicios_adicionales.'"
 data-id_proceso_tramites="'.$id_proceso_tramites.'"
 data-total_umas_pagar="'.$MONTO_TOTAL_UMAS.'"
class="btn btn-danger bs-sm" title="Revisar Pago Imprimir Permiso"><i class="bi bi-check-circle"></i><font size="1">Pago Pesupuesto</font></a>&nbsp;';

}

#################################################
#################################################
## Revisa Pago Inspeccion - Revalidacion
#################################################

if (  $operacion=='Revalidando' &&  $estatus=='Revalidando Recibo Inpeccion'  )  {

##
$sql_tramite="SELECT * FROM tramite WHERE descripcion_tramite='Inspeccion'";
$result_tramite = mysqli_query($con,$sql_tramite);
$row_tramite = mysqli_fetch_assoc($result_tramite);
$ID_TRAMITE=$row_tramite['id'];
$MONTO_UMAS_Inspeccion=$row_tramite['monto_umas'];
###$$$$
$RECIBO_INSPECCION_PAGADO="";
$sql_pagoI22="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Inspeccion Revalidacion' AND `estatus_pago`='PAGADO' AND id_proceso_tramites=0";
##echo $sql_pagoI22;
$result_pagoI22 = mysqli_query($con,$sql_pagoI22);
if (mysqli_num_rows($result_pagoI22) > 0) {
$RECIBO_INSPECCION_PAGADO="SI";
} else {
$RECIBO_INSPECCION_PAGADO="NO";
}
##echo "RECIBO_INSPECCION_PAGADO=".$RECIBO_INSPECCION_PAGADO;
###$$$$
#### RECIBO INSPECCION
if ($estatus=='Pago INSP-Revalidacion' || $RECIBO_INSPECCION_PAGADO=='SI')  {
} else {
echo '<a href="datosParaPagar_pdf_html.php?id='.$IDPRINCIPAL.'--'.$ID_TRAMITE.'--0X" target="_blank" class="btn btn-danger bs-sm" style="background-color:#AC905B;"> <i class="bi bi-file-earmark-pdf"></i><font size="1"> Recibo Inspección</font></a>&nbsp;';
}
#### Revisar Pago INSP
$ID_PAGO_INS=0;
$ID_PAGO_RAD=0;
##
$sql_pagoI="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Inspeccion Revalidacion' AND `estatus_pago`='Pendiente Revalidacion' AND id_proceso_tramites=0";
##echo $sql_pagoI;
$result_pagoI = mysqli_query($con,$sql_pagoI);
if (mysqli_num_rows($result_pagoI) > 0) {
$row_pagoI = mysqli_fetch_assoc($result_pagoI);
$ID_PAGO_INS=$row_pagoI['id'];
} else {
$ID_PAGO_INS=0;
}
##
if ( $estatus=='Pago INSP-Revalidacion' || $ID_PAGO_INS!=0 )  {
$sql_pagoI2="SELECT * FROM `pagos` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Inspeccion Revalidacion' AND `estatus_pago`='Pendiente Revalidacion' AND id_proceso_tramites=0";
##echo $sql_pagoI2;
$result_pagoI2 = mysqli_query($con,$sql_pagoI2);
if (mysqli_num_rows($result_pagoI2) > 0) {
$row_pagoI2 = mysqli_fetch_assoc($result_pagoI2);
$fecha_pagoI2=$row_pagoI2['fecha_pago'];
$montoI2=$row_pagoI2['monto'];
##echo '<font size="1"><b>[Inspección Pagada ('.$fecha_pagoI2.') $'.number_format($montoI2,2).'] </b></font>&nbsp;';

echo '<a href="#revisarPagoTramiteRevalidacion" data-bs-toggle="modal" data-bs-target="#revisarPagoTramiteRevalidacion" data-id_pago_ins="'.$ID_PAGO_INS.'"  data-id_pago_rad="'.$ID_PAGO_RAD.'"  data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'"
 data-total_umas_pagar="'.$MONTO_UMAS_Inspeccion.'"
 data-id_tramite_solicitado="'.$ID_TRAMITE_SOLICITADO.'"
 data-id_proceso_tramites="'.$id_proceso_tramites.'"
 data-tramite_pagoid="'.$ID_TRAMITE.'" data-tramite_pago="Inspeccion"  class="btn btn-danger bs-sm" title="Pago Inspeción"><i class="bi bi-check-circle"></i><font size="1">Pago Inspeción('.$ID_PAGO_INS.')</font></a>&nbsp;';

} else {
if ( $RECIBO_INSPECCION_PAGADO=="SI") {
echo '<a href="#" class="btn btn-success bs-sm"><i class="bi bi-currency-dollar"></i><font color="white" size="1">INSP Pagado</font></a>&nbsp;';
} else {
echo '<font size="1" color="red"><b>Error Pago Inspeccion</b></font>&nbsp;';
}
}
}

###################               
###################               
}
###################               
###################               
##
if ( $estatus=='Pagos-IRAD-Cambio' || $estatus=='Inspeccion Realizada' || $estatus=='RAD Realizado')  {
##echo '<a href="#EfectuarInspeccion" data-bs-toggle="modal" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" class="btn btn-danger bs-sm" title="Registrar Inspección"> <i class="bi bi-clipboard-check"></i><font size="1"> Registrar Inspección </font></a>&nbsp;';
echo '<a href="principalFotos.php?id='.$IDPRINCIPAL.'&page='.$page.'&id_proceso_tramites='.$id_proceso_tramites.'"  class="btn btn-danger bs-sm" title="Registrar Inspección"> <i class="bi bi-clipboard-check"></i><font size="1"> Registrar Inspección </font></a>&nbsp;';
##
echo '<a href="principalPDFs.php?id='.$IDPRINCIPAL.'&page='.$page.'&id_proceso_tramites='.$id_proceso_tramites.'"  class="btn btn-danger bs-sm" title="Registrar RAD"> <i class="bi bi-clipboard-check"></i><font size="1"> Registrar R y A Docs </font></a>&nbsp;';

}

###################
###################
##
if ( $estatus=='Pago INSP-Revalidacion' )  {

echo '<a href="principalFotosRevalidacion.php?id='.$IDPRINCIPAL.'&page='.$page.'&id_proceso_tramites='.$id_proceso_tramites.'"  class="btn btn-danger bs-sm" title="Registrar Inspección"> <i class="bi bi-clipboard-check"></i><font size="1"> Registrar Inspección </font></a>&nbsp;';
##

}

###################
###################
##
if ( $estatus=='Pago IRAD-CierreTemporal' )  {

echo '<a href="principalFotosCierreTemporal.php?id='.$IDPRINCIPAL.'&page='.$page.'&id_proceso_tramites='.$id_proceso_tramites.'&id_cierre_temporal='.$id_cierre_temporal.'"  class="btn btn-danger bs-sm" title="Registrar Inspección"> <i class="bi bi-clipboard-check"></i><font size="1"> Registrar Inspección </font></a>&nbsp;';
##

}


###################               
###################               
if ( $estatus=='Presupuesto' || $estatus=='Cierre Temporal' )  {

  if ( is_numeric($MONTO_UMAS_tramite) ) {
 $concepto_tramite=$TRAMITE." {".number_format($MONTO_UMAS_tramite,2)." umas}";
 } else {
 $concepto_tramite=$TRAMITE." {Presupuesto umas}";
 $MONTO_UMAS_tramite=0;
 }
$concepto_giro=$GIRO." {".number_format($COBRO_UMAS_giro,2)." umas}";
$concepto_modalidad=$modalidad_graduacion_alcoholica." [".$numero_modalidad_graduacion_alcoholica."] {".number_format($monto_umas_total_modalidad_graduacion_alcoholica,2)." umas}";
$concepto_servicios_adicionales=$servicios_adicionales." [".$numero_servicios_adicionales."]  {".number_format($monto_umas_total_servicios_adicionales,2)." umas }";

##echo ''.$MONTO_UMAS_tramite.', '.$monto_umas_total_servicios_adicionales.', '.$monto_umas_total_modalidad_graduacion_alcoholica,', '.$COBRO_UMAS_giro;

$MONTO_TOTAL_UMAS=$MONTO_UMAS_tramite+$monto_umas_total_servicios_adicionales+$monto_umas_total_modalidad_graduacion_alcoholica+$COBRO_UMAS_giro;

if ($operacion=='Revalidando' ) {
echo '<a href="datosParaPagar_pdf_Presupuesto_html.php?id='.$IDPRINCIPAL.'&ri=0X" target="_blank" class="btn btn-danger bs-sm" style="background-color:#AC905B;"> <i class="bi bi-file-earmark-pdf"></i><font size="1" color="black"> Recibo Presupuesto Revalidación</font></a>&nbsp;';

echo '<a href="#revisarPagoPresupuestoTramiteRevalidacion" data-bs-toggle="modal" data-bs-target="#revisarPagoPresupuestoTramiteRevalidacion" 
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'"
 data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'"
 data-concepto_tramite="'.$concepto_tramite.'"
 data-tramite_pago="Revalidación del Permiso"
 data-concepto_giro="'.$concepto_giro.'"
 data-id_tramite="'.$id_tramite.'"
 data-concepto_modalidad="'.$concepto_modalidad.'"
 data-concepto_servicios_adicionales="'.$concepto_servicios_adicionales.'"
 data-id_proceso_tramites="'.$id_proceso_tramites.'"
 data-total_umas_pagar="'.$MONTO_TOTAL_UMAS.'"
class="btn btn-danger bs-sm" title="Revisar Pago Presupuesto"><i class="bi bi-check-circle"></i><font size="1">Pago Pesupuesto</font></a>&nbsp;';




} else {


if ( str_contains($operacion, 'Cierre Temporal')  ) {

$piecesOperacion=explode("-", $operacion);
$id_cierre_temporal=$piecesOperacion[1]; 

echo '<a href="datosParaPagar_pdf_Presupuesto_html.php?id='.$IDPRINCIPAL.'&ri='.$ID_TRAMITE_SOLICITADO.'Z'.$id_cierre_temporal.'" target="_blank" class="btn btn-danger bs-sm" style="background-color:#AC905B;"> <i class="bi bi-file-earmark-pdf"></i><font size="1" color="black"> Recibo Cierre Temporal</font></a>&nbsp;';

echo '<a href="#revisarPagoPresupuestoCierreTemporal" data-bs-toggle="modal" data-bs-target="#revisarPagoPresupuestoCierreTemporal"
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'"
 data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'"
 data-concepto_tramite="'.$concepto_tramite.'"
 data-tramite_pago="Cierre Temporal"
 data-concepto_giro="'.$concepto_giro.'"
 data-id_tramite="'.$id_tramite.'"
 data-concepto_modalidad="'.$concepto_modalidad.'"
 data-concepto_servicios_adicionales="'.$concepto_servicios_adicionales.'"
 data-id_proceso_tramites="'.$id_cierre_temporal.'"
 data-total_umas_pagar="'.$MONTO_TOTAL_UMAS.'"
class="btn btn-danger bs-sm" title="Revisar Pago Cierre Temporal"><i class="bi bi-check-circle"></i><font size="1">Pago Cierre Temporal</font></a>&nbsp;';

} else {



echo '<a href="datosParaPagar_pdf_Presupuesto_html.php?id='.$IDPRINCIPAL.'" target="_blank" class="btn btn-danger bs-sm" style="background-color:#AC905B;"> <i class="bi bi-file-earmark-pdf"></i><font size="1" color="black"> Recibo Presupuesto</font></a>&nbsp;';


echo '<a href="#revisarPagoPresupuestoTramite" data-bs-toggle="modal" data-bs-target="#revisarPagoPresupuestoTramite"
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'"
 data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'"
 data-concepto_tramite="'.$concepto_tramite.'"
 data-tramite_pago="Tramite Presupuesto"
 data-concepto_giro="'.$concepto_giro.'"
 data-id_tramite="'.$id_tramite.'"
 data-concepto_modalidad="'.$concepto_modalidad.'"
 data-concepto_servicios_adicionales="'.$concepto_servicios_adicionales.'"
 data-id_proceso_tramites="'.$id_proceso_tramites.'" 
 data-total_umas_pagar="'.$MONTO_TOTAL_UMAS.'"
class="btn btn-danger bs-sm" title="Revisar Pago Presupuesto"><i class="bi bi-check-circle"></i><font size="1">Pago Pesupuesto</font></a>&nbsp;';
}
}

}
 ## LOS ELIMINE
 ##data-tramite_pagoid="'.$ID_TRAMITE.'"
 ##data-id_pago_ins="'.$ID_PAGO_INS.'"
 ##data-id_pago_rad="'.$ID_PAGO_RAD.'"



###################               
###################               
if ( $estatus=='Pago Tramite' || $estatus=='Pago Revalidacion' || $estatus=='Pago Cierre Temporal' )  {

switch ($TRAMITE_tramite_SOLICITADO) {
case 'Cambio de Domicilio y Cambio de Titular':
##
echo  '<a href="#ActualizarDatosEstablecimiento_y_Titular" data-bs-toggle="modal" data-bs-target="#ActualizarDatosEstablecimiento_y_Titular" 
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" 
 data-folio="'.$folio.'" 
 data-idprincipal="'.$IDPRINCIPAL.'" 
 data-clave_catastral="'.$clave_catastral.'"  
 data-pagina="'.$page.'" 
 data-calle_establecimiento="'.$calle_establecimiento.'" 
 data-entre_calles_establecimiento="'.$entre_calles_establecimiento.'" 
 data-numero_establecimiento="'.$numero_establecimiento.'" 
 data-numerointerno_local_establecimiento="'.$numerointerno_local_establecimiento.'" 
 data-cp_establecimiento="'.$cp_establecimiento.'" 
 data-capacidad_comensales_personas="'.$capacidad_comensales_personas.'" 
 data-superficie_establecimiento="'.$superficie_establecimiento.'" 
 data-colonia_id="'.$colonia_id.'" 
 data-delegacion_id="'.$delegacion_id.'" 
 data-observaciones="'.$observaciones.'" 
 data-nombre_persona_fisicamoral_solicitante="'.$nombre_persona_fisicamoral_solicitante.'" 
 data-nombre_representante_legal_solicitante="'.$nombre_representante_legal_solicitante.'"
 data-domicilio_solicitante="'.$domicilio_solicitante.'" i
 data-email_solicitante="'.$email_solicitante.'" 
 data-telefono_solicitante="'.$telefono_solicitante.'" 
 data-fisica_o_moral="'.$fisica_o_moral.'" 
 data-rfc="'.$rfc.'" 
 class="btn btn-danger bs-sm" title="Actualizar Datos -  Cambio de Domicilio y Cambio de Titular" style="background-color:#FF0000;color:black" ><i class="bi bi-pencil"></i><font size="1" color="white"> Actualizar Datos - Cambio de Domicilio y de Titular</font></a>';
##
break;


case 'Cambio de Domicilio':
##
echo  '<a href="#ActualizarCambioDeDomicilioEstablecimiento" data-bs-toggle="modal" data-bs-target="#ActualizarCambioDeDomicilioEstablecimiento"   
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'"
 data-folio="'.$folio.'"
 data-idprincipal="'.$IDPRINCIPAL.'"
 data-clave_catastral="'.$clave_catastral.'"
 data-pagina="'.$page.'"
 data-calle_establecimiento="'.$calle_establecimiento.'"
 data-entre_calles_establecimiento="'.$entre_calles_establecimiento.'"
 data-numero_establecimiento="'.$numero_establecimiento.'"
 data-numerointerno_local_establecimiento="'.$numerointerno_local_establecimiento.'"
 data-cp_establecimiento="'.$cp_establecimiento.'"
 data-capacidad_comensales_personas="'.$capacidad_comensales_personas.'"
 data-superficie_establecimiento="'.$superficie_establecimiento.'"
 data-colonia_id="'.$colonia_id.'"
 data-delegacion_id="'.$delegacion_id.'"
 data-observaciones="'.$observaciones.'"
 data-nombre_persona_fisicamoral_solicitante="'.$nombre_persona_fisicamoral_solicitante.'"
 data-nombre_representante_legal_solicitante="'.$nombre_representante_legal_solicitante.'"
 data-domicilio_solicitante="'.$domicilio_solicitante.'" i
 data-email_solicitante="'.$email_solicitante.'"
 data-telefono_solicitante="'.$telefono_solicitante.'"
 data-fisica_o_moral="'.$fisica_o_moral.'"
 data-rfc="'.$rfc.'"
 class="btn btn-danger bs-sm" title="Actualizar Datos -  Cambio de Domicilio" style="background-color:#FF0000;color:black" ><i class="bi bi-pencil"></i><font size="1" color="white"> Actualizar Datos - Cambio de Domicilio</font></a>';
##
break;

case 'Cambio de Giro':

$porcionesNOTA = explode("**", $NOTA_proceso_tramites);
$GiroID_seleccionado=trim($porcionesNOTA[1]);

echo  '<a href="#ActualizarGiro" data-bs-toggle="modal" data-bs-target="#ActualizarGiro" 
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" 
 data-folio="'.$folio.'" 
 data-idprincipal="'.$IDPRINCIPAL.'" 
 data-pagina="'.$page.'" 
 data-id_giro="'.$id_giro.'" 
 data-descripcion_giro="'.$GIRO.'" 
 data-nota="'.$NOTA_proceso_tramites.'" 
 data-giro_id_seleccionado="'.$GiroID_seleccionado.'"  
 class="btn btn-dark bs-sm" title="Actualizar GiroModalidadServiciosEsp Establecimiento"><i class="bi bi-pencil"></i><font size="2" color="white"> Actualizar Datos - Giro </font></a>';
break;

##

case 'Mantenimiento Servicios Adicionales':

$porcionesNOTA = explode("CHANG_SA", $NOTA_proceso_tramites);
$SA_seleccionado=trim($porcionesNOTA[1]);

echo  '<a href="#modificarServicioAdicional" data-bs-toggle="modal" data-bs-target="#modificarServicioAdicional" 
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" 
 data-folio="'.$folio.'" 
 data-idprincipal="'.$IDPRINCIPAL.'" 
 data-pagina="'.$page.'" 
 data-id_giro="'.$id_giro.'" 
 data-descripcion_giro="'.$GIRO.'" 
 data-nota="'.$NOTA_proceso_tramites.'" 
 data-SA_seleccionado="'.$SA_seleccionado.'"  
 class="btn btn-dark bs-sm" title="Actualizar GiroModalidadServiciosEsp Establecimiento"><i class="bi bi-pencil"></i><font size="2" color="white"> Actualizar Datos - Servicios Adicionales </font></a>';
break;


case 'Cambio de Nombre Comercial':
##
echo  '<a href="#ActualizarDatosNombreComercial" data-bs-toggle="modal" data-bs-target="#ActualizarDatosNombreComercial"
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'"
 data-folio="'.$folio.'"
 data-idprincipal="'.$IDPRINCIPAL.'"
 data-pagina="'.$page.'"
 class="btn btn-danger bs-sm" title="Actualizar Datos -  Cambio de Nombre Comercial" style="background-color:#FF0000;color:black" ><i class="bi bi-pencil"></i><font size="1" color="white"> Actualizar Datos - Cambio de Nombre Comercial</font></a>';
##
break;

case 'Cambio Titular por Herencia':
##
echo  '<a href="#ActualizarTitularHerencia" data-bs-toggle="modal" data-bs-target="#ActualizarTitularHerencia""
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'"
 data-folio="'.$folio.'"
 data-idprincipal="'.$IDPRINCIPAL.'"
 data-pagina="'.$page.'"
 data-nombre_persona_fisicamoral_solicitante="'.$nombre_persona_fisicamoral_solicitante.'"
 data-nombre_representante_legal_solicitante="'.$nombre_representante_legal_solicitante.'"
 data-domicilio_solicitante="'.$domicilio_solicitante.'" i
 data-email_solicitante="'.$email_solicitante.'"
 data-telefono_solicitante="'.$telefono_solicitante.'"
 data-fisica_o_moral="'.$fisica_o_moral.'"
 data-rfc="'.$rfc.'"
 class="btn btn-danger bs-sm" title="Actualizar Datos -  Cambio de Titular por Herencia" style="background-color:#FF0000;color:black" ><i class="bi bi-pencil"></i><font size="1" color="white"> Actualizar Datos - Cambio de Titular por Herecia</font></a>';
##
        break;

case 'Cambio de Titular':
##
echo  '<a href="#ActualizarCambioDeTitular" data-bs-toggle="modal" data-bs-target="#ActualizarCambioDeTitular""
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'"
 data-folio="'.$folio.'"
 data-idprincipal="'.$IDPRINCIPAL.'"
 data-pagina="'.$page.'"
 data-nombre_persona_fisicamoral_solicitante="'.$nombre_persona_fisicamoral_solicitante.'"
 data-nombre_representante_legal_solicitante="'.$nombre_representante_legal_solicitante.'"
 data-domicilio_solicitante="'.$domicilio_solicitante.'" i
 data-email_solicitante="'.$email_solicitante.'"
 data-telefono_solicitante="'.$telefono_solicitante.'"
 data-fisica_o_moral="'.$fisica_o_moral.'"
 data-rfc="'.$rfc.'"
 class="btn btn-danger bs-sm" title="Actualizar Datos -  Cambio de Titular" style="background-color:#FF0000;color:black" ><i class="bi bi-pencil"></i><font size="1" color="white"> Actualizar Datos - Cambio de Titular</font></a>';
##
break;





case 'Revalidacion del Permiso':
##
echo  '<a href="#RevaldacionPermiso" data-bs-toggle="modal" data-bs-target="#RevaldacionPermiso"
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'"
 data-folio="'.$folio.'"
 data-numero_permiso="'.$numero_permiso.'"
 data-fecha_expiracion="'.$fecha_expiracion.'"
 data-idprincipal="'.$IDPRINCIPAL.'"
 data-pagina="'.$page.'"
 class="btn btn-danger bs-sm" title="Revalidación Permiso" style="background-color:#FF0000;color:black" ><i class="bi bi-r-square"></i><font size="1" color="white"> Revalidación Permiso</font></a>';
##
break;


case 'Cierre Temporal':

$piecesOperacion=explode("-", $operacion);
$id_cierre_temporal=$piecesOperacion[1];

##
include("modal/cierre_temporal.php");
##

echo  '<a href="#CierreTemporal" data-bs-toggle="modal" data-bs-target="#CierreTemporal"
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'"
 data-folio="'.$folio.'"
 data-numero_permiso="'.$numero_permiso.'"
 data-fecha_expiracion="'.$fecha_expiracion.'"
 data-idprincipal="'.$IDPRINCIPAL.'"
 data-pagina="'.$page.'"
 class="btn btn-danger bs-sm" title="Cierre Temporal" style="background-color:#FF0000;color:black" ><i class="bi bi-c-square"></i><font size="1" color="white"> Cierre Temporal</font></a>';
##
break;

case 'Impresión de Permiso':
##
echo  '<a href="#RevaldacionPermiso" data-bs-toggle="modal" data-bs-target="#RevaldacionPermiso"
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'"
 data-folio="'.$folio.'"
 data-numero_permiso="'.$numero_permiso.'"
 data-fecha_expiracion="'.$fecha_expiracion.'"
 data-idprincipal="'.$IDPRINCIPAL.'"
 data-pagina="'.$page.'"
 class="btn btn-danger bs-sm" title="Imprimir Permiso" style="background-color:#FF0000;color:black" ><i class="bi bi-p-square"></i><font size="1" color="white"> Imprimir Permiso</font></a>';
##
        break;


  default:
}



}

?>

</center></div>

<br>
        <div class="estatus-seccion">
            <div class="row p-2">
                <div class="col-md-4 col-4 mb-md-0">
                    <div class="etiqueta" style="background-color: var(--color-primary); color: white;">Número de Permiso</div>
                    <div class="valor"><?php echo $folio; ?></div>
                </div>
                <div class="col-md-4 col-4 mb-md-0">
                    <div class="etiqueta" style="background-color: var(--color-primary); color: white;">Fecha Autorizacón</div>
                    <div class="valor"><?php echo $fecha_autorizacion; ?></div>
                </div>
                <div class="col-md-4 col-4">
                    <div class="etiqueta" style="background-color: var(--color-primary); color: white;">Fecha Expiración</div>
                    <div class="valor"><?php echo $fecha_expiracion; ?></div>
                </div>
            </div>
        </div>
        

        <!-- Sección de estatus -->
        <div class="estatus-seccion">
            <div class="row p-2">
                <div class="col-md-4 col-4 mb-md-0">
                    <div class="etiqueta" style="background-color: var(--color-primary); color: white;">Estatus</div>
                    <div class="valor"><?php echo $estatus; ?></div>
                </div>
                <div class="col-md-4 col-4 mb-md-0">
                    <div class="etiqueta" style="background-color: var(--color-primary); color: white;">Operación</div>
                    <div class="valor"><?php echo $operacion; ?></div>
                </div>
                <div class="col-md-4 col-4">
                    <div class="etiqueta" style="background-color: var(--color-primary); color: white;">Fecha Registro</div>
                    <div class="valor"><?php echo $fecha_alta; ?></div>
                </div>
            </div>
        </div>
        

        <!-- Sección de datos del solicitante -->
        <div class="seccion-datos">
            <div class="encabezado">
                <h4>Datos del Solicitante</h4>
            </div>
            <div class="contenido">
                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">Persona Física/Moral</div>
                        <div class="valor"><?php echo $nombre_persona_fisicamoral_solicitante; ?></div>
                    </div>
                </div>
                
                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">Representante Legal</div>
                        <div class="valor"><?php echo $nombre_representante_legal_solicitante; ?></div>
                    </div>
		</div>

                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">RFC</div>
                        <div class="valor"><?php echo $rfc; ?> ( <font color="blue">Persona <?php echo $fisica_o_moral; ?> </font> )</div>
                    </div>
                </div>
                
                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">Domicilio</div>
                        <div class="valor"><?php echo $domicilio_solicitante; ?></div>
                    </div>
                </div>
                
                <div class="row fila-datos">
                    <div class="col-md-6 col-12">
                        <div class="etiqueta">Email</div>
                        <div class="valor"><?php echo $email_solicitante; ?></div>
                    </div>
                    <div class="col-md-6 col-12 mt-md-0 mt-3">
                        <div class="etiqueta">Teléfono</div>
                        <div class="valor"><?php echo $telefono_solicitante; ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Botones de acción -->
	<!-- <div class="area-botones"> --!>
	<center><div>
	</div></center>


    </div>
</div>

<!-- Espacio adicional antes del footer -->
<div style="margin-bottom: 30px;"></div>

<hr>
<?php 

mysqli_close($con);
include("footer.php"); 

?>

<script>


$( "#guardar_CierreTemporal" ).submit(function( event ) {
  $('#Button_guardar_CierreTemporal').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/cierre_temporal.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxDatosCierreTemporal").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxDatosCierreTemporal").html(datos);
                        $('#Button_guardar_CierreTemporal').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('principal.php?page=".$page."&action=ajax');";
?>
                        }, 2000);

                  }
        });
  event.preventDefault();
});



$( "#guardar_RevaldacionPermiso" ).submit(function( event ) {
  $('#Button_guardar_registroPrincipalEstablecimiento_y_Titular').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/revalidacion_permiso.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxDatosRevalidacionPermiso").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxDatosRevalidacionPermiso").html(datos);
                        $('#Button_guardar_registroPrincipalEstablecimiento_y_Titular').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('principal.php?page=".$page."&action=ajax');";
?>
                        }, 2000);

                  }
        });
  event.preventDefault();
});




$( "#modificar_ServiciosAdicionales" ).submit(function( event ) {
  $('#Button_guardar_RevalidacionPermiso').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/ActualizarDatosSA.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxGuardarServicioAdicional").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxGuardarServicioAdicional").html(datos);
                        $('#Buttonmodificar_ServiciosAdicionales').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('principal.php?page=".$page."&action=ajax');";
?>

                        }, 2000);

                  }
        });
  event.preventDefault();
});




$( "#guardar_registroPrincipalGiro" ).submit(function( event ) {
  $('#Button_guardar_registroPrincipalGiro').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/ActualizarDatosGIRO.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxGuardarRegistroPrincipalGiro").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxGuardarRegistroPrincipalGiro").html(datos);
                        $('#Button_guardar_registroPrincipalGiro').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('principal.php?page=".$page."&action=ajax');";
?>
                        }, 2000);

                  }
        });
  event.preventDefault();
});



$( "#guardar_registroPrincipalEstablecimiento_y_Titular" ).submit(function( event ) {
  $('#Button_guardar_registroPrincipalEstablecimiento_y_Titular').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/ActualizarDatosEstablecimiento_y_Titular.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxActualizarDatosEstaTitular").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxActualizarDatosEstaTitular").html(datos);
                        $('#Button_guardar_registroPrincipalEstablecimiento_y_Titular').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('principal.php?page=".$page."&action=ajax');";
?>
                        }, 2000);

                  }
        });
  event.preventDefault();
});



$( "#guardar_registroPrincipalDomicilioEstablecimiento" ).submit(function( event ) {
  $('#Button_guardar_registroPrincipalDomicilioEstablecimiento').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/ActualizarDatosDomicilio.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxActualizarDomicilioEstablecimiento").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxActualizarDomicilioEstablecimiento").html(datos);
                        $('#Button_guardar_registroPrincipalDomicilioEstablecimiento').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('principal.php?page=".$page."&action=ajax');";
?>
                        }, 2000);

                  }
        });
  event.preventDefault();
});



$( "#guardar_registroPrincipalTitularHerencia" ).submit(function( event ) {
  $('#Button_guardar_registroPrincipalTitularHerencia').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/ActualizarDatosTitularHerencia.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxActualizarDatosTitularHerencia").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxActualizarDatosTitularHerencia").html(datos);
                        $('#Button_guardar_registroPrincipalTitularHerencia').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('principal.php?page=".$page."&action=ajax');";
?>
                        }, 2000);

                  }
        });
  event.preventDefault();
});



$( "#guardar_registroPrincipalTitular" ).submit(function( event ) {
  $('#Button_guardar_registroPrincipalTitular').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/ActualizarDatosTitular.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxActualizarDatosTitular").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxActualizarDatosTitular").html(datos);
                        $('#Button_guardar_registroPrincipalTitular').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('principal.php?page=".$page."&action=ajax');";
?>
                        }, 2000);

                  }
        });
  event.preventDefault();
});



$( "#guardar_DatosNombreComercial" ).submit(function( event ) {
  $('#Button_guardar_DatosNombreComercial').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/ActualizarDatosNombreComercial.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxDatosNombreComercial").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxDatosNombreComercial").html(datos);
                        $('#Button_guardar_DatosNombreComercial').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('principal.php?page=".$page."&action=ajax');";
?>
                        }, 2000);

                  }
        });
  event.preventDefault();
});




$( "#registro_guardar_pago_presupuestoTramiteCierreTemporal" ).submit(function( event ) {
  $('#Button_registro_guardar_pago_presupuestoTramiteCierreTemporal').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/revisar_pagoPresupuestoCierreTemporal.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajaxPagoPresupuestoTramiteCierreTemporal").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajaxPagoPresupuestoTramiteCierreTemporal").html(datos);
			$('#Button_registro_guardar_pago_presupuestoTramiteCierreTemporal').attr("disabled", true);
			window.setTimeout(function() {
				$(".alert").fadeTo(150, 0).slideUp(150, function(){
				$(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('detalleRegistroTramite.php?id=".$IDPRINCIPAL."--".$page."--".$ID_TRAMITE_SOLICITADO."');";
?>


			}, 2000);

		  }
	});
  event.preventDefault();
});



$( "#registro_guardar_pagoTramiteRevalidacion" ).submit(function( event ) {
  $('#Button_registro_guardar_pagoTramiteRevalidacion').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/registro_guardar_pagoTramiteRevalidacionPago.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxPagoTramiteRevalidacion").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxPagoTramiteRevalidacion").html(datos);
                        $('#Button_registro_guardar_pagoTramiteRevalidacion').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('detalleRegistroTramite.php?id=".$IDPRINCIPAL."--".$page."--".$ID_TRAMITE_SOLICITADO."');";
?>


                        }, 2000);

                  }
        });
  event.preventDefault();
});




$( "#registro_guardar_pagoTramiteCambio" ).submit(function( event ) {
  $('#Button_registro_guardar_pagoTramiteCambio').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/registro_guardar_pagoTramitePago.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxPagoTramiteCambio").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxPagoTramiteCambio").html(datos);
                        $('#Button_registro_guardar_pagoTramiteCambio').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('detalleRegistroTramite.php?id=".$IDPRINCIPAL."--".$page."--".$ID_TRAMITE_SOLICITADO."');";
?>


                        }, 2000);

                  }
        });
  event.preventDefault();
});




$( "#registro_guardar_PagoInspRAD_CierreTemporal" ).submit(function( event ) {
  $('#Button_registro_guardar_PagoInspRAD_CierreTemporal').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/registro_guardar_pagoInspRAD_CierreTemporal.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxPagoInspRAD_CierreTemporal").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxPagoInspRAD_CierreTemporal").html(datos);
                        $('#Button_registro_guardar_PagoInspRAD_CierreTemporal').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('detalleRegistroTramite.php?id=".$IDPRINCIPAL."--".$page."--".$ID_TRAMITE_SOLICITADO."');";
?>


                        }, 2000);

                  }
        });
  event.preventDefault();
});






$( "#registro_guardar_pago_presupuestoImprimirPermiso" ).submit(function( event ) {
  $('#Button_registro_guardar_pago_presupuestoImprimirPermiso').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/registro_guardar_ImprimirPermiso.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxPagoPresupuestoImprimirPermiso").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxPagoPresupuestoImprimirPermiso").html(datos);
                        $('#Button_registro_guardar_pago_presupuestoImprimirPermiso').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('principal.php?page=".$page."&action=ajax');";
?>
                        }, 2000);

                  }
        });
  event.preventDefault();
});






$( "#registro_guardar_pago_presupuestoTramiteRevalidacion" ).submit(function( event ) {
  $('#Button_registro_guardar_pago_presupuestoTramiteRevalidacion').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/registro_guardar_TramitePresupuestoRevalidacion.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxPagoPresupuestoTramiteRevalidacion").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxPagoPresupuestoTramiteRevalidacion").html(datos);
                        $('#Button_registro_guardar_pago_presupuestoTramiteRevalidacion').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('detalleRegistroTramite.php?id=".$IDPRINCIPAL."--".$page."--0X');";
?>
                        }, 2000);

                  }
        });
  event.preventDefault();
});


$( "#registro_guardar_pago_presupuestoTramite" ).submit(function( event ) {
  $('#Button_registro_guardar_pago_presupuestoTramite').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/registro_guardar_TramitePresupuesto.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxPagoPresupuestoTramite").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxPagoPresupuestoTramite").html(datos);
                        $('#Button_registro_guardar_pago_presupuestoTramite').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('detalleRegistroTramite.php?id=".$IDPRINCIPAL."--".$page."--".$ID_TRAMITE_SOLICITADO."');";
?>
                        }, 2000);

                  }
        });
  event.preventDefault();
});



$( "#registro_guardar_inspeccion" ).submit(function( event ) {
  $('#Button_registro_guardar_inspeccion').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/registro_guardar_inspeccion.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajaxInspeccion").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajaxInspeccion").html(datos);
			$('#Button_registro_guardar_inspeccion').attr("disabled", true);
			window.setTimeout(function() {
				$(".alert").fadeTo(150, 0).slideUp(150, function(){
				$(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('principal.php?page=".$page."&action=ajax');";
?>

			}, 2000);

		  }
	});
  event.preventDefault();
});






// Inicializar eventos para los botones de modal
$(document).ready(function() {
    $('[data-bs-toggle="modal"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        
        // Extraer los datos de los atributos data
	var nombre_persona_fisicamoral_solicitante = $(this).data('nombre_persona_fisicamoral_solicitante');
	var nombre_representante_legal_solicitante = $(this).data('nombre_representante_legal_solicitante');
	var domicilio_solicitante = $(this).data('domicilio_solicitante');
	var email_solicitante = $(this).data('email_solicitante');
	var telefono_solicitante = $(this).data('telefono_solicitante');
	var rfc = $(this).data('rfc');
	var fisica_o_moral = $(this).data('fisica_o_moral');

	// --
	var nombreComercial = $(this).data('nombre_comercial_establecimiento');
	var clave_catastral = $(this).data('clave_catastral');
	var calle_establecimiento = $(this).data('calle_establecimiento');
	var entre_calles_establecimiento = $(this).data('entre_calles_establecimiento');
	var numero_establecimiento = $(this).data('numero_establecimiento');
	var numerointerno_local_establecimiento = $(this).data('numerointerno_local_establecimiento');
	var cp_establecimiento = $(this).data('cp_establecimiento');
	var capacidad_comensales_personas = $(this).data('capacidad_comensales_personas');
	var superficie_establecimiento = $(this).data('superficie_establecimiento');
	var colonia_id = $(this).data('colonia_id');
	var delegacion_id = $(this).data('delegacion_id');
	var observaciones = $(this).data('observaciones');
	// --
	var id_giro = $(this).data('id_giro');
	var descripcion_giro = $(this).data('descripcion_giro');
	var modalidad_graduacion_alcoholica = $(this).data('modalidad_graduacion_alcoholica');
	var servicios_adicionales = $(this).data('servicios_adicionales');

	var nota = $(this).data('nota');
	var giro_id_seleccionado = $(this).data('giro_id_seleccionado');

	// --
        var folio = $(this).data('folio');
        var idPrincipal = $(this).data('idprincipal');
        var pagina = $(this).data('pagina');
        var tramite_pagoid = $(this).data('tramite_pagoid');
	var tramite_pago = $(this).data('tramite_pago');

        var id_pago_rad = $(this).data('id_pago_rad');
	var id_pago_ins = $(this).data('id_pago_ins');

        var concepto_tramite = $(this).data('concepto_tramite');
        var concepto_giro = $(this).data('concepto_giro');
        var concepto_modalidad = $(this).data('concepto_modalidad');
        var concepto_servicios_adicionales = $(this).data('concepto_servicios_adicionales');
	var total_umas_pagar = $(this).data('total_umas_pagar');
	var id_tramite_solicitado = $(this).data('id_tramite_solicitado');

	var id_tramite = $(this).data('id_tramite');
	var id_proceso_tramites = $(this).data('id_proceso_tramites');

        
        // Abrir el modal utilizando Bootstrap 5
        var myModal = new bootstrap.Modal(document.querySelector(target));
        
        // Transferir los datos al modal antes de mostrarlo
	$(target + ' #mod_nombre_persona_fisicamoral_solicitante').val(nombre_persona_fisicamoral_solicitante);
	$(target + ' #mod_nombre_representante_legal_solicitante').val(nombre_representante_legal_solicitante);
	$(target + ' #mod_domicilio_solicitante').val(domicilio_solicitante);
	$(target + ' #mod_email_solicitante').val(email_solicitante);
	$(target + ' #mod_telefono_solicitante').val(telefono_solicitante);
	$(target + ' #mod_rfc').val(rfc);
	$(target + ' #mod_fisica_o_moral').val(fisica_o_moral);

	$(target + ' #mod_nota').val(nota);
	$(target + ' #mod_giro_id_seleccionado').val(giro_id_seleccionado);

	// --
        $(target + ' #mod_nombre_comercial_establecimiento').val(nombreComercial);
        $(target + ' #mod_clave_catastral').val(clave_catastral);
        $(target + ' #mod_calle_establecimiento').val(calle_establecimiento);
        $(target + ' #mod_entre_calles_establecimiento').val(entre_calles_establecimiento);
        $(target + ' #mod_numero_establecimiento').val(numero_establecimiento);
        $(target + ' #mod_numerointerno_local_establecimiento').val(numerointerno_local_establecimiento);
        $(target + ' #mod_cp_establecimiento').val(cp_establecimiento);
        $(target + ' #mod_capacidad_comensales_personas').val(capacidad_comensales_personas);
        $(target + ' #mod_superficie_establecimiento').val(superficie_establecimiento);
        $(target + ' #mod_id_colonia').val(colonia_id);
        $(target + ' #mod_id_delegacion').val(delegacion_id);
        $(target + ' #mod_observaciones').val(observaciones);
	// --
        $(target + ' #mod_descripcion_giro').val(descripcion_giro);
        $(target + ' #mod_id_giro').val(id_giro);
        $(target + ' #mod_modalidad_graduacion_alcoholica').val(modalidad_graduacion_alcoholica);
        $(target + ' #mod_servicios_adicionales').val(servicios_adicionales);

	// --
	$(target + ' #mod_concepto_tramite').val(concepto_tramite);
	$(target + ' #mod_concepto_giro').val(concepto_giro);
	$(target + ' #mod_concepto_modalidad').val(concepto_modalidad);
	$(target + ' #mod_concepto_servicios_adicionales').val(concepto_servicios_adicionales);
	$(target + ' #mod_total_umas_pagar').val(total_umas_pagar);
	$(target + ' #mod_id_tramite_solicitado').val(id_tramite_solicitado);

	$(target + ' #mod_id_tramite').val(id_tramite);
	$(target + ' #mod_id_proceso_tramites').val(id_proceso_tramites);

        $(target + ' #mod_id_pago_rad').val(id_pago_rad);
        $(target + ' #mod_id_pago_ins').val(id_pago_ins);
        $(target + ' #mod_tramite_pago').val(tramite_pago);
        $(target + ' #mod_tramite_pagoid').val(tramite_pagoid);
        $(target + ' #mod_folio').val(folio);
        $(target + ' #mod_idprincipal, ' + target + ' #IDPRINCIPAL').val(idPrincipal);
        $(target + ' #mod_pagina, ' + target + ' #page').val(pagina);
        
        // Mostrar el modal
        myModal.show();
    });
});
</script>
</body>
</html>



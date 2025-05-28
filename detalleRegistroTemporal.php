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
	include("modal/revisar_pagoTemp.php");
	include("modal/revisar_pagoPresupuestoTemp.php");
	include("modal/eliminar_registro.php");

	include("modal/actualizar_datos_solicitanteTemporal.php");
	include("modal/actualizar_datos_establecimientoTemporal.php");
	include("modal/actualizar_giro_modalidad_serviciosesp.php");

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
            max-width: 90%;
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

    ##$IDPRINCIPAL = $_GET['id'];
    ##$page = isset($_GET['page']) ? $_GET['page'] : 1; // Asegurarse que siempre existe page

##
$ID = $_GET['id'];
##$ID = intval($_GET['id']);
$porciones = explode("--", $ID);
$IDPRINCIPAL=intval($porciones[0]);
$page=$porciones[1];
$ID_TRAMITE_SOLICITADO=$porciones[2];


} else {
    $IDPRINCIPAL = $_POST['idRT'];
    ##$page = isset($_POST['page']) ? $_POST['page'] : 1; // Asegurarse que siempre existe page
    $page=$_POST['paginaRT'];
    $ID_TRAMITE_SOLICITADO=$_POST['id_tramiteRT'];
}
#################################
#################################



$sqlPrincipal="SELECT * FROM principal_temp WHERE id=".$IDPRINCIPAL;
$row = mysqli_fetch_array(mysqli_query($con,$sqlPrincipal));

$principal_id=$row['id'];
$folio=$row['folio'];

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
if ( $delegacion_id=='' || $delegacion_id==NULL ) {
$COLONIA='ND';
$DELEGACION='ND';
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
?>

    <div class="mt-4">
        <!-- Encabezado del programa -->
        <div class="encabezado-programa">
            <h6 class="mb-0"><font color="red"><b>Registro Permiso Temporal </b></font>-  Establecimiento, Solicitante, Estatus y Operación</h6>
        </div>
        
        <!-- Sección de datos del establecimiento -->
        <div class="seccion-datos">
            <div class="encabezado">
                <h4>Datos del Establecimiento</h4>
            </div>
	    <div class="contenido">


                <div class="row fila-datos">
                    <div class="col-10">
                        <div class="etiqueta">Tramite</div>
			<div class="valor valor-destacado"><?php echo $TRAMITE; ?>  {<?php echo number_format($MONTO_UMAS_tramite,2); ?> umas}</div>



                    </div>
                    <div class="col-md-2 col-4">
                        <div class="etiqueta">Folio</div>
                        <div class="valor"><?php echo $folio; ?></div>
                    </div>
                </div>


                <div class="row fila-datos">
                    <div class="col-4">
                        <div class="etiqueta">Giro</div>
			<div class="valor"><?php echo $GIRO; ?>   {<?php echo number_format($COBRO_UMAS_giro,2) ?> umas}</div>
                    </div>
                    <div class="col-8">
                        <div class="etiqueta">Servicios Adicionales</div>
			<div class="valor valor-destacado"><?php echo $servicios_adicionales; ?> * [<?php echo $numero_servicios_adicionales; ?>] {<?php echo $monto_umas_total_servicios_adicionales; ?> umas}</div>
		    </div>
		  </div>


                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">Modalidad Graduación Alcohólica</div>
			<div class="valor"><?php echo $modalidad_graduacion_alcoholica; ?> * [<?php echo $numero_modalidad_graduacion_alcoholica; ?>]</div>
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
			<div class="valor valor-destacado"><?php echo $servicios_adicionales; ?> * [<?php echo $numero_servicios_adicionales; ?>] {<?php echo $monto_umas_total_servicios_adicionales; ?> umas}</div>
                    </div>
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
        
    </div>
</div>

	
        <!-- Botones de acción -->
	<!-- <div class="area-botones"> --!>
	<center><div  class="area-botones">

<?php

echo '<button type="button" onclick="window.location.href=\'principal_temp.php?page='.$page.'&action=ajax\'" class="btn btn-info bs-sm" style="background-color:#FFFFFF;" > <i class="bi bi-arrow-left"></i><font size="1"> Regresar</font></button>';
//<a href="principal.php?page='.$page.'" class="btn btn-info" style="background-color:#FFFFFF;"> <i class="bi bi-arrow-left"></i><font color="black" size="1"> Regresar </font></a>

?>

          




<?php 	


##
if ( $estatus=='Generar Recibos IRAD' || $estatus=='Pago INS' ||  $estatus=='Pago RAD' ) {

#################
echo '<a href="generarTemporal_pdf_html.php?id='.$IDPRINCIPAL.'" target="_blank" class="btn btn-danger btn-sm"> <i class="bi bi-file-earmark-pdf"></i><font size="1"> Datos Generales </font></a>';
#################
//** Inspección ( tabla tramites )
##
$sql_tramite="SELECT * FROM tramite WHERE descripcion_tramite='Inspeccion - Permiso Temporal'";
$result_tramite = mysqli_query($con,$sql_tramite);
$row_tramite = mysqli_fetch_assoc($result_tramite);
$ID_TRAMITE=$row_tramite['id'];
$MONTO_UMAS_Inspeccion=$row_tramite['monto_umas'];

#### RECIBO INSPECCION
if ( $estatus=='Pago INS' )  {
} else {
echo '<a href="datosParaPagarTemporal_pdf_html.php?id='.$IDPRINCIPAL.'--'.$ID_TRAMITE.'--'.$ID_TRAMITE_SOLICITADO.'" target="_blank" class="btn btn-warning btn-sm"><i class="bi bi-file-earmark-pdf"></i><font size="1">Recibo Inspección</font></a>';
}
#### Revisar Pago INSP
$ID_PAGO_INS=0;
$ID_PAGO_RAD=0;
##
$sql_pagoI="SELECT * FROM `pagos_temp` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Inspeccion' AND `estatus_pago`='Pendiente' AND id_proceso_tramites=".$id_proceso_tramites;
$result_pagoI = mysqli_query($con,$sql_pagoI);
if (mysqli_num_rows($result_pagoI) > 0) {
$row_pagoI = mysqli_fetch_assoc($result_pagoI);
$ID_PAGO_INS=$row_pagoI['id'];
} else {
$ID_PAGO_INS=0;
}
##
if ( $estatus=='Pago INS' )  {
$sql_pagoI2="SELECT * FROM `pagos_temp` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Inspeccion' AND `estatus_pago`='Pendiente' AND id_proceso_tramites=".$id_proceso_tramites;
$result_pagoI2 = mysqli_query($con,$sql_pagoI2);
if (mysqli_num_rows($result_pagoI2) > 0) {
$row_pagoI2 = mysqli_fetch_assoc($result_pagoI2);
$fecha_pagoI2=$row_pagoI2['fecha_pago'];
$montoI2=$row_pagoI2['monto'];
##echo '<font size="1"><b>Inspección Pagada ('.$fecha_pagoI2.') $'.number_format($montoI2,2).'</b></font>&nbsp;';
} else {
echo '<a href="#" class="btn btn-success btn-sm"><i class="bi bi-currency-dollar"></i><font color="white" size="1">INSP Pagado</font></a>';
##echo '<font size="1" color="red"><b>Error Pago Inspeccion</b></font>&nbsp;';
}
} else {
echo '<a href="#revisarPagoTemp" data-bs-toggle="modal" data-bs-target="#revisarPagoTemp" data-id_pago_ins="'.$ID_PAGO_INS.'"  data-id_pago_rad="'.$ID_PAGO_RAD.'"  data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'"
 data-total_umas_pagar="'.$MONTO_UMAS_Inspeccion.'" data-tramite_pagoid="'.$ID_TRAMITE.'" data-tramite_pago="Inspeccion"  class="btn btn-danger btn-sm" title="Pago Inspección"><i class="bi bi-check-circle"></i><font size="1">Pago Inspeción('.$ID_PAGO_INS.')</font></a>';
}
### RECEPCION ANALISIS DE DOCUMENTOS
//** Análisis y Revisión Documentos ( tabla tramites )
##
$sql_tramite="SELECT * FROM tramite WHERE descripcion_tramite='Recepcion y Analisis Documentos - Permiso Temporal'";
$result_tramite = mysqli_query($con,$sql_tramite);
$row_tramite = mysqli_fetch_assoc($result_tramite);
$ID_TRAMITE=$row_tramite['id'];
$MONTO_UMAS_RAD=$row_tramite['monto_umas'];
##
if ( $estatus=='Pago RAD' )  {
} else {
echo '<a href="datosParaPagarTemporal_pdf_html.php?id='.$IDPRINCIPAL.'--'.$ID_TRAMITE.'--'.$ID_TRAMITE_SOLICITADO.'" target="_blank" class="btn btn-warning btn-sm"> <i class="bi bi-file-earmark-pdf"></i><font size="1">Recibo AR Docs</font></a>';
}
#### Revisar Pago RAD
#### 
$sql_pagoRAD="SELECT * FROM `pagos_temp` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Recepcion y Analisis Documentos' AND `estatus_pago`='Pendiente' AND id_proceso_tramites=".$id_proceso_tramites;
$result_pagoRAD = mysqli_query($con,$sql_pagoRAD);
if (mysqli_num_rows($result_pagoRAD) > 0) {
$row_pagoRAD = mysqli_fetch_assoc($result_pagoRAD);
$ID_PAGO_RAD=$row_pagoRAD['id'];
} else {
$ID_PAGO_RAD=0;
}
##
##
if ( $estatus=='Pago RAD' )  {
	$sql_pagoRAD2="SELECT * FROM `pagos_temp` WHERE `id_principal`=$IDPRINCIPAL AND `concepto`='Recepcion y Analisis Documentos' AND `estatus_pago`='Pendiente' AND id_proceso_tramites=".$id_proceso_tramites;
$result_pagoRAD2 = mysqli_query($con,$sql_pagoRAD2);
if (mysqli_num_rows($result_pagoRAD2) > 0) {
$row_pagoRAD2 = mysqli_fetch_assoc($result_pagoRAD2);
$fecha_pagoRAD2=$row_pagoRAD2['fecha_pago'];
$montoRAD2=$row_pagoRAD2['monto'];
##echo '<font size="1"><b>RAD Pagado ('.$fecha_pagoRAD2.') $'.number_format($montoRAD2,2).'</b></font>&nbsp;';
} else {
//echo '<font size="1" color="red"><b>Error Pago RAD</b></font>&nbsp;';
echo '<a href="#" class="btn btn-success btn-sm"><i class="bi bi-currency-dollar"></i><font color="white" size="1">RAD Pagado</font></a>';
}
} else {
echo '<a href="#revisarPagoTemp" data-bs-toggle="modal" data-bs-target="#revisarPagoTemp" data-id_pago_ins="'.$ID_PAGO_INS.'"  data-id_pago_rad="'.$ID_PAGO_RAD.'" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" data-tramite_pagoid="'.$ID_TRAMITE.'"
 data-total_umas_pagar="'.$MONTO_UMAS_RAD.'"
 data-tramite_pago="Recepcion y Analisis Documentos"  class="btn btn-danger btn-sm" title="Revisar Pago RA Documentos"><i class="bi bi-check-circle"></i><font size="1">Pago RADocs('.$ID_PAGO_RAD.')</font></a>';
}
###################               
###################               
###################               
if ( $estatus=='Generar Recibos IRAD' ) {

echo  '<a href="#EliminarRegistro" data-bs-toggle="modal" data-bs-target="#EliminarRegistro" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" class="btn btn-dark bs-sm" title="Eliminar Registro"><font color="red"><i class="bi bi-trash"></i></font></a>';


echo '<div class="dropup">';
echo '<button class="dropbtn"><font size="1" color="red">Actualizar Registro</font></button>';
echo '<div class="dropup-content">';
//echo  '<a href="#ActualizarGiroModalidadServiciosEsp" data-bs-toggle="modal" data-bs-target="#GiroModalidadServiciosEsp" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" data-id_giro="'.$id_giro.'" data-modalidad_graduacion_alcoholica="'.$modalidad_graduacion_alcoholica.'" data-servicios_adicionales="'.$servicios_adicionales.'" class="btn btn-dark bs-sm" title="Actualizar GiroModalidadServiciosEsp Establecimiento"><font color="red" size="2"><i class="bi bi-pencil"></i> Giro, Modalidad y SE</font></a>';
##
echo  '<a href="#ActualizarDatosEstablecimientoTemporal" data-bs-toggle="modal" data-bs-target="#ActualizarDatosEstablecimientoTemporal" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-clave_catastral="'.$clave_catastral.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" data-calle_establecimiento="'.$calle_establecimiento.'" data-entre_calles_establecimiento="'.$entre_calles_establecimiento.'" data-numero_establecimiento="'.$numero_establecimiento.'" data-numerointerno_local_establecimiento="'.$numerointerno_local_establecimiento.'" data-cp_establecimiento="'.$cp_establecimiento.'" data-capacidad_comensales_personas="'.$capacidad_comensales_personas.'" data-superficie_establecimiento="'.$superficie_establecimiento.'" data-colonia_id="'.$colonia_id.'" data-delegacion_id="'.$delegacion_id.'" data-observaciones="'.$observaciones.'" class="btn btn-dark bs-sm" title="Actualizar Datos Establecimiento"><font color="red" size="2"><i class="bi bi-pencil"></i> Datos del Establecimiento</font></a>';
##
echo  '<a href="#ActualizarDatosSolicitanteTemporal" data-bs-toggle="modal" data-bs-target="#ActualizarDatosSolicitanteTemporal" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" data-nombre_persona_fisicamoral_solicitante="'.$nombre_persona_fisicamoral_solicitante.'" data-nombre_representante_legal_solicitante="'.$nombre_representante_legal_solicitante.'" data-domicilio_solicitante="'.$domicilio_solicitante.'" data-email_solicitante="'.$email_solicitante.'" data-telefono_solicitante="'.$telefono_solicitante.'" data-fisica_o_moral="'.$fisica_o_moral.'" data-rfc="'.$rfc.'"  class="btn btn-dark bs-sm" title="Actualizar Datos Solicitante"><font color="red" size="2"><i class="bi bi-pencil"></i> Datos del Solicitante</font></a>';
echo '</div>';
echo '</div>';
}


}
//chang
###################               
###################               
## Revisar si ya se realizo la INSPECCION
$sql_INSPECCION="SELECT COUNT(*) AS INSPECCION FROM  inspeccion WHERE id_principal=".$IDPRINCIPAL." AND id_proceso_tramites=".$id_proceso_tramites." AND en_proceso='FIN'";
$result_INSPECCION = mysqli_query($con,$sql_INSPECCION);
$row_INSPECCION = mysqli_fetch_assoc($result_INSPECCION);
$INSPECCION=$row_INSPECCION['INSPECCION'];
## Revisar si ya se realizo la REVISION Y ANALISIS DE DOCUMENTOS
$sql_RAD="SELECT COUNT(*) AS RAD FROM  recepcion_analisis_documentos WHERE id_principal=".$IDPRINCIPAL." AND id_proceso_tramites=".$id_proceso_tramites." AND en_proceso='FIN'";
$result_RAD = mysqli_query($con,$sql_RAD);
$row_RAD = mysqli_fetch_assoc($result_RAD);
$RAD=$row_RAD['RAD'];
###################               
###################               


###################               
###################               
##
if ( $estatus=='Pagos IRAD' || $estatus=='Inspeccion Realizada' || $estatus=='RAD Realizado')  {

echo '<a href="#" class="btn btn-success bs-sm"><i class="bi bi-currency-dollar"></i><font color="white" size="1">INSP-RAD Pagados</font></a>';



if ( 
empty($calle_establecimiento) ||  
empty($clave_catastral) ||  
empty($domicilio_solicitante) ||  
empty($email_solicitante) ||  
empty($nombre_persona_fisicamoral_solicitante) ||  
empty($telefono_solicitante) 
) {

####
echo '<div class="dropup">';
echo '<button class="dropbtn"><font size="1" color="red">Actualizar Registro</font></button>';
echo '<div class="dropup-content">';
echo  '<a href="#ActualizarGiroModalidadServiciosEsp" data-bs-toggle="modal" data-bs-target="#GiroModalidadServiciosEsp" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" data-id_giro="'.$id_giro.'" data-modalidad_graduacion_alcoholica="'.$modalidad_graduacion_alcoholica.'" data-servicios_adicionales="'.$servicios_adicionales.'" class="btn btn-dark bs-sm" title="Actualizar GiroModalidadServiciosEsp Establecimiento"><font color="red" size="2"><i class="bi bi-pencil"></i> Giro, Modalidad y SE</font></a>';
##
echo  '<a href="#ActualizarDatosEstablecimientoTemporal" data-bs-toggle="modal" data-bs-target="#ActualizarDatosEstablecimientoTemporal" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-clave_catastral="'.$clave_catastral.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" data-calle_establecimiento="'.$calle_establecimiento.'" data-entre_calles_establecimiento="'.$entre_calles_establecimiento.'" data-numero_establecimiento="'.$numero_establecimiento.'" data-numerointerno_local_establecimiento="'.$numerointerno_local_establecimiento.'" data-cp_establecimiento="'.$cp_establecimiento.'" data-capacidad_comensales_personas="'.$capacidad_comensales_personas.'" data-superficie_establecimiento="'.$superficie_establecimiento.'" data-colonia_id="'.$colonia_id.'" data-delegacion_id="'.$delegacion_id.'" data-observaciones="'.$observaciones.'" class="btn btn-dark bs-sm" title="Actualizar Datos Establecimiento"><font color="red" size="2"><i class="bi bi-pencil"></i> Datos del Establecimiento</font></a>';
##
echo  '<a href="#ActualizarDatosSolicitanteTemporal" data-bs-toggle="modal" data-bs-target="#ActualizarDatosSolicitanteTemporal" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" data-nombre_persona_fisicamoral_solicitante="'.$nombre_persona_fisicamoral_solicitante.'" data-nombre_representante_legal_solicitante="'.$nombre_representante_legal_solicitante.'" data-domicilio_solicitante="'.$domicilio_solicitante.'" data-email_solicitante="'.$email_solicitante.'" data-telefono_solicitante="'.$telefono_solicitante.'" data-fisica_o_moral="'.$fisica_o_moral.'" data-rfc="'.$rfc.'"  class="btn btn-dark bs-sm" title="Actualizar Datos Solicitante"><font color="red" size="2"><i class="bi bi-pencil"></i> Datos del Solicitante</font></a>';
echo '</div>';
echo '</div>';

####	
echo '<a href="#"  class="btn btn-danger bs-sm" title="Registrar Inspección"> <i class="bi bi-clipboard-check"></i><font size="1"> Registrar Inspección </font></a>';
##
echo '<a href="#"  class="btn btn-danger bs-sm" title="Registrar RAD"> <i class="bi bi-clipboard-check"></i><font size="1"> Registrar R y A Docs </font></a>';


} else {
if ( $INSPECCION>0 ) {
} else {
echo '<a href="principalFotosTemporal.php?id='.$IDPRINCIPAL.'&page='.$page.'&id_proceso_tramites='.$id_proceso_tramites.'"  class="btn btn-danger bs-sm" title="Registrar Inspección"> <i class="bi bi-clipboard-check"></i><font size="1"> Registrar Inspección </font></a>';
}
##
if ( $RAD>0 ) {
} else {
echo '<a href="principalPDFsTemporal.php?id='.$IDPRINCIPAL.'&page='.$page.'&id_proceso_tramites='.$id_proceso_tramites.'"  class="btn btn-danger bs-sm" title="Registrar RAD"> <i class="bi bi-clipboard-check"></i><font size="1"> Registrar R y A Docs </font></a>';
}
#########
if ( $INSPECCION>0 && $RAD>0  )  {
$Kuery_Update2="UPDATE principal_temp SET estatus='Presupuesto' WHERE id=".$IDPRINCIPAL;
if (!mysqli_query($con,$Kuery_Update2)) echo mysqli_error();
}
#########
}

}
###################               
###################               
##
if ( $estatus=='Presupuesto' || ( $INSPECCION>0 && $RAD>0 ) )  {

$concepto_tramite=$TRAMITE." {".number_format($MONTO_UMAS_tramite,2)." umas}";
$concepto_giro=$GIRO." {".number_format($COBRO_UMAS_giro,2)." umas}";
$concepto_modalidad=$modalidad_graduacion_alcoholica." [".$numero_modalidad_graduacion_alcoholica."] {".number_format($monto_umas_total_modalidad_graduacion_alcoholica,2)." umas}";
$concepto_servicios_adicionales=$servicios_adicionales." [".$numero_servicios_adicionales."]  {".number_format($monto_umas_total_servicios_adicionales,2)." umas }";
$MONTO_TOTAL_UMAS=$MONTO_UMAS_tramite+$monto_umas_total_servicios_adicionales+$monto_umas_total_modalidad_graduacion_alcoholica+$COBRO_UMAS_giro;
echo '<a href="datosParaPagar_pdf_Temporal_html.php?id='.$IDPRINCIPAL.'--'.$id_tramite.'--SI--SI" target="_blank" class="btn btn-danger bs-sm" style="background-color:#AC905B;"> <i class="bi bi-file-earmark-pdf"></i><font size="1"> Recibo Presupuesto</font></a>';

echo '<a href="#revisarPagoPresupuestoTemp" data-bs-toggle="modal" data-bs-target="#revisarPagoPresupuestoTemp" 
 data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" 
 data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" 
 data-concepto_tramite="'.$concepto_tramite.'"  
 data-tramite_pago="Permiso Nuevo Presupuesto"  
 data-concepto_giro="'.$concepto_giro.'"  
 data-id_tramite="'.$id_tramite.'"  
 data-id_proceso_tramites="'.$id_proceso_tramites.'"  
 data-concepto_modalidad="'.$concepto_modalidad.'"  
 data-concepto_servicios_adicionales="'.$concepto_servicios_adicionales.'"  
 data-total_umas_pagar="'.$MONTO_TOTAL_UMAS.'"  
class="btn btn-danger bs-sm" title="Revisar Pago Presupuesto"><i class="bi bi-check-circle"></i><font size="1">Pago Pesupuesto</font></a>';

}
 ## LOS ELIMINE
 ##data-tramite_pagoid="'.$ID_TRAMITE.'" 
 ##data-id_pago_ins="'.$ID_PAGO_INS.'"  
 ##data-id_pago_rad="'.$ID_PAGO_RAD.'" 
?>


	</div></center>



<!-- Espacio adicional antes del footer -->
<div style="margin-bottom: 30px;"></div>
<br>
<hr>
<?php 

mysqli_close($con);
include("footer.php"); 

?>

<script>



$( "#guardar_PrincipalEstablecimientoInicioTemporal" ).submit(function( event ) {
  $('#Button_guardar_PrincipalEstablecimientoInicioTemporal').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/ActualizarDatosEstablecimientoInicioTemporal.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxGuardarPrincipalEstablecimientoInicioTemporal").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxGuardarPrincipalEstablecimientoInicioTemporal").html(datos);
                        $('#Button_guardar_PrincipalEstablecimientoInicioTemporal').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('detalleRegistroTemporal.php?id=".$IDPRINCIPAL."--".$page."--".$ID_TRAMITE_SOLICITADO."');";
?>
                        }, 2000);

                  }
        });
  event.preventDefault();
});



$( "#guardar_PrincipalSolicitanteInicioTemporal" ).submit(function( event ) {
  $('#Button_guardar_PrincipalSolicitanteInicioTemporal').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/ActualizarDatosSolicitanteInicioTemporal.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxGuardarPrincipalSolicitanteInicioTemporal").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxGuardarPrincipalSolicitanteInicioTemporal").html(datos);
                        $('#Button_guardar_PrincipalSolicitanteInicioTemporal').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('detalleRegistroTemporal.php?id=".$IDPRINCIPAL."--".$page."--".$ID_TRAMITE_SOLICITADO."');";
?>
                        }, 2000);

                  }
        });
  event.preventDefault();
});





$( "#registro_guardar_pagoTemp" ).submit(function( event ) {
  $('#Button_registro_guardar_pagoTemp').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/registro_guardar_pagoTemp.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajaxPagoTemp").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajaxPagoTemp").html(datos);
			$('#Button_registro_guardar_pagoTemp').attr("disabled", true);
			window.setTimeout(function() {
				$(".alert").fadeTo(150, 0).slideUp(150, function(){
					$(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('detalleRegistroTemporal.php?id=".$IDPRINCIPAL."--".$page."--".$ID_TRAMITE_SOLICITADO."');";
?>
			}, 2000);

		  }
	});
  event.preventDefault();
});


$( "#registro_guardar_pago_presupuestoTemp" ).submit(function( event ) {
  $('#Button_registro_guardar_pago_presupuestoTemp').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/registro_guardar_pago_presupuestoTemp.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxPagoPresupuestoTemp").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxPagoPresupuestoTemp").html(datos);
                        $('#Button_registro_guardar_pago_presupuestoTemp').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('principal_temp.php?page=".$page."&action=ajax');";
?>


                        }, 22000);

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
				location.replace('principal.php');
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
	var clave_catastral = $(this).data('clave_catastral');
	// --
	var id_giro = $(this).data('id_giro');
	var modalidad_graduacion_alcoholica = $(this).data('modalidad_graduacion_alcoholica');
	var servicios_adicionales = $(this).data('servicios_adicionales');

	// --
        var folio = $(this).data('folio');
        var idPrincipal = $(this).data('idprincipal');
        var pagina = $(this).data('pagina');
        var tramite_pagoid = $(this).data('tramite_pagoid');
	var tramite_pago = $(this).data('tramite_pago');

	var id_proceso_tramites = $(this).data('id_proceso_tramites');

        var id_pago_rad = $(this).data('id_pago_rad');
	var id_pago_ins = $(this).data('id_pago_ins');

        var concepto_tramite = $(this).data('concepto_tramite');
        var concepto_giro = $(this).data('concepto_giro');
        var concepto_modalidad = $(this).data('concepto_modalidad');
        var concepto_servicios_adicionales = $(this).data('concepto_servicios_adicionales');
	var total_umas_pagar = $(this).data('total_umas_pagar');

	var id_tramite = $(this).data('id_tramite');

        
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

	// --
        $(target + ' #mod_nombre_comercial_establecimiento').val(nombreComercial);
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
        $(target + ' #mod_clave_catastral').val(clave_catastral);
	// --
        $(target + ' #mod_id_giro').val(id_giro);
        $(target + ' #mod_modalidad_graduacion_alcoholica').val(modalidad_graduacion_alcoholica);
        $(target + ' #mod_servicios_adicionales').val(servicios_adicionales);

	// --
	$(target + ' #mod_concepto_tramite').val(concepto_tramite);
	$(target + ' #mod_concepto_giro').val(concepto_giro);
	$(target + ' #mod_concepto_modalidad').val(concepto_modalidad);
	$(target + ' #mod_concepto_servicios_adicionales').val(concepto_servicios_adicionales);
	$(target + ' #mod_total_umas_pagar').val(total_umas_pagar);

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



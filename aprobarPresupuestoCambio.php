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
	//include("modal/revisar_pagoTramiteCambio.php");
	//include("modal/revisar_pagoPresupuesto.php");
	//include("modal/efectuar_inspeccion.php");
	//include("modal/actualizar_datos_solicitante.php");
	//include("modal/actualizar_datos_establecimiento.php");
	//include("modal/actualizar_giro_modalidad_serviciosesp.php");

include("modal/elegirGiro.php");
include("modal/aprobrarTramite.php");

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

$ley_ingresos='';

###################################

$sql_tramite10="SELECT * FROM tramite WHERE id=".$ID_TRAMITE_SOLICITADO;
$result_tramite10 = mysqli_query($con,$sql_tramite10);
$row_tramite10 = mysqli_fetch_assoc($result_tramite10);
$TRAMITE_tramite_SOLICITADO=$row_tramite10['descripcion_tramite'];
$MONTO_UMAS_tramite_SOLICITADO=$row_tramite10['monto_umas'];
$CUENTA_tramite_SOLICITADO=$row_tramite10['cuenta'];
$INSPECCION_tramite_SOLICITADO=$row_tramite10['inspeccion'];
$RAD_tramite_SOLICITADO=$row_tramite10['revision_analisis_docs'];
$DESCUENTO_tramite_SOLICITADO=$row_tramite10['descuento'];


###################################
$sql_proceso_tramite="SELECT COUNT(*) AS EXISTE_REG_proceso_tramite_EN_PROCESO FROM  proceso_tramites WHERE id_tramite=".$ID_TRAMITE_SOLICITADO." AND en_proceso='EN PROCESO'";
$result_proceso_tramite = mysqli_query($con,$sql_proceso_tramite);
$row_proceso_tramite = mysqli_fetch_assoc($result_proceso_tramite);
$EXISTE_REG_proceso_tramite_EN_PROCESO=$row_proceso_tramite['EXISTE_REG_proceso_tramite_EN_PROCESO'];

##echo "EXISTE_REGISTRO_proceso_tramite_EN_PROCESO=".$EXISTE_REG_proceso_tramite_EN_PROCESO;
#################################

if (isset($_POST['GIRO_SOLICITADO'])) {
$GIRO_SOLICITADO = $_POST['GIRO_SOLICITADO'];

if ( $GIRO_SOLICITADO!=0 ) {
#
$sql_PRINCIPAL="SELECT giro FROM principal WHERE id=".$IDPRINCIPAL;
$result_sql_PRINCIPAL = mysqli_query($con,$sql_PRINCIPAL);
$row_sql_PRINCIPAL = mysqli_fetch_assoc($result_sql_PRINCIPAL);
$GIRO_PRINCIPAL=$row_sql_PRINCIPAL['giro'];
#
$sql_giro_PRINCIPAL="SELECT * FROM giro WHERE id=".$GIRO_PRINCIPAL;
$result_giro_PRINCIPAL = mysqli_query($con,$sql_giro_PRINCIPAL);
$row_giro_PRINCIPAL = mysqli_fetch_assoc($result_giro_PRINCIPAL);
$GIRO_PRINCIPAL=$row_giro_PRINCIPAL['descripcion_giro'];
$MONTO_UMAS_PRINCIPAL=$row_giro_PRINCIPAL['monto_umas'];

###
$sql_giro_solicitado="SELECT * FROM giro WHERE id=".$GIRO_SOLICITADO;
$result_giro_solicitado = mysqli_query($con,$sql_giro_solicitado);
$row_giro_solicitado = mysqli_fetch_assoc($result_giro_solicitado);
$GIRO_solicitado=$row_giro_solicitado['descripcion_giro'];
$MONTO_UMAS_giro_solicitado=$row_giro_solicitado['monto_umas'];
###

#####$$$$$$$
if ( $MONTO_UMAS_PRINCIPAL < $MONTO_UMAS_giro_solicitado ) {
$TOTAL_UMAS_GIRO=$MONTO_UMAS_giro_solicitado-$MONTO_UMAS_PRINCIPAL;
} else {
$TOTAL_UMAS_GIRO=$MONTO_UMAS_tramite_SOLICITADO;
}

$MONTO_UMAS_tramite_SOLICITADO=$TOTAL_UMAS_GIRO;
#####$$$$$$$

//echo "GIRO PRINCIPAL=".$GIRO_PRINCIPAL.", monto (".$MONTO_UMAS_PRINCIPAL.")";
//echo "GIRO SOLICITADO=".$GIRO_SOLICITADO.", ".$GIRO_solicitado." (".$MONTO_UMAS_giro_solicitado.") <br> PRESUPUESTO=".$TOTAL_UMAS_GIRO;

$MONTO_UMAS_tramite_SOLICITADO=$TOTAL_UMAS_GIRO;
$listo_presupuesto='SI';
} else {
echo "GIRO SOLICITADO=".$GIRO_SOLICITADO;
$listo_presupuesto='NO';
}

} else {
$GIRO_SOLICITADO=0;
$GIRO_solicitado=0;
}

#################################
#################################

$sqlPrincipal="SELECT * FROM principal WHERE id=".$IDPRINCIPAL;
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

	$fecha_autorizacion=$row['fecha_autorizacion'];
	$fecha_expiracion=$row['fecha_expiracion'];

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
#####  TRAMITE :
####	Cambio de Giro
###################################################
if ( $TRAMITE_tramite_SOLICITADO=='Cambio de Giro' ) {
$CAMBIO_DE_GIRO="SI";
$ley_ingresos="Articulo 22, Fracción III-B a).- En los permisos que se solicite el cambio de giro, se
cobrará la diferencia del valor del costo del permiso, y en los casos de disminución de la actividad, se cobrará 6.50 veces la Unidad de Medida y Actualización (UMA) vigente.";
} else {
$CAMBIO_DE_GIRO="NO";
}
##################################################
#####  TRAMITE :
####	Cambio de Domicilio y Cambio de Titular
###################################################

if ( $TRAMITE_tramite_SOLICITADO=='Cambio de Domicilio y Cambio de Titular' && $DESCUENTO_tramite_SOLICITADO=='SI' ) {
$MONTO_UMAS_tramite_SOLICITADO_calculo= ((100 - $MONTO_UMAS_tramite_SOLICITADO ) / 100) * $MONTO_UMAS_giro;
$MONTO_UMAS_tramite_SOLICITADO=$MONTO_UMAS_tramite_SOLICITADO_calculo;

$ley_ingresos="Articulo 22, Fracción  III-B d).- En caso de haber sido solicitados y autorizados el cambio de titular y el cambio de domicilio en el mismo trámite, se pagará el 55% (cincuenta y cinco por ciento) sobre el valor de la expedición de un permiso nuevo del giro solicitado por ambos conceptos.";
$listo_presupuesto='SI';
}

###&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
###&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

if ( $TRAMITE_tramite_SOLICITADO=='Cambio de Nombre Comercial' && $DESCUENTO_tramite_SOLICITADO=='SI' ) {
$MONTO_UMAS_tramite_SOLICITADO_calculo= ((100 - $MONTO_UMAS_tramite_SOLICITADO ) / 100) * $MONTO_UMAS_giro;
$MONTO_UMAS_tramite_SOLICITADO=$MONTO_UMAS_tramite_SOLICITADO_calculo;

$ley_ingresos="Articulo 22, Fracción  III-B e).- Por el cambio de nombre comercial se pagará 1% (uno por ciento), sobre el valor de la expedición del permiso nuevo.";
$listo_presupuesto='SI';
}

###&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
###&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

if ( $TRAMITE_tramite_SOLICITADO=='Cambio Titular por Herencia' && $DESCUENTO_tramite_SOLICITADO=='SI' ) {
$MONTO_UMAS_tramite_SOLICITADO_calculo= ((100 - $MONTO_UMAS_tramite_SOLICITADO ) / 100) * $MONTO_UMAS_giro;
$MONTO_UMAS_tramite_SOLICITADO=$MONTO_UMAS_tramite_SOLICITADO_calculo;

$ley_ingresos="Articulo 22, Fracción  III-B c).- Habiendo sido autorizado el cambio de titular, cuando el nuevo titular adquiera los derechos por adjudicación hereditaria se pagará el 10% (diez por ciento), sobre el valor de la expedición de un permiso nuevo del giro solicitado.";
$listo_presupuesto='SI';
}


#################################
############################

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
?>

    <div class="mt-4">
        <!-- Encabezado del programa -->
        <div class="encabezado-programa">
            <h6 class="mb-0"><b>Moduló de Cambios - Aprobación del Trámite</b></h6>
        </div>

        <!-- Sección de datos del establecimiento -->
        <div class="seccion-datos">
                <div class="row fila-datos">
                    <div class="col-10">
                        <div class="etiqueta">Tramite</div>
			<div class="valor valor-destacado">

<?php
echo '<font color="black">'.$TRAMITE_tramite_SOLICITADO.' &nbsp;&nbsp;</font>';


if ( $listo_presupuesto=='SI' ) {

echo '<font color="red">'.number_format($MONTO_UMAS_tramite_SOLICITADO,2).'  umas </font>';

if ( $TRAMITE_tramite_SOLICITADO=='Cambio de Giro' && $CAMBIO_DE_GIRO=="SI" ) {
echo '<font color="black"> &nbsp;-  Giro Solicitado:'.$GIRO_solicitado.' &nbsp; ('.number_format($MONTO_UMAS_giro_solicitado,2).' umas )</font>';
}

} else {
echo '<font color="blue">Presupuesto No Disponible </font>';
}
?>


		     </div>

                    </div>


                    <div class="col-md-2 col-4">
                        <div class="etiqueta">Folio</div>
                        <div class="valor"><?php echo $folio; ?></div>
                    </div>
                </div>


                <div class="row fila-datos">
                    <div class="col-12">
			<div class="valor">
<?php
echo '<span class="msg" ><small><i>'.$ley_ingresos.'</i></small></span>';
?>

			</div>
                    </div>
                </div>




            <div class="encabezado">
                <h4>Datos del Establecimiento y Solicitante</h4>
            </div>
	    <div class="contenido">

                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">Nombre Comercial</div>
                        <div class="valor valor-destacado"><?php echo $nombre_comercial_establecimiento; ?></div>
                    </div>
                </div>


                <div class="row fila-datos">
                    <div class="col-4">
                        <div class="etiqueta">Giro</div>
			<div class="valor"><?php echo $GIRO; ?>  (<font color="blue"><?php echo number_format($MONTO_UMAS_giro,2); ?> umas</font>)</div>
                    </div>
                    <div class="col-8">
                        <div class="etiqueta">Servicios Adicionales</div>
			<div class="valor valor-destacado"><?php echo $servicios_adicionales; ?> * [<?php echo $numero_servicios_adicionales; ?>]</div>
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
                    <div class="col-md-6 col-12">
                        <div class="etiqueta">Persona Física/Moral</div>
                        <div class="valor"><?php echo $nombre_persona_fisicamoral_solicitante; ?></div>
                    </div>
                    <div class="col-md-6 col-12 mt-md-0 mt-3">
                        <div class="etiqueta">Representante Legal</div>
                        <div class="valor"><?php echo $nombre_representante_legal_solicitante; ?></div>
                    </div>
		</div>



            </div>
        </div>
        
<!-- Botones de acción -->
<!-- <div class="area-botones"> --!>
<center><div>

<?php
echo '<a href="principal.php?page='.$page.'" class="btn btn-info bs-sm" style="background-color:#FFFFFF;"> <i class="bi bi-arrow-left"></i><font color="black" size="1"> Regresar </font></a>&nbsp;';

#######################
#### Seleccionar Giro
if ( $CAMBIO_DE_GIRO=="SI" ) {
echo '<a href="#elegirGiro" data-bs-toggle="modal" data-bs-target="#elegirGiro" data-idprincipal="'.$IDPRINCIPAL.'" data-folio="'.$folio.'" data-pagina="'.$page.'" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-id_tramite_solicitado="'.$ID_TRAMITE_SOLICITADO.'" data-descripcion_giro="'.$GIRO.'"  class="btn btn-success" title="Elegir Giro"><i class="bi bi-cup-straw"></i><font size="1">Selecciona Giro</font></a>&nbsp;';
}

//chang
if ( $listo_presupuesto=='SI') {
//echo ' data-id_tramite_solicitado="'.$ID_TRAMITE_SOLICITADO.'" 
// data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'"
// data-descripcion_giro="'.$GIRO.'" 
// data-tramite_solicitado="'.$TRAMITE_tramite_SOLICITADO.'" 
// data-descripcion_tramite_solicitado="'.$TRAMITE_tramite_SOLICITADO.'"  
// data-cambio_giro_solicitado="'.$GIRO_solicitado.'" 
//data-cambio_id_giro_solicitado="'.$GIRO_SOLICITADO.'" 
// data-cambio_de_giro="'.$CAMBIO_DE_GIRO.'"  
// data-monto_umas_tramite_solicitado="'.$MONTO_UMAS_tramite_SOLICITADO.'"';

echo '<a href="#aprobrarTramite" data-bs-toggle="modal" data-bs-target="#aprobrarTramite" data-idprincipal="'.$IDPRINCIPAL.'" data-folio="'.$folio.'" data-pagina="'.$page.'" 
data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" 
 data-id_tramite_solicitado="'.$ID_TRAMITE_SOLICITADO.'" 
 data-descripcion_giro="'.$GIRO.'" 
 data-tramite_solicitado="'.$TRAMITE_tramite_SOLICITADO.'" 
 data-descripcion_tramite_solicitado="'.$TRAMITE_tramite_SOLICITADO.'"  
 data-cambio_giro_solicitado="'.$GIRO_solicitado.'" 
 data-cambio_id_giro_solicitado="'.$GIRO_SOLICITADO.'" 
 data-cambio_de_giro="'.$CAMBIO_DE_GIRO.'"  
 data-monto_umas_tramite_solicitado="'.number_format($MONTO_UMAS_tramite_SOLICITADO,2).'"  
 class="btn btn-dark" title="Aprobrar Tramite - '.$TRAMITE_tramite_SOLICITADO.' - '.number_format($MONTO_UMAS_tramite_SOLICITADO,2).' umas"><i class="bi bi-list-check"></i><font size="1">Aprobar Tramite</font></a>&nbsp;';
}

##echo '<a href="principalPDFs.php?id='.$IDPRINCIPAL.'&page='.$page.'"  class="btn btn-danger bs-sm" title="Registrar RAD"> <i class="bi bi-clipboard-check"></i><font size="1"> Cambio de Domicilio y Titular </font></a>&nbsp;';



?>



    </div>
</div>

<!-- Espacio adicional antes del footer -->
<div style="margin-bottom: 30px;"></div>

<hr>
<?php include("footer.php"); ?>

<script>


$( "#aprobrarTramitePost" ).submit(function( event ) {
  $('#Button_aprobrarTramite').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/aprobrarTramite.php",
                        data: parametros,
                         beforeSend: function(objeto){
                           $("#resultados_ajaxaprobrarTramite").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxaprobrarTramite").html(datos);
                        $('#Button_aprobrarTramite').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
                                location.replace('principal.php');
                        }, 3000);

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
				location.replace('principal.php');
			}, 3000);

		  }
	});
  event.preventDefault();
});


$( "#registro_guardar_pago_presupuesto" ).submit(function( event ) {
  $('#Button_registro_guardar_pago_presupuesto').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/registro_guardar_pago_presupuesto.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxPagoPresupuesto").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxPagoPresupuesto").html(datos);
                        $('#Button_registro_guardar_pago_presupuesto').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
                                location.replace('principal.php');
                        }, 3000);

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
			}, 3000);

		  }
	});
  event.preventDefault();
});






// Inicializar eventos para los botones de modal
$(document).ready(function() {
    $('[data-bs-toggle="modal"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
        
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
	// --
	var id_giro = $(this).data('id_giro');
	var descripcion_giro = $(this).data('descripcion_giro');
	var modalidad_graduacion_alcoholica = $(this).data('modalidad_graduacion_alcoholica');
	var servicios_adicionales = $(this).data('servicios_adicionales');

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

	var tramite_solicitado = $(this).data('tramite_solicitado');
	var descripcion_tramite_solicitado = $(this).data('descripcion_tramite_solicitado');
	var cambio_giro_solicitado = $(this).data('cambio_giro_solicitado');
	var cambio_id_giro_solicitado = $(this).data('cambio_id_giro_solicitado');
	var cambio_de_giro = $(this).data('cambio_de_giro');
	var monto_umas_tramite_solicitado = $(this).data('monto_umas_tramite_solicitado');

	var id_tramite = $(this).data('id_tramite');

        
        // Abrir el modal utilizando Bootstrap 5
        var myModal = new bootstrap.Modal(document.querySelector(target));
        
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

	$(target + ' #mod_tramite_solicitado').val(tramite_solicitado);
	$(target + ' #mod_descripcion_tramite_solicitado').val(descripcion_tramite_solicitado);
	$(target + ' #mod_cambio_giro_solicitado').val(cambio_giro_solicitado);
	$(target + ' #mod_cambio_id_giro_solicitado').val(cambio_id_giro_solicitado);
	$(target + ' #mod_cambio_de_giro').val(cambio_de_giro);
	$(target + ' #mod_monto_umas_tramite_solicitado').val(monto_umas_tramite_solicitado);


	$(target + ' #mod_id_tramite').val(id_tramite);

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



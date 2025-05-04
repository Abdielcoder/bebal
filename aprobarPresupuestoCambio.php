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

include("modal/elegirGiro.php");
include("modal/aprobrarTramite.php");


        $active_usuarios="";
        $active_colonias="";
        $active_delegaciones="";
        $active_giro="";
        $active_tramite="";
        $active_modalidad="";
        $active_serviciosAdicionales="";
        $active_reportes="";
        $active_principal="active";


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
##echo $sql_tramite10;
$result_tramite10 = mysqli_query($con,$sql_tramite10);
$row_tramite10 = mysqli_fetch_assoc($result_tramite10);
$TRAMITE_tramite_SOLICITADO=$row_tramite10['descripcion_tramite'];
$MONTO_UMAS_tramite_SOLICITADO=$row_tramite10['monto_umas'];
$CUENTA_tramite_SOLICITADO=$row_tramite10['cuenta'];
$INSPECCION_tramite_SOLICITADO=$row_tramite10['inspeccion'];
$RAD_tramite_SOLICITADO=$row_tramite10['revision_analisis_docs'];
$DESCUENTO_tramite_SOLICITADO=$row_tramite10['descuento'];
$OPERACION_tramite_SOLICITADO=$row_tramite10['operacion'];

##echo "TRAMITE_tramite_SOLICITADO=".$TRAMITE_tramite_SOLICITADO;
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
$ID_SERVICIOS_ADICIONALES_PERMISIONARIO=$row['id_servicios_adicionales_permisionario'];
#################################
$sqlSAP="SELECT * FROM servicios_adicionales_permisionario WHERE id=".$ID_SERVICIOS_ADICIONALES_PERMISIONARIO." AND id_principal=".$IDPRINCIPAL;
##echo $sqlSAP;
$rowSAP = mysqli_fetch_array(mysqli_query($con,$sqlSAP));

$numero_mesas_de_billarACTUAL=$rowSAP['mesas_de_billar'];
$pista_de_baileACTUAL=$rowSAP['pista_de_baile'];
$musica_grabada_y_aparatosACTUAL=$rowSAP['musica_grabada_y_aparatos'];
$conjunto_musicalesACTUAL=$rowSAP['conjunto_musicales'];
$espectaculos_artisticosACTUAL=$rowSAP['espectaculos_artisticos'];

##echo " numero_mesas_de_billar ( $numero_mesas_de_billarACTUAL ), pista_de_baile ( $pista_de_baileACTUAL ), musica_grabada_y_aparatos ( $musica_grabada_y_aparatosACTUAL ), $conjunto_musicales ( $conjunto_musicalesACTUAL ) espectaculos_artisticos ( $espectaculos_artisticosACTUAL )";

#################################
if (isset($_POST['elegir_ServiciosAdicionales'])) {

$listo_presupuesto='SI';
###########################
$SERVICIOS_ADICIONALES_LISTA='';
$SERVICIOS_ADICIONALES_SOLICITADO=1;
$SERVICIOS_LISTA='';
$SERVICIOS_LISTA_RAW='';
$cuentaSA=0;
$cuentaSA_presupuesto=0;
$monto_umas_total_servicios_adicionales=0;
#
###############
$numero_mesas_de_billar=$_POST['numero_mesas_de_billar_presupuesto'];
$pista_de_baile=$_POST['pista_de_baile_presupuesto'];
##echo 'pista de baile='.$pista_de_baile.'<br>';
$musica_grabada_y_aparatos=$_POST['musica_grabada_y_aparatos_presupuesto'];
$conjunto_musicales=$_POST['conjunto_musicales_presupuesto'];
$espectaculos_artisticos=$_POST['espectaculos_artisticos_presupuesto'];

###############
if ( $numero_mesas_de_billar=='Zero' && $pista_de_baile=='Zero' && $musica_grabada_y_aparatos=='Zero' && $conjunto_musicales=='Zero' && $espectaculos_artisticos=='Zero' ) {
$SERVICIOS_LISTA='0';
$SERVICIOS_LISTA_RAW='0';
$SERVICIOS_ADICIONALES_LISTA='No Servicios Adicionales';
$cuentaSA=0;
$cuentaSA_presupuesto=0;
$monto_umas_total_servicios_adicionales=0;
$total_presupuesto=0;
} else {
	##
	$COBRAR_mesas_de_billar_adcionales=0;
	if ( $numero_mesas_de_billar!='Zero' ) {
	if ( $numero_mesas_de_billar > $numero_mesas_de_billarACTUAL ) {
	$mesas_de_billar_adcionales=$numero_mesas_de_billar-$numero_mesas_de_billarACTUAL;
	$COBRAR_mesas_de_billar_adcionales=$mesas_de_billar_adcionales;
	$SERVICIOS_ADICIONALES_LISTA.= " Mesas de Billar Adicionales (".$mesas_de_billar_adcionales.")";
        $SERVICIOS_LISTA_RAW.='**'.$numero_mesas_de_billar.'--MesasdeBillar**';
	$cuentaSA_presupuesto++;
	}
        $SERVICIOS_LISTA.=' ( '.$numero_mesas_de_billar.' Mesa(s) de Billar ) ';
        $cuentaSA++;
	} else {
	$numero_mesas_de_billar=0;
	$SERVICIOS_ADICIONALES_LISTA.= ' -- Mesa(s) de Billar Eliminada(s)';
        $SERVICIOS_LISTA_RAW.='**0--MesasdeBillar**';
	$COBRAR_mesas_de_billar_adcionales=0;
	}
	#
	$COBRO_pista_de_baile=0;
        if ( $pista_de_baile==1 ) {
        $SERVICIOS_LISTA.=' ( Pista de Baile ) ';
	$cuentaSA++;
	$SERVICIOS_LISTA_RAW.='**1--PistadeBaile**';
	if ( $pista_de_baileACTUAL==0 ) { $SERVICIOS_ADICIONALES_LISTA.= ' -- Pista de Baile Adicionales'; $COBRO_pista_de_baile=1; $cuentaSA_presupuesto++; }
	} else {
	$pista_de_baile=0;
	if ( $pista_de_baileACTUAL==1 ) { $SERVICIOS_ADICIONALES_LISTA.= ' -- Pista de Baile Eliminada'; $COBRO_pista_de_baile=0; }
       	$SERVICIOS_LISTA_RAW.='**0--PistadeBaile**';
	}
	#
	$COBRO_musica_grabada_y_aparatos=0;
        if ( $musica_grabada_y_aparatos==1 ) {
        $SERVICIOS_LISTA.=' ( Musica Grabada y Aparatos Musicales ) ';
	$cuentaSA++;
	$SERVICIOS_LISTA_RAW.='**1--MusicaGrabadayAparatosMusicales**';
	if ( $musica_grabada_y_aparatosACTUAL==0 ) { $SERVICIOS_ADICIONALES_LISTA.= ' -- Musica Grabada y Aparatos Adicionales'; $COBRO_musica_grabada_y_aparatos=1; $cuentaSA_presupuesto++;  }
	} else {
	$musica_grabada_y_aparatos=0;
	if ( $musica_grabada_y_aparatosACTUAL==1 ) { $SERVICIOS_ADICIONALES_LISTA.= ' -- Musica Grabada y Aparatos Eliminada'; $COBRO_musica_grabada_y_aparatos=0; }
       	$SERVICIOS_LISTA_RAW.='**0--MusicaGrabadayAparatosMusicales**';
	}
	#
	$COBRO_conjunto_musicales=0;
        if ( $conjunto_musicales==1 ) {
        $SERVICIOS_LISTA.=' ( Conjunto Musicales ) ';
	$cuentaSA++;
	$SERVICIOS_LISTA_RAW.='**1--ConjuntoMusicales**';
	if ( $conjunto_musicalesACTUAL==0 ) { $SERVICIOS_ADICIONALES_LISTA.= ' -- Conjunto Musicales Adicional'; $COBRO_conjunto_musicales=1; $cuentaSA_presupuesto++; }
	} else {
	$conjunto_musicales=0;
	if ( $conjunto_musicalesACTUAL==1 ) { $SERVICIOS_ADICIONALES_LISTA.= ' -- Conjunto Musicales Eliminada'; $COBRO_conjunto_musicales=0; }
       	$SERVICIOS_LISTA_RAW.='**0--ConjuntoMusicales**';
	}
	#
	$COBRO_espectaculos_artisticos=0;
        if ( $espectaculos_artisticos==1 ) {
        $SERVICIOS_LISTA.=' ( Espectaculos Artisticos ) ';
	$cuentaSA++;
	$SERVICIOS_LISTA_RAW.='**1--EspectaculosArtisticos**';
	if ( $espectaculos_artisticosACTUAL==0 ) { $SERVICIOS_ADICIONALES_LISTA.= ' -- Espectaculos Artisticos Adicional'; $COBRO_espectaculos_artisticos=1; $cuentaSA_presupuesto++; }
	} else {
	$espectaculos_artisticos=0;
	if ( $espectaculos_artisticosACTUAL==1 ) { $SERVICIOS_ADICIONALES_LISTA.= ' -- Espectaculos Artisticos Eliminada'; $COBRO_espectaculos_artisticos=0; }
       	$SERVICIOS_LISTA_RAW.='**0--EspectaculosArtisticos**';
	}
#
$arregloSA_musica_grabada_y_aparatos=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Musica Grabada y Aparatos Musicales'"));
$umas_musica_grabada_y_aparatos=$arregloSA_musica_grabada_y_aparatos[0];
$monto_musica_grabada_y_aparatos=$umas_musica_grabada_y_aparatos*$musica_grabada_y_aparatos;
$COBROsubtotal_musica_grabada_y_aparatos=$COBRO_musica_grabada_y_aparatos*$umas_musica_grabada_y_aparatos;
#
$arregloSA_numero_mesas_de_billar=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Mesas de Billar, por cada Mesa'"));
$umas_numero_mesas_de_billar=$arregloSA_numero_mesas_de_billar[0];
$monto_numero_mesas_de_billar=$umas_numero_mesas_de_billar*$numero_mesas_de_billar;
$COBROsubtotal_mesas_de_billar_adicionales=$COBRAR_mesas_de_billar_adcionales*$umas_numero_mesas_de_billar;
#
$arregloSA_pista_de_baile=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Pista de Baile'"));
$umas_pista_de_baile=$arregloSA_pista_de_baile[0];
$monto_pista_de_baile=$umas_pista_de_baile*$pista_de_baile;
$COBROsubtotal_pista_de_baile=$COBRO_pista_de_baile*$umas_pista_de_baile;
#
$arregloSA_conjunto_musicales=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Conjunto Musicales'"));
$umas_conjunto_musicales=$arregloSA_conjunto_musicales[0];
$monto_conjunto_musicales=$umas_conjunto_musicales*$conjunto_musicales;
$COBROsubtotal_conjunto_musicales=$COBRO_conjunto_musicales*$umas_conjunto_musicales;
#
$arregloSA_espectaculos_artisticos=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Espectaculos Artisticos'"));
$umas_espectaculos_artisticos=$arregloSA_espectaculos_artisticos[0];
$monto_espectaculos_artisticos=$umas_espectaculos_artisticos*$espectaculos_artisticos;
$COBROsubtotal_espectaculos_artisticos=$COBRO_espectaculos_artisticos*$umas_espectaculos_artisticos;
##
$monto_umas_total_servicios_adicionales=$monto_musica_grabada_y_aparatos+$monto_numero_mesas_de_billar+$monto_pista_de_baile+$monto_conjunto_musicales+$monto_espectaculos_artisticos;

$total_presupuesto=$COBROsubtotal_espectaculos_artisticos+$COBROsubtotal_conjunto_musicales+$COBROsubtotal_pista_de_baile+$COBROsubtotal_musica_grabada_y_aparatos+$COBROsubtotal_mesas_de_billar_adicionales;

}
$MONTO_UMAS_tramite_SOLICITADO=$total_presupuesto;
#
###########################

##echo 'Servicios Adicionales [[ '.$SERVICIOS_LISTA.'  ]]  '.$cuentaSA.' Item(s) Total UMAS '.$monto_umas_total_servicios_adicionales.' <br>';

##$MONTO_UMAS_tramite_SOLICITADO=$monto_umas_total_servicios_adicionales;
} else {
$SERVICIOS_ADICIONALES_SOLICITADO=0;
}
##echo 'total_presupuesto='.$total_presupuesto;
#################################
#################################
#################################
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

$servicios_adicionalesDB=$row['servicios_adicionales'];
$servicios_adicionales_rawDB=$row['servicios_adicionales_raw'];
$numero_servicios_adicionalesDB=$row['numero_servicios_adicionales'];
$monto_umas_total_servicios_adicionalesDB=$row['monto_umas_total_servicios_adicionales'];

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
#################################
#################################
#################################

####################
#####################
include("modal/actualizar_serviciosAdicionales.php");
####################
#####################
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
$MONTO_UMAS_REVALIDACION_ANUAL=$row_giro['monto_umas_revalidacion_anual'];

$COBRO_UMAS_giro=$MONTO_UMAS_giro;      //##  Permiso Nuevo


##################################################
#####  TRAMITE :
####	Cambio de Giro
###################################################
if ( $TRAMITE_tramite_SOLICITADO=='Cambio de Giro' ) {
$CAMBIO_DE_GIRO="SI";
$ley_ingresos="Articulo 22, Fracción III-B a).- En los permisos que se solicite el cambio de giro, se cobrará la diferencia del valor del costo del permiso, y en los casos de disminución de la actividad, se cobrará 6.50 veces la Unidad de Medida y Actualización (UMA) vigente.";
} else {
$CAMBIO_DE_GIRO="NO";
}
##################################################
#####  TRAMITE :
####	Mantenimiento Servicios Adicionales
###################################################
if ( $TRAMITE_tramite_SOLICITADO=='Mantenimiento Servicios Adicionales' ) {
$SERVICIOS_ADICIONALES="SI";
$ley_ingresos="Articulo 22, Fracción IV.-Para efectos de los servicios adicionales, se otorgarán sólo en aquellos giros a que refiere la ley de la materia y su reglamento, pagando por la autorización los siguientes derechos";
} else {
$SERVICIOS_ADICIONALES="NO";
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
##################################################
#####  TRAMITE :
####    Cierre Temporal
###################################################

if ( $TRAMITE_tramite_SOLICITADO=='Cierre Temporal' && $DESCUENTO_tramite_SOLICITADO=='NO' ) {
$MONTO_UMAS_tramite_SOLICITADO=$MONTO_UMAS_tramite_SOLICITADO;

$ley_ingresos="Articulo 22, Fracción  V.-Autorización respecto de cierre temporal y aviso de no inconveniente de intención de ceder derechos del permiso, de acuerdo a lo siguiente:  A).- Autorización respecto a cierre temporal.";
$listo_presupuesto='SI';
}
##################################################
#####  TRAMITE :
####    Ceder Permiso
###################################################
if ( $TRAMITE_tramite_SOLICITADO=='Ceder Permiso' && $DESCUENTO_tramite_SOLICITADO=='NO' ) {
$MONTO_UMAS_tramite_SOLICITADO=$MONTO_UMAS_tramite_SOLICITADO;

$ley_ingresos="Articulo 22, Fracción  V.-Autorización respecto de cierre temporal y aviso de no inconveniente de intención de ceder derechos del permiso, de acuerdo a lo siguiente:  B).- Autorización respecto a aviso de no inconveniente de intención de ceder los derechos de permiso.";
$listo_presupuesto='SI';
}
##################################################
#####  TRAMITE :
####    Impresión de Permiso
###################################################
if ( $TRAMITE_tramite_SOLICITADO=='Impresión de Permiso' && $DESCUENTO_tramite_SOLICITADO=='NO' ) {
$MONTO_UMAS_tramite_SOLICITADO=$MONTO_UMAS_tramite_SOLICITADO;
$ley_ingresos="Articulo 22, Fracción  VI-.-Expedición de nueva impresión de permisos otorgados.";
$listo_presupuesto='SI';
}
##################################################
#####  TRAMITE :
####   Anuencia o Revalidacion
###################################################
if ( $TRAMITE_tramite_SOLICITADO=='Anuencia o Revalidacion' && $DESCUENTO_tramite_SOLICITADO=='NO' ) {
$MONTO_UMAS_tramite_SOLICITADO=$MONTO_UMAS_REVALIDACION_ANUAL;
$ley_ingresos="Articulo 22, Fracción  VII.-Derechos por revalidación anual de permisos.";
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

###&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
###&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

if ( $TRAMITE_tramite_SOLICITADO=='Cambio de Titular' && $DESCUENTO_tramite_SOLICITADO=='SI' ) {
$MONTO_UMAS_tramite_SOLICITADO_calculo= ((100 - $MONTO_UMAS_tramite_SOLICITADO ) / 100) * $MONTO_UMAS_giro;
$MONTO_UMAS_tramite_SOLICITADO=$MONTO_UMAS_tramite_SOLICITADO_calculo;

$ley_ingresos="Articulo 22, Fracción  III-B b).- Habiendo sido autorizado el cambio de titular o el cambio de domicilio, se pagará el 50% (cincuenta por ciento) y el 15% (quince por ciento) respectivamente, sobre el valor de la expedición de un permiso nuevo del giro solicitado..";
$listo_presupuesto='SI';
}

###&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
###&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

if ( $TRAMITE_tramite_SOLICITADO=='Cambio de Domicilio' && $DESCUENTO_tramite_SOLICITADO=='SI' ) {
$MONTO_UMAS_tramite_SOLICITADO_calculo= ((100 - $MONTO_UMAS_tramite_SOLICITADO ) / 100) * $MONTO_UMAS_giro;
$MONTO_UMAS_tramite_SOLICITADO=$MONTO_UMAS_tramite_SOLICITADO_calculo;

$ley_ingresos="Articulo 22, Fracción  III-B b).- Habiendo sido autorizado el cambio de titular o el cambio de domicilio, se pagará el 50% (cincuenta por ciento) y el 15% (quince por ciento) respectivamente, sobre el valor de la expedición de un permiso nuevo del giro solicitado..";
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
<?php

switch ($OPERACION_tramite_SOLICITADO) {
  case "Cambio":
echo '<h6 class="mb-0"><b>Moduló de Cambios - Aprobación del Trámite</b></h6>';
    break;
  case "Revalidacion":
 echo '<h6 class="mb-0"><b>Revalidación de Permiso</b></h6>';
    break;
  case "Imprimir":
echo '<h6 class="mb-0"><b>Imprimir Permiso</b></h6>';
    break;
  default:
echo '<h6 class="mb-0"><b>Moduló de Cambios - Aprobación del Trámite</b></h6>';
}

?>
        </div>

        <!-- Sección de datos del establecimiento -->

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

#####
if ( $TRAMITE_tramite_SOLICITADO=='Cambio de Giro' && $CAMBIO_DE_GIRO=="SI" ) {
echo '<font color="black"> &nbsp;-  Giro Solicitado:'.$GIRO_solicitado.' &nbsp; ('.number_format($MONTO_UMAS_giro_solicitado,2).' umas )</font>';
}
#####
#$SERVICIOS_ADICIONALES_LISTA
if ( $SERVICIOS_ADICIONALES_SOLICITADO==1 && isset($_POST['elegir_ServiciosAdicionales']) ) {
echo '<font size="1" color="blue"> de ['.$cuentaSA_presupuesto.'] Servicios Adicionales Solicitado(s) [[ '.$SERVICIOS_ADICIONALES_LISTA.'  ]]  </font>';
echo '<font size="1" color="black">, Quedando un total de '.$cuentaSA.' Item(s) [['.$SERVICIOS_LISTA.']]  con un Monto '.$monto_umas_total_servicios_adicionales.'</font>';
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
                    <div class="col-10">
                        <div class="etiqueta">Nombre Comercial</div>
                        <div class="valor valor-destacado"><?php echo $nombre_comercial_establecimiento; ?></div>
                    </div>
                    <div class="col-md-2 col-4">
                        <div class="etiqueta">Número Permiso</div>
			<div class="valor"><?php echo $numero_permiso; ?></div>

                    </div>
                </div>


                <div class="row fila-datos">
                    <div class="col-4">
                        <div class="etiqueta">Giro</div>
			<div class="valor"><?php echo $GIRO; ?>  (<font color="blue"><?php echo number_format($MONTO_UMAS_giro,2); ?> umas</font>)</div>
                    </div>
                    <div class="col-8">
			<div class="etiqueta">Servicios Adicionales</div>
<?php
echo '<div class="valor valor-destacado">'.$servicios_adicionalesDB.' * ['.$numero_servicios_adicionalesDB.' Items ] ( '.$monto_umas_total_servicios_adicionalesDB.' umas )</div>';
?>
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


###################################
#### Seleccionar Servicio Adicional
if ( $SERVICIOS_ADICIONALES=="SI" ) {
echo '<a href="#elegirServicioAdicional" data-bs-toggle="modal" data-bs-target="#elegirServicioAdicional" data-idprincipal="'.$IDPRINCIPAL.'" data-folio="'.$folio.'" data-pagina="'.$page.'" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-id_tramite_solicitado="'.$ID_TRAMITE_SOLICITADO.'" data-descripcion_giro="'.$GIRO.'"  class="btn btn-success" title="Elegir Giro"><i class="bi bi-cup-straw"></i><font size="1">Selecciona Servicio Adicional</font></a>&nbsp;';
}




//chang
if ( $listo_presupuesto=='SI') {

if ( $SERVICIOS_ADICIONALES_SOLICITADO==1 && isset($_POST['elegir_ServiciosAdicionales']) ) {
echo '<a href="#aprobrarTramite" data-bs-toggle="modal" data-bs-target="#aprobrarTramite" data-idprincipal="'.$IDPRINCIPAL.'" data-folio="'.$folio.'" data-pagina="'.$page.'"
data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'"
 data-id_tramite_solicitado="'.$ID_TRAMITE_SOLICITADO.'"
 data-descripcion_giro="'.$GIRO.'" 

 data-tramite_solicitado="'.$TRAMITE_tramite_SOLICITADO.'"
 data-descripcion_tramite_solicitado="'.$TRAMITE_tramite_SOLICITADO.'"

 data-cambio_giro_solicitado="ND" 
 data-cambio_id_giro_solicitado="ND'.$GIRO_SOLICITADO.'" 
 data-cambio_de_giro="'.$CAMBIO_DE_GIRO.'"  

 data-cambio_de_sa="'.$SERVICIOS_ADICIONALES_SOLICITADO.'"  
 data-servicios_adicionales_agregados="'.$SERVICIOS_ADICIONALES_LISTA.'"  
 data-servicios_adicionales_agregados_raw="'.$SERVICIOS_LISTA_RAW.'"  
 data-servicios_adicionales_total="'.$cuentaSA_presupuesto.'"  
 data-servicios_adicionales_total_raw="'.$cuentaSA.'"  

 data-monto_umas_tramite_solicitado="'.number_format($MONTO_UMAS_tramite_SOLICITADO,2).'"
 class="btn btn-dark" title="Aprobrar Tramite - '.$TRAMITE_tramite_SOLICITADO.' - '.number_format($MONTO_UMAS_tramite_SOLICITADO,2).' umas" ><i class="bi bi-list-check"></i><font size="1">Aprobar Tramite</font></a>&nbsp;';

} else {
echo '<a href="#aprobrarTramite" data-bs-toggle="modal" data-bs-target="#aprobrarTramite" data-idprincipal="'.$IDPRINCIPAL.'" data-folio="'.$folio.'" data-pagina="'.$page.'" 
data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" 
 data-id_tramite_solicitado="'.$ID_TRAMITE_SOLICITADO.'" 
 data-descripcion_giro="'.$GIRO.'" 

 data-tramite_solicitado="'.$TRAMITE_tramite_SOLICITADO.'" 
 data-descripcion_tramite_solicitado="'.$TRAMITE_tramite_SOLICITADO.'"  
 data-cambio_giro_solicitado="'.$GIRO_solicitado.'" 
 data-cambio_id_giro_solicitado="'.$GIRO_SOLICITADO.'" 
 data-cambio_de_giro="'.$CAMBIO_DE_GIRO.'"  

 data-cambio_de_sa="'.$SERVICIOS_ADICIONALES_SOLICITADO.'"  
 data-servicios_adicionales_agregados="ND"  
 data-servicios_adicionales_agregados_raw="ND"  
 data-servicios_adicionales_total="ND"  
 data-servicios_adicionales_total_raw="ND"  

 data-monto_umas_tramite_solicitado="'.number_format($MONTO_UMAS_tramite_SOLICITADO,2).'"  
 class="btn btn-dark" title="Aprobrar Tramite - '.$TRAMITE_tramite_SOLICITADO.' - '.number_format($MONTO_UMAS_tramite_SOLICITADO,2).' umas"><i class="bi bi-list-check"></i><font size="1">Aprobar Tramite</font></a>&nbsp;';
}
}

##echo '<a href="principalPDFs.php?id='.$IDPRINCIPAL.'&page='.$page.'"  class="btn btn-danger bs-sm" title="Registrar RAD"> <i class="bi bi-clipboard-check"></i><font size="1"> Cambio de Domicilio y Titular </font></a>&nbsp;';



?>



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
				location.replace('principal.php');
			}, 2000);

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

var cambio_de_sa= $(this).data('cambio_de_sa');
var servicios_adicionales_agregados= $(this).data('servicios_adicionales_agregados');
var servicios_adicionales_agregados_raw= $(this).data('servicios_adicionales_agregados_raw');
var servicios_adicionales_total= $(this).data('servicios_adicionales_total');
var servicios_adicionales_total_raw= $(this).data('servicios_adicionales_total_raw');

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

$(target + ' #mod_cambio_de_sa').val(cambio_de_sa);
$(target + ' #mod_servicios_adicionales_agregados').val(servicios_adicionales_agregados);
$(target + ' #mod_servicios_adicionales_agregados_raw').val(servicios_adicionales_agregados_raw);
$(target + ' #mod_servicios_adicionales_total').val(servicios_adicionales_total);
$(target + ' #mod_servicios_adicionales_total_raw').val(servicios_adicionales_total_raw);

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



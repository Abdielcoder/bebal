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
    
$ID = $_GET['id'];
$IDPRINCIPAL = $_GET['id'];
$page = $_GET['page'];

###################################
include("modal/eliminar_registroDatosConstancia.php");
###################################




$arregloCuentaPresupuesto=mysqli_fetch_array(mysqli_query($con,"SELECT  COUNT(*)  FROM `presupuesto` WHERE id_principal=$ID AND estatus='Inicio'"));
$CUENTA_presupuesto=$arregloCuentaPresupuesto[0];

if ( $CUENTA_presupuesto>0 ) {
$arregloPresupuesto=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `presupuesto` WHERE id_principal=$ID AND estatus='Inicio'"));
$TRAMITES_PRESUPUESTO=$arregloPresupuesto['tramites'];
$TRAMITES_RAW_PRESUPUESTO=$arregloPresupuesto['tramites_raw'];

$TRAMITES_PRESUPUESTO=$arregloPresupuesto['tramites'];
$RFC=$arregloPresupuesto['rfc'];
$FISICA_O_MORAL=$arregloPresupuesto['fisica_o_moral'];
$NOMBRE_PERSONA_FISICAMORAL_SOLICITANTE=$arregloPresupuesto['nombre_persona_fisicamoral_solicitante'];
$NOMBRE_REPRESENTANTE_SOLICITANTE=$arregloPresupuesto['nombre_representante_legal_solicitante'];
$DOMICILIO_SOLICITANTE=$arregloPresupuesto['domicilio_solicitante'];
$EMAIL_SOLICITANTE=$arregloPresupuesto['email_solicitante'];
$TELEFONO_SOLICITANTE=$arregloPresupuesto['telefono_solicitante'];
} else {
$TRAMITES_PRESUPUESTO='No Existe Información';
$TRAMITES_RAW_PRESUPUESTO='NA';
$TRAMITES_PRESUPUESTO='<font color="red" size="1">Dato No Disponible</font>';
$RFC='<font color="red" size="1">Dato No Disponible</font>';
$FISICA_O_MORAL='<font color="red" size="1">Dato No Disponible</font>';
$NOMBRE_PERSONA_FISICAMORAL_SOLICITANTE='<font color="red" size="1">Dato No Disponible</font>';
$NOMBRE_REPRESENTANTE_SOLICITANTE='<font color="red" size="1">Dato No Disponible</font>';
$DOMICILIO_SOLICITANTE='<font color="red" size="1">Dato No Disponible</font>';
$EMAIL_SOLICITANTE='<font color="red" size="1">Dato No Disponible</font>';
$TELEFONO_SOLICITANTE='<font color="red" size="1">Dato No Disponible</font>';
}
##echo 'TRAMITES_PRESUPUESTO='.$TRAMITES_PRESUPUESTO.'<br>';
##echo 'TRAMITES_RAW_PRESUPUESTO='.$TRAMITES_RAW_PRESUPUESTO.'<br>';

#################
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
$fecha_autorizacion=$row['fecha_autorizacion'];
$fecha_expiracion=$row['fecha_expiracion'];
$numero_permiso=$row['numero_permiso'];
$id_giro=$row['giro'];
#########################
$modalidad_graduacion_alcoholica=$row['modalidad_graduacion_alcoholica'];
$modalidad_graduacion_alcoholica_raw=$row['modalidad_graduacion_alcoholica_raw'];
$monto_umas_total_modalidad_graduacion_alcoholica=$row['monto_umas_total_modalidad_graduacion_alcoholica'];
$numero_modalidad_graduacion_alcoholica=$row['numero_modalidad_graduacion_alcoholica'];

$servicios_adicionales=$row['servicios_adicionales'];
$servicios_adicionales_raw=$row['servicios_adicionales_raw'];
$numero_servicios_adicionales=$row['numero_servicios_adicionales'];
$monto_umas_total_servicios_adicionales=$row['monto_umas_total_servicios_adicionales'];

################
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
$sql_giro="SELECT * FROM giro WHERE id=".$id_giro;
$result_giro = mysqli_query($con,$sql_giro);
$row_giro = mysqli_fetch_assoc($result_giro);
$GIRO=$row_giro['descripcion_giro'];
$HORARIO_FUNCIONAMIENTO=$row_giro['horario_funcionamiento'];
$MONTO_UMAS_giro=$row_giro['monto_umas'];
$MONTO_UMAS_REV_CAMB_giro=$row_giro['monto_umas_revalidacion_cambios'];
$CUENTA_giro=$row_giro['cuenta'];

##################################################
$sql_municipio="SELECT municipio FROM municipio WHERE id=".$id_municipio;
$result_municipio = mysqli_query($con,$sql_municipio);
$row_municipio = mysqli_fetch_assoc($result_municipio);
$MUNICIPIO=$row_municipio['municipio'];
##
if ( $delegacion_id=='' || empty($delegacion_id) ) {
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
}
##

####################
include("modal/elegirTramitePresupuesto.php");
#####################
?>

    <div class="mt-4">
        <!-- Encabezado del programa -->
	<div class="encabezado-programa">
<?php
echo '<h6 class="mb-0">Tramites Para Elaborar Constancia</h6>';
?>
        </div>

        <div class="seccion-datos">
        <div class="col-12">
		<div class="etiqueta">Tramite(s) - Presupuesto Constancia</div>
<?php
//$porcionesTR = explode("--", $TRAMITES_RAW_PRESUPUESTO);
//$cuantos_porcionesTR=count($porcionesTR);

//for ( $ii=0; $ii<$cuantos_porcionesTR; $ii++ ) {
##echo $porcionesTR[$ii].'<br>'; 
//$porcionesTRCC = explode("**",$porcionesTR[$ii]);
##echo 'Id '.$porcionesTRCC[0].', Descripcion '.$porcionesTRCC[1].'<br>'; 
//echo '<font size="2">'.$porcionesTRCC[1].'</font><br>'; 
//}

echo '<font size="2" color="blue">'.$TRAMITES_PRESUPUESTO.'</font>';

?>

    </div>


        <!-- Sección de datos del solicitante -->
            <div class="encabezado">
                <h4>Datos del Solicitante</h4>
            </div>
	    <div class="contenido">

                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">Persona Física/Moral</div>
                        <div class="valor"><?php echo $NOMBRE_PERSONA_FISICAMORAL_SOLICITANTE; ?></div>
                    </div>
                </div>


                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">Representante Legal</div>
                        <div class="valor"><?php echo $NOMBRE_REPRESENTANTE_SOLICITANTE; ?></div>
                    </div>
                </div>

                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">RFC</div>
                        <div class="valor"><?php echo $RFC; ?> ( <font color="blue">Persona <?php echo $FISICA_O_MORAL; ?> </font> )</div>
                    </div>
                </div>

                <div class="row fila-datos">
                    <div class="col-12">
                        <div class="etiqueta">Domicilio</div>
                        <div class="valor"><?php echo $DOMICILIO_SOLICITANTE; ?></div>
                    </div>
                </div>

                <div class="row fila-datos">
                    <div class="col-md-6 col-12">
                        <div class="etiqueta">Email</div>
                        <div class="valor"><?php echo $EMAIL_SOLICITANTE; ?></div>
                    </div>
                    <div class="col-md-6 col-12 mt-md-0 mt-3">
                        <div class="etiqueta">Teléfono</div>
                        <div class="valor"><?php echo $TELEFONO_SOLICITANTE; ?></div>
                    </div>
                </div>


<br>

<!-- Botones de acción -->
<!-- <div class="area-botones"> --!>
<center><div>

<?php
echo '<button type="button" onclick="window.location.href=\'principal.php?page='.$page.'&action=ajax\'" class="btn btn-info bs-sm" style="background-color:#FFFFFF;"> <i class="bi bi-arrow-left"></i><font size="1" color="black"> Regresar</font></button>&nbsp;';

if ( $CUENTA_presupuesto>0 ) {
echo '<a href="generarPresupuestoTramites_pdf_html.php?id='.$ID.'&page='.$page.'"" class="btn btn-xs btn-action btn-dark" title="Presupuesto '.$folio.', '.$nombre_comercial_establecimiento.'"  target="_blank"><i class="bi bi-calculator"></i><font size="1">Consultar Constancia</font></a>&nbsp;';

echo  '<a href="#EliminarRegistroConstancia" data-bs-toggle="modal" data-bs-target="#EliminarRegistroConstancia"  class="btn btn-dark bs-sm" title="Eliminar Datos Constancia"><font color="red" size="2"><i class="bi bi-trash"></i></font><font color="white" size="1">Eliminar Datos Constancia</font></a>';
} else {


echo '<a href="#elegirTramitePresupuesto" class="btn btn-xs btn-action btn-success" title="Presupuesto '.$folio.', '.$nombre_comercial_establecimiento.'" onclick="obtener_datos('.$id.','.$page.');" data-bs-toggle="modal" data-bs-target="#elegirTramitePresupuesto"><i class="bi bi-calculator"></i><font color="white" size="1"> Agregar Datos Constancia</font></a>&nbsp;';

echo '<a href="#" class="btn btn-xs btn-action btn-dark" title="Presupuesto '.$folio.', '.$nombre_comercial_establecimiento.'"   disabled><i class="bi bi-calculator"></i><font size="1">Consultar Constancia</font></a>&nbsp;';

echo  '<a href="#" data-bs-toggle="modal" class="btn btn-dark bs-sm" title="Eliminar Datos Constancia" disabled><font color="red" size="2"><i class="bi bi-trash"></i></font><font color="white" size="1">Eliminar Datos Constancia</font></a>';
}

?>

</center></div>



<br>





        <!-- Sección de datos del establecimiento -->
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
        


<!-- Espacio adicional antes del footer -->
<div style="margin-bottom: 30px;"></div>

<hr>
<?php 

mysqli_close($con);
include("footer.php"); 

?>

<script>


$( "#elegir_tramitePresupuesto" ).submit(function( event ) {
  $('#Button_elegir_tramitePresupuesto').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/agregar_TramitePresupuestoConstancia.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxElegirTramitePresupuesto").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxElegirTramitePresupuesto").html(datos);
                        $('#Button_elegir_tramitePresupuesto').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});

<?php
//location.replace('principal.php');
echo "location.replace('detalleRegistroPresupuestoTramite.php?id=".$ID."&page=".$page."');";
?>



                        }, 2000);

                  }
        });
  event.preventDefault();
});



$( "#eliminar_registroConstancia" ).submit(function( event ) {
  $('#Button_eliminar_registroConstancia').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/eliminar_datos_constancia.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxeliminar_registroConstancia").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxeliminar_registroConstancia").html(datos);
                        $('#Button_eliminar_registroConstancia').attr("disabled", true);
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


</script>
</body>
</html>



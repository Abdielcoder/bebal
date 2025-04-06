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
	include("modal/revisar_pago.php");
	include("modal/eliminar_registro.php");
	include("modal/efectuar_inspeccion.php");
	include("modal/actualizar_datos_solicitante.php");
	include("modal/actualizar_datos_establecimiento.php");
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
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Asegurarse que siempre existe page
} else {
    $IDPRINCIPAL = $_POST['IDPRINCIPAL'];
    $page = isset($_POST['page']) ? $_POST['page'] : 1; // Asegurarse que siempre existe page
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
$sql_giro="SELECT * FROM giro WHERE id=".$id_giro;
$result_giro = mysqli_query($con,$sql_giro);
$row_giro = mysqli_fetch_assoc($result_giro);
$GIRO=$row_giro['descripcion_giro'];
$HORARIO_FUNCIONAMIENTO=$row_giro['horario_funcionamiento'];
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
            <h6 class="mb-0">Registro Establecimiento, Solicitante, Estatus y Operación</h6>
        </div>
        
        <!-- Sección de datos del establecimiento -->
        <div class="seccion-datos">
            <div class="encabezado">
                <h4>Datos del Establecimiento</h4>
            </div>
            <div class="contenido">
                <div class="row fila-datos">
                    <div class="col-md-2 col-6">
                        <div class="etiqueta">Folio</div>
                        <div class="valor"><?php echo $folio; ?></div>
                    </div>
                    <div class="col-md-5 col-6">
                        <div class="etiqueta">Giro</div>
                        <div class="valor"><?php echo $GIRO; ?></div>
                    </div>
                    <div class="col-md-5 col-12 mt-md-0 mt-3">
                        <div class="etiqueta">Modalidad Graduación Alcohólica</div>
                        <div class="valor"><?php echo $modalidad_graduacion_alcoholica; ?> * [<?php echo $numero_modalidad_graduacion_alcoholica; ?>] {<?php echo number_format($monto_umas_total_modalidad_graduacion_alcoholica); ?> umas}</div>
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
                        <div class="valor valor-destacado"><?php echo $servicios_adicionales; ?> * [<?php echo $numero_servicios_adicionales; ?>] {<?php echo number_format($monto_umas_total_servicios_adicionales); ?> umas}</div>
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
        
        
        <!-- Botones de acción -->
	<div class="area-botones">

       <a href="principal.php?page=<?php echo $page; ?>" class="btn btn-info bs-sm" style="background-color:#FFFFFF;"> <i class="bi bi-arrow-left"></i><font color="black" size="1"> Regresar </font></a>
          
       <a href="generar_pdf_html.php?id=<?php echo $IDPRINCIPAL; ?>" target="_blank" class="btn btn-danger"> <i class="bi bi-file-earmark-pdf"></i><font size="1"> Datos Generales </font></a>




<?php 	


switch ($estatus) {
##
case 'Generar Recibo Inspeccion':
//** Inspección - Permiso Nuevo ( tabla tramites )
##
$sql_tramite="SELECT id FROM tramite WHERE descripcion_tramite='Inspección - Permiso Nuevo'";
$result_tramite = mysqli_query($con,$sql_tramite);
$row_tramite = mysqli_fetch_assoc($result_tramite);
$ID_TRAMITE=$row_tramite['id'];
##
echo '<a href="datosParaPagar_pdf_html.php?id='.$IDPRINCIPAL.'--'.$ID_TRAMITE.'" target="_blank" class="btn btn-danger bs-sm" style="background-color:#AC905B;"> <i class="bi bi-file-earmark-pdf"></i><font size="2"> Recibo Inspección</font></a>';

echo '<a href="#revisarPago" data-bs-toggle="modal" data-bs-target="#revisarPago" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'"  data-tramite_pagoid="'.$ID_TRAMITE.'" data-tramite_pago="Inspección - Permiso Nuevo"  class="btn btn-danger bs-sm" title="Revisar Pago Inspección"><i class="bi bi-check-circle"></i><font size="2"> Revisar Pago Inspeción </font></a>';

                
echo  '<a href="#EliminarRegistro" data-bs-toggle="modal" data-bs-target="#EliminarRegistro" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" class="btn btn-dark bs-sm" title="Eliminar Registro"><i class="bi bi-trash"></i><font size="2" color="red"> Eliminar Registro</font></a>';


##echo  '<a href="#EliminarRegistro" data-bs-toggle="modal" data-bs-target="#EliminarRegistro" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" class="btn btn-dark bs-sm" title="Eliminar Registro"><i class="bi bi-pencil"></i><font size="2"> Actualizar Registro</font></a>';

echo '<div class="dropup">';
echo '<button class="dropbtn"><font size="1">Actualizar Registro</font></button>';
echo '<div class="dropup-content">';
echo  '<a href="#ActualizarGiroModalidadServiciosEsp" data-bs-toggle="modal" data-bs-target="#GiroModalidadServiciosEsp" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" data-id_giro="'.$id_giro.'" data-modalidad_graduacion_alcoholica="'.$modalidad_graduacion_alcoholica.'" data-servicios_adicionales="'.$servicios_adicionales.'" class="btn btn-dark bs-sm" title="Actualizar GiroModalidadServiciosEsp Establecimiento"><i class="bi bi-pencil"></i><font size="2" color="white"> Giro, Modalidad y SE</font></a>';
##
echo  '<a href="#ActualizarDatosEstablecimiento" data-bs-toggle="modal" data-bs-target="#ActualizarDatosEstablecimiento" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" data-calle_establecimiento="'.$calle_establecimiento.'" data-entre_calles_establecimiento="'.$entre_calles_establecimiento.'" data-numero_establecimiento="'.$numero_establecimiento.'" data-numerointerno_local_establecimiento="'.$numerointerno_local_establecimiento.'" data-cp_establecimiento="'.$cp_establecimiento.'" data-capacidad_comensales_personas="'.$capacidad_comensales_personas.'" data-superficie_establecimiento="'.$superficie_establecimiento.'" data-colonia_id="'.$colonia_id.'" data-delegacion_id="'.$delegacion_id.'" data-observaciones="'.$observaciones.'" class="btn btn-dark bs-sm" title="Actualizar Datos Establecimiento"><i class="bi bi-pencil"></i><font size="2" color="white"> Datos del Establecimiento</font></a>';
##
echo  '<a href="#ActualizarDatosSolicitante" data-bs-toggle="modal" data-bs-target="#ActualizarDatosSolicitante" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" data-nombre_persona_fisicamoral_solicitante="'.$nombre_persona_fisicamoral_solicitante.'" data-nombre_representante_legal_solicitante="'.$nombre_representante_legal_solicitante.'" data-domicilio_solicitante="'.$domicilio_solicitante.'" data-email_solicitante="'.$email_solicitante.'" data-telefono_solicitante="'.$telefono_solicitante.'" data-fisica_o_moral="'.$fisica_o_moral.'" data-rfc="'.$rfc.'"  class="btn btn-dark bs-sm" title="Actualizar Datos Solicitante"><i class="bi bi-pencil"></i><font size="2" color="white"> Datos del Solicitante</font></a>';
echo '</div>';
echo '</div>';

break;

##
case 'Efectuar Inspeccion':
echo '<a href="#EfectuarInspeccion" data-bs-toggle="modal" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" class="btn btn-danger bs-sm" title="Registrar Inspección"> <i class="bi bi-clipboard-check"></i><font size="2"> Registrar Inspección </font></a>';
break;

##
case 'Inspeccion Realizada':

//** Análisis y Revisión Documentos - Permiso Nuevo ( tabla tramites )
##
$sql_tramite="SELECT id FROM tramite WHERE descripcion_tramite='Análisis y Revisión Documentos - Permiso Nuevo'";
$result_tramite = mysqli_query($con,$sql_tramite);
$row_tramite = mysqli_fetch_assoc($result_tramite);
$ID_TRAMITE=$row_tramite['id'];
##
echo '<a href="datosParaPagar_pdf_html.php?id='.$IDPRINCIPAL.'--'.$ID_TRAMITE.'" target="_blank" class="btn btn-danger bs-sm" style="background-color:#AC905B;"> <i class="bi bi-file-earmark-pdf"></i><font size="2"> Recibo AR Documentos</font></a>';


echo '<a href="#revisarPago" data-bs-toggle="modal" data-bs-target="#revisarPago" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" data-tramite_pagoid="'.$ID_TRAMITE.'" data-tramite_pago="Análisis y Revisión Documentos - Permiso Nuevo"  class="btn btn-danger bs-sm" title="Revisar Pago AR Docuentos"><i class="bi bi-check-circle"></i><font size="2"> Revisar Pago AR Documentos</font></a>';


break;
##

default:


}








?>




        </div>
    </div>
</div>

<!-- Espacio adicional antes del footer -->
<div style="margin-bottom: 30px;"></div>

<hr>
<?php include("footer.php"); ?>

<script>
$( "#registro_guardar_pago" ).submit(function( event ) {
  $('#Button_registro_guardar_pago').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/registro_guardar_pago.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajaxPago").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajaxPago").html(datos);
			$('#Button_registro_guardar_pago').attr("disabled", true);
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
        var tramite_pago = $(this).data('tramite_pago');
        
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
	// --
        $(target + ' #mod_id_giro').val(id_giro);
        $(target + ' #mod_modalidad_graduacion_alcoholica').val(modalidad_graduacion_alcoholica);
        $(target + ' #mod_servicios_adicionales').val(servicios_adicionales);

	// --
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


